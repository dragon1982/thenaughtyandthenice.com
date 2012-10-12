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
        $this->db->select('performers_profile.*, performers.*'.', '.$this->table.'.*');
        $this->db->from('champagne_rooms');
        $this->db->join('performers', 'performers.id = champagne_rooms.performer_id', 'left');	
		$this->db->join('performers_profile', 'performers_profile.performer_id = champagne_rooms.performer_id', 'left');	
		$this->db->order_by("champagne_rooms.start_time", 'DESC'); 
		$this->db->limit(1); 
		return $this->db->get();	
	}	
	
	public function get_all_featured(){	
        $this->db->select('performers_profile.*, performers.*'.', '.$this->table.'.*');
        $this->db->from('champagne_rooms');
        $this->db->join('performers', 'performers.id = champagne_rooms.performer_id', 'left');	
		$this->db->join('performers_profile', 'performers_profile.performer_id = champagne_rooms.performer_id', 'left');	
		$this->db->order_by("champagne_rooms.start_time", 'DESC'); 
		$this->db->limit(4,1); 
		return $this->db->get();	
	}
	
	public function get_all(){	
        $this->db->select('performers_profile.*, performers.*'.', '.$this->table.'.*');
        $this->db->from('champagne_rooms');
        $this->db->join('performers', 'performers.id = champagne_rooms.performer_id', 'left');	
		$this->db->join('performers_profile', 'performers_profile.performer_id = champagne_rooms.performer_id', 'left');	
		$this->db->order_by("champagne_rooms.start_time", 'DESC'); 
		$this->db->limit(100,5); 
		return $this->db->get();	
	}	
        
	public function get_by_id($id) {
                $join_table = 'performers';
		$id = abs(intval($id));
                $this->db->select($this->table.'.*, '.$join_table.'.username as performer_username, '.$join_table.'.id as performer_id');
                $this->db->join($join_table, $join_table.'.id = '.$this->table.'.performer_id', 'left');
		return $this->db->where($this->table.'.id',$id)->get($this->table)->row();
	}
        
        public function sold_tickets($id){
                $table = 'champagne_rooms_users';
                $this->db->select('count(*) as number');
		$result = $this->db
                    ->where('champagne_room_id',$id)
                    ->get($table)->row();
                return $result->number;
        }
        
        public function joined_user($id,$user_id){
                $table = 'champagne_rooms_users';
                $this->db->select('count(*) as number');
		$result = $this->db
                    ->where('champagne_room_id',$id)
                    ->where('user_id',$user_id)
                    ->get($table)->row();
                return (boolean)$result->number;
        }
        
        public function join($id,$user_id){
                $table = 'champagne_rooms_users';
                echo $sql ='INSERT INTO `'.$table.'`(`champagne_room_id`,`user_id`) VALUES('.$this->db->escape($id).','.$this->db->escape($user_id).')';
                return $this->db->query($sql);
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