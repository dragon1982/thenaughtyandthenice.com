<?php
Class Countries extends CI_Model{
	
	private $table = 'countries';
	
	public function get_all(){
		return $this->db->get($this->table)->result();
	}
}