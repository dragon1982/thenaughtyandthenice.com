<?php

Class Performers_languages extends CI_Model{
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza lista cu limbi suportate
	 * @return unknown_type
	 */
	function get_multiple_by_performer_id($id) {
		$query = $this->db->where('performer_id', $id)->get('performers_languages')->result();
		return $query;
	}
	
	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga $language in performers_languages dupa $user_id
	 * @param $user_id
	 * @param $language
	 * @author VladG
	 */
	function add($user_id, $language) {		
		$data = array(
		   'language_code' => $language ,
		   'performer_id' => $user_id 
		);

		return $this->db->insert('performers_languages', $data); 
	}
	
	#############################################################################################
	######################################### DELETE ############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Sterge $language in performers_languages dupa $user_id
	 * @param $id
	 * @param $language
	 * @author VladG
	 */
	function remove($user_id, $language){
		return $this->db->where('language_code', $language)->where('performer_id', $user_id)->delete('performers_languages'); 
	}
}