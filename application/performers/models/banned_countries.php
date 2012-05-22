<?php
class Banned_countries extends CI_Model{
	
	var $banned_contries	= 'banned_countries';
	var $banned_states		= 'banned_states';
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################
	

	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza Country banate dupa $performer_id
	 * @param $performer_id
	 */
	function get_multiple_by_performer_id($performer_id){
		return $this->db->where('performer_id',$performer_id)->get($this->banned_contries)->result();
	}
	
	
	##################################################################################################
	########################################## UPDATE ################################################
	##################################################################################################		
	
	

	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga $countries la lista de ban a performerului - COUNTRIES
	 * @param unknown_type $user_id
	 * @param unknown_type $countries
	 * @author VladG
	 */
	function add($user_id, $countries) {		
		$data = array(
		   'performer_id'	=> $user_id ,
		   'country_code' 	=> $countries
		);
		
		return $this->db->insert($this->banned_contries, $data); 
	}

	
	##################################################################################################
	########################################## DELETE ################################################
	##################################################################################################	

	// -----------------------------------------------------------------------------------------
	/**
	 * Sterge din banned_states $countries in functie de $user_id - COUNTRIES
	 * @param $user_id
	 * @param $countries
	 * @author VladG
	 */
	function remove($user_id, $countries){
		return $this->db->where('performer_id', $user_id)->where('country_code', $countries)->delete($this->banned_contries); 
	}
	
}