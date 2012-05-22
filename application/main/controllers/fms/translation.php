<?php
class Translation_controller extends CI_Controller{
	
	function __cosntruct(){
		parent::__construct();
	}
	
	function index(){
		$this->load->view('fms/translations');
	}
}