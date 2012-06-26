<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_controller extends MY_Controller{
	
	var $chat;
	
	// -----------------------------------------------------------------------------------------	

	function __construct(){
		parent::__construct();
		if($this->user->id <= 0) die();

		require_once BASEPATH.'libraries/Chat.php';
		$this->chat = new Chat($this->user->id, 'performer');
	}
	
	
	// -----------------------------------------------------------------------------------------	

	function index(){
		$this->chat->startSession();
	}
	
	function heartbeat(){
		$this->chat->heartbeat();
	}
	
	function send(){
		if(!$to = $this->input->post('to', null)) die();
		$to = explode('_',$to);
		$id = $to[0];
		$type = $to[1];
		$message = $this->input->post('message', null);
		if(!$friend = $this->friends->get_one($this->chat->getId(), $id, $type)) die;
		$this->chat->send($friend->id,$friend->type,$message);
	}
	
	function close(){
		$this->chat->close();
	}
}