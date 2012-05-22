<?php
/**
 * Users model
 * @author Andrei
 *
 */
/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Email $email
 * @property CI_Form_validation $form_validation
 * @property CI_URI $uri
 * @property Firephp $firephp
 * @property CI_DB_active_record $db
 * @property Users $users
 */
Class System_logs extends CI_Model{
	
	var $system_logs = 'system_logs';
	
	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################

	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un log in DB
	 * @param $date
	 * @param $actor
	 * @param $actor_id
	 * @param $action_on
	 * @param $action_on_id
	 * @param $action
	 * @param $action_comment
	 * @param $ip
	 * @param $key
	 * @return unknown_type
	 */
	function add($date,$actor,$actor_id,$action_on,$action_on_id,$action,$action_comment,$ip = NULL,$key = NULL){
		$data = array(
			'date'			=> $date,
			'actor'			=> $actor,
			'actor_id'		=> $actor_id,
			'action_on'		=> $action_on,
			'action_on_id'	=> $action_on_id,
			'action'		=> $action,
			'action_comment'=> $action_comment,
			'ip'			=> $ip,
			'key'			=> $key		
		);
		
		if($this->db->insert($this->system_logs,$data)){
			return $this->db->insert_id();
		}
		
		return FALSE;
	}	
}