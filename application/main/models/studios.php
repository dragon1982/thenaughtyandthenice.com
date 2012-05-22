<?php
/**
 * Modelu pentru affiliati
 * @author adjunct VladG
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
Class Studios extends CI_Model{

	var $studios 		= 'studios';
	var $performers  	= 'performers';
	var $watchers 		= 'watchers';
	
	
	##################################################################################################
	############################################# GET ################################################
	##################################################################################################	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza ceva dupa id
	 * @param $id - parametru dupa case  se face update
	 * @return unknown_type
	 */
	function get_one_by_id($id) {
		return $this->db->where('id',$id)->limit(1)->get($this->studios)->row();
	} 

	/**
	 * Returneaza toate studiourile 
	 */
	function get_all(){
		return $this->db->get($this->studios)->result();
	}
	##################################################################################################
	############################################# ADD ################################################
	##################################################################################################	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Adauga credite unui studio
	 * @param $studio_id
	 * @param $credits
	 * @return unknown_type
	 */
	function add_credits($studio_id,$credits){
		$this->db->query('UPDATE `studios` SET `credits` = `credits` + ' . $this->db->escape($credits) . ' WHERE `id` = ' . $this->db->escape($studio_id) );
	}
	
	##################################################################################################
	########################################### UPDATE ###############################################
	##################################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Update studio details
	* @param $id - parametru dupa case  se face update
	* @param $update - tabelul in care se face update
	* @return unknown_type
	*/
	function update($id,$update) {
		$this->db->where('id',$id);
		$this->db->set($update);
		if($this->db->update($this->studios)){
			return TRUE;
		} else {
			return FALSE;
		}
	
	}	
		
}