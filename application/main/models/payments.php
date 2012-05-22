<?php
class Payments extends CI_Model{
	
	var $payments = 'payments';
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza ultimul payment dupa filtru 
	 * @param $filters
	 * @return unknown_type
	 */
	function get_last_payment_by_filters($filters = array()){
		if(isset($filters['studio_id'])){
			$this->db->where('studio_id',$filters['studio_id']);
		}
		
		if(isset($filters['performer_id'])){
			$this->db->where('performer_id',$filters['performer_id']);
		}
		
		if(isset($filters['affiliate_id'])){
			$this->db->where('affiliate_id',$filters['affiliate_id']);
		}
		
		return $this->db->order_by('paid_date','desc')->limit(1)->get($this->payments)->row();
	}	
	
	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un payment
	 * @param unknown_type $paid_date
	 * @param unknown_type $from_date
	 * @param unknown_type $to_date
	 * @param unknown_type $amount
	 * @param unknown_type $status
	 * @param unknown_type $comment
	 * @param unknown_type $account
	 * @param unknown_type $payment_name
	 * @param unknown_type $studio_id
	 * @param unknown_type $performer_id
	 * @param unknown_type $affiliate_id
	 * @author Baidoc
	 */
	function add($paid_date,$from_date,$to_date,$amount,$status,$comment,$account, $payment_name,$studio_id = NULL,$performer_id = NULL,$affiliate_id = NULL){	
		$data = array(
			'paid_date'				=> $paid_date,
			'from_date'				=> $from_date,
			'to_date'				=> $to_date,
			'amount_chips'			=> $amount,
			'status'				=> $status,
			'comments'				=> $comment,
			'payment_fields_data'	=> $account,
			'payment_name'			=> $payment_name,
			'studio_id'				=> $studio_id,
			'performer_id'			=> $performer_id,
			'affiliate_id'			=> $affiliate_id
		);
		
		$this->db->insert($this->payments,$data);
	}
}