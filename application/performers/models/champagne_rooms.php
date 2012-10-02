<?php
class Champagne_rooms extends MY_Model {
	
	private $table = 'champagne_rooms';
	
	public function __construct() {
		$this->set_table($this->table);
	}
        
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza un payment dupa id
	 * @param unknown_type $payment_id
	 * @author Baidoc
	 */
	function get_one_by_id($id){
		return $this->db->where('id',$id)->get($this->table)->row();
	}
	
	function get_users($id){
                $this->db->select('users.id,users.username');
                $this->db->join('users', 'users.id = champagne_rooms_users.user_id', 'inner');
		return $this->db->where('champagne_rooms_users.champagne_room_id',$id)->get('champagne_rooms_users')->result();
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza paymenturile dupa filtre sau numarul de paymenturi daca se da parametrul $count
	 * @param $user_id
	 * @param $limit
	 * @param $offset
	 * @param $filters
	 * @param $count
	 */
	function get_multiple_by_performer_id($performer_id, $limit = FALSE, $offset = FALSE, $filters, $count = FALSE){
		if($count){
			$this->db->select('count(distinct(id)) as total');
		} else {
			$this->db->select('*');
					 $this->db->limit($limit);
					 $this->db->offset($offset);
		}
		
		$this->db->from($this->table)
				 ->where($this->table . '.performer_id', $performer_id); 	
		
		$this->db->order_by('id','desc');
		
		if($count){
			return $this->db->get()->row()->total;
		} else {
			return $this->db->get()->result();
		}
	}	
}