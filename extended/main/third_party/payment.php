<?php
abstract class Payment {
	
	private $user;
	private $CI;
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza o instanta catre una din gatewayuri
	 * @param $user
	 * @param $forced_gateway
	 * @return unknown_type
	 */
	static function get_instance($user,$forced_gateway = FALSE){
		
		//demo only
		$forced_gateway = 'test_gateway';
		
		//am primit un gateway?
		if($forced_gateway){
			
			//if file does not exist
			if( ! file_exists( APPEXPATH . 'third_party/' . strtolower($forced_gateway).EXT )){
				die('Payment gateway ' . $forced_gateway . ' not implemented!');
			}
			
			require_once APPEXPATH . 'third_party/' . strtolower($forced_gateway).EXT;
			return new $forced_gateway($user);	
		}	
		
		
		//folosesc gatewayu default alocat userului
		switch($user->gateway){
			case 'test_gateway':{
				//demo only				
				require_once APPEXPATH . 'third_party/test_gateway.php';
				return new test_gateway($user);
			}
		}		
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza pagina de plata unde este redirectionat utilizatorul
	 * @return string
	 */
	abstract function get_payment_page();
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Suge bani din contu utilizatorului
	 * @return unknown_type
	 */
	abstract function auth();
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Functia de refund
	 * @return unknown_type
	 */
	abstract function refund();
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Genereaza dintrun array un url-string
	 * @param $params
	 * @return string
	 */
	function implode( $params ){
		$result = '';
		foreach( $params as $key=>$value ){
			$result .= '&' . $key . '=' . urlencode($value);
		}
		
		return $result;
	}


	// -----------------------------------------------------------------------------------------	
	/**
	 * Parseaza un XML
	 * @param $response
	 * @return array
	 */
	function parser($response = FALSE){
		if( ! $response ){
			return FALSE;
		}		
		$this->CI = &get_instance();
		
		$this->CI->load->library('MY_XML_Parser');
		
		$parsed = $this->CI->my_xml_parser->parse($response);
		
		if( ! $parsed ){
			return FALSE;
		}
		
		return $parsed;	
	}	
}