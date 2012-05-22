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
	 * Returneaza toate fmsurile
	 * @return unknown_type
	 */
	function get_multiple(){
		return $this->db->get($this->fms)->result();
	}
	
	#############################################################################################
	####################################### ADD #################################################
	#############################################################################################
	// -----------------------------------------------------------------------------------------	
	/**
	 * 
	 * @param $name
	 * @param $max_hosted_performers
	 * @param $status
	 * @param $fms
	 * @param $fms_for_video
	 * @param $fms_for_preview
	 * @param $fms_for_delete
	 * @param $fms_test
	 * @return unknown_type
	 */
	function add($name,$max_hosted_performers,$status,$fms,$fms_for_video,$fms_for_preview,$fms_for_delete,$fms_test){
		$data = array(
							'name'					=> $name,
							'max_hosted_performers' => $max_hosted_performers,
							'status' 				=> $status,
							'fms'					=> $fms,
							'fms_for_video'			=> $fms_for_video,
							'fms_for_preview'		=> $fms_for_preview,
							'fms_for_delete'		=> $fms_for_delete,
							'fms_test'				=> $fms_test
		);		
		
		$this->db->insert($this->fms,$data);
		$this->db->drop_memcache_key('fms_list');
	}
	
	#############################################################################################
	####################################### UPDATE ##############################################
	#############################################################################################
	// -----------------------------------------------------------------------------------------
	/**
	 * Update
	 * @param $fms_id
	 * @param $data
	 */
	function update($fms_id,$data){
		$this->db->where('fms_id',$fms_id)->update($this->fms,$data);
		$this->db->drop_memcache_key('fms_list');
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga/sterge numarul de performeri hostati pe fms
	 * @param $fms_id
	 * @param $modifier
	 * @return unknown_type
	 */
	function add_hosted_performer($fms_id,$modifier){
		$this->db->query('UPDATE `fms` SET `current_hosted_performers` = `current_hosted_performers` + ' . $this->db->escape($modifier) . ' WHERE `fms_id` = ' . $this->db->escape($fms_id) );
		$this->db->drop_memcache_key('fms_list');
	}	
	
	#############################################################################################
	####################################### DELETE ##############################################
	#############################################################################################
	// -----------------------------------------------------------------------------------------
	/**
	 * Sterge un fms dupa id
	 * @param $id
	 */
	function delete_by_id($id){
		$this->db->where('fms_id',$id)->delete($this->fms);
		$this->db->drop_memcache_key('fms_list');
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