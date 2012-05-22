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
class Free extends Videos{
	
	public $video_type 		= 0; // free/private
	public $has_paid 		= 0;
	public $user_paid_chips = 0;
	public $performer_chips = 0;
	public $studio_chips 	= 0;
	public $site_chips		= 0;		
		
	/**
	 * Constructor
	 * @param $user
	 * @param $performer
	 * @param $watcher
	 */
	function __construct($user,$performer = FALSE,$watcher = FALSE){
		$this->CI 			= &get_instance();
		$this->CI->load->model('users');
		$this->user 		= $user;
		$this->performer 	= $performer;
		$this->watcher		= $watcher;	
	}
	
	
	/**
	 * Verifica daca are deja un chat/video deschis
	 * @return unknown_type
	 */
	function can_start_video(){
		
		//pentru userii nelogati
		if( $this->user->id < 0  && $this->CI->watchers->get_one_active_session_by_ip($this->user->ip_address) ){
			return FALSE;			
		}
		
		//useril are deja un chat deschis
		if( $this->user->id && $this->CI->watchers->get_one_active_session_by_user_id($this->user->id) ){
			return FALSE;	
		}	
				
		return TRUE;				
	}
	
	
	/**
	 * Taxeaza userul
	 * @return unknown_type
	 */
	function tax(){
		return TRUE;
	}
}