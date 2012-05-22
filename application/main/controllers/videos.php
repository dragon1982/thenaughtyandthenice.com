<?php
/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Email $email
 * @property CI_Form_validation $form_validation
 * @property CI_URI $uri
 * @property Firephp $fireph
 * @property CI_DB_active_record $db
 * @property Users $users
 * @property Credits $credits
 * @property Watchers $watchers
 * @property Performers $performers
 * @property Performers_videos $performers_videos 
 * @property System_logs $system_logs
 */
class Videos_controller extends MY_Controller{
	
	private $video_details = FALSE;
	public $fms_list;
	public $video_type = NULL;
	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('performers_videos');
		$this->load->model('performers');
		
		$this->load->config('filters');
		$this->load->helper('filters');
		
        $this->load->helper('text');		
		$this->load->model('fms');
		$this->fms_list = create_array_by_property($this->fms->get_multiple(),'fms_id');
		
		//purifica filtrele
		$_GET['filters'] 	= purify_filters((isset($_GET['filters'])?$_GET['filters']:NULL));
		$this->video_type	= purify_video_type((isset($_GET['type'])?$_GET['type']:NULL));		
	}
	
	/*
	 * Listare videouri
	 */
	function index(){
		$this->load->library('pagination');	
				
		$filters = $this->input->get('filters');
		
		//seteaza filtrele pentru pagina actuala
		$settings = initialize_filters($filters,$order_by = NULL,'listing');
				
		$settings['filters']['type']	= $this->video_type;
		$config['per_page']		= 16;			
		$config['base_url'] 	= site_url('videos/page/');	
		$config['total_rows']   = $this->performers_videos->get_multiple_videos($settings['filters'],$this->pagination->per_page,(int)$this->uri->segment(3),TRUE);
		$this->pagination->initialize($config);

		if($config['total_rows'] == 0 && $this->uri->segment(3) > 0){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('no matches found')));
			redirect();	
		}
		
		$this->load->model('watchers');

		$this->load->model('categories');
		$data['videos'] 				= $this->performers_videos->get_multiple_videos($settings['filters'],$this->pagination->per_page,(int)$this->uri->segment(3));
		$data['pagination']				= $this->pagination->create_links();
		$data['categories'] 			= $this->categories->get_all_categories();
			
		if( sizeof($data['videos']) > 0 && $this->user->id){
			$this->load->model('watchers');
			$performer_videos = extract_values_by_property($data['videos'] , 'video_id');
			$paid_videos =   $this->watchers->get_multiple_by_performer_id(FALSE,FALSE,FALSE,array('type'=>'premium_video','user_id'=>$this->user->id,'performer_videos'=>$performer_videos),FALSE);
			mark_paid_videos($data['videos'],$paid_videos);
		}
				
		$data['_categories']			= TRUE;
		$data['_sidebar']				= FALSE;
		$data['_signup_header']			= TRUE;
		$data['page'] 					= 'videos/index';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Videos').' - '.SETTINGS_SITE_TITLE;		
		
		$this->load->view('template', $data);
		
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Vede un video
	 * @param $video_id
	 */	
	function view($video_id = FALSE){		
		$this->im_in_modal = TRUE;
	
		if( ! $video_id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid video id')));
			redirect('videos');					
		}

		if( ! $data['video'] = $this->performers_videos->get_one_by_id($video_id)){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid video id')));
			redirect('videos');			
		}
		
		if( $data['video']->is_paid ){
			
			$this->load->model('watchers');
			$is_paid = $this->watchers->get_multiple_by_user_id($this->user->id,1,FALSE,array('is_paid'=>1,'performer_video_id'=>$data['video']->video_id));


			if( ! $is_paid ){
				$this->video_details = $data['video'];
				
				//daca formuarul nu e valid face return; nu merge mai departe doar afiseaza formularul, daca nu trece si ajunge sa afiseze videoul
				if( ! $this->ask_for_pay_agreement() ){
					return;	
				}
				
			}
		}
				
		$this->load->model('fms');
		$data['fms'] =$this->fms_list[$data['video']->fms_id];
		
		$data['performer']				= $this->performers->get_one_by_id($data['video']->performer_id);	
		$data['page'] 					= 'videos/view';	
			
		$this->load->model('watchers');
		$this->load->view('template-modal',$data);
	}
	
	/**
	 * 
	 * arata pagina de cumparare access la videoul respectiv
	 * @author Baidoc
	 */
	private function ask_for_pay_agreement(){
		$this->im_in_modal = TRUE;
				
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('agree', lang('agree'),'trim|required');
		
		//useril are deja un chat deschis
		if( $this->watchers->get_one_active_session_by_user_id($this->user->id) ){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=> lang('please close all your chat sessions before you can buy access to a paid video!')));
			redirect();
		}
			
		//nu are destui bani pt a plati
		if( $this->user->credits < $this->video_details->price ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('you have unsufficient funds in your account to buy access to this paid video!')));
			redirect('add-credits');
		}

		
		if($this->form_validation->run() === FALSE){
			
			//requestul nu e din ajax
			if( ! $this->input->is_ajax_request() ){
				redirect();
			}
						
			if( ! $this->video_details ){
				redirect();
			}
								
			$data['video']	= $this->video_details;				
			$this->load->view('confirmations/pay_video',$data);
			
			return FALSE;
		}
		else 
		{
			$total_amount = $this->video_details->price;
			
			$performer 			= $this->performers->get_one_by_id($this->video_details->performer_id);
			
			//banii siteului
			$website_amount		= round( $total_amount * $performer->website_percentage / 100 , 2 );
			
			//banii performerului
			$performer_amount 	= $total_amount - $website_amount;
			
			$studio_amount 		= 0;
			
			if( $performer->studio_id ){
					
				$this->load->model('studios');
				$studio = $this->studios->get_one_by_id($performer->studio_id);
				$studio_amount = round( $performer_amount * $studio->percentage / 100 ,2);
				$performer_amount -= $studio_amount;
			}
			
			$this->db->trans_begin();
			
			$watcher = array(
						'start_date'		=> time(),
						'end_date'			=> time(),
						'show_is_over'		=> 1,
						'type'				=> 'premium_video',
						'ip'				=> ip2long($this->input->ip_address()),
						'fee_per_minute'	=> 0,
						'unique_id'			=> $this->watchers->generate_one_unique_id(),
						'user_id'			=> $this->user->id,
						'username'			=> $this->user->username,
						'user_paid_chips'	=> $this->video_details->price,
						'performer_chips'	=> $performer_amount,
						'studio_chips'		=> $studio_amount,
						'site_chips'		=> $website_amount,
						'studio_id'			=> $performer->studio_id,
						'performer_id'		=> $performer->id,
						'performer_video_id'=> $this->video_details->video_id,
						'paid'				=> 1		
			);
			
			$this->watchers->add($watcher);
			
			$this->users->add_credits($this->user->id,-$this->video_details->price);
			$this->performers->add_credits($performer->id,$performer_amount);
			if($performer->studio_id){
				$this->studios->add_credits($performer->studio_id,$studio_amount+$performer_amount);
			}
			
			//nu am reusit sa adaug in db userul
			if($this->db->trans_status() == FALSE){
					
				//fac rollback la date
				$this->db->trans_rollback();
					
				$this->load->model('developers');
				//fac un log cu in care scriu ca $user_idu nu a primit $x credite , conform logului $x din tabela $y
				//lost_updates($this->user->id,$pay['log_table'],$pay['log_id'],$data['packages'][$this->input->post('package')]['credits']);
			
				$this->load->library('user_agent');
					
				$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('An error occured')));
				//redirectionez pe pagina de unde a venit
				redirect($this->agent->referrer());
			}
			
			$this->db->trans_commit();
			
			$this->system_log->add(
            	'user', 
				$this->user->id,
            	'user', 
				$this->user->id,
            	'buy_video', 
				sprintf('Paid %s for video id %s',$this->video_details->price,$this->video_details->video_id),
				time(),
				ip2long($this->input->ip_address())
			);			

			$this->session->set_flashdata('open_modal_video',$this->video_details->video_id);
			redirect($performer->nickname . '?tab=videos');			
		}
		
	}
}