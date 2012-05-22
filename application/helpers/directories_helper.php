<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Directory management
 * 
 * @author Baidoc
 * @package performers,studios
 */


// -------------------------------------------------------------------------
if ( ! function_exists('generate_directory')) {
	
	/**
	 * Genereaza directoarele necesare pentru performer/studio
	 * @param $user_type (studio/performer)
	 * @param $user_id
	 */
	function generate_directory($user_type,$user_id){
		$CI = &get_instance();
		$CI->load->helper('file');
		
		if($user_type == 'performer'){
			if( ! is_dir ('uploads/performers/' . $user_id) ){
				mkdir('uploads/performers/' . $user_id				,0777);
				chmod('uploads/performers/' . $user_id				,0777);
				
				mkdir('uploads/performers/' . $user_id . '/medium/'	,0777);
				chmod('uploads/performers/' . $user_id . '/medium/'	,0777);
				
				mkdir('uploads/performers/' . $user_id . '/small/' 	,0777);
				chmod('uploads/performers/' . $user_id . '/small/'	,0777);
				
				mkdir('uploads/performers/' . $user_id . '/others/'	,0777);
				chmod('uploads/performers/' . $user_id . '/others/'	,0777);
				
				mkdir('uploads/performers/' . $user_id . '/paid/'	,0777);
				chmod('uploads/performers/' . $user_id . '/paid/'	,0777);
				
				mkdir('uploads/performers/' . $user_id . '/paid/small',0777);
				chmod('uploads/performers/' . $user_id . '/paid/small',0777);
				
				write_file(BASEPATH . '../uploads/performers/' . $user_id . '/paid/.htaccess','deny from all');	
			}
		}
		
		if($user_type == 'studio'){
			if( ! is_dir('uploads/studios/' . $user_id)){
				mkdir('uploads/studios/' . $user_id,0777);
				chmod('uploads/studios/' . $user_id,0777);
			}
		}		
	}
}


// -------------------------------------------------------------------------
if ( ! function_exists('delete_directory')) {
	
	/**
	 * Sterge un director pt studio/performer
	 * @param $user_type (studio/performer)
	 * @param $user_id
	 */
	function delete_directory($user_type,$user_id){
		if($user_type == 'performer'){
			rmdir(BASEPATH . '../uploads/performers/' . $user_id);
		}
		if($user_type == 'studio'){
			rmdir(BASEPATH . '../uploads/studios/' . $user_id);
		}		
	}
}

// -------------------------------------------------------------------------
if ( ! function_exists('generate_unique_name')) {
	
	/**
	 * Genereaza un nume de fisier unic pentru directorul dat
	 * @param $directory
	 * @param $file
	 */
	function generate_unique_name($directory, $file){

		$ext = strtolower(substr(strrchr($file, '.'), 1));
		
		$file = md5($file . mt_rand()) . '.' . $ext;
		while( file_exists( $directory . $file ) ){
			$file = md5($file . mt_rand()). '.' . $ext;	
		}
		
		return $file;
	}
}


// -------------------------------------------------------------------------
if( ! function_exists('copy_directory')){

	/**
	 * Copiaza un director
	 * @param unknown_type $source
	 * @param unknown_type $destination
	 * @author Baidoc
	 */
	function copy_directory( $source, $destination ) {
		if ( is_dir( $source ) ) {
			@mkdir( $destination );
			$directory = dir( $source );
			while ( FALSE !== ( $readdirectory = $directory->read() ) ) {
				if ( $readdirectory == '.' || $readdirectory == '..' ) {
					continue;
				}
				$PathDir = $source . '/' . $readdirectory;
				if ( is_dir( $PathDir ) ) {
					copy_directory( $PathDir, $destination . '/' . $readdirectory );
					continue;
				}
				copy( $PathDir, $destination . '/' . $readdirectory );
			}
	
			$directory->close();
		}else {
			copy( $source, $destination );
		}
	}
}