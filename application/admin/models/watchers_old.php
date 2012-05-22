<?php

Class Watchers_old extends MY_Model{
	
	private $table = 'watchers_old';
	
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
	 * Returneaza o sessiune unica din wtf table
	 * @param $unique_id
	 * @author Baidoc
	 */
	function get_one_old_by_unique_id($unique_id){
		return $this->db->query('
								SELECT * FROM ' . $this->table . ' 
										WHERE
								`unique_id` = ' . $this->db->escape($unique_id) . '
								
								UNION
								
								SELECT * FROM ' . $this->old_table . '
										WHERE
								`unique_id` = ' . $this->db->escape($unique_id)
		)->row();
	}
		
	#############################################################################################
	####################################### HELPERE #############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Genereaza un id unic de watcher
	* @param $perfix - in caz ca o sa fie mai multe sisteme de chat integrate gen campoints
	* sa evitam coliziunea folosim prefixuri
	* @return unknown_type
	*/
	function generate_one_unique_id($prefix = 'a'){
	
		do{
			$hash = $prefix . sha1(uniqid(mt_rand(),TRUE));
			$exists = $this->get_one_old_by_unique_id($hash);
		}
		while($exists);
	
		return $hash;
	}	
	
}