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
		
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un studio dupa hash
	 * @param $hash
	 * @return unknown_type
	 */
	function get_one_by_hash($hash){
		return $this->db->where('hash',$hash)->limit(1)->get($this->studios)->row();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un studio dupa username
	 * @param $username
	 * @return unknown_type
	 */
	function get_one_by_username($username){
		return $this->db->where('username',$username)->limit(1)->get($this->studios)->row();
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un performer dupa email
	 * @param $email
	 * @return object
	 */
	function get_one_by_email($email){
		return $this->db->where('email',$email)->limit(1)->get($this->studios)->row();
	}
		
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza performere dupa studio
	 * @param $id - parametrul dupa care cauta
	 * @param $filter - filtru
	 * @return array
	 */
	function get_multiple_performers_by_studio_id($studio_id, $filters = FALSE) {		

		$this->db->where('studio_id', $studio_id);

		if(isset($filters['status']) && ($filters['status'] == 'approved' || $filters['status'] == 'pending' || $filters['status'] == 'rejected' )){
			$this->db->where('performers.status', $filters['status']);
		}
		if(isset($filters['contract']) && ($filters['contract'] == 'approved' || $filters['contract'] == 'pending' || $filters['contract'] == 'rejected' )){
			$this->db->where('contract_status', $filters['contract']);
		}
		if(isset($filters['photo_id']) && ($filters['photo_id'] == 'approved' || $filters['photo_id'] == 'pending' || $filters['photo_id'] == 'rejected' )){
			$this->db->where('photo_id_status', $filters['photo_id']);
		}
		if(isset($filters['webcam']) && ($filters['webcam'] == 'approved' || $filters['webcam'] == 'pending' || $filters['webcam'] == 'rejected' )){
			$this->db->where('webcam_picture_status', $filters['webcam']);
		}		

		return $this->db->get($this->performers)->result();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un studio in baza de date
	 * @param unknown_type $username
	 * @param unknown_type $password
	 * @param unknown_type $hash
	 * @param unknown_type $email
	 * @param unknown_type $firstname
	 * @param unknown_type $lastname
	 * @param unknown_type $status
	 * @param unknown_type $address
	 * @param unknown_type $state
	 * @param unknown_type $city
	 * @param unknown_type $zip
	 * @param unknown_type $phone
	 * @param unknown_type $payment
	 * @param unknown_type $ip
	 * @param unknown_type $contract_status
	 * @param unknown_type $account
	 * @param unknown_type $percentage
	 * @author Alex
	 */
	function add($username,$password,$hash,$email,$firstname,$lastname,$status = 'pending',$time,$ip,$contract_status,$address,$state,$city,$zip,$phone,$country,$payment, $account, $percentage,$release = 0){
		$this->db->insert(
			$this->studios,
			array(
				'username'			=> $username ,
				'password '			=> $password ,
				'hash'				=> $hash ,
				'email'				=> $email ,
				'first_name'		=> $firstname ,
				'last_name'			=> $lastname ,
				'status'			=> $status ,
				'register_date'		=> $time ,
				'register_ip'	    => $ip,
				'contract_status'   => $contract_status,
				'address'		    => $address ,
				'state'				=> $state ,
				'city'				=> $city ,
				'zip'				=> $zip ,
				'phone'				=> $phone,
				'country_code'		=> $country ,
				'payment'			=> $payment ,		//metoda de plata, 1-2-3-4-5 (paypal, cec, ...)
				'account'			=> $account ,
				'percentage'		=> $percentage,
				'release'			=> $release
			)
		);
		
		return $this->db->insert_id();
	}
	
	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza castigurile pentru performer dupa id
	 * @return unknown_type
	 */
	function get_studio_earnings_by_performer_id($performer_id) {
		
	}

	// -----------------------------------------------------------------------------------------	
	/**
	 * Construieste sumarul pentru performeri
	 * @param array $performers 
	 * @param pointer $data
	 * @return array
	 */
	function get_multiple_performers_summary($performers , & $data){
		$data['approved_performers'] 				= 0;
		$data['contract_approved_performers'] 		= 0;
		$data['photo_id_approved_performers'] 		= 0;
		$data['webcam_capture_approved_performers'] = 0;

		$data['pending_performers'] 				= 0;
		$data['contract_pending_performers'] 		= 0;
		$data['photo_id_pending_performers'] 		= 0;
		$data['webcam_capture_pending_performers'] 	= 0;

		$data['rejected_performers'] 				= 0;
		$data['contract_rejected_performers'] 		= 0;
		$data['photo_id_rejected_performers'] 		= 0;
		$data['webcam_capture_rejected_performers'] = 0;

		foreach($performers as $performer){
			// count status
			if($performer->status == 'approved'){
				$data['approved_performers']++;
			}

			if($performer->status == 'pending'){
				$data['pending_performers']++;
			}

			if($performer->status == 'rejected'){
				$data['rejected_performers']++;
			}

			//count contract status
			if($performer->contract_status == 'approved'){
				$data['contract_approved_performers']++;
			}

			if($performer->contract_status == 'pending'){
				$data['contract_pending_performers']++;
			}

			if($performer->contract_status == 'rejected'){
				$data['contract_rejected_performers']++;
			}

			//count photo_id status
			if($performer->photo_id_status == 'approved'){
				$data['photo_id_approved_performers']++;
			}

			if($performer->photo_id_status == 'pending'){
				$data['photo_id_pending_performers']++;
			}

			if($performer->photo_id_status == 'rejected'){
				$data['photo_id_rejected_performers']++;
			}

		}		
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
	
	
	##################################################################################################
	########################################## MODELARE ##############################################
	##################################################################################################	
	// -----------------------------------------------------------------------------------------
	/**
	 * Verifica daca userul e aprobat automat sau e in pending default
	 * @return unknown_type
	 */
	function require_verification(){
		if( ! EMAIL_ACTIVATION ){
			return FALSE;
		}
		return TRUE;
	}	
}
