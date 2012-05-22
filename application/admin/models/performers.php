<?php

Class Performers extends MY_Model {
	
	private $table = 'performers';
	
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
	

	
	/**Updateaza statusul unui performer dat prin ID
	 * 
	 * @param $performer_id
	 * @param $status_type
	 * @param $status
	 * @return unknown_type
	 */
	function update_performer_status($performer_id, $status_type, $status) {
		return $this->db->where('id', $performer_id)->update($this->table, array($status_type => $status));
	}
	
	/**
	* Adauga credite unui performer
	* @param $performer_id
	* @param $credits
	* @return unknown_type
	*/
	function add_credits($performer_id,$credits){	
		$this->db->query('UPDATE `performers` SET `credits` = `credits` + ' . $this->db->escape($credits) . ' WHERE `id` = ' . $this->db->escape($performer_id) );
	}	
}