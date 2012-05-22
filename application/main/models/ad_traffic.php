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
	function get_by_ad_id($ad_id, $start_date = FALSE, $end_date = FALSE){		
		$this->db->where('ad_id',$ad_id);

		if($start_date > 0){
			$this->db->where('date >', $start_date);
		}
		
		if($end_date > 0){
			$this->db->where('date <', $end_date);
		}
				
		return $this->db->get($this->table)->result();	
	}	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Calculeaza castigurile unui studio din o anumita perioada
	 * @param unknown_type $affiliate_id
	 * @param unknown_type $start
	 * @param unknown_type $stop
	 * @author Baidoc
	 */
	function get_earnings_by_affiliate_id($affiliate_id,$start,$stop){
		return $this->db->select('SUM(earnings) as total')->where('affiliate_id',$affiliate_id)
					->where('date >',$start)->where('date <=',$stop)->get($this->table)->row()->total;
	}	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga sau editeaza un row
	 * @param integer $id
	 * @return object
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
	

	
}