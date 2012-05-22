<?php

Class Payment_methods extends MY_Model {
	
	private $table = 'payment_methods';
	var $performers = 'performers';
	
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
	 * Daca se modifica o metoda de plata, sau se da reject, resetam metoda de plata la performerii care o folosesc
	 * @param $performer_id
	 * @param $account
	 * @return unknown_type
	 */
	function update_performer_accounts($method_id) {
		return $this->db->where('payment', $method_id)
						->set(array('account' => '', 'payment' => '0'))
						->update($this->performers);
	}
	
}