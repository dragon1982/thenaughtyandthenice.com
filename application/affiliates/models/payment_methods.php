<?php
Class Payment_methods extends CI_Model{
	var $payment_methods 	= 'payment_methods';
	var $affiliates 		= 'affiliates';
	
	
	/**
	 * Returneaza un payment method dupa id
	 * @param unknown_type $id
	 * @author Baidoc
	 */
	function get_one_by_id($id){
		return $this->db->where('id', $id)->limit(1)->get($this->payment_methods)->row();
	}
	
	/**
	 * Returneaza toate metodele de plata aprobate
	 * @author Baidoc
	 */
	function get_all_approved() {
		return $this->db->where('status', 'approved')->get($this->payment_methods)->result();
	}

	
	##################################################################################################
	############################################# MODELARE ###########################################
	##################################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	* Returneaza metoda de plata dupa id dintr-un array
	* @param unknown_type $methods
	* @param unknown_type $payment_id
	* @author Baidoc
	*/
	function get_method_by_id($methods,$payment_id){
		if( ! $payment_id ){
			return FALSE;
		}
	
	
		if(is_array($methods) && sizeof($methods) !== 0){
			foreach($methods as $method){
				if($method->id == $payment_id){
					return $method;
				}
			}
		}
		return FALSE;
	}	
}