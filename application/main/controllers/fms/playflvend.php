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
 * @property Performers_videos $performers_videos
 * @property Studios $studios
 * @property Watchers $watchers
 * @property System_logs $system_logs
 */

class Playflvend_controller extends MY_FMS{
	
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
		$this->file_log = APPPATH.'logs/fms/playflvend.txt';
		
		//params from fms
		$this->params   = array(
						'userId'		=> 'user_id',
						'userName'		=> 'username',
						'performerId'	=> 'performer_id',
						'pasword'		=> 'password',
						'ip'			=> 'ip',
						'videoId'		=> 'video_id',
						'performerId'	=> 'performer_id',
						'uniqId'		=> 'unique_id'		
		);		
				
	}
	
	function index(){
		$this->write_request($this->file_log, NULL, TRUE, FALSE);
		
		$data 		= $this->fms->generate_params($this->params,TRUE);
		
		//verify user credentials
		$this->load->model('users');
		
		$user = $this->users->get_one_by_id($data['user_id']);
		
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
		
		$watcher = $this->watchers->get_one_by_unique_id($data['unique_id']);
		
		if( ! $watcher ){
			$this->write_request($this->file_log, 'status=deny&log=watcher_doesnt_exist', FALSE, TRUE);							
		}
		
		if( ! $this->watchers->update($watcher->id,array('show_is_over'=>1,'end_date'=>time()))){
			$this->write_request($this->file_log, 'status=deny&log=database_error', FALSE, TRUE);
		}
		
		$this->write_request($this->file_log, 'status=ok', FALSE, TRUE);
	}
}