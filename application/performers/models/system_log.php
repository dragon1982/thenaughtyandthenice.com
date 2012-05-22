<?php
class System_log extends CI_Model {
	var $system_logs = 'system_logs';
	
	function add($actor, $actor_id , $action_on, $action_on_id , $action, $message, $date, $ip) {
		return $this->db->insert(
			$this->system_logs,
			array(
				'actor'				=> $actor ,
				'actor_id'			=> $actor_id ,
				'action_on'			=> $action_on ,
				'action_on_id'		=> $action_on_id ,
				'action'			=> $action ,
				'action_comment'	=> $message ,
				'date'				=> $date ,
				'ip'				=> $ip
			)
		);
	}
}