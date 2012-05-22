<?php

Class Admins extends CI_Model{
	
	private $table = 'admins';
		

	/**
	 * Returneaza un admin dupa id
	 * @param unknown_type $id
	 * @author Baidoc
	 */
	function get_one_by_id($id){
		return $this->db->where('id',$id)->limit(1)->get($this->table)->row();
	}
	
	/**
	 * Returneaza un admin dupa hash
	 * 
	 * @author CagunA
	 * @since 25 Jul 2011
	 *  
	 * @param $hash
	 * @return object
	 */
	public function get_one_by_hash($hash){
		return $this->db->where('hash',$hash)->get($this->table)->row();
	}
	
	
	
	/**
	 * Returneaza un admin dupa $username
	 * 
	 * @author CagunA
	 * @since 25 Jul 2011
	 *  
	 * @param string $username
	 * @return object
	 */	
	function get_one_by_username($username){
		return $this->db->where('username',$username)->limit(1)->get($this->table)->row();
	}
	
}