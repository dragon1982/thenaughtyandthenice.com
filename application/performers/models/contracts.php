<?php
class Contracts extends CI_Model{
	
	private $contracts = 'contracts';

	##################################################################################################
	############################################# GET ################################################
	##################################################################################################

	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un contract dupa ID
	 * @param $contract_id
	 * @return unknown_type
	 */	
	function get_one_by_id($contract_id){
		return $this->db->where('id',$contract_id)->get($this->contracts)->row();	
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza contractele unui performer
	 * @param $performer_id
	 * @return array
	 */
	function get_multiple_by_performer_id($performer_id,$filters = FALSE,$count = FALSE){
		
		if(isset($filters['status'])){
			$this->db->where('status',$filters['status']);
		}		
		
		$this->db->where('performer_id',$performer_id);
		
		if($count){
			return $this->db->select('count(id) as total')->get($this->contracts)->row()->total;
		}
		return $this->db->get($this->contracts)->result();
	}
	
	##################################################################################################
	############################################# ADD ################################################
	##################################################################################################

	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un contract
	 * @param $name_on_disk
	 * @param $status
	 * @param $performer_id
	 */
	function add($name_on_disk,$status,$performer_id){
		$this->db->insert(
			$this->contracts,
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
	 * Sterge un contract dupa ID
	 * @param $contract_id
	 * @return unknown_type
	 */	
	function delete_by_id($contract_id){
		return $this->db->where('id',$contract_id)->delete($this->contracts);	
	}
}