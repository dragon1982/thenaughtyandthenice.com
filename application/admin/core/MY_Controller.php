<?php
/**
 * General controller
 * @author Andrei
 *
 */
class MY_Controller extends CI_Controller{
	
	public $user;
	
	/**
	 * Construieste obiectul $user
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();		
		$this->user = $this->access->get_account('admin');
		
		if(SETTINGS_DEBUG){
			$this->output->enable_profiler();
		}
		
	}
}



/**
 * Admin controller
 * @author	CagunA
 *
 */
class MY_Admin extends MY_Controller{
	

	/**
	 * Restrictioneaza accessul catre controllerul de admin
	 */
	function __construct(){
		parent::__construct();
		$this->access->restrict('admins');
	}
}


