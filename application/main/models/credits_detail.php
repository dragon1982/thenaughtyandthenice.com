<?php
Class Credits_detail extends CI_Model{
	
	private $credits_detail = 'credits_detail';
	
	##################################################################################################
	############################################# ADD ################################################
	##################################################################################################
	function add($credit_id,$log_table,$log_id,$special = NULL,$extra_field = NULL){
		$data = array(
			'credit_id'	=> $credit_id,
			'log_table'	=> $log_table,
			'log_id'	=> $log_id,
			'special'	=> $special,
			'extra_field'=> $extra_field
		);
		
		$this->db->insert($this->credits_detail,$data);
	}
}