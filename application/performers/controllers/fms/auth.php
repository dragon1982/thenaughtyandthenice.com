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
					'userName'		=> 'username',
					'userType'		=> 'user_type',
					'pasword'		=> 'password',
					'fmsId'			=> 'fms_id', 
					'performerId'	=> 'performer_id'
		);
	}
	
	/**
	 * User AUTH
	 */
	function index(){
		$this->write_request($this->file_log, NULL, TRUE, FALSE); 
		
		$data = $this->fms->generate_params($this->params,TRUE);

		//verify user credentials
		$this->load->model('performers');
		
		$user = $this->performers->get_one_by_id($data['performer_id']);
				
		// nu exista userul
		if( ! $user ){			
			$this->write_request($this->file_log, 'status=deny&log=invalid_user_id', FALSE, TRUE);				
		}
		
		//date de login invalide
		if( $user->password !== $data['password']){
			$this->write_request($this->file_log,'status=deny&log=invalid_credentials',FALSE, TRUE);
		}
			
		//userul nu e activ
		if( $user->status !== 'approved'){
			$this->write_request($this->file_log, 'status=deny&log=user_got_susspended', FALSE, TRUE);
		}

		$changes['fms_id'] =$data['fms_id'];
		
		if( $data['user_type'] == 'fmle'){
			$changes['is_online_hd'] = 1;
		}
		//nu am putut sa adaug in DB sessiunea de watcher
		if( ! $this->performers->update($user->id,$changes))
		{
			$this->write_request($this->file_log, 'status=deny&log=database_error_please_retry', FALSE, TRUE);			
		}
		
		$this->load->model('fms');		
		$this->fms->add_hosted_performer($data['fms_id'],1);
		
		$this->write_request($this->file_log, 'status=allow', FALSE, TRUE);						
	}
}