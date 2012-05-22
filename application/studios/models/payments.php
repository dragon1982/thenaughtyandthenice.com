<?php
/**
 * Modelu pt platile efectuate
 * @author Andrei
 *
 */
Class Payments extends CI_Model{
	
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
			$this->db->select('paid_date, amount_chips,from_date,to_date');
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
		
	// -----------------------------------------------------------------------------------------
	/**
	* Returneaza paymenturile dupa filtre sau numarul de paymenturi daca se da parametrul $count
	* @param $user_id
	* @param $limit
	* @param $offset
	* @param $count
	*/
	function get_multiple_by_studio_id($studio_id, $limit = FALSE, $offset = FALSE,  $count = FALSE){
		if($count){
			$this->db->select('count(distinct(id)) as total');
		} else {
			$this->db->select('paid_date, amount_chips,from_date,to_date,id');
			$this->db->limit($limit);
			$this->db->offset($offset);
		}
		
		$this->db->from($this->payments)->where($this->payments . '.studio_id', $studio_id)->where($this->payments . '.performer_id IS NULL');
		
				
		$this->db->order_by('id','desc');
		
		if($count){
			return $this->db->get()->row()->total;
		} else {
			return $this->db->get()->result();
		}
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza platile pentru performerii unui studio dintro anumita data
	 * @param unknown_type $studio_id
	 * @param unknown_type $paid_date
	 * @author Baidoc
	 */
	function get_studio_payments($studio_id,$paid_date){
		$this->db->select('performers.*,payments.*,payments.id as id');
		$this->db->join('performers','performers.id=payments.performer_id','inner')
				 ->where('performers.studio_id',$studio_id)
				 ->where('paid_date',$paid_date);
		
		return $this->db->get($this->payments)->result();
	}
		
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza platile facute catre un studio
	 * @param $studio_id
	 * @return unknown_type
	 */
	function get_payments_by_studio_id($studio_id){
		return $this->db->where('account_id',$studio_id)->where('to','studio')->get($this->payments)->result();
	}
}