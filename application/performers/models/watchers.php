<?php
class Watchers extends CI_Model{
	
	var $watchers = 'watchers';
	var $old_watchers = 'watchers_old';
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################
		
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza sessiunea activa a unui user
	 * @param $user_id
	 * @return unknown_type
	 */	
	function get_one_active_session_by_user_id($user_id){
		$this->db->where('show_is_over',0)->where('user_id',$user_id)->union($this->old_watchers)->get($this->watchers)->row();
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza o sessiune de watcher dupa unique_id
	 * @param $unique_id
	 * @param $join - sa faca join si in tabela users,performers,studios
	 * @return unknown_type
	 */
	function get_one_by_unique_id($unique_id,$join = FALSE){
		if( $join ){
			$this->db->select('users.id as user_id,users.username,users.password,users.credits,users.status')//users
					->select('performers.id as performer_id,performers.status,is_online,is_online_hd,is_online_type,is_in_private,nude_chips_price,private_chips_price')//performers
					->select('studios.id as studio_id, percentage')	//studios
					->select('watchers.id,type,start_date,end_date,duration,show_is_over,ip,fee_per_minute,user_paid_chips,studio_chips,performer_chips,master_studio_chips,unique_id,was_banned,ban_date,ban_expire_date')//watchers
					->join('users',			'users.id 		= watchers.user_id',		'left')
					->join('performers',	'performers.id 	= watchers.performer_id',	'left')
					->join('studios',		'studios.id 	= performers.studio_id',	'left');
		}
				
		return $this->db->union($this->old_watchers)->where('unique_id',$unique_id)->limit(1)->get($this->watchers)->row();
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
	
		if( isset($filters['type'])){
			$this->db->where_in('type',$filters['type']);
		}
	
		$this->db->union($this->old_watchers);
	
		if($count){
			$results = $this->db->get($this->watchers)->result();
			return sum_union_counts($results);
		} else {
			return $this->db->get($this->watchers)->result();
		}
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * 
	 * Returneaza sumarul chaturilor grupate pe tip
	 * @param unknown_type $filters
	 * @author Baidoc
	 */
	function get_multiple_summaries($filters){
		$this->db->select('sum(performer_chips) as performer_chips,type');
		
		if(isset($filters['performer_id'])){
			$this->db->where('performer_id',$filters['performer_id']);
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
		
		$this->db->group_by('type');		
		return $this->db->get($this->old_watchers)->result();
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Numara cate accesari a avut un performer
	 * @param $performer_id
	 * @return unknown_type
	 */
	function count_chat_access($performer_id) {
		$this->db->select('count(id) as number')
				 ->where('performer_id', $performer_id)
				 ->union($this->old_watchers);
		return $this->db->get($this->watchers)->row()->number;
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
			$exists = $this->get_one_by_unique_id($hash);
		}
		while($exists);
	
		return $hash;		
	}
	
		// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un watcher in DB
	 * @param array $data 
	 * @return boolean
	 */	
	function add($data){
		if($this->db->insert($this->watchers,$data)){
			return TRUE;
		}
		return FALSE;
	}
	
}