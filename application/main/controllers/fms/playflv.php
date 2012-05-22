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

Class Playflv_controller extends MY_FMS{
	
	
	var $file_log;
	var $params; 
	var $is_user = FALSE;
	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		
		$this->load->helper('generic');
		$this->load->model('fms');
		$this->load->model('watchers');
		
		//file logger
		$this->file_log = APPPATH.'logs/fms/playfile.txt';
		
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
		
		//sa pot face diferenta pe viitor intre user/admin/studio
		$saved_user = $this->input->get_post('userId');
		
		$data = $this->fms->generate_params($this->params,TRUE);
							
		$this->load->model('users');		
		$user = $this->get_login_credentials($saved_user,$data['user_id']);
		
		//verify user credentials
		$this->load->model('users');
				
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
		
		$this->load->model('performers_videos');
		
		$video_details = $this->performers_videos->get_one_by_id($data['video_id'],TRUE);
		
		if( ! $video_details ){
			$this->write_request($this->file_log, 'status=deny&log=invalid_video_id', FALSE, TRUE);			
		}
		
		require_once APPPATH.'models/video/videos.php';
		$video = Videos::get_instance($user,$video_details);
		
		//daca e int inseamna ca e user, daca nu are un prefix in fata
		if(  $this->is_user ){
			
			//nu poate sa inceapa o sessiune noua
			if( ! $video->can_start_video()){
				$this->write_request($this->file_log, 'status=deny&log=user_has_another_chat_opened_or_no_credits', FALSE, TRUE);
			}
		}
		
		$this->write_request($this->file_log, 'status=allow&videoName=' . $video_details->flv_file_name, FALSE, TRUE);		
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
		
		if(substr($saved_user,0,1) == 'p'){
			$this->load->model('performers');
			return $this->performers->get_one_by_id($user_id);
		}		

		if(substr($saved_user,0,1) == 'a'){
			$this->load->model('admins');
			return $this->admins->get_one_by_id($user_id);
		}
		
		$this->is_user = TRUE;
		$this->load->model('users');
		return $this->users->get_one_by_id($user_id);
		
	}	
} 