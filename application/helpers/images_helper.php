<?php

// -------------------------------------------------------------------------
if( ! function_exists('check_for_valid_type') ) {
	
	function check_for_valid_type($file_path){
		if( ! file_exists($file_path) ){
			return FALSE;
		}
		
		$ext = substr(strrchr($file_path, '.'), 1);
		
		switch($ext){
			case 'pdf':{
				return check_for_valid_pdf($file_path);
			}
			case 'zip':{
				return check_for_valid_zip($file_path);
			}
			default:{
				return check_for_valid_image($file_path);
			}
			
		}
	
	}
}

if( ! function_exists('check_for_valid_zip') ){
	/**
	 * Valideaza un zip
	 * @param unknown_type $zip_path
	 * @author Baidoc
	 */
	function check_for_valid_zip($zip_path){
		
		require_once 'application/libraries/pclzip.lib.php';
		
		try{
			$zip = new PclZip($zip_path);
			if (($list = $zip->listContent()) == 0) {
				return FALSE;
			}			
		}catch(Exception $e){
			return FALSE;
		}
		
		return TRUE;
		
	}
}

if( ! function_exists('check_for_valid_pdf') ){

	/**
	 * PDF validation 
	 * @param unknown_type $pdf_path
	 * @author Baidoc
	 */
	function check_for_valid_pdf($pdf_path){
		require_once 'application/libraries/pdf/fpdf.php';
		require_once 'application/libraries/pdf/fpdi.php';
		
		try{
			$pdf = new FPDI();
			// add a page
			$pdf->AddPage();
			// set the sourcefile
			@$pdf->setSourceFile($pdf_path);
			unset($pdf);						
		}catch(Exception $e){
			return FALSE;
		}
		
		return TRUE;
	}
}

// -------------------------------------------------------------------------
if ( ! function_exists('check_for_valid_image')) {
	
	/**
	 * Verifica daca imaginea e valida
	 * @param $image_path
	 * @return bool
	 */
	function check_for_valid_image($image_path){	
		try{
			$properties = getimagesize($image_path);
		}catch (Exception $e){
			return FALSE;
		}
		
		//properties nu e array, nu continue cel putin 3 elemente, widht si height < 16
		if( ! is_array($properties) || sizeof($properties) < 3 || $properties[0] < 16 || $properties[1] < 16 ){
			return FALSE;
		}
		
		$CI = & get_instance();
		
		$config['image_library'] 	= 'gd2';
		$config['source_image'] 	= $image_path;
		$config['create_thumb'] 	= FALSE;
		$config['maintain_ratio'] 	= FALSE;
		$config['width'] 			= $properties[0];
		$config['height'] 			= $properties[1];
		
		$CI->load->library('image_lib', $config);

		if($CI->image_lib->resize()){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
