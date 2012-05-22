<?php

Class Users extends MY_Model{
	
	private $table = 'users';
	
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
	
// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un user dupa id, si face join in tabela user_details
	 * @param $id
	 * @return object
	 */
	function get_one_by_id_and_full_details($id){
		return $this->db->where('id', $id)->from('users')->join('users_detail', 'users_detail.user_id = users.id ', 'inner')->limit(1)->get()->row();
	}
	
	
	/**
	* Adauga credite unui user
	* @param $user_id
	* @param $credits
	* @return unknown_type
	*/
	function add_credits($user_id,$credits){	
		$this->db->query('UPDATE `users` SET `credits` = `credits` + ' . $this->db->escape($credits) . ' WHERE `id` = ' . $this->db->escape($user_id) );
	}
	
}