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

	public function get_featured(){	
        $this->db->select('*');
        $this->db->from('champagne_rooms');
        $this->db->join('performers', 'performers.id = champagne_rooms.performer_id', 'left');	
		$this->db->join('performers_profile', 'performers_profile.performer_id = champagne_rooms.performer_id', 'left');	
		$this->db->order_by("champagne_rooms.start_time", 'DESC'); 
		$this->db->limit(1); 
		return $this->db->get();	
	}	
	
	public function get_all_featured(){	
        $this->db->select('*');
        $this->db->from('champagne_rooms');
        $this->db->join('performers', 'performers.id = champagne_rooms.performer_id', 'left');	
		$this->db->join('performers_profile', 'performers_profile.performer_id = champagne_rooms.performer_id', 'left');	
		$this->db->order_by("champagne_rooms.start_time", 'DESC'); 
		$this->db->limit(4,1); 
		return $this->db->get();	
	}
	
	public function get_all(){	
        $this->db->select('*');
        $this->db->from('champagne_rooms');
        $this->db->join('performers', 'performers.id = champagne_rooms.performer_id', 'left');	
		$this->db->join('performers_profile', 'performers_profile.performer_id = champagne_rooms.performer_id', 'left');	
		$this->db->order_by("champagne_rooms.start_time", 'DESC'); 
		$this->db->limit(100,5); 
		return $this->db->get();	
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