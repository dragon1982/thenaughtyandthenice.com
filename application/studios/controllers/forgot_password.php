<?php
class Forgot_password_controller extends MY_Controller {
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('studios');
		$this->access->restrict('logged_out');
	}

	
	// -----------------------------------------------------------------------------------------	
	/** 
	 * Controller pentru forgot password
	 */	
	function index() {	
		$this->im_in_modal = TRUE;
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username',	lang('username'),	'trim|required');
		$this->form_validation->set_rules('email',		lang('email'),		'trim|required|valid_email|mail_belog_to_user[studios]');		

		if($this->form_validation->run() === FALSE){
						
			$data['_categories']		= FALSE;
			$data['_sidebar']			= FALSE;
			$data['_signup_header']		= FALSE;
			$data['page'] 				= 'forgot_password';
			$data['description'] 		= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 			= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 			= lang('Forgot password').' - '.SETTINGS_SITE_TITLE;
			
			$this->load->view('template-modal', $data);	
		}
		else
		{
			$this->load->library('email');
			$email = $this->input->post('email');
			$username = $this->input->post('username');
			$this->email->from(SUPPORT_EMAIL,SUPPORT_NAME);
			$this->email->to($email);
			$this->email->subject(lang('Forgot password'));						

			//selectez userul din DB
			$user = $this->studios->get_one_by_username($username);
			
			$reset_password_link 	= site_url("reset_password?time=".time()."&username=$username&secure_code=".md5(time().$user->hash));
			
			$email_content = $this->load->view('emails/forgot_password_'.$this->config->item('lang_selected'), array(), TRUE);
			$this->load->helper('emails');
			
			$replaced_variables = get_avaiable_variabiles('forgot_password', TRUE);
			$replace_value = array($user->username,  $user->email,  $reset_password_link,  main_url(), WEBSITE_NAME);

			$email_content = preg_replace($replaced_variables, $replace_value, $email_content);
			
			$this->email->message($email_content);		
			$this->email->send();
			
			$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Please check your mail to reset your password')));
			redirect('login');					
		}
		
	}
		
}