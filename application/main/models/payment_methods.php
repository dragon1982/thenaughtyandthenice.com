<?php
Class Payment_methods extends CI_Model{
	var $payment_methods 	= 'payment_methods';
	var $performers 		= 'performers';
	
	
	##################################################################################################
	############################################# GET ################################################
	##################################################################################################
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza un payment method dupa id
	 * @param unknown_type $id
	 * @author Baidoc
	 */
	function get_one_by_id($id){
		return $this->db->where('id', $id)->limit(1)->get($this->payment_methods)->row();
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza toate payment methodurile aprobate
	 * @author Baidoc
	 */
	function get_all_approved() {
		return $this->db->where('status', 'approved')->get($this->payment_methods)->result();
	}
	
	
	
	##################################################################################################
	############################################# ADD ################################################
	##################################################################################################
	// -----------------------------------------------------------------------------------------		
	/**
	 * Adauga o metoda de plata unui perfomer dat prin ID
	 * @param $performer_id
	 * @param $payment_method_id
	 * @param $account
	 * @return unknown_type
	 */
	function add_payment_method($performer_id, $payment_method_id, $account) {
		return $this->db->where('id', $performer_id)
						->update($this->performers, array('payment' => $payment_method_id, 'account' => $account));
	}
	
	##################################################################################################
	############################################# EDIT ###############################################
	##################################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Editeaza o metoda de plata
	 * @param unknown_type $performer_id
	 * @param unknown_type $account
	 * @author Baidoc
	 */
	function edit_payment_method($performer_id, $account) {
		return $this->db->where('id', $performer_id)
						->set('account', $account)
						->update($this->performers);
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