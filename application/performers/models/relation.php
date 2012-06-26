<?php
require_once(BASEPATH.'libraries/General_Relation.php');

class Relation extends General_Relation{
	
	var $type = 'performer';
	
	function add($from_id, $to_id, $to_type, $status = 'pending'){
		return parent::add($from_id, $this->type, $to_id, $to_type, $status);
	}

}