<?php
class Chat_logs extends CI_Model{
	
	private $chat_logs = 'chat_logs';
	
	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Adauga un log pentru performer 
	 * @param unknown_type $performer_id
	 * @param unknown_type $add_date
	 * @param unknown_type $log
	 * @author Baidoc
	 */
	function add($performer_id,$add_date,$log){
		$data = array(
			'performer_id'	=> $performer_id,
			'add_date'		=> $add_date,
			'log'			=> $log	
		);
		
		$this->db->insert($this->chat_logs,$data);
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza logurile dupa filtre
	 * @param integer $performer_id
	 * @param integer $limit
	 * @param integer $offset
	 * @param array $filters
	 * @param array $joins
	 * @param boolean $count
	 * @return unknown_type
	 */
	function get_multiple_by_performer_id($performer_id, $limit= FALSE, $offset = FALSE, $filters = array(), $joins = array(), $count = FALSE) {
		if($count){
			$this->db->select('count(distinct(watchers.id)) as number');	
		} else {
			
			$this->db->select('chat_logs.*');
			
			//joins performer table
			if (isset($joins['performers'])) {
				$this->db->select('performers.username as performer');
				$this->db->join('performers', 'performers.id=chat_logs.performer_id', 'inner');
			}
			
						
			$this->db->order_by('chat_logs.id', 'desc');
			$this->db->limit($limit);
			$this->db->offset($offset);			
		}
		
		$this->db->where('chat_logs.performer_id', $performer_id);
		
		if (isset($filters['start'])) {
			$this->db->where('add_date >=', strtotime($filters['start']));
		}
		
		if (isset($filters['stop'])) {
			$this->db->where('add_date <', strtotime($filters['stop']));
		}
		
		if($count){
			return $this->db->get($this->chat_logs)->row()->number;
		} else {
			return $this->db->get($this->chat_logs)->result();
		}
	}	
}