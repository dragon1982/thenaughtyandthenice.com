<?php
Class Test_Gateway extends Payment{
	
	var $table;
	
	// -----------------------------------------------------------------------------------------	
	/**
	 *  Constructor
	 */
	function __construct($user){
		//creare instanta la obiectu CI
		$this->CI = & get_instance();
		
		//incarcare 
		$this->CI->load->model(strtolower(__CLASS__).'_processor');
		
		$this->table = strtolower(__CLASS__).'_processor';
		
		$this->user = $user;
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Sugere de bani
	 * @param Array $data 
	 */
	function auth($data = array()){
		$log_id = $this->CI->test_gateway_processor->log($data);
		return array('success'=>TRUE,'log_table'=>$this->table,'log_id'=>$log_id,'invoice_id'=>mt_rand(100000000,900000000));
	}	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * 
	 * 
	 */
	function get_payment_page($data = array()){
		
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * (non-PHPdoc)
	 * @see web/application/main/third_party/Payment#refund()
	 */
	function refund($data = array()){
		
	}
	
	
	/**
	 * Verifica daca raspunsu 
	 * @param array $response
	 * @return boolean
	 */
	protected function check_fraud($response = FALSE){
		if( ! isset($response['REASON'])){
			return FALSE;
		}
		
		foreach($this->blacklist as $blacklisted) {
			if( strpos ( strtolower ( $response['REASON'] ) , $blacklisted ) !== FALSE){
				$this->mark_as_fraud($response['REASON']);
				return TRUE;
			} 
		}
	}	
	
}
