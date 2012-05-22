<?php
class System_log extends MY_Model{
	
	
	private $table = 'system_logs';
	
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
	
	
	function add($actor, $actor_id , $action_on, $action_on_id , $action, $message, $date, $ip) {
		return $this->db->insert(
		$this->table,
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