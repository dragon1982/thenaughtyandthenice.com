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

Class EndSession_controller extends MY_FMS{
	
	var $file_log;
	var $params; 
	var $types = array(
						'free' 		=> 'public',
						'nude'		=> 'private_public',
						'private'	=> 'private',
						'true_private'=> 'private',
						'spy'		=> 'spy',
						'peek'		=> 'peek'
	); 
	
	/**
	 * Constructor 
	 */
	function __construct(){		
		parent::__construct();
		$this->load->helper('generic');
		$this->load->model('fms');
		
		//file logger
		$this->file_log = APPPATH.'logs/fms/end_session.txt';
		
		
		
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
	 * End session function
	 */
	function index(){
		$this->write_request($this->file_log, NULL, TRUE, FALSE); 
		
		$data = $this->fms->generate_params($this->params,TRUE);
				
		if( $data['user_type'] == 'performer' ){
			return $this->performer($data);
		}
		
		//verify user credentials
		$this->load->model('watchers');
		
		$watcher = $this->watchers->get_one_by_unique_id($data['unique_id'],TRUE);
		
		//sessiunea de watcher nu exista
		if( ! $watcher ){
			$this->write_request($this->file_log, 'status=deny&log=watcher_not_found', FALSE, TRUE);
		}
		
		
		//doar userii logati au date de autentificare 
		if( $data['user_id'] > 0){
			//date de login invalide
			if( $watcher->password !== $data['password']){
				$this->write_request($this->file_log,'status=deny&log=invalid_credentials',FALSE, TRUE);
			}
		}
		
		//sessiunea a fost inchisa deja
		if( $watcher->show_is_over ){
			$this->write_request($this->file_log, 'status=deny&log=watcher_already_dead', FALSE, TRUE);
		}
		
		require_once APPPATH.'models/chat/chats.php';
		$chat = Chats::get_instance($this->types[$watcher->type],FALSE,FALSE,$watcher);
		
		$chat->end_session();
		
		$this->system_log->add(
            			'user', 
            			$watcher->user_id,
            			'user', 
            			$watcher->user_id, 
            			'end_chat', 
            			sprintf('User has spent %s credits.', $watcher->user_paid_chips), 
            			time(), 
            			ip2long($this->input->ip_address()),
            			$watcher->id
					);
		$this->write_request($this->file_log, 'status=ok&log=closed', FALSE, TRUE);
	}
	
	/**
	 * Inchid sessiunea unui performer
	 * @param $data
	 * @return unknown_type
	 */
	function performer($data){
		
		$this->load->model('performers');
		
		$performer = $this->performers->get_one_by_id($data['performer_id']);
		
		if( ! $performer ){
			$this->write_request($this->file_log, 'status=deny&log=invalid_performer', FALSE, TRUE);	
		}
		
		if( $performer->password !== $data['password'] ){
			$this->write_request($this->file_log, 'status=deny&log=invalid_credentials', FALSE, TRUE);
		}
		
		$changes['is_online'] 			= 0;
		$changes['is_online_hd']		= 0;
		$changes['is_in_private']		= 0;
		$changes['is_online_type'] 		= NULL;
		$changes['fms_id']				= NULL;
		$changes['enable_peek_mode']	= 1;
		
		$this->performers->update($data['performer_id'],$changes);

		$this->load->model('fms');
		$this->fms->add_hosted_performer($performer->fms_id,-1);
		
		$this->write_request($this->file_log, 'status=ok&log=performer_went_offline', FALSE, TRUE);
	}
}