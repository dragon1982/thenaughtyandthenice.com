<?php
/**
 */

Class Relation_controller extends MY_Users{
	
	//constructor
	function __construct(){
		parent::__construct();
		$this->load->model('relation');	
	}

	// ------------------------------------------------------------------------	
	
	function add() {
		$id = $this->input->post('id', null);
		$type = $this->input->post('type', null);
		if(!$friend = $this->friends->get_one($this->user->id,$id,$type)){
			$this->relation->add($this->user->id,$id,$type);
		}
		redirect($this->agent->referrer());
	}
	
	// ------------------------------------------------------------------------	
	
	function delete() {
		$rel_id = $this->input->post('rel_id', null);
		$rel_ids = array();
		$friends = $this->friends->get($this->user->id);
		foreach($friends as $friend) $rel_ids[] = $friend->rel_id;
		if(in_array($rel_id, $rel_ids)) $this->relation->delete($rel_id);
		redirect($this->agent->referrer());
	}
	
	// ------------------------------------------------------------------------	
	
	function accept() {
		$rel_id = $this->input->post('rel_id', null);
		$rel_ids = array();
		$friends = $this->friends->get($this->user->id,'pending');
		foreach($friends as $friend) {
			if($friend->owner) $rel_ids[] = $friend->rel_id;
		}
		if(in_array($rel_id, $rel_ids)) $this->relation->update($rel_id,'accepted');
		redirect($this->agent->referrer());
	}
	
	// ------------------------------------------------------------------------	
	function ban() {
		$this->load->model('performers');
		$rel_id = $this->input->post('rel_id', null);
		$rel_ids = array();
		$friends = $this->friends->get($this->user->id,'accepted');
		foreach($friends as $friend) {
			if($friend->rel_id == $rel_id){
				$this->relation->update($rel_id, $friend->owner?'banned':'ban');
				break;
			}
		}
		redirect($this->agent->referrer());
	}
	
}