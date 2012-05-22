<?php
class Login_controller extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->access->restrict('logged_out');
		$this->load->library('form_validation');
	}
	
	function index() {		
		$this->form_validation->set_rules('username', lang('username'), 'trim|required|alpha_dash');
		$this->form_validation->set_rules('password',lang('password'),'trim|required|verify_login[admin]');		
		if($this->form_validation->run() === FALSE){
			$this->load->view('login');
			return;
		} else {
			
			redirect();
		}
	}

}