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
class Spy extends Chats{
	
	public $chat_type = 'spy';
	
	// -----------------------------------------------------------------------------------------	
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
	
	
	// -----------------------------------------------------------------------------------------			
	/**
	 * Verifica daca poate incepe o sessiune noua
	 * @tutorial - performerul trebuie sa apartina de studio?! :)
	 * @see application/main/models/chat/Chats#can_start_session()
	 */
	function can_start_session(){
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
		return TRUE;
	}
	
	
	// -----------------------------------------------------------------------------------------			
	/**
	 * Taxeaza o sessiune (e free)
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