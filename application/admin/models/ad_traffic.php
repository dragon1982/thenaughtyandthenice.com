<?php

Class Ad_traffic extends MY_Model{
	
	private $table = 'ad_traffic';
	
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
	 * Returneaza traffic dupa ad_id si un interval de timp 
	 * @param integer $id
	 * @return object
	 */
	function get_by_affiliate_id($affiliate_id, $start_date = FALSE, $end_date = FALSE){
		
		$this->db->select('sum(`ad_traffic`.`earnings`) as earning, count(`action`) as actions, `ad_id`, `action`, name', TRUE);
		
		$this->db->where('ad_traffic.affiliate_id',$affiliate_id);
		
		$this->db->join('ad_zones', 'ad_traffic.ad_id = ad_zones.id', 'left');

		if($start_date > 0){
			$this->db->where('date >', $start_date);
		}
		
		if($end_date > 0){
			$this->db->where('date <', $end_date);
		}
		
		$this->db->group_by('ad_id, action');
		
		return $this->db->get($this->table)->result();	
	}	
}