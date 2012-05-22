<?php
// -------------------------------------------------------------------------
if( ! function_exists('prepare_themes_dropdown')){
	
	/**
	 * THemes list
	 * @return multitype:unknown 
	 * @author Baidoc
	 */
	function prepare_themes_dropdown() {
		$CI = &get_instance();
		$CI->load->helper('directory');
		$map = directory_map('./assets/', 1);
		$themes = array();
		foreach($map as $item) {
			if(substr($item, 0 ,7) == "modena_") {
				$themes[$item] = $item;
			}
		}
		return $themes;
	}
}

// -------------------------------------------------------------------------
if( ! function_exists('implode_to_array')){
	
	/**
	 * Pentru blacklist sa genereze datele
	 * @param unknown_type $data
	 * @author Baidoc
	 */
	function implode_to_array($data){
		if( ! is_array($data)){
			return NULL;
		}
		if(sizeof($data) == 0){
			return NULL;
		}

		$glue = '';
		foreach($data as $row=>$line){
			$glue .= "'" . $line . "',";
		}
		
		return substr($glue,0,-1);
	}
}

// ---------------------------------------------------------------
if( ! function_exists('array2url')  ){
	
	/**
	 * Transforma un array in parametru de get/post
	 * @param $array
	 * @return unknown_type
	 */
	function array2url($array, $append_array_name = FALSE){
		
		if( ! is_array($array) || sizeof($array) == 0){
			return '';
		}
		
		$string = '';
		foreach( $array as $key => $value ){
			
			if( is_array($value) ) continue;
			if( $append_array_name === FALSE ){
				$string .= $key . '=' . urlencode(htmlentities($value)) . '&';
			} else {
				$string .= $append_array_name . '[' . $key . ']=' . urlencode(htmlentities($value)) . '&';
			}
		}
		
		if( strlen($string) > 0 ){
			return substr($string,0,-1);
		}
		
		return '';
	}
}
