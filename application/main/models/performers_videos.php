<?php
class Performers_videos extends CI_Model{
	
	private $performers_videos 	= 'performers_videos';
	private $performers_categories 	= 'performers_categories';	
	private $performers			= 'performers';
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################

	// -----------------------------------------------------------------------------------------	  	
	/**
	 * Returneaza un video dupa id
	 * @param $video_id
	 * @param $get_performer_details - default false
	 * @return object
	 */
	function get_one_by_id($video_id,$get_performer_details = FALSE){
		if( $get_performer_details ){
			$this->db->join($this->performers, $this->performers . '.id = ' . $this->performers_videos . '.performer_id','inner');
			$this->db->join('studios',			'studios.id = ' . $this->performers . '.studio_id',						'left' );
		}
		
		return $this->db->where('video_id',$video_id)->get($this->performers_videos)->row();	
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza un video dupa nume
	 * @param unknown_type $flv_name
	 * @param unknown_type $performer_id
	 * @author Baidoc
	 */
	function get_one_by_flv_name($flv_name,$performer_id = FALSE){
		$this->db->where('flv_file_name',$flv_name)->limit(1);
		if($performer_id){
			$this->db->where('performer_id',$performer_id);
		}
		return $this->db->get($this->performers_videos)->row();
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Returneaza videouri dupa performer_id
	 * @param $performer_id
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	function get_multiple_by_performer_id($performer_id,$limit,$offset,$count = FALSE){
		$this->db->where('performer_id',$performer_id);
		
		if($count){
			$this->db->select('count(video_id) as number');
			return $this->db->get($this->performers_videos)->row()->number;
		}
		
		return $this->db->limit($limit)
				 ->offset($offset)
				 ->get($this->performers_videos)
				 ->result();
		
	}
	
	/**
	 * Returneaza videouri dupa filtru
	 * @param $filters
	 * @param $limit
	 * @param $offset
	 * @param $order_by
	 * @param $count
	 * @param $rand
	 * @return unknown_type
	 */
	function get_multiple_videos($filters = array(),$limit = 10,$offset = 0,$count = FALSE,$rand = FALSE){
		
		$this->db->select('performers.nickname');
		$this->db->select('performers_videos.*');
		$this->db->join($this->performers,'performers.id=performers_videos.performer_id',			'inner');
		
		//filtru pe categori
		if(isset($filters['category'])){
			$this->db->join($this->performers_categories,$this->performers_categories . '.performer_id = ' . $this->performers_videos . '.performer_id','inner');
			$this->db->join('categories',$this->performers_categories . '.category_id = categories.id',	'inner');
			$this->db->where_in('categories.link',$filters['category']);	
		}		
		
		if(isset($filters['type']) && $filters['type'] !== NULL){
			$this->db->where('is_paid',$filters['type']);
		}
		

		if( $rand ){
			$this->db->order_by('rand()');
		}
		if($count){			
			$this->db->select('count(distinct(performers_videos.video_id)) as total');
			
			if( isset( $filters['country_code'] ) ){
				$this->db->where('(SELECT COUNT(performer_id) FROM `banned_countries` WHERE `banned_countries`.`performer_id` = `performers_videos`.`performer_id` AND `banned_countries`.`country_code` =  '.$this->db->escape($filters['country_code']).') = 0');
			}
			
			//filtru pe statul de origine (ban pe stat)
			if( isset( $filters['state_code'] ) ){
				$this->db->where('(SELECT COUNT(performer_id) FROM `banned_states` WHERE `banned_states`.`performer_id` = `performers_videos`.`performer_id` AND `banned_states`.`state_code` =  '.$this->db->escape($filters['state_code']).') = 0');
			}
						
			return $this->db->get($this->performers_videos)->row()->total;			
		} else {
			
			//filtru pe tara de origine (ban pe tara)
			if( isset( $filters['country_code'] ) ){
				$this->db->having('(SELECT COUNT(performer_id) FROM `banned_countries` WHERE `banned_countries`.`performer_id` = `performers_videos`.`performer_id` AND `banned_countries`.`country_code` =  '.$this->db->escape($filters['country_code']).') = 0');
			}
			
			//filtru pe statul de origine (ban pe stat)
			if( isset( $filters['state_code'] ) ){
				$this->db->having('(SELECT COUNT(performer_id) FROM `banned_states` WHERE `banned_states`.`performer_id` = `performers_videos`.`performer_id` AND `banned_states`.`state_code` =  '.$this->db->escape($filters['state_code']).') = 0');
			}

			$this->db->group_by($this->performers_videos . '.video_id');
			$this->db->limit($limit);
			$this->db->offset($offset);			
			
			return $this->db->get($this->performers_videos)->result();
		}		
	}

	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################		

	// -----------------------------------------------------------------------------------------		
	/**
	 * Adauga un video pentru un performer
	 * @param $description
	 * @param $flv_name
	 * @param $description
	 * @param $add_date
	 * @param $length
	 * @param $fms_id
	 * @param $performer_id
	 * @return unknown_type
	 */
	function add($flv_name,$description,$add_date,$length,$fms_id,$performer_id){
		$data = array(
			'description'		=> $description,
			'flv_file_name'		=> $flv_name,
			'add_date'			=> $add_date,
			'length'			=> $length,
			'fms_id'			=> $fms_id,
			'performer_id'		=> $performer_id
		);
		
		if( ! $video_id = $this->db->insert($this->performers_videos,$data)){
			return FALSE; 
		}
		
		return $this->db->insert_id();
	}
	
	#############################################################################################
	######################################## EDIT ###############################################
	#############################################################################################	
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Editeaza un video
	 * @param $id
	 * @param $data
	 * @return unknown_type
	 */
	function edit($id,$data){
		return $this->db->where('video_id',$id)->set($data)->update($this->performers_videos);
	}
	
	
	#############################################################################################
	####################################### DELETE ##############################################
	#############################################################################################

	// -----------------------------------------------------------------------------------------		
	/**
	 * Sterge un video dupa $id
	 * @param $id
	 */
	function delete_one_by_id($id){
		$this->db->where('video_id',$id)->delete($this->performers_videos);
	}
}