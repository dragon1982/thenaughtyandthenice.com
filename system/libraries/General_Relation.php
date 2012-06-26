<?php

class General_Relation extends CI_Model {
	
	private $table = 'relations';

	// -----------------------------------------------------------------------------------------
	
	function get($id){
		return $this->db->where('id',$id)->limit(1)->get($this->table)->row();
	}
	
	// -----------------------------------------------------------------------------------------
	
	function add($from_id, $from_type, $to_id, $to_type, $status = 'pending'){
		$data = array(
		   'from_id'	=> $from_id ,
		   'from_type'	=> $from_type ,
		   'to_id'		=> $to_id,
		   'to_type'	=> $to_type,
		   'status'     => $status
		);
		$this->db->trans_start();
		$this->db->insert($this->table, $data);
		$id = $this->db->insert_id();
		$this->db->trans_complete();
		return $id;
	}
	
	// -----------------------------------------------------------------------------------------
	
	function update($id, $status){
		$data = array('status' => $status);
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data); 
	}	
	
	// -----------------------------------------------------------------------------------------
	
	function delete($id){
		return $this->db->delete($this->table, array('id' => $id)); 
	}
}