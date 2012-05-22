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
}