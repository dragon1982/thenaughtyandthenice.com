<?php
/**
 * 
 * @author Thibaut
 *
 */
class Champagne_rooms extends MY_Model{
	
	
	private $table = 'champagne_rooms';
	
	public function __construct() {
		$this->set_table($this->table);
	}
	
	public function get_by_id($id) {
                $join_table = 'performers';
		$id = abs(intval($id));
                $this->db->select($this->table.'.*, '.$join_table.'.username as performer_username, '.$join_table.'.id as performer_id');
                $this->db->join($join_table, $join_table.'.id = '.$this->table.'.performer_id', 'left');
		return $this->db->where($this->table.'.id',$id)->get($this->table)->row();
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
	
	
}