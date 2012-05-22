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
 * @property Fms $fms
 * @property System_logs $system_logs
 * @property Watchers $watchers
 */
Class Trueprivate_controller extends MY_FMS{
	
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
		$this->file_log = APPPATH.'logs/fms/truprivate.txt';
		
		
		
		//params from fms
		$this->params   = array(
					'isTruePrivate'	=> 'is_peek_enabled',
					'userId'		=> 'user_id',
					'uniqId'		=> 'unique_id',
					'performerId'	=> 'performer_id'
		);
	}

	/**
	 * 
	 * @return unknown_type
	 */
	function index(){
		$this->write_request($this->file_log, NULL, TRUE, FALSE); 
		
		$data = $this->fms->generate_params($this->params,TRUE);
		
		//verify user credentials
		$this->load->model('performers');		
		$user = $this->performers->get_one_by_id($data['performer_id']);
				
		$this->load->model('watchers');
		$watcher = $this->watchers->get_one_by_unique_id($data['unique_id']);
		if( ! $watcher ){
			$this->write_request($this->file_log, 'status=deny&log=invalid_unique_id', FALSE, TRUE);
		}
		
		if( $watcher->show_is_over || $watcher->user_id !== $data['user_id'] || $watcher->performer_id !== $data['performer_id'] ){
			$this->write_request($this->file_log, 'status=deny&log=invalid_datas', FALSE, TRUE);
		}
		
		// nu exista userul
		if( ! $user ){			
			$this->write_request($this->file_log, 'status=deny&log=invalid_user_id', FALSE, TRUE);				
		}
					
		$peek = ($data['is_peek_enabled']=='true'?0:1);
		
		//nu am putut sa adaug in DB sessiunea de watcher
		if( ! $this->performers->update($user->id,array('enable_peek_mode'=>$peek,'is_in_private'=>1)))
		{
			$this->write_request($this->file_log, 'status=deny&log=database_error_please_retry', FALSE, TRUE);			
		}
		
		$this->write_request($this->file_log, 'status=allow', FALSE, TRUE);			
	}
}