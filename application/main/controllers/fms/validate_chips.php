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
 * @property System_logs $system_logs
 * @property Watchers $watchers
 */
class Validate_chips_controller extends MY_FMS{
	
	var $file_log;
	var $params; 
		
	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		
		$this->load->helper('generic');
		$this->load->model('fms');
		
		//file logger
		$this->file_log = APPPATH.'logs/fms/validate_chips.txt';
		
		//params from fms
		$this->params   = array(
					'ip'			=> 'ip',
					'userId'		=> 'user_id',
					'userName'		=> 'username',
					'userType'		=> 'user_type',
					'pasword'		=> 'password',
					'performerId'	=> 'performer_id',
					'uniqId'		=> 'unique_id' 
		);		
	}
	
	/**
	 * Verifica daca poate intra in private chat din alt tip de chat
	 */
	function index(){
		$this->write_request($this->file_log, NULL, TRUE, FALSE); 
		
		$data = $this->fms->generate_params($this->params,TRUE);
				
		//verify user credentials
		$this->load->model('users');
		
		$user = $this->users->get_one_by_id($data['user_id']);
		
		if( ! $user ){
			$this->write_request($this->file_log,'status=deny&log=invalid_credentials',FALSE, TRUE);
		}

		//date de login invalide
		if( $user->password !== $data['password']){
			$this->write_request($this->file_log,'status=deny&log=invalid_credentials',FALSE, TRUE);
		}
			
		//verify performer credentials
		$this->load->model('performers');
		$performer = $this->performers->get_one_by_id($data['performer_id']);
		
		//performerul nu exista
		if( ! $performer ){
			$this->write_request($this->file_log, 'status=deny&log=invalid_performer_id', FALSE, TRUE);
		}		
		
		//doar in privat se apeleaza controllerul curent
		require_once APPPATH.'models/chat/chats.php';
		$chat = Chats::get_instance('private',$user,$performer);
		
		if( ! $chat->can_start_session(TRUE) ){
			$this->write_request($this->file_log, 'status=deny&log=no_access', FALSE, TRUE);						
		}
		
		//@TODO: sa blokez floodu de requesturi
		
		$this->write_request($this->file_log, 'status=allow', FALSE, TRUE);
	}
} 