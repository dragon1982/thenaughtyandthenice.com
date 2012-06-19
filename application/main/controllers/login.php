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
 */
class Login_controller extends MY_Controller{
	
	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->access->restrict('logged_out');
		
	}


	/**
	 * Login
	 */
	function index() {
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('username',	lang('username'),		'trim|required|alpha_dash|min_length[3]|max_length[25]');
		$this->form_validation->set_rules('password',	lang('password'),		'trim|required|min_length[3]|verify_login[user]');

		if($this->form_validation->run() === FALSE){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>form_error('password')));
			redirect();
		} else {
			redirect();
		}
	}
	
	function static_login() {
		$this->load->view('static_login');
	}
}