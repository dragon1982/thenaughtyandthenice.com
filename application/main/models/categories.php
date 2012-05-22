<?php
Class Categories extends CI_Model{	
	
	var $categories = 'categories';
	
	##################################################################################################
	############################################# GET ################################################
	##################################################################################################
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * returneaza categoriile si subcategoriile
	 * @author VladG
	 * @return array
	 */
	function get_all_categories(){
            return $this->db->set_memcache_key('categories_list',array(),120)->get($this->categories)->result();
	}
	

    // -----------------------------------------------------------------------------------------
	/**
	 * Returneaza numaru total de perf onliner si nr total d performeri
	 * @param $category_id
	 * @return object
	 */
	function count_online_performers_by_category_id($category_id) {
		return $this->db->select('SUM(is_online) as online_performers, COUNT(id) as performers_total')
					->join('performers_categories','performers.id = performers_categories.performer_id and performers_categories.category_id = '.$this->db->escape($category_id),'inner')
					->where('status','approved')
					->get('performers')->row();
	}

	##################################################################################################
	############################################# UPDATE #############################################
	##################################################################################################
	
	/**
	 * Updateaza detaliile unei categorii
	 * @param unknown_type $cat_id
	 * @param array $data
	 * @author Baidoc
	 */
	function update($cat_id,$data){
		$this->db->where('id',$cat_id)->set($data)->update($this->categories);
	}
		
}