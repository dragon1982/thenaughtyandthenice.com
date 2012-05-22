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
 */
Class Login_controller extends MY_Controller{
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->access->restrict('logged_out');
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Functia de login pentru performer
	 * @return unknown_type
	 */
	function index() {
		
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username',lang('username'),'trim|required');
		$this->form_validation->set_rules('password',lang('password'),'trim|required|verify_login[affiliate]');

		if($this->form_validation->run() === FALSE){
						
			$data['page'] 				= 'login';
			$data['description'] 		= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 			= SETTINGS_SITE_KEYWORDS;
			$data['page_title'] 		= lang('Affiliate Login').' - '.SETTINGS_SITE_TITLE;
			
			$this->load->view('template', $data);
			return;	
		}	
		redirect();
	}
}	