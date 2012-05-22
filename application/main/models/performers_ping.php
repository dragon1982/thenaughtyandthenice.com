<?php
class Performers_ping extends CI_Model{
	
	private $performers_ping = 'performers_ping';
	
	##################################################################################################
	############################################# GET ################################################
	##################################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza o lista de performeri cu pinguri vechi
	 * @param unknown_type $time
	 * @author Baidoc
	 */
	function get_multiple_expired_pings($time){
		return $this->db->where('last_ping <',$time)->get($this->performers_ping)->result();
	}

	##################################################################################################
	############################################# ADD ################################################
	##################################################################################################	

	// -----------------------------------------------------------------------------------------	
	/**
	 * Adaguga un ping de la performer
	 * @param unknown_type $performer_id
	 * @param unknown_type $time
	 * @author Baidoc
	 */
	function add_ping($performer_id,$time){
		$this->db->query(sprintf('INSERT INTO `%s` (`performer_id`,`last_ping`) VALUES (%s,%s) 
									ON DUPLICATE KEY UPDATE `last_ping` = %s',$this->performers_ping,$this->db->escape($performer_id),$time,$time));
	}

	##################################################################################################
	############################################# DEL ################################################
	##################################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Sterge un ping de la performer
	 * @param unknown_type $performer_id
	 * @author Baidoc
	 */
	function delete($performer_id){
		$this->db->where('performer_id',$performer_id)->delete($this->performers_ping);
	}
	
}