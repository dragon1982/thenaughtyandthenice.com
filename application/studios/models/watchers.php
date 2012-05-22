<?php
class Watchers extends CI_Model{
	
	var $watchers 	= 'watchers';
	var $watchers_old = 'watchers_old';
	var $performers = 'performers';
	var $studios 	= 'studios';


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
		return $this->db->where('show_is_over',0)->where('user_id',$user_id)->limit(1)->get($this->watchers)->row();
	}

	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza sessiunea activa dupa ip
	 * @param $ip
	 * @return unknown_type
	 */
	function get_one_active_session_by_ip($ip){
		return $this->db->where('show_is_over',0)->where('ip',$ip)->limit(1)->get($this->watchers)->row();
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
				
		return $this->db->where('unique_id',$unique_id)->limit(1)->get($this->watchers)->row();
	}

	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza costul sessiunii active pentru un user
	 * @param $user_id
	 * @return int
	 */
	function get_one_last_active_chat_cost($user_id){
		$data =  $this->db->select('user_paid_chips')->where('user_id',$user_id)->limit(1)->get($this->watchers)->row();

		if( ! $data ){
			return 0;
		}
		
		return $data->user_paid_chips;
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
	function get_multiple_by_user_id($user_id, $limit= FALSE, $offset = FALSE, $filters = array(), $joins = array(),$count = FALSE) {
		if($count){
			$this->db->select('count(id) as number');	
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
		
		$this->db->where('watchers.user_id', $user_id);
		
		if (isset($filters['start'])) {
			$this->db->where('start_date >=', $filters['start']);
		}
		if (isset($filters['stop'])) {
			$this->db->where('end_date <', $filters['stop']);
		}
		
		if($count){
			$results = $this->db->get($this->watchers)->result();
			return sum_union_counts($results);
		} else {
			return $this->db->get($this->watchers)->result();
		}
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
			$results = $this->db->get($this->watchers)->result();
			return sum_union_counts($results);
		} else {
			return $this->db->get($this->watchers)->result();
		}
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
	function get_multiple_by_studio_id($studio_id, $limit= FALSE, $offset = FALSE, $filters = array(), $joins = array(), $count = FALSE) {
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
		
		$this->db->where('watchers.studio_id', $studio_id);
		
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
		
		$this->db->union($this->watchers_old);
				
		if($count){
			$results = $this->db->get($this->watchers)->result();
			return sum_union_counts($results);
		} else {
			return $this->db->get($table)->result();
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
		
		return $this->db->get($this->watchers_old)->result();
	}	
 
	/**
	 * Numara cate accesari a avut un performer
	 * @param $performer_id
	 * @return unknown_type
	 */
	function count_chat_access($performer_id) {
		$this->db->select('count(id) as number')
				 ->where('performer_id', $performer_id);
		return $this->db->get($this->watchers)->row()->number;
	}	
	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un watcher in DB
	 * @param $data
	 * @return boolean
	 */	
	function add($data){
		if($this->db->insert($this->watchers,$data)){
			return TRUE;
		}
		return FALSE;
	}
	
	#############################################################################################
	####################################### UPDATE ##############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Updateaza un watcher
	 * @param $id - ce id sal updatezi
	 * @param $data - ce date trebuie updatate
	 * @return boolean
	 */	
	function update($id,$data){
		if($this->db->where('id',$id)->set($data)->update($this->watchers)){
			return TRUE;
		}
		return FALSE;
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
	 * Returneaza castigurile unui studio pe o perioada de timp grupate pe performeri
	 * @param $studio_id - id-ul studioului
	 * @param @limit - cate inregistrari pe pagina
	 * @param @offset - de la ce pagina
	 * @param @filters - start , stop, perioada pe care se returneaza
	 * @param @count - daca se da, returneaza numarul total
	 * @return unknown_type
	 */
	function get_studio_earnings_by_date($studio_id, $limit = FALSE, $offset = FALSE, $filters, $count = FALSE){
		if($count){
			$this->db->select('count(distinct(performers.id)) as total');
		} else {
			$this->db->select('SUM(studio_chips) as studio_chips, SUM(performer_chips) as performer_chips, performer_id')
					 ->select('performers.username, performers.id');
					 $this->db->limit($limit);
					 $this->db->offset($offset);
		}
		
		$this->db->from($this->performers)
				 ->join($this->watchers_old, 'watchers_old.performer_id = performers.id', 'inner')
				 ->where($this->performers . '.studio_id', $studio_id); 	
		

		if (isset($filters['start'])) {
			$this->db->where('start_date >=', strtotime($filters['start']));
		}
		if (isset($filters['stop'])) {
			$this->db->where('end_date <', strtotime($filters['stop']));
		}
		
		if( isset($filters['type'])){
			$this->db->where_in('type',$filters['type']);
		}
				
		if($count){
			return $this->db->get()->row()->total;
		} else {
			$this->db->group_by('performers.id');
			return $this->db->get()->result();
		}
	}
}
