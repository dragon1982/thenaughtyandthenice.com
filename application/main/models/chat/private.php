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
//e privat deoarece cuvantu private e rezervat
class Privat extends Chats{
	
	public  $chat_type;
	private $tax_data;
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Constructor
	 * @param $user
	 * @param $performer
	 * @param $watcher
	 */
	function __construct($user,$performer = FALSE,$watcher = FALSE,$tax_data = FALSE, $true_private = FALSE){
		$this->CI 			= &get_instance();
		$this->CI->load->model('users');
		$this->user 		= $user;
		$this->performer 	= $performer;
		$this->watcher		= $watcher;
		$this->tax_data		= $tax_data;
		$this->chat_type	= ( $true_private ) ? 'true_private' : 'private'; 
		
		$this->CI->load->model('watchers');			
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Verifica daca userul poate intra in privat
	 * - nu are alte sessiuni deschise
	 * - are destui bani
	 * - e approved
	 * - nu e banat
	 * @TUTORIAL - can vrea sa intre din alt tip de chat in privat trebuie sa il las sa aiba o sessiune deschisa
	 */
	function can_start_session($allow_opened_sessions = FALSE){
					
		$active_session = $this->CI->watchers->get_one_active_session_by_user_id($this->user->id);
		//useril are deja un chat deschis
		if( $this->user->id && $active_session && ! $allow_opened_sessions ){
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
		
		
		if( $this->CI->watchers->check_user_for_ban_by_performer_id($this->user->id,$this->performer->id,FALSE) ){
			return FALSE;
		}
		
		return TRUE;				
		
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Inchide sessiunea de chat la user
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
		if( $this->watcher->show_is_over == 1 ){
			return FALSE;		
		}

		//verific daca nu cumva sia schimbat statusul intre timp
		if( $this->watcher->type != 'private' && $this->watcher->type != 'true_private' ){			
			if($this->tax_data['true_private']) {
				$this->create_empty_session($this->watcher,'true_private');
			} else {
				$this->create_empty_session($this->watcher,'private');
			}	

			$this->end_session();		
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
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Returneaza costul/minut
	 * @return unknown_type
	 */
	function get_fee_per_minute(){
		if(isset($this->watcher->fee_per_minute))		
			return $this->watcher->fee_per_minute;

		if( $this->chat_type == 'private'){
			if( isset($this->performer->private_chips_price) ){
				return $this->performer->private_chips_price;
			}
		} else {
			if( isset($this->performer->true_private_chips_price) ){
				return $this->performer->true_private_chips_price;
			}			
		}
	}
}