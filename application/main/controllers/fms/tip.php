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
class Tip_controller extends MY_FMS{
	
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
		$this->file_log = APPPATH.'logs/fms/tip.txt';
		
		//params from fms
		$this->params   = array(
						'userId'		=> 'user_id',
						'pasword'		=> 'password',
						'performerId'	=> 'performer_id',
						'amount'		=> 'amount',
						'uniqId'		=> 'unique_id'
						
		);
	}

	/**
	 * User TIP
	 */
	function index(){
		$this->write_request($this->file_log, NULL, TRUE, FALSE); 
				
		$data = $this->fms->generate_params($this->params,TRUE);
				
		//verify user credentials
		$this->load->model('users');
		
		$user = $this->users->get_one_by_id($data['user_id']);
		
		// nu exista userul
		if( ! $user ){
			$this->write_request($this->file_log, 'status=deny&log=invalid_user_id', FALSE, TRUE);				
		}
		
		//date de login invalide
		if( $user->password !== $data['password']){
			$this->write_request($this->file_log,'status=deny&log=invalid_credentials',FALSE, TRUE);		
		}
		
		$watcher = $this->watchers->get_one_by_unique_id($data['unique_id'],TRUE);
		
		if( ! $watcher ){
			$this->write_request($this->file_log,'status=deny&log=invalid_credentials',FALSE, TRUE);
		}
		
		require_once APPPATH.'models/chat/chats.php';
		$chat = Chats::get_instance('public', FALSE, FALSE, $watcher);
		
		if( ! $chat->can_tip_performer($data['amount'])){
			$this->write_request($this->file_log,'status=deny&messageIndex=2&log=bad_credentials',FALSE, TRUE);
		}
		
		$aux = $chat->get_slices($data['amount'],$watcher);
		$data['performer_chips']	= $aux['performer_chips'];
		$data['studio_chips']		= $aux['studio_chips'];
		$data['site_chips']			= $aux['site_chips'];
		
		$w = array(
			'type'				=> 'gift',
			'start_date'		=> time(),
			'end_date'			=> time(),
			'show_is_over'		=> 1,
			'fee_per_minute'	=> NULL,
			'unique_id'			=> $this->watchers->generate_one_unique_id(),
			'user_id'			=> $user->id,
			'user_paid_chips'	=> $data['amount'],
			'performer_chips'	=> $data['performer_chips'],
			'studio_chips'		=> $data['studio_chips'],
			'site_chips'		=> $data['site_chips'],
			'username'			=> $user->username,
			'studio_id'			=> $watcher->studio_id,
			'performer_id'		=> $watcher->performer_id,		
		);
		
		$this->db->trans_start();

		if($data['studio_chips'] > 0){
			$this->load->model('studios');
			$this->studios->add_credits($watcher->studio_id,$data['studio_chips']+$data['performer_chips']);
		}
		
		$this->load->model('performers');
		$this->performers->add_credits($watcher->performer_id,$data['performer_chips']);
		
		$this->users->add_credits($user->id,-$data['amount']);
		
				
		$this->watchers->add($w);
		

		if($this->db->trans_status() == FALSE){
			
			//fac rollback la date
			$this->db->trans_rollback();
			
			$this->write_request($this->file_log, 'status=deny', FALSE, TRUE);
		}		
		
		$this->db->trans_commit();
		$this->write_request($this->file_log, 'status=ok', FALSE, TRUE);
	}	
	
}