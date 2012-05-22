<?php
Class Mp3_controller extends CI_Controller{
	
	
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		$this->load->model('music');
		$data['songs']	= $this->music->get_all();
		$this->load->view('fms/mp3',$data);		
	}
}