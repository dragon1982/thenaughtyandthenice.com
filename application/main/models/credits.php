<?php
Class Credits extends CI_Model{
	
	private $credits 		= 'credits';
	private $credits_detail = 'credits_detail';
		
	##################################################################################################
	############################################# GET ################################################
	##################################################################################################

		
	// -----------------------------------------------------------------------------------------
	/**
	 * returneaza credite dupa id
	 * @param $id
	 */	
	function get_one_by_id($id){
		$query = $this->db->where('id', $id, 1)->get('credits')->row();
		return $query;
	}
	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * reutnreaza credite dupa user_id
	 * @param $id
	 */
	function get_one_by_user_id($id){
		$query = $this->db->where('user_id', $id, 1)->get('credits')->row();
		return $query;
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza credite dupa invoice id
	 * @param $id
	 */
	function get_one_by_invoice_id($id){
		$query = $this->db->where('invoice_id', $id, 1)->get('credits')->row();
		return $query;
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * returneaza mai multe credite dupa user id
	 * @param $id
	 */
	function get_multiple_by_user_id($id, $limit, $offset, $filters, $count = FALSE){	
		$this->db->where('user_id', $id);
		
		
		if ( isset( $filters['start'] ) && is_int( $filters['start']) ) {
			$this->db->where('date >=', $filters['start']);
		}
		if ( isset( $filters['stop'] ) && is_int( $filters['stop']) ) {
			$this->db->where('date <=', $filters['stop']);
		}
		
		if( $count ){
			$this->db->select('count(id) as total');
			return $this->db->get($this->credits)->row()->total;			
		} else {
			$this->db->limit($limit);		
			$this->db->offset($offset);
			$this->db->order_by('id','desc');
			return  $this->db->get('credits')->result();
		}
	}
	
	##################################################################################################
	############################################# ADD ################################################
	##################################################################################################
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga in tabela credits datele
	 * @param int $amount_paid
	 * @param enum $currency_paid
	 * @param int $amount_received
	 * @param enum $currency_received
	 * @param int $date
	 * @param enum $type
	 * @param int $invoice_id
	 * @param enum $status
	 * @param int $user_id
	 * @return int/FALSE
	 */
	function add($amount_paid = 0,$currency_paid = 'USD',$amount_received = 0,$currency_received = 'chips', $date , $type = 'subscription' , $invoice_id = 0,$status = 'approved',$user_id = 0){
		
		$credits = new stdClass();
		$credits->currency_paid 	= $currency_paid;
		$credits->amount_paid 		= $amount_paid;
		$credits->currency_received = $currency_received;
		$credits->amount_received 	= $amount_received;
		$credits->date 				= $date;
		$credits->type 				= $type;
		$credits->invoice_id 		= $invoice_id;
		$credits->status 			= $status;
		$credits->user_id 			= $user_id;
		
		if($this->db->insert($this->credits, $credits)){
			return $this->db->insert_id();
		}
		 
		return FALSE;				
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga detaliile pentru un credit
	 * @param $log_table
	 * @param $log_id
	 * @param $special
	 * @param $extra_field
	 * @return boolean
	 */
	function add_credits_detail($log_table,$log_id,$special = NULL,$extra_field = NULL){
		$data = array(
			'log_table'		=> $log_table,
			'log_id'		=> $log_id,
			'special'		=> $special,
			'extra_field'	=> $extra_field
		);
		if($this->db->insert($this->credits_detail,$data)){
			return TRUE;
		}
		return FALSE;
	}
	
}