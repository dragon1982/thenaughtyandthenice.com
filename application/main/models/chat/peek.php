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
class Peek extends Chats{
	
	public $chat_type = 'peek';
	
	/**
	 * Constructor, initializeaza clasa
	 * @param $user
	 * @param $details
	 */
	function __construct($user,$performer = FALSE,$watcher = FALSE){
		$this->CI 			= &get_instance();
		$this->CI->load->model('users');
		$this->CI->load->model('watchers');
		$this->user 		= $user;
		$this->performer 	= $performer;		
		$this->watcher		= $watcher;
	}
	
	/**
	 * Verifica daca userul poate porni un peek chat
	 * @tutorial - trebuie ca performerul sa accepte peek mode
	 * @tutorial - user aprooved
	 * @see application/main/models/chat/Chats#can_start_session()
	 */
	function can_start_session($allow_opened_sessions = FALSE){
			
		//performerul nu accepta peek chat
		if( ! $this->performer->enable_peek_mode ){
			return FALSE;
		}
				
		$active_session = $this->CI->watchers->get_one_active_session_by_user_id($this->user->id);
				
		//useril are deja un chat deschis
		if( $this->user->id && $active_session && ! $allow_opened_sessions  ){
			return FALSE;	
		}
		
		$credits = $this->user->credits;
		if( $active_session ){
			$credits -= $active_session->user_paid_chips;
		}
		
		//nu are destui bani pt a plati
		if( $credits <  $this->get_fee_by_duration(1,$this->get_fee_per_minute()) ){
			return FALSE;
		}
		
		//verifica daca userul are ban
		if( $this->CI->watchers->check_user_for_ban_by_performer_id($this->user->id,$this->performer->id,FALSE) ){
			return FALSE;
		}					
		
		//verifica daca sa depasit limita de performeri din chat
		if( $this->performer->max_nude_watchers >= $this->CI->watchers->get_multiple_by_performer_id($this->performer->id,FALSE,FALSE,array('type'=>'peek','show_is_over'=>0),TRUE)){	
			return FALSE;
		}
		
		return TRUE;		
	}
	
	/**
	 * Inchidere sessiune
	 * (non-PHPdoc)
	 * @see application/main/models/chat/Chats#end_session()
	 */
	function end_session(){
		$this->end_session_paid($this->watcher);
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Verifica daca userul indeplineste conditiile sa continue chatul
	 *  - are destui bani
	 *  - e approved
	 *  - nu ia fost pusa sessiunea pe closed
	 */
	function can_continue_session(){
				
		if( $this->watcher->duration < MINIMUM_PAID_CHAT_TIME ){
			return TRUE;
		}
				
		//mai are mai putin de 10 secunde de chat .. il dau afara
		if( ( $this->watcher->credits - $this->watcher->user_paid_chips ) < ($this->get_fee_per_minute() / 6) ){
			return FALSE;
		}
		
		//showul e gata
		if( $this->watcher->show_is_over ){
			return FALSE;		
		}
		
		return TRUE;		
	}
	
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Taxeaza o sessiune
	 * @see application/main/models/chat/Chats#tax_session()
	 */
	function tax_session(){
		$this->CI->load->model('watchers');
		$data['duration']			= time() - $this->watcher->start_date;
		$data['end_date']			= time();
		$data['user_paid_chips']	= $this->get_fee_by_duration($data['duration'],$this->get_fee_per_minute());
		
		//adaug in aray valorile ce trebuie sa incaseze performerul si studioul
		$aux = $this->get_slices($data['user_paid_chips'],$this->watcher);
		$data['performer_chips']	= $aux['performer_chips'];
		$data['studio_chips']		= $aux['studio_chips'];
		$data['site_chips']			= $aux['site_chips'];
		
		//update the data
		$this->CI->watchers->update($this->watcher->id,$data);
		
		$this->update_watcher($data);	
	}
	
	/**
	 * Returneaza costul/minut
	 * @return unknown_type
	 */
	function get_fee_per_minute(){
		if(isset($this->watcher->fee_per_minute))		
			return $this->watcher->fee_per_minute;

		if(isset($this->performer->peek_chips_price))
			return $this->performer->peek_chips_price;		
	}
}