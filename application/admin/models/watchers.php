<?php

Class Watchers extends MY_Model{
	
	private $table = 'watchers';
	private $old_table = 'watchers_old';
	
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
	 * Returneaza o sessiune unica din wtf table
	 * @param $unique_id
	 * @author Baidoc
	 */
	function get_one_old_by_unique_id($unique_id){
		return $this->db->query('
								SELECT * FROM ' . $this->table . ' 
										WHERE
								`unique_id` = ' . $this->db->escape($unique_id) . '
								
								UNION
								
								SELECT * FROM ' . $this->old_table . '
										WHERE
								`unique_id` = ' . $this->db->escape($unique_id)
		)->row();
	}
		
	#############################################################################################
	####################################### HELPERE #############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Genereaza un id unic de watcher
	* @param $perfix - in caz ca o sa fie mai multe sisteme de chat integrate gen campoints
	* sa evitam coliziunea folosim prefixuri
	* @return unknown_type
	*/
	function generate_one_unique_id($prefix = 'a'){
	
		do{
			$hash = $prefix . sha1(uniqid(mt_rand(),TRUE));
			$exists = $this->get_one_old_by_unique_id($hash);
		}
		while($exists);
	
		return $hash;
	}	
	
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza sessiunile dupa filtre
	 * @param $user_id
	 * @param $limit
	 * @param $offset
	 * @param $filters
	 * @param $joins
	 * @param $count
	 * @return unknown_type
	 */
	function get_multiple_by_performer_id($performer_id, $limit= FALSE, $offset = FALSE, $filters = array(), $joins = array(), $count = FALSE) {
		if($count){
			$this->db->select('count(distinct(watchers.id)) as number');	
		} else {
			
			$this->db->select('watchers.*');
			
			//joins performer table
			if (isset($joins['performers'])) {
				$this->db->select('performers.username as performer');
				$this->db->join('performers', 'performers.id=watchers.performer_id', 'inner');
			}
			
			if (isset($joins['users'])) {
				$this->db->select('credits');
				$this->db->join('users','users.id=watchers.user_id','left');
			}
						
			$this->db->order_by('watchers.id', 'desc');
			$this->db->limit($limit);
			$this->db->offset($offset);			
		}
		
		$this->db->where('watchers.performer_id', $performer_id);
		
		if (isset($filters['start'])) {
			$this->db->where('start_date >=', strtotime($filters['start']));
		}
		
		if (isset($filters['stop'])) {
			$this->db->where('end_date <', strtotime($filters['stop']));
		}
		
		if(isset($filters['show_is_over'])){
			$this->db->where('show_is_over',$filters['show_is_over']);
		}
		
		if( isset($filters['type'])){
			$this->db->where_in('type',$filters['type']);
		}

		if( isset($filters['user_id']) ){
			$this->db->where('user_id',$filters['user_id']);
		}
		$this->db->union('watchers_old');
		if($count){
			$results = $this->db->get($this->table)->result();
			return sum_union_counts($results);
		} else {
			return $this->db->get($this->table)->result();
		}
	}	
	
	// -----------------------------------------------------------------------------------------
	/**
	 *
	 * Returneaza sumarul chaturilor grupate pe tip
	 * @param unknown_type $filters
	 * @author Baidoc
	 */
	function get_multiple_summaries($filters,$group_by = array()){
		$this->db->select('sum(performer_chips) as performer_chips,sum(studio_chips) as studio_chips,type');
	
		if(isset($filters['performer_id'])){
			$this->db->where('performer_id',$filters['performer_id']);
		}
	
		if(isset($filters['studio_id'])){
			$this->db->where('studio_id',$filters['studio_id']);
		}		
		if(isset($filters['start'])){
			$this->db->where('start_date >=',$filters['start']);
		}
	
		if(isset($filters['stop'])){
			$this->db->where('end_date <',$filters['stop']);
		}
	
		if(isset($filters['type'])){
			$this->db->where_in('type',$filters['type']);
		}
	
		if(isset($group_by['type'])){
			$this->db->group_by('type');
		}
		
		if(isset($group_by['performer_id'])){
			$this->db->group_by('performer_id');
		}		
		
		return $this->db->get($this->old_table)->result();
	}	
 
	
}