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
		return $this->db->where('fms_id',$id)->get($this->fms)->row();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza mai multe FMSuri 
	 * @return unknown_type
	 */
	function get_multiple(){
		return $this->db->get($this->fms)->result();
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
			switch($key){
				case  'userId':
					if($this->input->get_post($key)){
						$data[$param]	= substr($this->input->get_post($key),1);
						break;
					}					
				default:
					$data[$param]	= $this->input->get_post($key);
			}		}
		
		return $data;
	}	
}