<?php
/**
 */

Class Relation_controller extends MY_Controller{
	
	//constructor
	function __construct(){
		parent::__construct();
		$this->load->model('users');
		$this->load->model('performers');		
	}

	// ------------------------------------------------------------------------	
	
	function add() {
		$id = $this->input->post('id', null);
		$type = $this->input->post('type', null);
		if(!$friend = $this->users->get_friend($this->user->id,'performer',$id,$type)){
			$this->users->add_relation($this->user->id,'user',$id,$type);
		}
		redirect();
	}
	
	// ------------------------------------------------------------------------	
	
	function delete() {
		$rel_id = $this->input->post('rel_id', null);
		$rel_ids = array();
		$friends = $this->users->get_friends($this->user->id,'performer');
		foreach($friends as $friend) $rel_ids[] = $friend->rel_id;
		if(in_array($rel_id, $rel_ids)) $this->users->delete_relation($rel_id);
		redirect();
	}
	
	// ------------------------------------------------------------------------	
	
	function accept() {
		$rel_id = $this->input->post('rel_id', null);
		$rel_ids = array();
		$friends = $this->users->get_friends($this->user->id,'performer','pending');
		foreach($friends as $friend) {
			if($friend->owner) $rel_ids[] = $friend->rel_id;
		}
		if(in_array($rel_id, $rel_ids)) $this->users->update_relation($rel_id);
		redirect();
	}
	
	// ------------------------------------------------------------------------	
	function ban() {
		$this->load->model('performers');
		$rel_id = $this->input->post('rel_id', null);
		$rel_ids = array();
		$friends = $this->users->get_friends($this->user->id,'performer','accepted');
		foreach($friends as $friend) {
			if($friend->rel_id == $rel_id){
				$this->users->update_relation($rel_id, $friend->owner?'banned':'ban');
				break;
			}
		}
		redirect();
	}
}