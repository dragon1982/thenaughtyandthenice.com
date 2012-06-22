<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_controller extends MY_Controller{
	
	var $chat;
	
	// -----------------------------------------------------------------------------------------	

	function __construct(){
		parent::__construct();
		if($this->user->id <= 0) die();
		$this->load->model('users');
		require_once BASEPATH.'libraries/Chat.php';
		$this->chat = new Chat($this->user->id, $this->user->username, 'performer');
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
		$username = $to[0];
		$type = $to[1];
		$message = $this->input->post('message', null);
		if(!$friend = $this->{$type.'s'}->get_one_by_username($username)) die;
		if(!$this->users->is_friend($this->chat->getId(), $this->chat->getType(), $friend->id, $type)) die;
		$this->chat->send($friend->id,$username,$type,$message);
	}
	
	function close(){
		$this->chat->close();
	}
}