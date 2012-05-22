<?php
Class Settings extends MY_Model {
	
	private $table = 'settings';
	
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
	
	function update_where_key ($key, $value) {
		return $this->db->where('key', $key)->set('value', $value)->update($this->table);
	}
	
	function get_by_name($name){
		return $this->db->where('name', $name)->get($this->table)->row();
	}
	
}