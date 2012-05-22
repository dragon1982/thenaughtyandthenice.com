<?php
/**
 * 
 * @author Andrei
 *
 */
abstract class Chats{

	public $user;
	public $performer;
	public $watcher;	
	public $CI;
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Returneaza o instanta catre tipul de chat dorit
	 * @param $session_type
	 * @param $user
	 * @param $performer
	 * @param $tax_data - pentru tax sa vad daca sia schimbat tipul de chat
	 * @return unknown_type
	 */
	static function get_instance($session_type,$user,$performer = FALSE,$watcher = FALSE,$tax_data = FALSE,$true_private = FALSE){
		
		switch($session_type){
			case 'public':{
				require_once APPPATH.'models/chat/free.php';
				return new Free($user,$performer,$watcher,$tax_data);				
			}
			case 'private_public':{
				require_once APPPATH.'models/chat/nude.php';
				return new Nude($user,$performer,$watcher,$tax_data);							
			}
			case 'private':{
				require_once APPPATH.'models/chat/private.php';
				
				fwrite(fopen(APPPATH.'logs/tx.txt','a'),serialize($true_private));
				
				return new Privat($user,$performer,$watcher,$tax_data,$true_private);										
			}			
			case 'spy':{
				require_once APPPATH.'models/chat/spy.php';
				return new Spy($user,$performer,$watcher);							
			}
			case 'peek':{
				require_once APPPATH.'models/chat/peek.php';
				return new Peek($user,$performer,$watcher,$tax_data);							
			}						
		}
	} 
	
	// -----------------------------------------------------------------------------------------			
	/**
	 * Verifica daca un user poate face sau nu tip
	 * @param $amount
	 * @return unknown_type
	 */
	function can_tip_performer($amount){
		$this->CI = & get_instance();

		//mai are destule credite?
		if( $this->watcher->credits - $this->watcher->user_paid_chips - $this->watcher->fee_per_minute < $amount ){
			return FALSE;
		}
		
		return TRUE;
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Inchide sessiunea free a unui user
	 * @param $watcher
	 * @return unknown_type
	 */
	function end_session_free($watcher){
		$this->CI->load->model('watchers');
		$data['show_is_over'] 	= 1;
		$data['end_date']		= time();
		$data['duration']		= time() - $this->watcher->start_date;
		
		//update the data
		$this->CI->watchers->update($this->watcher->id,$data);		
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Inchide sessiunea platita a unui user 
	 * 
	 * @tutorial - trebuie scazute chipsurile de la user,adaugate chipsurile la performer si daca e cazu la studio 
	 *  
	 * @param $watcher
	 * @return unknown_type
	 */
	function end_session_paid($watcher){
		//trag bani de la user
		$this->CI->users->add_credits($this->watcher->user_id,-$this->watcher->user_paid_chips);

		if($this->watcher->studio_chips > 0){//trebuie si studiou sa isi ia partea
			
			$this->CI->load->model('studios');
			
			$this->CI->studios->add_credits($this->watcher->studio_id,$this->watcher->studio_chips+$this->watcher->performer_chips);
		}
		
		$this->CI->load->model('performers');
		$this->CI->performers->add_credits($this->watcher->performer_id,$this->watcher->performer_chips);
		
		//inchid sessiunea
		$this->CI->load->model('watchers');
		$data['show_is_over'] 	= 1;
		
		if($watcher->end_date == 0){
			$data['end_date'] = time();
		}
		
		//update the data
		$this->CI->watchers->update($this->watcher->id,$data);
	}	

	/**
	 * Creeaza o sessiune noua
	 * @param $watcher
	 * @param $type
	 * @return unknown_type
	 */
	function create_empty_session($watcher,$type = 'private'){
		$this->CI->load->model('performers');
		
		$this->CI->load->model('watchers');
		
		
		$w = array(
			'start_date'	=> time(),
			'fee_per_minute'=> $this->CI->performers->get_fee_per_minute($watcher,$type),
			'type'			=> $type,
			'unique_id'		=> $watcher->unique_id,
			'ip'			=> $watcher->ip,
			'user_id'		=> $watcher->user_id,
			'username'		=> $watcher->username,
			'studio_id'		=> $watcher->studio_id,
			'performer_id'	=> $watcher->performer_id
		);
		
		return $this->CI->watchers->add($w);		
			
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Returneaza un array cu cat ii revine studioului si performerului
	 * @param $total_amount
	 * @param $watcher
	 * @return unknown_type
	 */
	function get_slices($total_amount,$watcher){
		
		//banii siteului
		$website_amount		= round( $total_amount * $watcher->website_percentage / 100 , 2 );

		//banii performerului
		$performer_amount 	= $total_amount - $website_amount;
				
		$studio_amount 		= 0;
		
		if( $watcher->studio_id ){
			$studio_amount = round( $performer_amount * $watcher->percentage / 100 ,2);
			$performer_amount -= $studio_amount; 			 
		}
		
		return array('performer_chips'=>$performer_amount,'studio_chips'=>$studio_amount,'site_chips'=>$website_amount);
	}
	
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Returneaza suma ce trebuie platita pentru o anumita durata de chat
	 * @param $duration
	 * @param $fee_per_minute
	 * @return unknown_type
	 */
	function get_fee_by_duration($duration,$fee_per_minute){
		
		if( $duration < MINIMUM_PAID_CHAT_TIME ){
			$duration = MINIMUM_PAID_CHAT_TIME;
		}
		
		return round($duration * $fee_per_minute / 60 , 2);
	}

	// -----------------------------------------------------------------------------------------			
	/**
	 * Updateaza detaliile unui watcher (dupa ce a fost taxata sessiunea trebuie sa si propag in watcher in caz de end_Session)
	 * @param $data
	 * @return null
	 */
	function update_watcher($data){	
		if(sizeof($data) > 0){
			foreach($data as $key => $value){
				$this->watcher->$key = $value;
			}
		}
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Called by AUTH
	 * verifica daca userul poate intra in chat cu performerul
	 * @return unknown_type
	 */
	abstract function can_start_session();
	
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Called by TAX/ENDSESSION
	 * inchide sessiunea de chat
	 * @return unknown_type
	 */
	abstract function end_session();

	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Called by TAX
	 * Verifica daca userul mai poate continua sessiunea
	 * @return unknown_type
	 */
	abstract function can_continue_session();

	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Called by TAX
	 * @return unknown_type
	 */
	abstract function tax_session();

	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Returneaza pretul/minut pentru un anumit tip de chat
	 * @return integer
	 */
	abstract function get_fee_per_minute();
	
}