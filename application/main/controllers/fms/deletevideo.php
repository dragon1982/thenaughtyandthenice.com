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
 * @property Performers_videos $performers_videos
 * @property Fms $fms
 */
class Deletevideo_controller extends MY_FMS{
		
	var $file_log;
	var $params; 
	private $user_type;
	
	// --------------------------------------------------------------------------
	/*
	 * Constructor
	 */	
	function __construct(){
		parent::__construct();
		$this->load->helper('generic');
		$this->load->model('fms');
		$this->load->model('performers_videos');		
		//file logger
		$this->file_log = APPPATH.'logs/fms/deletevideo.txt';
				
		//params from fms
		$this->params   = array(
					'performerId'	=> 'performer_id',
					'userId'		=> 'user_id',
					'userType'		=> 'user_type',					
					'uniqId'		=> 'unique_id',
					'pasword'		=> 'password',
					'lengt'			=> 'length',
					'flvName'		=> 'flv_name'		
		);				
	}
	
	
	// --------------------------------------------------------------------------
	/**
	 * 
	 * @author Baidoc
	 */
	function index(){		
		$this->write_request($this->file_log, NULL, TRUE, FALSE);
						
		$data = $this->fms->generate_params($this->params,TRUE);		

		//sa pot face diferenta pe viitor intre user/admin/studio
		$saved_user = $this->input->get_post('userId');
				
		$user = $this->get_login_credentials($saved_user,$data['user_id']);
		
		//date de login invalide
		if( $user->password !== $data['password']){
			$this->write_request($this->file_log,'status=deny&log=invalid_credentials',FALSE, TRUE);
		}
		
		//userul nu e activ
		if( $user->status !== 'approved'){
			$this->write_request($this->file_log, 'status=deny&log=user_got_susspended', FALSE, TRUE);
		}		
		
		//daca e perforemr verific si daca e chiar videoul lui
		if( $this->user_type == 'performer' && $user->id != $data['performer_id']){
			$this->write_request($this->file_log, 'status=deny&log=you_are_kidding', FALSE, TRUE);
		}

		//daca e studio iau performerul pt studiou respectiv
		if( $this->user_type == 'studio' ){
			$this->load->model('performers');
			$performer = $this->performers->get_one_by_id($data['performer_id']);
			
			//nu exista performerul cerut
			if( ! $performer ){
				$this->write_request($this->file_log, 'status=deny&log=invalid_performer_id', FALSE, TRUE);
			}
			
			//performerul nu apaartine studioului
			if( $performer->studio_id != $user->id ){
				$this->write_request($this->file_log, 'status=deny&log=get_a_life', FALSE, TRUE);
			}
		}
		
		$video = $this->performers_videos->get_one_by_flv_name($data['flv_name'],$data['performer_id']);
						
		//inexistent video		
		if( ! $video ){			
			$this->write_request($this->file_log, 'status=deny&log=invalid_flv_name', FALSE, TRUE);
		}

		$this->performers_videos->delete_one_by_id($video->video_id);				
		$this->write_request($this->file_log, 'status=allow', FALSE, TRUE);	
		
	}
	
	// --------------------------------------------------------------------------	
	/**
	* Returneaza detaliile userului logat
	* @param $saved_user
	* @param $user_id
	* @return object
	*/
	protected function get_login_credentials($saved_user,$user_id){
		if(substr($saved_user,0,1) == 'a'){
			$this->user_type = 'admin';
			$this->load->model('admins');
			return $this->admins->get_one_by_id($user_id);
		}
	
		if(substr($saved_user,0,1) == 's'){
			$this->user_type = 'studio';
			$this->load->model('studios');
			return $this->studios->get_one_by_id($user_id);
		}
		
		$this->user_type = 'performer';
		$this->load->model('performers');
		return $this->performers->get_one_by_id($user_id);
	
	}	
}