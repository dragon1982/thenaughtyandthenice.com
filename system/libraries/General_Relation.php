<?php

class General_Relation {
	
	private static $table = 'relations';
	private static $db;
	private $id;
	private $from_id;
	private $from_type;
	private $to_id;
	private $to_type;
	private $status;
	
	// -----------------------------------------------------------------------------------------
	
	public function __construct($id){
		$id = intval($id);
		if(!$relation = self::db()->where('id',$id)->limit(1)->get(self::$table)->row()) {
			throw new Exception('Relation not found');	
		}else{
			$this->id = $id;
			$this->refresh($relation);
		}
	}
	
	// -----------------------------------------------------------------------------------------
	
	private static function db(){
		if(!self::$db) {
			$model = new CI_Model;
			self::$db = $model->db;
		}
		return self::$db;
	}
	
	// -----------------------------------------------------------------------------------------
	
	private function refresh($relation = null){
		if(!$relation) $relation = $this->db->where('id',$this->id)->limit(1)->get(self::$table)->row();
		$this->from_id = $relation->from_id;
		$this->from_type = $relation->from_type;
		$this->to_id = $relation->to_id;
		$this->to_type = $relation->to_type;
		$this->status = $relation->status;
	}
	
	// -----------------------------------------------------------------------------------------
	
	public static function add($from_id, $from_type, $to_id, $to_type){
		$data = array(
		   'from_id'	=> $from_id ,
		   'from_type'	=> $from_type ,
		   'to_id'		=> $to_id,
		   'to_type'	=> $to_type,
		   'status'     => 'pending'
		);
		if(self::db()->insert(self::$table, $data)){
			return new Relation(self::db()->insert_id());
		}
	}
	
	
	// -----------------------------------------------------------------------------------------
	
	function delete(){
		self::db()->delete(self::$table, array('id' => $this->id)); 
	}
	
	// -----------------------------------------------------------------------------------------
	
	function update($data){
		self::db()->where('id', $this->id);
		return self::db()->update(self::$table, $data); 
	}
}