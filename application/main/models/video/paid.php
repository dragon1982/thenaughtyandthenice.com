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
class Paid extends Videos{
	
	public $video_type 		= 1;
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
	function __construct($user,$video){
		$this->CI 			= &get_instance();
		$this->user 		= $user;
		$this->video		= $video;
		$this->CI->load->model('watchers');	
	}
	
	/**
	 * Verifica daca userul a platit deja videoul
	 * @return unknown_type
	 */
	function has_paid_video(){		
		
		$is_paid = $this->CI->watchers->get_multiple_by_user_id($this->user->id,1,FALSE,array('is_paid'=>1,'performer_video_id'=>$this->video->video_id));
		
		if( sizeof($is_paid) >= 1 ){
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * Verifica daca poate sa vada videoul
	 * @return unknown_type
	 */
	function can_start_video(){

		//daca e deja platit
		if( ! $this->has_paid_video() ){
			return FALSE;
		}
				
		return TRUE;				
	}
	
}