<?php
/**
 * Failure logins table
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
class Failure_logins extends CI_Model{
	
	var $failure_logins = 'failure_logins';
	
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################
		
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un failure login dupa ip
	 * @param $ip
	 * @return unknown_type
	 */
	function get_one_by_ip($ip){
		return $this->db->where('ip',$ip)->get($this->failure_logins)->row();
	}
	
	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################
		
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un failuire
	 * @param $ip
	 * @param $username
	 * @return unknown_type
	 */
	function add($ip,$username){
		$this->db->insert(
			$this->failure_logins,
			array(
				'ip'			=> $ip,
				'username' 		=> $username,
				'failed_logins' => 1,
				'last_failure'	=> time()
			)
		);
	}	
	
	#############################################################################################
	######################################### UPDATE ############################################
	#############################################################################################

	// -----------------------------------------------------------------------------------------
	/**
	 * Incrementeaza failurile pe baza de ip
	 * @param $ip
	 * @param $failures
	 * @param $username
	 * @return unknown_type
	 */
	function increment_failures_by_ip($ip, $failures, $username){
		$record = $this->get_one_by_ip($ip);
		if(	! $record ) {
			$this->add($ip, $username);
			
			return;
		}

		$record->username 		= $username;
		$record->failed_logins 	= $failures+1;
		$record->last_failure 	= time();

		$this->db->set($record)->where('id', $record->id)->update($this->failure_logins);
	}	
	
	#############################################################################################
	######################################### DELETE ############################################
	#############################################################################################
		
	// -----------------------------------------------------------------------------------------
	/**
	 * Sterge incarcarile nereusite de login pe baza de ip
	 * @param $ip
	 * @return unknown_type
	 */
	function delete_failures_by_ip($ip){
		$this->db->where('ip',$ip)->delete($this->failure_logins);
	}
	
}