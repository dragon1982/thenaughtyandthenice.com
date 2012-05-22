<?php
class Home_controller extends MY_Admin {
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {		
		redirect('statistics');
		
	}
	
	function logout() {
		$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'admin', 
            			$this->user->id, 
            			'logout', 
            			'Admin has logged out.', 
            			time(), 
            			ip2long($this->input->ip_address())
		);
		$this->session->sess_destroy();
		redirect('login');
	}
	
}