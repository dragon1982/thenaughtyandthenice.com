<?php
require_once(BASEPATH.'libraries/General_Friends.php');

class Friends extends General_Friends{
	
	var $type = 'performer';
	var $parent;
	
	function __construct(){
		$this->parent = new parent();
	}
	
	function get_data($id, $status = null){
		return $this->parent->get_data($id, $this->type, $status);
	}
	
	function get($id, $status = null){
		return $this->parent->get($id, $this->type, $status);
	}
	
	function get_one($id, $search_id, $search_type, $status = null) {
		return $this->parent->get_one($id, $this->type, $search_id, $search_type, $status = null);
	}
	
	function is_friend($id, $search_id, $search_type){
		return $this->parent->is_friend($id, $this->type, $search_id, $search_type);
	}

}