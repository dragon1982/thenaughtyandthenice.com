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
 * @property Fms $fms
 */

Class Banmanager_controller extends MY_FMS{
	
	var $file_log;
	var $params; 
	protected $user_type;
	
	/*
	 * Constructor
	 */
	function __construct(){		
		parent::__construct();
		$this->load->helper('generic');
		$this->load->model('fms');
		
		//file logger
		$this->file_log = APPPATH.'logs/fms/banmanager.txt';
				
		//params from fms
		$this->params   = array(
					'ip'			=> 'ip',
					'bannedUserId '	=> 'banned_user_id',
					'userId'		=> 'user_id',
					'pasword'		=> 'password',
					'performerId'	=> 'performer_id',
		);
	}
	
	/**
	 * Banmanager
	 */
	function index(){
		$this->write_request($this->file_log, NULL, TRUE, FALSE); 
		
		$data = $this->fms->generate_params($this->params,TRUE);

		$user = $this->get_login_credentials($this->input->post('userId'));
		if( ! $user) {
			$this->write_request($this->file_log, 'status=deny&log=invalid_user_id', FALSE, TRUE);				
		}
		
		if( $user->password != $data['password'] ){
			$this->write_request($this->file_log, 'status=deny&log=bad_credentials', FALSE, TRUE);
		}
				
		$data['banned_user_id'] = substr($this->input->post('bannedUserId'),1);
		
		//verify user credentials
		$this->load->model('watchers');
		
		$change['was_banned']		= 1;
		$change['ban_date']			= time();
		$change['ban_expire_date']	= time() + BAN_EXPIRE_DATE;
		
		//userul e logat
		if($data['banned_user_id']){
			
			$sessions = $this->watchers->get_multiple_by_user_id($data['banned_user_id']);
			if(sizeof($sessions) == 0){
				return;
			}

			$this->system_log->add(
				$this->user_type,
				$user->id,
				'user', 
				$data['banned_user_id'],
				'ban', 
				'User got banned', 
				time(),
				ip2long($data['ip'])
			);							
		} 
		else
		{//usserul nu e logat, il banez dupa ip
			
			$sessions = $this->watchers->get_multiple_active_by_ip($data['ip']);
			if(sizeof($sessions) == 0){
				return;
			}			
		}
		
		//adaug in toate sessiunile banu
		foreach($sessions as $session){
			$this->watchers->update($session->id,$change);
		}

		$this->write_request($this->file_log, 'status=ok', FALSE, TRUE);
	}
	
	
	/**
	* Returneaza detaliile userului logat
	* @param $saved_user
	* @param $user_id
	* @return object
	*/
	protected function get_login_credentials($user_id){
		if(substr($user_id,0,1) == 's'){
			$this->user_type = 'studio';
			$this->load->model('studios');
			return $this->studios->get_one_by_id(substr($user_id,1));
		}
		
		if(substr($user_id,0,1) == 'a'){
			$this->user_type = 'admin';
			$this->load->model('admins');
			return $this->admins->get_one_by_id(substr($user_id,1));
		}
		
		$this->user_type = 'performer';
		$this->load->model('performers');
		return $this->performers->get_one_by_id($user_id);
	}	
	
}
		