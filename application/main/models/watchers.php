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
	 * @tutorial daca nu e logat il verific dupa ip
	 * @param $user_id
	 * @return unknown_type
	 */	
	function get_one_active_session_by_user_id($user_id){
		if($user_id > 0){
			return $this->db->where('show_is_over',0)->where('user_id',$user_id)->limit(1)->get($this->watchers)->row();
		} 
	}

	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza sessiunea activa dupa ip
	 * @param $ip
	 * @return unknown_type
	 */
	function get_one_active_session_by_ip($ip){
		return $this->db->where('show_is_over',0)->where('ip',ip2long($ip))->limit(1)->get($this->watchers)->row();
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
					->select('performers.id as performer_id,performers.status,is_online,is_online_hd,is_online_type,is_in_private,nude_chips_price,private_chips_price,true_private_chips_price,peek_chips_price,website_percentage')//performers
					->select('studios.id as studio_id, percentage')	//studios
					->select('watchers.id,type,start_date,end_date,duration,show_is_over,ip,fee_per_minute,user_paid_chips,studio_chips,performer_chips,unique_id,was_banned,ban_date,ban_expire_date')//watchers
					->join('users',			'users.id 		= watchers.user_id',		'left')
					->join('performers',	'performers.id 	= watchers.performer_id',	'left')
					->join('studios',		'studios.id 	= performers.studio_id',	'left');
		}
				
		return $this->db->where('unique_id',$unique_id)->union($this->old_watchers)->limit(1)->order_by('id','desc')->get($this->watchers)->row();
	}

	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza o sessiune unica din wtf table
	 * @param $unique_id
	 * @author Baidoc
	 */
	function get_one_old_by_unique_id($unique_id){
		return $this->db->query('
							SELECT * FROM ' . $this->watchers . ' 
									WHERE
							`unique_id` = ' . $this->db->escape($unique_id) . '
							
							UNION
							
							SELECT * FROM ' . $this->old_watchers . '
									WHERE
							`unique_id` = ' . $this->db->escape($unique_id)
						)->row();
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
		
		if( isset( $filters['start'] ) ) {
			$this->db->where('start_date >=', $filters['start']);
		}
		if( isset( $filters['stop'] ) ) {
			$this->db->where('end_date <', $filters['stop']);
		}
		
		if( isset( $filters['is_paid'] ) ){
			$this->db->where('paid',$filters['is_paid']);
		}
		
		if( isset( $filters['performer_video_id']) ){
			$this->db->where('performer_video_id',$filters['performer_video_id']);
		}
		
		if( isset( $filters['performer_id'] ) ){
			$this->db->where('performer_id',$filters['performer_id']);	
		}
		
		$this->db->union($this->old_watchers);
		if( $count ){
			$results = $this->db->get($this->watchers)->result();
			return sum_union_counts($results);
		} else {
			$this->db->order_by('id','desc');
			return $this->db->get($this->watchers)->result();
		}
	}
	
	/**
	 * Returneaza prima sessiune a unui performer
	 * @param unknown_type $performer_id
	 * @author Baidoc
	 */
	function get_first_activity_by_performer_id($performer_id){
		return $this->db->where('performer_id',$performer_id)->limit(1)->order_by('id','asc')->get($this->old_watchers)->row();
	}
	

	/**
	* Returneaza prima sessiune a unui studio
	* @param unknown_type $studio_id
	* @author Baidoc
	*/	
	function get_first_activity_by_studio_id($studio_id){
		return $this->db->where('studios.id',$studio_id)->join('studios','studios.id=watchers_old.studio_id','inner')->order_by('watchers_old.id','asc')->limit(1)->get($this->old_watchers)->row();
	}	
	
	/**
	 * Returneaza sessiunile neinchise
	 * @return array 
	 */
	function get_multiple_frozen_sessions($last_call = FALSE){
		return $this->db->where('show_is_over',0)->where('end_date <',$last_call)->get($this->watchers)->result();
	}
	
	/**
	 * Returneaza sessiunile deschise de pe un ip 
	 * @param $ip 
	 * @return array
	 */
	function get_multiple_active_by_ip($ip){
		return $this->db->where('ip',ip2long($ip))->where('show_is_over',0)->get($this->watchers)->result();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza cate credite a castigat studioul in intervalul dat
	 * @param unknown_type $studio_id
	 * @param unknown_type $start
	 * @param unknown_type $stop
	 * @author Baidoc
	 */
	function get_total_credits_by_studio_id($studio_id,$start,$stop){
		$this->db->select('( sum(studio_chips) + sum(performer_chips) )  as total')
				->join('performers','performers.id=watchers_old.performer_id','inner')
				->where('show_is_over',1)
				->where('start_date >=',$start)
				->where('end_date <=',$stop)
				->where('performers.studio_id',$studio_id);
		
		return $this->db->get($this->old_watchers)->row()->total;
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza cate credite a castigat performerul in intervalul dat
	 * @param unknown_type $performer_id
	 * @param unknown_type $start
	 * @param unknown_type $stop
	 * @author Baidoc
	 */
	function get_total_credits_by_performer_id($performer_id,$start,$stop){
		$this->db->select('sum(performer_chips) as total')
				 ->where('show_is_over',1)
				 ->where('start_date >=',$start)
				 ->where('end_date <=',$stop)		
				 ->where('performer_id',$performer_id);
	
		return $this->db->get($this->old_watchers)->row()->total;
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
		
		if($performer_id){
			$this->db->where('watchers.performer_id', $performer_id);
		}
		
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
		
		if( isset($filters['performer_videos'])){
			$this->db->where_in('performer_video_id',$filters['performer_videos']);
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
	 * Verifica daca userul are ban activ la performerul dat
	 * @tutorial - daca userul nu e logat verific ipul daca cumva e banat
	 * @param $user_id
	 * @param $performer_id
	 * @param $ip
	 * @return bool
	 */
	function check_user_for_ban_by_performer_id($user_id,$performer_id,$ip){
		if($user_id > 0){
			return $this->db->where('user_id',$user_id)->where('performer_id',$performer_id)->where('ban_expire_date >',time())->union($this->old_watchers)->get($this->watchers)->row();	
		} else {
			return $this->db->where('ip',ip2long($ip))->where('performer_id',$performer_id)->where('ban_expire_date >',time())->union($this->old_watchers)->get($this->watchers)->row();
		}
		
	}

	
	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################
	
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
	
	/**
	 * 
	 * Muta sessiunile inchise 
	 * @author Baidoc
	 */
	function move_old_watchers(){
		
		$this->db->trans_begin();		
        $this->db->query("INSERT IGNORE INTO `{$this->old_watchers}` (type,start_date,end_date,duration,show_is_over,ip,fee_per_minute,user_paid_chips,site_chips,studio_chips,performer_chips,unique_id,was_banned,ban_date,ban_expire_date,user_id,username,studio_id,performer_id,is_imported,performer_video_id,paid) SELECT type,start_date,end_date,duration,show_is_over,ip,fee_per_minute,user_paid_chips,site_chips,studio_chips,performer_chips,unique_id,was_banned,ban_date,ban_expire_date,user_id,username,studio_id,performer_id,is_imported,performer_video_id,paid FROM `{$this->watchers}` WHERE show_is_over = 1"); 
		$this->db->query("DELETE FROM `{$this->watchers}` WHERE `show_is_over` = 1");
		
		if( $this->db->trans_status() == FALSE ){
			$this->db->trans_rollback();
			return;
		}
		
		$this->db->trans_commit();
		
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
	 * Verifica daca tipul de chat e valid
	 * @param $type
	 * @return unknown_type
	 */
	function valid_chat_type($type){
		$this->load->config('others');
		if( ! key_exists($type,$this->config->item('session_types')) ){
			return FALSE;
		}
		
		return TRUE;
	}
	
}