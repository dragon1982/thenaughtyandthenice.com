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
}