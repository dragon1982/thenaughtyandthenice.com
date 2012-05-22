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
Class Users extends CI_Model{
	
	var $users 			= 'users';
	var $users_detail 	= 'users_detail';
	#############################################################################################
	##################################### DATABASE ##############################################
	#############################################################################################
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza userul dupa id
	 * @param $id
	 * @return object
	 */
	function get_one_by_id($id){		
		return $this->db->where('id',$id)->set_memcache_key('id-%s',array($id),3)->get($this->users)->row();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un user dupa id, si face join in tabela user_details
	 * @param $id
	 * @return object
	 */
	function get_one_by_id_and_full_details($id){
		return $this->db->where('id',$id)->join($this->users_detail,'users_detail.user_id = users.id ','inner')->get($this->users)->row();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un user dupa username
	 * @param $username
	 * @return unknown_type
	 */
	function get_one_by_username($username){
		return $this->db->where('username',$username)->get($this->users)->row();
	}
		
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza un user dupa hash
	 * @param $hash
	 * @return object
	 */
	function get_one_by_hash($hash){
		return $this->db->where('hash',$hash)->get($this->users)->row();
	}
	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################

	// -----------------------------------------------------------------------------------------	
	/**
	 * Adauga un user in baza de date
	 * @param $username
	 * @param $password
	 * @param $hash
	 * @param $email
	 * @param $status
	 * @param $gateway
	 * @param $credits
	 * @return unknown_type
	 */
	function add($username,$password,$hash,$email,$status = 'pending',$gateway,$credits){
		$this->db->insert($this->users,
			array(
				'username'			=> $username,
				'password'			=> $password,
				'hash'				=> $hash,
				'email'				=> $email,
				'status'			=> $status,
				'gateway'			=> $gateway,
				'credits' 			=> $credits
			)
		);
		
		return $this->db->insert_id();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga detaliile pentru un user
	 * @param $user_id
	 * @param $register_ip
	 * @param $register_date
	 * @param $country_code
	 * @param $newsletter
	 * @param $affiliate_id
	 * @param $affiliate_type
	 * @return null
	 */	
	function add_users_detail($user_id,$register_ip,$register_date,$country_code,$newsletter,$affiliate_id,$affiliate_type){
		$this->db->insert($this->users_detail,
			array(
				'user_id'		=> $user_id,
				'register_ip'	=> $register_ip,
				'register_date'	=> $register_date,
				'country_code'	=> $country_code,
				'newsletter'	=> $newsletter,
				'affiliate_id'	=> $affiliate_id,
				'affiliate_type'=> $affiliate_type
			)			
		);
	}

	#############################################################################################
	######################################### UPDATE ############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Updateaza un user
	 * @param $id
	 * @param $update
	 * @return boolean
	 */
	function update($id,$update){	
		$this->db->where('id',$id);
		$this->db->set($update);
		if($this->db->update($this->users)){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Updateaza detaliile unui user
	 * @param $id
	 * @param $update
	 * @return boolean
	 */
	function update_details($id,$update){	
		$this->db->where('user_id',$id);
		$this->db->set($update);
		if($this->db->update($this->users_detail)){
			return TRUE;
		} else {
			return FALSE;
		}
	}	

	
	#############################################################################################
	######################################### DELETE ############################################
	#############################################################################################
		
	// -----------------------------------------------------------------------------------------
	
	
	#############################################################################################
	##################################### MODELING ##############################################
	#############################################################################################
	
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