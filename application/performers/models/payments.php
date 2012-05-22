<?php
class Payments extends CI_Model {
	
	var $payments = 'payments';
	
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################

	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza un payment dupa id
	 * @param unknown_type $payment_id
	 * @author Baidoc
	 */
	function get_one_by_id($payment_id){
		return $this->db->where('id',$payment_id)->get($this->payments)->row();
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza paymenturile dupa filtre sau numarul de paymenturi daca se da parametrul $count
	 * @param $user_id
	 * @param $limit
	 * @param $offset
	 * @param $filters
	 * @param $count
	 */
	function get_multiple_by_performer_id($performer_id, $limit = FALSE, $offset = FALSE, $filters, $count = FALSE){
		if($count){
			$this->db->select('count(distinct(id)) as total');
		} else {
			$this->db->select('id,paid_date, amount_chips,from_date,to_date');
					 $this->db->limit($limit);
					 $this->db->offset($offset);
		}
		
		$this->db->from($this->payments)
				 ->where($this->payments . '.performer_id', $performer_id); 	
		
		if($filters['start']) {
			$this->db->where('paid_date >=', strtotime($filters['start']));
		}

		if($filters['stop']) {
			$this->db->where('paid_date <', strtotime($filters['stop']));
		}
		
		$this->db->order_by('id','desc');
		
		if($count){
			return $this->db->get()->row()->total;
		} else {
			return $this->db->get()->result();
		}
	}	
}