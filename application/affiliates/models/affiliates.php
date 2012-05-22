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
	
	var $table = 'affiliates';
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza affiliate id-ul
	 * @param $cookie
	 * @return unknown_type
	 */
	function get_affiliate_id_from_cookie($cookie){
		//@TODO: get affiliate id
		return NULL;
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza tipul de affiliat
	 * @param $cookie
	 * @return unknown_type
	 */
	function get_affiliate_type_from_cookie($cookie){
		//@TODO: get affiliate type
		return NULL;		
	}
		
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un affiliat dupa id
	 * @param integer $id
	 * @return object
	 */
	function get_by_id($id){
		return $this->db->where('id',$id)->limit(1)->get($this->table)->row();
	}
		
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un affiliat dupa username
	 * @param string $username
	 * @return object 
	 */
	function get_by_username($username){
		return $this->db->where('username',$username)->limit(1)->get($this->table)->row();	
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
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un performer dupa email
	 * @param $email
	 * @return object
	 */
	function get_one_by_email($email){
		return $this->db->where('email',$email)->limit(1)->get($this->table)->row();
	}

	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un affiliat dupa token
	 * @param integer $id
	 * @return object
	 */
	function get_one_by_token($token){
		return $this->db->where('token',$token)->limit(1)->get($this->table)->row();	
	}	
	
		
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga sau editeaza un affiliate
	 * @param integer $id
	 * @return object
	 */
	public function save($rows){
		if(!is_array($rows) || count($rows) == 0){
			return FALSE;
		}
		if(isset($rows['id']) && $rows['id'] > 0){
			$this->db->update($this->table, $rows, array("id" => $rows['id']));
			return $rows['id'];
		}else{
			$this->db->insert($this->table, $rows);
			return $this->db->query("select last_insert_id() id")->row()->id;
		}
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Updateaza detaliile unui afiliat
	 * @param unknown_type $id
	 * @param unknown_type $data
	 * @author Baidoc
	 */
	function update($id,$data){
		$this->db->where('id',$id);
		$this->db->set($data);
		if($this->db->update($this->table)){
			return TRUE;
		}else{
			return FALSE;
		}		
		
	}
	

	
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