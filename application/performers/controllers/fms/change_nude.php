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
Class Change_nude_controller extends MY_FMS_Free{
	
	var $file_log;
	var $params; 
	
	/*
	 * Constructor
	 */
	function __construct(){		
		parent::__construct();
		$this->load->helper('generic');
		$this->load->model('fms');
		
		$this->types = array(	
								1	=>	'free',
								2	=>	'nude',
								3	=>	'private'
							);
		
		//file logger
		$this->file_log = APPPATH.'logs/fms/change_nude.txt';
						
		//params from fms
		$this->params   = array(
					'chatType'		=> 'chat_type',
					'label'			=> 'label',
					'userType'		=> 'user_type',
					'fmsId'			=> 'fms_id',
					'pasword'		=> 'password',
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
		
		//nu am putut sa adaug in DB sessiunea de watcher
		if( ! $this->performers->update($user->id,array('is_online'=>1,'fms_id'=>$data['fms_id'],'is_online_type'=>$this->types[$data['chat_type']])) )
		{
			$this->write_request($this->file_log, 'status=deny&log=database_error_please_retry', FALSE, TRUE);			
		}
		
		$this->write_request($this->file_log, 'status=allow&log='.$this->types[$data['chat_type']], FALSE, TRUE);			
	}
}