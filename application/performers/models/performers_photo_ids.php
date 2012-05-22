<?php
class Performers_photo_ids extends CI_Model{
	
	private $photo_ids = 'performers_photo_id';
	
	##################################################################################################
	############################################# GET ################################################
	##################################################################################################

	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un contract dupa ID
	 * @param $contract_id
	 * @return unknown_type
	 */	
	function get_one_by_id($photo_id){
		return $this->db->where('id',$photo_id)->get($this->photo_ids)->row();	
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza photo_idurile unui performer
	 * @param $performer_id
	 * @return array
	 */
	function get_multiple_by_performer_id($performer_id,$filters = FALSE,$count = FALSE){
		
		if(isset($filters['status'])){
			$this->db->where('status',$filters['status']);
		}		
		
		$this->db->where('performer_id',$performer_id);
		
		if($count){
			return $this->db->select('count(id) as total')->get($this->photo_ids)->row()->total;
		}
		return $this->db->get($this->photo_ids)->result();
	}	
	##################################################################################################
	############################################# ADD ################################################
	##################################################################################################

	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un buletin pentru performer
	 * @param $name_on_disk
	 * @param $status
	 * @param $performer_id
	 */
	function add($name_on_disk,$status,$performer_id){
		$this->db->insert(
			$this->photo_ids,
			array(
				'date'			=> time(),
				'name_on_disk' 	=> $name_on_disk,
				'status'		=> $status,
				'performer_id'	=> $performer_id
			)
		);
	}	
	
	##################################################################################################
	############################################# DEL ################################################
	##################################################################################################
	// -----------------------------------------------------------------------------------------
	/**
	 * Sterge un photo_id dupa ID
	 * @param $photo_id
	 * @return unknown_type
	 */	
	function delete_by_id($photo_id){
		return $this->db->where('id',$photo_id)->delete($this->photo_ids);	
	}	
}