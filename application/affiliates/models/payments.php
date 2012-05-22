<?php
class Payments extends CI_Model {
	
	var $payments = 'payments';
	
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################

	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza paymenturile dupa filtre sau numarul de paymenturi daca se da parametrul $count
	 * @param $affiliate_id
	 * @param $limit
	 * @param $offset
	 * @param $count
	 */
	function get_multiple_by_affiliate_id($affiliate_id, $limit = FALSE, $offset = FALSE,  $count = FALSE){
		if($count){
			$this->db->select('count(distinct(id)) as total');
		} else {
			$this->db->select('paid_date, amount_chips,from_date,to_date');
					 $this->db->limit($limit);
					 $this->db->offset($offset);
		}
		
		$this->db->from($this->payments)
				 ->where($this->payments . '.affiliate_id', $affiliate_id); 	
		
		
		$this->db->order_by('id','desc');
		
		if($count){
			return $this->db->get()->row()->total;
		} else {
			return $this->db->get()->result();
		}
	}
	
}