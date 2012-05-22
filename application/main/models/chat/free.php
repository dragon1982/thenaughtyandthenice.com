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
class Free extends Chats{
	
	public $chat_type = 'free';
		
	// -----------------------------------------------------------------------------------------		
	/**
	 * Constructor
	 * @param $user
	 * @param $performer
	 * @param $watcher
	 */
	function __construct($user,$performer = FALSE,$watcher = FALSE,$tax_data = FALSE){
		$this->CI 			= &get_instance();
		$this->CI->load->model('users');
		$this->user 		= $user;
		$this->performer 	= $performer;
		$this->watcher		= $watcher;	
	}
	
	// -----------------------------------------------------------------------------------------		
	/*
	 * Verifica daca un user poate intra in free chat
	 */
	function can_start_session(){

		$this->CI->load->model('watchers');
		
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
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Inchidere sessiune
	 * (non-PHPdoc)
	 * @see application/main/models/chat/Chats#end_session()
	 */
	function end_session(){
		$this->end_session_free($this->watcher);
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * (non-PHPdoc)
	 * @see web/application/performers/models/chat/Chats#can_continue_session()
	 */
	function can_continue_session(){
		
		if( $this->watcher->user_id > 0 ){//logged user
			
			if($this->watcher->credits > 0){//cu credits
				if( $this->watcher->duration > FREE_CHAT_LIMIT_LOGGED_WITH_CREDITS){
					return FALSE;
				}
			} else {//fara credite
				if( $this->watcher->duration > FREE_CHAT_LIMIT_LOGGED_NO_CREDITS){
					return FALSE;
				}				
			}
		} else {//user nelogat
			if($this->watcher->duration > FREE_CHAT_LIMIT_NOTLOGGED){
				return FALSE;
			}
			
		}
		
		return TRUE;
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * (non-PHPdoc)
	 * @see application/main/models/chat/Chats#tax_session()
	 */
	function tax_session(){		
		$this->CI->load->model('watchers');
		$data['duration']	= time() - $this->watcher->start_date;
		$data['end_date']	= time();
		
		//update the data
		$this->CI->watchers->update($this->watcher->id,$data);
		
		$this->update_watcher($data);	
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Returneaza costul/minut
	 * @return unknown_type
	 */
	function get_fee_per_minute(){
		return 0;
	}
}