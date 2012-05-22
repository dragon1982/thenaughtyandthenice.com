<?php
Class Chart extends CI_Model{
	
	private $table = 'watchers_old';
	
	public function get_data($start_date, $end_date, $performer_id = FALSE, $studio_id = FALSE ){
		
		$this->db->select("COUNT(`id`) AS `total_sessions`, SUM(`performer_chips`) as `performer_earnings`, SUM(`studio_chips`) as `studio_earnings`, SUM(`duration`) as `duration`, `type`, `performer_id`, `studio_id`, UNIX_TIMESTAMP(FROM_UNIXTIME(`start_date`, '%Y-%m-%d')) as `date`", FALSE);
		$this->db->where('start_date >', $start_date );
		$this->db->where('end_date <', $end_date );
		
		if($studio_id > 0){
			$this->db->where('studio_id', $studio_id );
		}
		
		if($performer_id > 0){
			$this->db->where('performer_id', $performer_id );
		}
		
		$this->db->group_by("FROM_UNIXTIME(`start_date`, '%Y %m %d'), `type`", FALSE);
		return $this->db->get($this->table)->result();
	}
	
	
	public function get_registers_data($start_date, $end_date, $table){
		
		$this->db->select("COUNT(`register_date`) AS `total`, UNIX_TIMESTAMP(FROM_UNIXTIME(`register_date`, '%Y-%m-%d')) as `date`", FALSE);
		$this->db->where('register_date >', $start_date );
		$this->db->where('register_date <', $end_date );
		$this->db->group_by("FROM_UNIXTIME(`register_date`, '%Y %m %d')", FALSE);
		return $this->db->get($table)->result();
	}
	
	
	public function get_affiliates_traffic_data($start_date, $end_date, $affiliate_id = FALSE){
		
		$this->db->select("COUNT(`date`) AS `total`, `action`, sum(`earnings`) as earnings, UNIX_TIMESTAMP(FROM_UNIXTIME(`date`, '%Y-%m-%d')) as `date`", FALSE);
		$this->db->where('date >', $start_date );
		$this->db->where('date <', $end_date );
		if($affiliate_id > 0){
			$this->db->where('affiliate_id', $affiliate_id);
		}
		
		$this->db->group_by("FROM_UNIXTIME(`date`, '%Y %m %d'), `action`", FALSE);
		return $this->db->get('ad_traffic')->result();
	}
	
	
	public function get_payments_data($start_date, $end_date, $performer_id = FALSE, $studio_id = FALSE, $affiliate_id = FALSE){
		
		$this->db->select("COUNT(`id`) AS `total`, `amount_chips`, UNIX_TIMESTAMP(FROM_UNIXTIME(`paid_date`, '%Y-%m-%d')) as `date`", FALSE);
		$this->db->where('paid_date >', $start_date );
		$this->db->where('paid_date <', $end_date );
		
		if($affiliate_id > 0){
			$this->db->where('affiliate_id', $affiliate_id);
		}
		if($performer_id > 0){
			$this->db->where('performer_id', $performer_id);
		}
		if($studio_id > 0){
			$this->db->where('studio_id', $studio_id);
		}
		
		$this->db->group_by("FROM_UNIXTIME(`paid_date`, '%Y %m %d')", FALSE);
		return $this->db->get('payments')->result();
	}
	
	
	function get_credits_data($start_date, $end_date){
		
		$this->db->select("COUNT(`id`) AS `total_transactions`, SUM(`amount_paid`) as `amount_paid`,  UNIX_TIMESTAMP(FROM_UNIXTIME(`date`, '%Y-%m-%d')) as `date`,currency_paid", FALSE);
		$this->db->where('date >', $start_date );
		$this->db->where('date <', $end_date );
		$this->db->where('type !=','bonus');

		$this->db->group_by("FROM_UNIXTIME(`date`, '%Y %m %d'), `currency_paid`", FALSE);
		return $this->get_summary_credits($this->db->get('credits')->result());
	}
	
	
	function get_summary_credits($data){
		if( sizeof($data) == 0 ){
			return array();
		}
		
		$result = array();
		
		foreach($data as $line){
			
			if( ! isset( $result[$line->date]) ){
				$result[$line->date]['eur'] = 0;
				$result[$line->date]['usd'] = 0;
				$result[$line->date]['eur transactions'] = 0;
				$result[$line->date]['usd transactions'] = 0;
				$result[$line->date]['total transactions'] = 0;
			}
			
			
			if( $line->currency_paid == 'USD'){
				$result[$line->date]['usd'] += $line->amount_paid;
				$result[$line->date]['usd transactions'] += $line->total_transactions;
			}
			
			
			if( $line->currency_paid == 'EUR'){
				$result[$line->date]['eur'] += $line->amount_paid;
				$result[$line->date]['eur transactions'] += $line->total_transactions;				
			}
			
			
			$result[$line->date]['total transactions'] += $line->total_transactions;
		}
		
		return $result;		
	}	
	
}