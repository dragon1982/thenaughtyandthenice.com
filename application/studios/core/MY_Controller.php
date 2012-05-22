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
		$this->user = $this->access->get_account('studio');
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
class MY_Studio extends MY_Controller{
	

	/**
	 * Restrictioneaza accessul catre controllerul de users
	 * @return null
	 */
	function __construct(){
		parent::__construct();
		$this->access->restrict('studios');
		$this->load->model('messages');
		$this->user->unread_messages = $this->messages->get_all_received_by_user_id($this->user->id, $this->user->type, FALSE, FALSE, TRUE, TRUE);
	}
}

/**
 * Controlleru pentru studiourile ce editeaza performeri
 */
class MY_Studio_Edit extends MY_Studio{
	
	public $performer;
	
	/*
	 * Restrictioneaza editarea unui performer ce nui apartine
	 */
	function __construct(){
		parent::__construct();
		
		$performer = $this->session->userdata('performer_id');
		if( ! $performer ){
		 	redirect('performers');
		}
		
		$this->load->model('performers');
		
		$performer = $this->performers->get_one_by_id($performer);
		
		if( ! $performer ){
			redirect('performers');
		}
		
		$this->performer = $performer;
		
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

