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
 * @property FMS $fms
 * @property Users $users
 * @property Performers $performers
 * @property Studios $studios
 * @property Watchers $watchers
 * @property System_logs $system_logs
 */
class Tax_controller extends MY_FMS{
	
	var $file_log;
	var $params; 

	// -----------------------------------------------------------------------------------------	
	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		
		$this->load->helper('generic');
		$this->load->model('fms');
		$this->load->model('watchers');
		
		//file logger
		$this->file_log = APPPATH.'logs/fms/tax.txt';
		
		//params from fms
		$this->params   = array(
						'userId'		=> 'user_id',
						'pasword'		=> 'password',
						'userType'		=> 'user_type',
						'performerId'	=> 'performer_id',
						'truePrivate'	=> 'true_private',
						'sessionType'	=> 'session_type',
						'uniqId'		=> 'unique_id'		
		);
	}
	
	// -----------------------------------------------------------------------------------------		
	/*
	 * Functia de tax
	 */
	function index(){
		$this->write_request($this->file_log, NULL, TRUE, FALSE); 
		
		$data 		= $this->fms->generate_params($this->params,TRUE);	 
		$watcher 	= $this->watchers->get_one_by_unique_id($data['unique_id'],TRUE);
		
		if( ! $watcher ){			
			$this->write_request($this->file_log, 'status=deny&log=watcher_does_not_exist', FALSE, TRUE);
		}
				
		if( ! $watcher->performer_id ){
			$this->write_request($this->file_log, 'status=deny&log=invalid_performer_id', FALSE, TRUE);
		}
				
		if( ! $watcher->is_online ){
			$this->write_request($this->file_log, 'status=deny&log=performer_went_offline', FALSE, TRUE);
		}
				
		if( $watcher->status !== 'approved' ){
			$this->write_request($this->file_log, 'status=deny&log=user_got_susspended', FALSE, TRUE);
		}
		
		require_once APPPATH.'models/chat/chats.php';
		$chat = Chats::get_instance($data['session_type'],FALSE,$watcher,$watcher,$data);
				
		$chat->tax_session();		
		if( ! $chat->can_continue_session() ){
			$this->write_request($this->file_log, 'status=deny&log=out_of_credits', FALSE, TRUE);			
		}		
		
		if($data['session_type'] == 'private' && $watcher->is_online_type !== 'private'){
			$this->load->model('performers');
			$this->performers->update($watcher->performer_id,array('is_in_private'=>1,'is_online_type'=>'private'));					
		}
		
		$this->write_request($this->file_log, 'status=allow', FALSE, TRUE);										
	}
}