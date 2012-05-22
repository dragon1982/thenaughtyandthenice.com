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
 */

class Documents_controller extends CI_Controller{
	
	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->user = $this->access->get_account();		
	}
	
	/*
	 * Tos loading
	 */
	function index(){
		$this->tos();	
	}

	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Contact
	 */
	function contact(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
	
		$this->form_validation->set_rules('subject',	lang('subject'),	'trim|required|min_length[2]|max_length[255]|purify');
		$this->form_validation->set_rules('email',		lang('email'),		'trim|required|min_length[2]|max_length[100]|purify|valid_email');
		$this->form_validation->set_rules('message',	lang('message'),	'trim|required|min_length[2]|max_length[1500]|purify');
	
		if($this->form_validation->run() === FALSE){
			$data['_payments_sidebar']		= FALSE;
			$data['_performer_menu']		= TRUE;
			$data['page'] 					= 'contact';
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Contact').' - '.SETTINGS_SITE_TITLE;
				
			$this->load->view('template', $data);
		}
		else
		{
			$this->load->library('email');
			$this->email->from($this->input->post('email'),$this->input->post('name'));
			$this->email->to(SUPPORT_EMAIL);
			$this->email->subject($this->input->post('subject'));
			$this->email->message($this->input->post('message'));
			if ($this->email->send()) {
				$this->session->set_flashdata('msg',array('success'=>TRUE,	'message'=>lang('Message Sent')));
			} else {
				$this->session->set_flashdata('msg',array('success'=>FALSE,	'message'=>lang('Error sending message')));
			}
			redirect(current_url());
		}
	}
		
	/*
	 * Terms of service
	 */
	function tos(){
		$this->load->model('categories');
		$data['_categories']			= false;
		$data['_sidebar']				= false;
		$data['_signup_header']			= true;
		$data['page'] 					= 'terms';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Terms And Conditions').' - '.SETTINGS_SITE_TITLE;
		$data['categories']				= $this->categories->get_all_categories();
		
		
		$this->load->view('template', $data);
	}
	
	/*
	 * Privacy Policy
	 */
	function policy(){
		$this->load->model('categories');
		$data['_categories']			= false;
		$data['_sidebar']				= false;
		$data['_signup_header']			= true;
		$data['page'] 					= 'policy';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Privacy policy ').' - '.SETTINGS_SITE_TITLE;
		$data['categories']				= $this->categories->get_all_categories();
		
		
		$this->load->view('template', $data);			
	}
	
	
	function policy_2257(){
		$this->load->model('categories');
		$data['_categories']			= false;
		$data['_sidebar']				= false;
		$data['_signup_header']			= true;
		$data['page'] 					= '2257';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('18 U.S.C 2257 Record-Keeping Requirements Compliance Statement').' - '.SETTINGS_SITE_TITLE;
		$data['categories']				= $this->categories->get_all_categories();
		
		
		$this->load->view('template', $data);		
	}
		
}