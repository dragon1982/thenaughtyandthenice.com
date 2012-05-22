<?php

Class Admins extends MY_Model{
	
	private $table = 'admins';
	
	public function __construct() {
		$this->set_table($this->table);
	}
	
	/**
	 * AVAILABLE METHODS:
	 * 
	 *		get_all($filters = FALSE, $count = FALSE, $order = FALSE, $offset = FALSE, $limit = FALSE)
	 *		get_by_id($id)
	 *		get_rand($many = 1)
	 *		save($data)
	 *		delete($id)
	 */
	

	
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