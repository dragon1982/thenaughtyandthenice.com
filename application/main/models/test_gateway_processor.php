<?php
Class Test_gateway_processor extends CI_Model{
	
	private $test_gateway_processor = 'test_gateway_processor';
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Logheaza actiunea gatewayului
	 * @param $data
	 * @return unknown_type
	 */
	function log($data){
		if($this->db->insert($this->test_gateway_processor,$data)){
			return $this->db->insert_id();
		}
						
		return FALSE;
	}
}