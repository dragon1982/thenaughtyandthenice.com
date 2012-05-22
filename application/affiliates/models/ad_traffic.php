<?php
/**
 * Modelu pentru ad traffic
 * @author CagunA
 *
 */
/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Email $email
 * @property CI_Form_validation $form_validation
 * @property CI_URI $uri
 * @property Firephp $firephp
 * @property CI_DB_active_record $db
 * @property Users $users
 */
Class Ad_traffic extends CI_Model{
	
	var $table = 'ad_traffic';
	

	
	
	
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
	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga sau editeaza un row
	 * @param array $id
	 * @return integer 
	 */
	public function save($rows){
		if(!is_array($rows) || count($rows) == 0){
			return FALSE;
		}
		if(isset($rows['id']) && $rows['id'] > 0){
			$this->db->update($this->table, $rows, array("id" => $rows['id']));
			return $rows['id'];
		}else{
			$this->db->insert($this->table, $rows);
			return $this->db->query("select last_insert_id() id")->row()->id;
		}
	}
	
	
	
	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza totalul castigurilor pentru un affiliate
	 * @param integer $id
	 * @return integer
	 */
	public function get_earning_by_affiliate_id($id){
		if($id <= 0){
			return FALSE;
		}
		
		return $this->db->select_sum('earnings', 'total')->where('affiliate_id', $id)->get($this->table)->row()->total;
	}
	
	

	
}