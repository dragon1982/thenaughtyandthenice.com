<?php
/**
 * 
 * @author Vlad
 *
 */
class Performers_categories extends CI_Model{
	
	var $categories = 'performers_categories';
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza categoriile dupa $performer_id
	 * @param $performer_id
	 */
	function get_multiple_by_performer_id($performer_id){
		return $this->db->where('performer_id',$performer_id)->get($this->categories)->result();
	}
	
	
	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga categorii in performers_categories dupa user id
	 * @param $user_id
	 * @param $language
	 * @author VladG
	 */
	function add($user_id, $category) {		
		$data = array(
		   'category_id' => $category ,
		   'performer_id' => $user_id 
		);

		return $this->db->insert('performers_categories', $data); 
	}
	
	
	#############################################################################################
	######################################### DELETE ############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Sterge categorii in performers_categories dupa user id
	 * @param $user_id
	 * @param $category
	 * @author VladG
	 */
	function remove($user_id, $category){
		return $this->db->where('category_id', $category)->where('performer_id', $user_id)->delete('performers_categories'); 
	}
}