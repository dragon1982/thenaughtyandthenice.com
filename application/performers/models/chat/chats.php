<?php
/**
 * 
 * @author Andrei
 *
 */
abstract class Chats{

	public $user;
	public $details;
	public $CI;
	
	static function getInstance($session_type,$user,$performer = FALSE){
		
		switch($session_type){
			case 'free':{
				require_once APPPATH.'models/chat/free.php';
				return new Free($user,$performer);				
			}
			case 'nude':{
				require_once APPPATH.'models/chat/nude.php';
				return new Nude($user,$performer);							
			}
			case 'private':{
				require_once APPPATH.'models/chat/private.php';
				return new Privat($user,$performer);										
			}			
			case 'spy':{
				require_once APPPATH.'models/chat/spy.php';
				return new Spy($user,$performer);							
			}
			case 'peek':{
				require_once APPPATH.'models/chat/peek.php';
				return new Peek($user,$performer);							
			}			
			default:{			
				die('ERROR');
			}
		}
	} 
	
	/**
	 * Called by AUTH
	 * verifica daca userul poate intra in chat cu performerul
	 * @return unknown_type
	 */
	abstract function can_start_session();
	
	/**
	 * Called by TAX/ENDSESSION
	 * inchide sessiunea de chat
	 * @return unknown_type
	 */
	abstract function end_session();
	
	/**
	 * Called by TAX
	 * Verifica daca userul mai poate continua sessiunea
	 * @return unknown_type
	 */
	abstract function can_continue_session();
	
	/**
	 * 
	 * @return unknown_type
	 */
	abstract function tax_session();
}