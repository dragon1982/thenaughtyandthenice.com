<?php
/**
 * Modelu pentru zones
 * @author CagunA
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
Class Ad_zones extends CI_Model{
	
	var $table = 'ad_zones';
	

	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un ad_zone dupa id
	 * @param integer $id
	 * @return object
	 */
	function get_by_id($id){
		return $this->db->where('id',$id)->limit(1)->get($this->table)->row();	
	}	

	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un ad_zone dupa hash
	 * @param integer $id
	 * @return object
	 */
	function get_one_by_hash($hash){
		return $this->db->where('hash',$hash)->limit(1)->get($this->table)->row();	
	}	
	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga sau editeaza un ad_zone
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
	

	
}