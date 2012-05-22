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
 * @property Performers $performers
 * @property Studios $studios
 * @property Watchers $watchers
 * @property System_logs $system_logs
 */

class Ballance_controller extends MY_FMS{
	
	var $file_log;
	var $params; 
	
	/*
	 * Constructor
	 */
	function __construct(){		
		parent::__construct();
		$this->load->helper('generic');
		$this->load->model('fms');
		
		//file logger
		$this->file_log = APPPATH.'logs/ballance.txt';
		
		//params from fms
		$this->params   = array(
					'userId'		=> 'user_id',
					'pasword'		=> 'password',
					'performerId'	=> 'performer_id',
					'chatType'		=> 'chat_type',
					'uniqId'		=> 'unique_id'
		);
	}

	/*
	 * Ballance function
	 */
	function index(){
		$data = $this->fms->generate_params($this->params,TRUE);
				
		//verify user credentials
		$this->load->model('watchers');
		
		$watcher = $this->watchers->get_one_by_unique_id($data['unique_id'],TRUE);
		
		//sessiunea de watcher nu exista
		if( ! $watcher ){
			$this->write_request($this->file_log, 'status=deny&log=watcher_not_found', TRUE, TRUE);
		}
		
		//date de login invalide
		if( $watcher->password !== $data['password']){
			$this->write_request($this->file_log,'status=deny&log=invalid_credentials',TRUE, TRUE);
		}
		
		require_once APPPATH.'models/chat/chats.php';
		$chat = Chats::get_instance($watcher->type,FALSE,FALSE,$watcher);
		
		$chat->get_ballance();
	}
} 