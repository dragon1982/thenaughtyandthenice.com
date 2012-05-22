<?php
class Banned_states extends CI_Model{
	
	var $banned_states			= 'banned_states';
	var $banned_countries		= 'banned_countries';
	
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza statele banate dupa $performer_id
	 * @param $performer_id
	 */
	function get_multiple_by_performer_id($performer_id){
		return $this->db->where('performer_id',$performer_id)->get($this->banned_states)->result();
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza enumurile valide dintrun camp
	 * @param $field
	 * @return unknown_type
	 */
	function get_enum_values($field){
		$enum_string = $this->db->query("SELECT COLUMN_TYPE
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_NAME = '{$this->banned_states}'
			AND COLUMN_NAME = ". $this->db->escape($field)."
		")->row()->COLUMN_TYPE;
				
		preg_match_all("{'([^'']*)'}si",$enum_string,$enum_array);
		
		return $enum_array[1];
	}	
	
	
	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga $language la lista de ban a performerului - STATE
	 * @param $user_id
	 * @param $state
	 * @author VladG
	 */
	function add($user_id, $state) {		
		$data = array(
		   'performer_id'	=> $user_id ,
		   'state_code' 	=> $state
		);
		
		return $this->db->insert($this->banned_states, $data); 
	}
	
	
	#############################################################################################
	######################################### DELETE ############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Sterge din banned_states #language in functie de $user_id - STATE
	 * @param $user_id
	 * @param $state
	 * @author VladG
	 */
	function remove($user_id, $state){
		return $this->db->where('state_code', $state)->where('performer_id', $user_id)->delete($this->banned_states); 
	}
}