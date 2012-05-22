<?php
class Performers_videos extends CI_Model{
	
	private $performers_videos = 'performers_videos';
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################


	// -----------------------------------------------------------------------------------------	  	
	/**
	 * Returneaza un video dupa id
	 * @param $id
	 * @return object
	 */
	function get_one_by_id($id){
		return $this->db->where('video_id',$id)->get($this->performers_videos)->row();	
	}
	
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Returneaza videouri dupa performer_id
	 * @param $performer_id
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	function get_multiple_by_performer_id($performer_id,$limit = FALSE,$offset = FALSE,$count = FALSE){
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

	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################		

	// -----------------------------------------------------------------------------------------		
	/**
	 * Adauga un video pentru un performer
	 * @param $name
	 * @param $flv_name
	 * @param $add_date
	 * @param $length
	 * @param $fms_id
	 * @param $performer_id
	 * @return unknown_type
	 */
	function add($name,$flv_name,$add_date,$length,$fms_id,$performer_id){
		$data = array(
			'name'				=> $name,
			'flv_file_name'		=> $flv_name,
			'add_date'			=> $add_date,
			'length'			=> $length,
			'fms_id'			=> $fms_id,
			'performer_id'		=> $performer_id
		);
		
		if( ! $this->db->insert($this->performers_videos,$data)){
			return FALSE; 
		}
		
		return TRUE;
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
	function update($id,$data){
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