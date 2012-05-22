<?php
class Performers_profile extends CI_Model{
	
	private $performers_profile = 'performers_profile';
	
	##################################################################################################
	############################################# GET ################################################
	##################################################################################################	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza enumurile valide dintrun camp
	 * @param $field
	 * @return unknown_type
	 */
	function get_enum_values($field){
		$enum_string = $this->db->query("SELECT COLUMN_TYPE
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_NAME = '{$this->performers_profile}'
			AND COLUMN_NAME = ". $this->db->escape($field)."
		")->row()->COLUMN_TYPE;
				
		preg_match_all("{'([^'']*)'}si",$enum_string,$enum_array);
		
		return $enum_array[1];
	}
	

	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un performer dupa id
	 * @param $email
	 * @return unknown_type
	 */	
	function get_one_by_id($id){
		return $this->db->where('performer_id',$id)->limit(1)->get($this->performers_profile)->row();
	}
	
	
	##################################################################################################
	############################################# UPDATE #############################################
	##################################################################################################	
	// -----------------------------------------------------------------------------------------
	/**
	 * Updateaza profilul unui performer
	 * @param $performer_id
	 * @param $data
	 */
	function update($performer_id,$data){
		if($this->db->where('performer_id',$performer_id)->set($data)->update($this->performers_profile)){
			return TRUE;
		}
		return FALSE;
	}
}