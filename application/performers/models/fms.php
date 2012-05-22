<?php
Class Fms extends CI_Model{
	
	private $fms = 'fms';
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza un fms dupa id
	 * @param $id
	 * @return object
	 */
	function get_one_by_id($id){
		return $this->db->where('fms_id',$id)->limit(1)->get($this->fms)->row();
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza fmsul cu cei mai putini performeri hostati
	 * @return object
	 */
	function get_one_by_lowest_traffic(){
		return $this->db->order_by('current_hosted_performers','asc')->where('status','active')->limit(1)->get($this->fms)->row();
	}	

	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza mai multe FMSuri 
	 * @return unknown_type
	 */
	function get_multiple(){
		return $this->db->get($this->fms)->result();
	}
	
	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################

	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga/sterge numarul de performeri hostati pe fms
	 * @param $fms_id
	 * @param $modifier
	 * @return unknown_type
	 */
	function add_hosted_performer($fms_id,$modifier){
		$this->db->query('UPDATE `fms` SET `current_hosted_performers` = `current_hosted_performers` + ' . $this->db->escape($modifier) . ' WHERE `fms_id` = ' . $this->db->escape($fms_id) );		
	}

	
	############################ HELPERS ###############################
	/**
	 * Genereaza/verifica parametrii primit de la FMS
	 * @param $params
	 * @param $strict
	 * @return array
	 */
	function generate_params($params , $strict = FALSE){
		
		foreach ($params as $key => $param){
			$data[$param]	= $this->input->post($key);	
		}
		
		return $data;
	}	
}