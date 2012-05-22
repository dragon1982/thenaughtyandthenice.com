<?php

Class Status extends CI_Model{

	
	/**Returneaza toate inregistrarile pentru un performer din tabelul dat ca si parametru (contracts, performers_photo_id)
	 * 
	 * @param $tabel - tabelul din care dorim sa luam datele
	 * @param $id
	 * @return unknown_type
	 */
	function get_all_by_performer_id($tabel, $id, $limit = FALSE, $offset = FALSE, $count = FALSE){
		if($count) {
			$this->db->select('count(*) as number');
		}
		$this->db->where('performer_id', $id)->from($tabel);
		if($limit) {
			$this->db->limit($limit);
		}
		if($offset) {
			$this->db->offset($offset);
		}
		if($count) {
			return $this->db->get()->row()->number;
		}
		else {
			return $this->db->get()->result();
		}
	}
	
	/**Returneaza toate inregistrarile pentru un studio din tabelul contracts
	 * 
	 * @param $tabel - tabelul din care dorim sa luam datele
	 * @param $id
	 * @return unknown_type
	 */
	function get_all_by_studio_id($id, $limit = FALSE, $offset = FALSE, $count = FALSE){
		if($count) {
			$this->db->select('count(*) as number');
		}
		$this->db->where('studio_id', $id)->from('contracts');
		if($limit) {
			$this->db->limit($limit);
		}
		if($offset) {
			$this->db->offset($offset);
		}
		if($count) {
			return $this->db->get()->row()->number;
		}
		else {
			return $this->db->get()->result();
		}
	}
	
	/**Seteaza statusul pentru tabelul dorit dupa id
	 * 
	 * @param $tabel
	 * @param $status
	 * @param $id
	 * @return unknown_type
	 */	
	function set_status($tabel, $status, $id){
		if($tabel == 'contracts' OR $tabel == 'performers_photo_id') {
			return $this->db->where('id', $id)->update($tabel, array('status' => $status));
		}
	}	
	
	/**Verifica daca exista statusul dat ca si parametru pentru un anumit performer / studio
	 * 
	 * @param $tabel
	 * @param $status
	 * @param $id
	 * @return unknown_type
	 */
	function verify_status($tabel, $status, $id , $is_studio = FALSE){
		if($tabel == 'contracts' OR $tabel == 'performers_photo_id') {
			$query = $this->db->get_where($tabel, array(($is_studio)?'studio_id':'performer_id' => $id , 'status' => $status));
			if($query->num_rows >= 1) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}	
}