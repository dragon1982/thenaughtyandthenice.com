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
		$this->user = $this->access->get_account('affiliate');
		
		if(SETTINGS_DEBUG){
			$this->output->enable_profiler();
		}
	}
}

/**
 * Users controller
 * @author Andrei
 *
 */
class MY_Performer extends MY_Controller{
	

	/**
	 * Restrictioneaza accessul catre controllerul de users
	 * @return null
	 */
	function __construct(){
		parent::__construct();
		$this->access->restrict('users');
	}
}


/**
 * Affiliate controller
 * @author	AgLiAn
 *
 */
class MY_Affiliate extends MY_Controller{
	

	/**
	 * Restrictioneaza accessul catre controllerul de affiliates
	 */
	function __construct(){
		parent::__construct();
		$this->access->restrict('affiliates');
	}
}

/**
 * Affiliate controller
 * @author	CagunA
 *
 */
class MY_Admin extends MY_Controller{
	

	/**
	 * Restrictioneaza accessul catre controllerul de affiliates
	 */
	function __construct(){
		parent::__construct();
		$this->access->restrict('admins');
	}
}


/**
 * Controllerul de FMS
 * @author Andrei
 *
 */
class MY_FMS extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$hash = $this->input->post('hash');
		if( defined('FMS_SECRET_HASH') && $hash !== FMS_SECRET_HASH ) {
			//writeRequest($this->fileLog, 'status=deny&log=bad_secret_hash', true, true);
		}
	}
	
	
}

