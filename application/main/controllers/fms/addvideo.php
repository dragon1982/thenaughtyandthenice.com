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
class Addvideo_controller extends MY_FMS{
		
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
		$this->file_log = APPPATH.'logs/fms/add_video_file.txt';
				
		//params from fms
		$this->params   = array(
					'performerId'	=> 'performer_id',
					'userId'		=> 'user_id',
					'userType'		=> 'user_type',					
					'uniqId'		=> 'unique_id',
					'pasword'		=> 'password',
					'lengt'			=> 'length',
					'fmsId'			=> 'fms_id',
					'flvName'		=> 'flv_name',
					'type'			=> 'type'		
		);		
	}
	
	/*
	 * Performer add video
	 */
	function index(){
		$this->write_request($this->file_log, NULL, TRUE, FALSE);

		$data = $this->fms->generate_params($this->params,TRUE);
		
		$this->load->model('performers');
		
		$performer = $this->performers->get_one_by_id($data['performer_id']);
		
		if( ! $performer ){
			$this->write_request($this->file_log,'status=deny&log=invalid_performer_id',FALSE, TRUE);			
		}
		
		if( $performer->password !== $data['password'] ){
			$this->write_request($this->file_log,'status=deny&log=invalid_credentials',FALSE, TRUE);			
		}
		
		if( $data['type'] == 'fmle'){
			$data['flv_name'] = 'mp4:' . $data['flv_name'] . '.f4v';
		}
		
		$this->load->model('performers_videos');
		
		$video_id = $this->performers_videos->add(
				$data['flv_name'],
				'',
				time(),
				$data['length'],
				$data['fms_id'],
				$data['performer_id']
		);
		
		$this->system_log->add(
			'performer', 
			$data['performer_id'],
		    'performer', 
			$data['performer_id'],
		    'add_video', 
			sprintf('Added video %s',$video_id),
			time(),
			ip2long($this->input->ip_address())
		);		
	}
	
}