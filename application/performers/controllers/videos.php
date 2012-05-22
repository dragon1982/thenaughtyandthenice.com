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
 * @property Performers $performers
 * @property Performers_videos $performers_videos
 * @property Fms $fms
 */

class Videos_controller extends MY_Performer{
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('performers_videos');
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Listare poze pentru un performer
	 * @return unknown_type
	 */
	function index(){
		$this->load->library('pagination');
		
		$this->load->model('watchers');
		$this->load->model('fms');
			
		$config['per_page']				= 12;
		$config['base_url'] 			= site_url('videos/page/');
		$config['total_rows']   		= $this->performers_videos->get_multiple_by_performer_id($this->user->id,$this->pagination->per_page,(int)$this->uri->segment(3),TRUE);
		$this->pagination->initialize($config);

		if( ! $config['total_rows'] && (int)$this->uri->segment(3) ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Page is empty!')));
			redirect('videos');
		}
		
		$data['pagination']				= $this->pagination->create_links();		
		$data['videos'] 				= $this->performers_videos->get_multiple_by_performer_id($this->user->id,$this->pagination->per_page,(int)$this->uri->segment(3));
		$data['fms']					= create_array_by_property($this->fms->get_multiple(),'fms_id');


        $data['_sidebar']       		= TRUE;
        $data['_performer_menu']		= TRUE;
		$data['page'] 					= 'videos/index';
		$data['description']			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords']				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle']				= lang('My videos').' - '.SETTINGS_SITE_TITLE;		
		
		$this->load->helper('text');
		$this->load->view('template',$data);		
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Editare poza performer
	 * @param $photo_id
	 * @return unknown_type
	 */
	function edit($video_id = FALSE){
		if( ! $video_id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid video id')));
			redirect('videos');				
		}

		if( ! $data['video'] = $this->performers_videos->get_one_by_id($video_id)){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid video id')));
			redirect('videos');			
		}
		
		if( $data['video']->performer_id !== $this->user->id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('The video you are trying to edit is not yours')));
			redirect('videos');			
		}

		$data['types']					= array(0=>lang('free'),1=>lang('paid'));
		$this->video_types				= $data['types'];
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('description',	lang('description'),	'trim|max_length[255]|strip_tags|purify');
		$this->form_validation->set_rules('type',			lang('type'),			'trim|required|valid_video_type');
		$this->form_validation->set_rules('price',			lang('price'),			'trim|valid_video_price');
				
		if( $this->form_validation->run() === FALSE ){
	       	$data['_sidebar']       		= TRUE;
	        $data['_performer_menu']		= TRUE;
			$data['page'] 					= 'videos/edit';
			$data['description']			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords']				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle']				= lang('Edit video').' - '.SETTINGS_SITE_TITLE;		
			
			$this->load->view('template',$data);
		} else {
			if( ! $this->performers_videos->update($video_id,array(
																	'description'=> $this->input->post('description'),
																	'is_paid'	=> $this->input->post('type'),
																	'price'		=> ($this->input->post('type'))?$this->input->post('price'):0
																	)
												)
			){
				$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Database error. Please retry')));
				redirect('videos');
			}
			
			$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Changes saved.')));
			$this->system_log->add(
            			'performer', 
            			$this->user->id,
            			'performer', 
            			$this->user->id, 
            			'edit_video', 
            			'Performer has edited video ' . $video_id, 
            			time(), 
            			ip2long($this->input->ip_address())
			);
			redirect('videos');
		}	
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
		
		if( $data['video']->performer_id !== $this->user->id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('The video you are trying to edit is not yours')));
			redirect('videos');		
		}		
		
		$this->load->model('fms');
		$data['fms'] = $this->fms->get_one_by_id($data['video']->fms_id);
		
		if( ! $data['fms'] ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid FMS!')));
			redirect();
		}		
		
		$data['performer']				= $this->user;
	
		$data['page'] 					= 'videos/view';	
			
		$this->load->view('template-modal',$data);
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Sterge poza performer
	 * @param $photo_id
	 * @return unknown_type
	 */
	/*
	function delete($photo_id = FALSE){
		if( ! $photo_id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid video id')));
			redirect('videos');	
		}
		
		if( ! $data['video'] = $this->performers_videos->get_one_by_id($photo_id)){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid video id')));
			redirect('videos');
		}
		
		if( $data['video']->performer_id !== $this->user->id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('The video you are trying to edit is not yours')));
			redirect('videos');		
		}
		
		$this->performers_videos->delete_one_by_id($photo_id);
				
	}	
	*/
}