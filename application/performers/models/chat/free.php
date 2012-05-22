<?php
class Free extends Chats{
	
	function __construct($user,$details = FALSE){
		$this->CI 		= &get_instance();
		$this->CI->load->model('users');
		$this->user 	= $user;
		$this->details 	= $details;		
	}
	
	function can_start_session(){
		$user = $this->CI->users->get_one_by_id(1);
		print_r($user);
	}
	
	function end_session(){
		
	}
	
	function can_continue_session(){
		
	}
	
	function tax_session(){
		
	}
	
}