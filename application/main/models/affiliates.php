<?php
/**
 * Modelu pentru affiliati
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
Class Affiliates extends CI_Model{
	
	private $table = 'affiliates';
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza affiliate id-ul
	 * @param $cookie
	 * @return unknown_type
	 */
	function get_affiliate_from_cookie($cookie = FALSE){
		
		if($cookie > 0){
			return $cookie;
		}
		
		return NULL;
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza toti affiliati approved
	 * @author Baidoc
	 */	
	function get_all_approved(){
		return $this->db->where('status','approved')->get($this->table)->result();
	}
		
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un affiliat dupa hash
	 * @param integer $id
	 * @return object
	 */
	function get_one_by_hash($hash){
		return $this->db->where('hash',$hash)->limit(1)->get($this->table)->row();	
	}	
	
	
	
	##################################################################################################
	############################################ UPDATE ##############################################
	##################################################################################################
	
	/**
	* Adauga credite unui performer
	* @param $affiliate_id
	* @param $credits
	* @return unknown_type
	*/
	function add_credits($affiliate_id,$credits){		
		$this->db->query('UPDATE `affiliates` SET `credits` = `credits` + ' . $this->db->escape($credits) . ' WHERE `id` = ' . $this->db->escape($affiliate_id) );
	}	
}