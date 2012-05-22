<?php

Class Payments extends MY_Model {
	
	private $table = 'payments';
	
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
	 * Returneaza platile pentru performerii unui studio dintro anumita data
	 * @param unknown_type $studio_id
	 * @param unknown_type $paid_date
	 * @author Baidoc
	 */
	function get_studio_payments($studio_id,$paid_date = FALSE, $status = FALSE){
		$this->db->select('performers.*,payments.*,payments.id as id');
		$this->db->join('performers','performers.id=payments.performer_id','inner')
		->where('performers.studio_id',$studio_id);
		
		if($paid_date){
			$this->db->where('paid_date',$paid_date);
		}
		
		if($status){
			$this->db->where('payments.status',$status);
		}
		
		return $this->db->get($this->table)->result();
	
	}
	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza platile pentru performerii unui studio dintro anumita data
	 * @param unknown_type $studio_id
	 * @param unknown_type $paid_date
	 * @author Baidoc
	 */
	function get_performer_payments($performer_id,$paid_date = FALSE, $status = FALSE){
		$this->db->select('performers.*,payments.*,payments.id as id');
		$this->db->join('performers','performers.id=payments.performer_id','inner');
		
		if($paid_date){
			$this->db->where('paid_date',$paid_date);
		}
		
		if($status){
			$this->db->where('payments.status',$status);
		}
		
		return $this->db->get($this->table)->result();
	
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza platile pentru performerii unui studio dintro anumita data
	 * @param unknown_type $studio_id
	 * @param unknown_type $paid_date
	 * @author Baidoc
	 */
	function get_affiliate_payments($affiliate_id,$paid_date = FALSE, $status = FALSE){
		$this->db->select('affiliates.*,payments.*,payments.id as id');
		$this->db->join('affiliates','affiliates.id=payments.affiliate_id','inner');
		
		if($paid_date){
			$this->db->where('paid_date',$paid_date);
		}
		
		if($status){
			$this->db->where('payments.status',$status);
		}
		
		return $this->db->get($this->table)->result();
	
	}
	
	
	
	
}