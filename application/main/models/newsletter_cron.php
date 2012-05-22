<?php

Class Newsletter_cron extends CI_Model {
	
	private $table = 'newsletter_cron';
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza tot din tabela newsletter_cron cu sau fara limita
	 * 
	 * @param integer $limit
	 * @return array 
	 */
	function get_all($limit){
		
		$this->db->where('sent',0);		
		if($limit > 0){
			$this->db->limit($limit);
		}
		
		return $this->db->get($this->table)->result();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Updateaza un cron
	 * @param unknown_type $id
	 * @param unknown_type $data
	 * @author Baidoc
	 */	
	function update($id,$data){
		 $this->db->where('id',$id)->set($data)->update($this->table);
	}
	
}