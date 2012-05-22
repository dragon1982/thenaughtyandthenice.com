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
 * @property Fms	$fms
 * @property Watchers $watchers
 */

Class Auth_controller extends MY_FMS{
	
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
		$this->file_log = APPPATH.'logs/fms/auth.txt';
				
		//params from fms
		$this->params   = array(
					'ip'			=> 'ip',
					'userId'		=> 'user_id',
					'userName'		=> 'username',
					'userType'		=> 'user_type',
					'pasword'		=> 'password',
					'performerId'	=> 'performer_id',
					'uniqId'		=> 'unique_id',
					'userType'		=> 'user_type',
					'sessionType'	=> 'session_type',
					'truePrivate'	=> 'true_private'
		);
	}
	
	/**
	 * User AUTH
	 */
	function index(){
		$this->write_request($this->file_log, NULL, TRUE, FALSE); 
		
		//sa pot face diferenta pe viitor intre user/admin/studio
		$saved_user = $this->input->get_post('userId');
		
		$data = $this->fms->generate_params($this->params,TRUE);
						
		$this->load->model('users');		
		$user = $this->get_login_credentials($saved_user,$data['user_id']);
		
		//verific daca exista deja session idu
		$this->load->model('watchers');		
		$watcher = $this->watchers->get_one_by_unique_id($data['unique_id']);
		if( $watcher ){
			$this->write_request($this->file_log,'status=deny&log=session_already_exists',FALSE, TRUE);			
		}
		
		
		// nu exista userul
		if( ! $user ){
			
			if(is_integer($data['user_id']))//userul e definit corect(intreg) dar nu exista in db
			{
				$this->write_request($this->file_log, 'status=deny&log=invalid_user_id', FALSE, TRUE);				
			} 
			else //userul e anonim nu e logat 
			{
				//userul e anonim, nu exista, creez un obiect virtual/temporar sa tina loc de $user pentru a putea trece de filtre
				$user = $this->users->create_virtual_user($data['username'],$data['password'],'approved');
			}
		}
		
		//date de login invalide
		if( $user->password !== $data['password']){
			$this->write_request($this->file_log,'status=deny&log=invalid_credentials',FALSE, TRUE);
		}

		//userul nu e activ
		if( $user->status !== 'approved'){
			$this->write_request($this->file_log, 'status=deny&log=user_got_susspended', FALSE, TRUE);
		}
		
		//verify performer credentials
		$this->load->model('performers');
		$performer = $this->performers->get_one_by_id($data['performer_id']);

		//performerul nu exista
		if( ! $performer ){
			$this->write_request($this->file_log, 'status=deny&log=invalid_performer_id', FALSE, TRUE);
		}
		
		if( $data['user_type'] == 'spy' )$data['session_type'] = 'spy';  
		
		$this->load->config('others');		
		if( ! in_array($data['session_type'],$this->config->item('session_types'))){
			$this->write_request($this->file_log, 'status=deny&log=invalid_session_type ' . $data['session_type'], FALSE, TRUE);
		}
		
		if($data['true_private'] == 'true'){
			$data['true_private'] = TRUE;
		}
		
		require_once APPPATH.'models/chat/chats.php';
		$chat = Chats::get_instance($data['session_type'],$user,$performer,FALSE,FALSE,$data['true_private']);		
		
		
		//nu poate sa inceapa o sessiune noua
		if( ! $chat->can_start_session()){
			$this->write_request($this->file_log, 'status=deny&log=user_has_another_chat_opened_or_no_credits', FALSE, TRUE);
		}
		
		if( $data['true_private'] ){
			$this->performers->update($performer->id,array('enable_peek_mode'=>0));
		}
		
		if( $data['user_type'] == 'spy' ){
			$watcher = array(
				'start_date'		=> time(),
				'type'				=> $chat->chat_type,
				'ip'				=> ip2long($data['ip']),
				'fee_per_minute'	=> $chat->get_fee_per_minute(),
				'unique_id'			=> $data['unique_id'],
				'username'			=> $user->username,
				'studio_id'			=> $performer->studio_id,
				'performer_id'		=> $performer->id,		
			);			
		} else {			
			$watcher = array(
				'start_date'		=> time(),
				'type'				=> $chat->chat_type,
				'ip'				=> ip2long($data['ip']),
				'fee_per_minute'	=> $chat->get_fee_per_minute(),
				'unique_id'			=> $data['unique_id'],
				'user_id'			=> $user->id,
				'username'			=> $user->username,
				'studio_id'			=> $performer->studio_id,
				'performer_id'		=> $performer->id,		
			);
		}
		
		//nu am putut sa adaug in DB sessiunea de watcher
		if( ! $this->watchers->add($watcher) )
		{
			$this->write_request($this->file_log, 'status=deny&log=database_error_please_retry', FALSE, TRUE);			
		}
		
		/** ONLY IF NEEDED 
		if( $data['user_type'] == 'viewer' ){
			$this->write_request($this->file_log, 'status=allow&allowChat=' . (($user->credits > 0) ? 1 : 0) , FALSE, TRUE);			
		} else {
			$this->write_request($this->file_log, 'status=allow', FALSE, TRUE);
		}
		*/
		
		$this->write_request($this->file_log, 'status=allow&allowChat=1', FALSE, TRUE);
								
	}
	
	/**
	 * Returneaza detaliile userului logat 
	 * @param $saved_user
	 * @param $user_id
	 * @return object
	 */
	protected function get_login_credentials($saved_user,$user_id){
		if(substr($saved_user,0,1) == 's'){
			$this->load->model('studios');
			return $this->studios->get_one_by_id($user_id);
		}

		if(substr($saved_user,0,1) == 'a'){
			$this->load->model('admins');
			return $this->admins->get_one_by_id($user_id);
		}
		
		$this->load->model('users');
		return $this->users->get_one_by_id($user_id);
	}
}