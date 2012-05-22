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
class Log_controller extends MY_FMS{
	
	var $file_log;
	var $params; 

	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		
		$this->load->helper('generic');
		$this->load->model('fms');
		$this->load->model('watchers');
		
		//file logger
		$this->file_log = APPPATH.'logs/fms/log.txt';
		
		//params from fms
		$this->params   = array(
						'performerId'	=> 'performer_id',
						'pasword'		=> 'password',
						'mess'			=> 'messages',
		);		
	}
	
	/**
	 * Log controller
	 */
	function index(){
		
		$this->write_request($this->file_log, NULL, TRUE, FALSE);
		
		$data 		= $this->fms->generate_params($this->params,TRUE);	 
		
		//verify performer credentials
		$this->load->model('performers');
		$performer = $this->performers->get_one_by_id($data['performer_id']);
		
		//performerul nu exista
		if( ! $performer ){
			$this->write_request($this->file_log, 'status=deny&log=invalid_performer_id', FALSE, TRUE);
		}

		if( $performer->password !== $data['password']){
			$this->write_request($this->file_log, 'status=deny&log=invalid_credentials', FALSE, TRUE);
		}
		
		if(strlen($data['messages']) < 4) return;
		
		$this->load->model('chat_logs');
		$this->chat_logs->add($data['performer_id'],time(),trim($data['messages']));
		
		$this->write_request($this->file_log, 'status=ok', FALSE, TRUE);
	}
	
}