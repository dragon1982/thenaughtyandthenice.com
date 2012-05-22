<?php

require_once BASEPATH.'/libraries/Pagination.php';

class Admin_pagination extends CI_Pagination{
	
	
	function __construct() {
		parent::__construct();
		$config = array();
		require APPPATH.'config/admin_pagination.php';
		
		$this->initialize($config);
	}
	
}