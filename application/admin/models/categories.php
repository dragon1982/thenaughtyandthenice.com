<?php
/**
 * 
 * @author CagunA
 *
 */
class Categories extends MY_Model{
	
	
	private $table = 'categories';
	
	public function __construct() {
		$this->set_table($this->table);
	}
	
	
	/**
	 * AVAILABLE METHODS:
	 * 
	 *		get_all($filters = FALSE, $count = FALSE, $order = FALSE, $offset = FALSE, $limit = FALSE)
	 *		get_by_id($id)
	 *		get_rand($many = 1)
	 *		save($data)
	 *		delete($id)
	 */
	
	

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

	/**
	 * Returneaza subcategoriile unei categorii
	 * @param unknown_type $cat_id
	 * @author Baidoc
	 */
	function get_childres($cat_id){
		return $this->db->where('parent_id',$cat_id)->get($this->table)->result();
	}
}