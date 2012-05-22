<?php
/**
 * 
 * @author Vlad
 *
 */
class Categories extends CI_Model{
	
	private $categories = 'categories';
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un array cu categorii si subcategori
	 * @return array
	 */
	function get_all_categories($group_by_level = TRUE) {
		$query = $this->db->get($this->categories)->result();
		
		if( ! $group_by_level) {
			return $query;
		}
		
		$main_categories = $this->get_main_categories($query);
		$sub_categories = $this->get_sub_categories($query,$main_categories);
		
		return array('main_categories'=>$main_categories,'sub_categories'=>$sub_categories);
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza categoriile principale dintrun array
	 * @param $categories
	 * @return array
	 */
	function get_main_categories($categories) {
		if(sizeof($categories) == 0){
			return FALSE;
		}
		
		$main_categories = array();
		
		foreach($categories as $category){
			if($category->parent_id == NULL){
				$main_categories[] = $category;
			}
		}
		
		return $main_categories;
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza subcategoriile dintrun array
	 * @param $categories
	 * @param $main_categories
	 * @return array
	 */
	function get_sub_categories($categories,$main_categories){
		if(sizeof($categories) == 0 || sizeof($main_categories) == 0) return;
		
		$sub_categories = array();
		
		foreach($main_categories as $main_category){
			foreach($categories as $category){
				if($category->parent_id == $main_category->id){
					$sub_categories[$main_category->id][] = $category;
				}
			}	
		}
		
		return $sub_categories;
	}
	

	
}