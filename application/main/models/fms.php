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
		return $this->db->set_memcache_key('fms_list',array(),5000)->get($this->fms)->result();
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
	
	#############################################################################################
	######################################### EDIT ##############################################
	#############################################################################################		
	// -----------------------------------------------------------------------------------------
	/**
	 * Updateaza detaliile unui fms
	 * @param $id
	 * @param $data
	 * @return unknown_type
	 */
	function update($id,$data){
		$this->db->where('fms_id',$id)->update($this->fms,$data);
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
					if($this->input->post($key)){
						$data[$param]	= substr($this->input->get_post($key),1);
						break;
					}					
				default:
					$data[$param]	= $this->input->get_post($key);
			}
				
		}
		
		return $data;
	}		
}