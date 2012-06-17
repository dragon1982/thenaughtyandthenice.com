<?php
/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Email $email
 * @property CI_Form_validation $form_validation
 * @property CI_URI $uri
 * @property Firephp $firephp
 * @property CI_DB_active_record $db
 * @property Users $users
 * @property Performers $performers
 * @property System_logs $system_logs
 * @property banned_countries $banned_countries
 * @property Messages $messages
 * @property Ratings $ratings
 * @property Watchers $watchers
 * @property Performers_reviews $performers_reviews
 */

class Performers_controller extends MY_Controller{

	public $fms_list;
	
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){		
		parent::__construct();
		$this->load->model('performers');
		$this->load->model('categories');
		
		$this->load->config('filters');
		$this->load->helper('filters');
		
		
		//purifica filtrele
		$_GET['filters'] = purify_filters((isset($_GET['filters'])?$_GET['filters']:NULL));
		
		$this->load->model('fms');
		$this->fms_list = create_array_by_property($this->fms->get_multiple(),'fms_id');
				
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Listare modele
	 * @return unknown_type
	 */
	function index(){
		
		$this->load->library('pagination');	
				
		$filters = $this->input->get('filters');
		//seteaza filtrele pentru pagina actuala
		$settings = initialize_filters($filters,$order_by = NULL,'listing');
				
		$config['per_page']		= 10;			
		$config['base_url'] 	= site_url('performers/page/');	
		$config['total_rows']   = $this->performers->get_multiple_performers($settings['filters'],$this->pagination->per_page,(int)$this->uri->segment(3),$settings['order_by'],TRUE);
		$this->pagination->initialize($config);
		
		$data['performers'] 			= $this->performers->get_multiple_performers($settings['filters'],$this->pagination->per_page,(int)$this->uri->segment(3),$settings['order_by']);
		$data['pagination']				= $this->pagination->create_links();
		$data['categories'] 			= $this->categories->get_all_categories();
			
		$data['_categories']			= true;
		$data['_sidebar']				= false;
		$data['_signup_header']			= true;
		$data['page'] 					= 'performers';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Our Models').' - '.SETTINGS_SITE_TITLE;
		
		$search = prepare_search_options();
		$data = array_merge($data, $search);
		
		$this->load->view('template', $data);
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Profil model
	 * @param $nickname
	 * @return unknown_type
	 */
	function profile($nickname = FALSE){
		if( ! $nickname ){
			show_404();
		}
		
		if( ! $this->performers->valid_performer($nickname) ){
			show_404();		
		}

		$performer = $this->performers->get_one_by_nickname($nickname,$this->user->id);
		
		if( ! isset($performer['performer']) || ! is_object($performer['performer']) ) {
			show_404();
		} 

		
		if($performer['performer']->status !== 'approved'){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=>lang('performer is suspended')));
			redirect('performers');			
		}
		
		$this->load->model('banned_countries');				
		//userul se afla intro regiune blacklistata de catre performer
		if($this->banned_countries->is_performer_blacklisted_region($performer['performer']->id)){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=>lang('invalid performer')));			
			redirect('performers');
		}

		$this->load->model('performers_videos');
		$this->load->model('performers_photos');		
		$videos = $this->performers_videos->get_multiple_by_performer_id($performer['performer']->id,FALSE,FALSE);
		$photos	= $this->performers_photos->get_multiple_by_performer_id($performer['performer']->id,FALSE,FALSE);
		
		$this->load->helper('performers');
		$this->load->model('performers_reviews');
		
		//videouri phooturi si languri 
		$data['performer'] 				= $performer['performer'];
		
		$data['photos']					= get_performer_photos($photos,FALSE);
		$data['photos_paid']			= get_performer_photos($photos,TRUE);
		$data['videos']					= get_performer_videos($videos,FALSE);
		$data['videos_paid']			= get_performer_videos($videos,TRUE);
		
		$data['languages']				= get_performer_languages($performer['profile']);
		$data['favorite']				= (isset($performer['performer']->favorite_id) && $performer['performer']->favorite_id)?TRUE:FALSE;		
		
		//reviewuri
		$this->load->library('pagination');
		$config['per_page']				= 10;			
		$config['uri_segment']			= 5;			
		$config['base_url']				= site_url('performers/profile/' . $performer['performer']->username . '/page/');	
		$config['total_rows']			= $this->performers_reviews->get_multiple_by_performer_id($performer['performer']->id, false, false, true);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();		
		$data['reviews'] = $this->performers_reviews->get_multiple_by_performer_id($performer['performer']->id, $config['per_page'], $this->uri->segment(5), false);
		
		//verificare daca galeria foto e deja platita
		if( sizeof($data['photos_paid']) > 0 ){
			if($this->user->id > 0){
				$this->load->model('watchers');
				$data['has_paid'] = $this->watchers->get_multiple_by_performer_id($data['performer']->id,1,0,array('type'=>'photos','user_id'=>$this->user->id),FALSE,TRUE);
			} else {
				$data['has_paid'] = FALSE;
			}
		}
		
		//verificare videouri platite daca sunt deja platite
		if( sizeof($data['videos_paid']) > 0 && $this->user->id > 0){
			$this->load->model('watchers');
			$paid_videos =   $this->watchers->get_multiple_by_performer_id($data['performer']->id,FALSE,FALSE,array('type'=>'premium_video','user_id'=>$this->user->id),FALSE);
			mark_paid_videos($data['videos_paid'],$paid_videos);	
		}
		
		//schedule
		$this->load->model('performers_schedules');
		$this->load->helper('schedule');		
		$data['schedule']  				= render_schedule($this->performers_schedules->get_schedule_by_performer_id($performer['performer']->id));
				
		//rating 
		$rate_data = $this->performers->get_performer_rate_details($data['performer']->id);				
        $data['rating']        = (int)$rate_data->rating;
        $data['ratings_count'] = (int)$rate_data->votes;
        
        //setare headers de no cache
        $this->output->set_header("HTTP/1.1 200 OK");
        $this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
                
		//profile model/helper
        $this->load->model('performers_profile');
        $this->load->helper('profile');
        
        //listare helpers
        $this->load->model('watchers');
        $this->load->helper('text');
        $data['categories'] 			= $this->categories->get_all_categories();        
        $data['_categories']			= TRUE;
        $data['_sidebar']				= FALSE;
        $data['_signup_header']			= TRUE;
        $data['page'] 					= 'profile/index';
        $data['description'] 			= SETTINGS_SITE_DESCRIPTION;
        $data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
        $data['pageTitle']				= sprintf(lang('%s\'s profile - %s'),$performer['performer']->nickname,SETTINGS_SITE_TITLE);        
        $search = prepare_search_options();
        $data = array_merge($data, $search);        
        $this->load->view('template',$data);
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Cauta un performer %performer% FUNCTIE PENTRU AJAX
	 * @param $performer
	 * @return unknown_type
	 */
	function search(){
		//nu e request prin ajax
		if( ! $this->input->is_ajax_request() ){
			//return;
		}
		
		$this->load->library('pagination');
		$this->load->library('user_agent');		
		$filters = $this->input->get('filters');
		
		//seteaza filtrele pentru pagina actuala
		$settings = initialize_filters($filters, $order_by = NULL, 'search');

		$config['per_page']		= 10;		  
		$config['base_url'] 	= site_url('search/page/');
		$config['uri_segment'] 	= 3;
		$config['total_rows']   = $this->performers->get_multiple_performers($settings['filters'],$this->pagination->per_page,(int)$this->uri->segment(3),$settings['order_by'],TRUE);
		$this->pagination->initialize($config);
		
		if($config['total_rows'] == 0 && $this->uri->segment(3) == 0){
			die('<div class="no_results">' . lang('No results found matching your search criteria.') . '</div>');
		} 
		
		if($config['total_rows'] == 0 && $this->uri->segment(3) > 0){
			die('<div class="no_results">' . lang('No results found matching your search criteria.') . '</div>');
		}
		

		$data['performers'] 	= $this->performers->get_multiple_performers($settings['filters'],$this->pagination->per_page,(int)$this->uri->segment(3),$settings['order_by']);
		$data['pagination']		= $this->pagination->create_links_for_ajax();
	
		$data['categories']		= $this->categories->get_all_categories();
		
		$search = prepare_search_options();
		$data = array_merge($data, $search);
		
		$this->load->view('ajax_result', $data);
	}
	
	/*
	 * Contact performer
	 */
	function contact(){     		
        //Formularul de contact                
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
		$this->form_validation->set_rules('subject',lang('subject'),'trim|required|min_length[2]|max_length[255]|purify|strip_tags');
		$this->form_validation->set_rules('message',lang('message'),'trim|required|min_length[2]|max_length[1500]|purify|strip_tags');
		
		$this->load->library('user_agent');
		if($this->input->post('performer_id') < 1){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('invalid performer id')));
			redirect($this->agent->referrer());							
		}
		
		if( ! $performer = $this->performers->get_one_by_id($this->input->post('performer_id')) ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('invalid performer id')));
			redirect($this->agent->referrer());			
		}
		
		if($this->form_validation->run() === FALSE) {	
			redirect($this->agent->referrer());								
		}
		else
		{
			$this->load->model('messages');
			
			if( $this->messages->add(
							$this->input->post('subject'),
							$this->input->post('message'),
							0,
							0,
							0,
							0,
							time(),
							'user',
							$this->user->id,
							'performer',
							$performer->id
				)) 
			{
				$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Message Sent')));
				redirect($this->agent->referrer());					
			} else {
				$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Error sending message')));
				redirect($this->agent->referrer());
			}	
		}					
	}

	/**
	* Adauga un review performerului dupa chat
	* @return unknown_type
	*/
	function add_performer_review(){
		$id = $this->input->get('id');
		if( ! $id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid review id')));
			redirect();
		}
	
		$this->load->model('watchers');
		$watcher = $this->watchers->get_one_by_unique_id($id);
	
		if( ! $watcher ){
			redirect();
		}
	
		if( $watcher->user_id !== $this->user->id ){
			redirect();
		}
	
		if( ! in_array($watcher->type,array('nude','private','peek','true_private') ) ){
			redirect();
		}
	
		$this->load->model('performers_reviews');
	
		$review = $this->performers_reviews->get_one_by_unique_id($id);
	
		if( $review ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('You already have added a review to the chat session')));
			redirect();
		}
	
		$performer = $this->performers->get_one_by_id($watcher->performer_id);;
		
		$this->load->library('form_validation'); 
		$this->form_validation->set_rules('message',	lang('message'),	'trim|required|strip_tags|max_length[255]|purify|prep_form');
		$this->form_validation->set_rules('rating[]',	lang('rate'),		'trim|required');
		
		if( $this->form_validation->run() === FALSE ){
				
			$data['_categories']			= TRUE;
			$data['_signup_header']			= FALSE;
			$data['uniq_id']				= $id;
			$data['page'] 					= 'add_performer_review';
			$data['performer']				= $performer;
	
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Add Review').' - '.SETTINGS_SITE_TITLE;
			$data['categories']				= $this->categories->get_all_categories();
			$data['favorite']				= FALSE;
			$this->load->view('template', $data);

		} else {
			
			$rating = $this->input->post('rating');
			$rating = array_sum($rating)/count($rating);
			
			$message = $this->input->post('message');
			
			$this->performers_reviews->add($this->user->id,$performer->id,$id,$message,$rating);
			
			$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Thank you for evaluation!')));
			redirect();
		}
	}
}