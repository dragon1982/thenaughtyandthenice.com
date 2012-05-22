<?php

Class Studios extends MY_Model{
	
	private $table = 'studios';
	
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
	

	/**Updateaza statusul unui studio dat prin ID
	 * 
	 * @param $performer_id
	 * @param $status_type
	 * @param $status
	 * @return unknown_type
	 */
	function update_studio_status($studio_id, $status_type, $status) {
		return $this->db->where('id', $studio_id)->update($this->table, array($status_type => $status));
	}
	
	/**
	* Adauga credite unui studio
	* @param $studio_id
	* @param $credits
	* @return unknown_type
	*/
	function add_credits($studio_id,$credits){
		$this->db->query('UPDATE `studios` SET `credits` = `credits` + ' . $this->db->escape($credits) . ' WHERE `id` = ' . $this->db->escape($studio_id) );
	}	
}