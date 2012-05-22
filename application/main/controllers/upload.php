<?php
/**
 * 
 * @author Andrei
 *
 */
Class Upload_controller extends CI_Controller{
	
	var $allowed = array(
		'contract' => array(
						'extensions'=>array('jpg','png','pdf','zip'),
						'size_limit'=> 8097152,
						'max_files'=>3
					),
		'photo_id'	=> array(
						'extensions'=>array('jpg','png','pdf','zip'),
						'size_limit'=> 8097152,
						'max_files'=>1
					),					
		'avatar'	=> array(
						'extensions'=>array('jpg','png'),
						'size_limit'=> 8097152,
						'max_files'=>1
					),
		'photos'	=> array(
						'extensions'=>array('jpg','png'),
						'size_limit'=> 8097152,
						'max_files'=>1
					)
	);
	
	// -----------------------------------------------------------------------------------------
	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Functie de upload
	 * @return unknown_type
	 */
	function index(){
		if( ! isset ($this->allowed[$this->input->get('type')]) ){
			echo json_encode(array('success'=>FALSE));
			return;
		}
		
		$alllowed_extensions 	= $this->allowed[$this->input->get('type')]['extensions'];
		$size_limit				= $this->allowed[$this->input->get('type')]['size_limit'];
		$file_name				= $this->input->get('qqfile');
		
		require_once 'application/libraries/ajax_file_upload'.EXT;  
		$uploader = new qqFileUploader($alllowed_extensions, $size_limit);
		$result = $uploader->handleUpload(MY_TEMP_PATH.'/');
		
		if( ! isset( $result['success'] ) || ! $result['success'] ){
			die(json_encode($result));
		}
						
		$files = ( is_array($this->session->userdata( $this->input->get('type') ) ) )?$this->session->userdata( $this->input->get('type') ):array();
		array_push( $files, array( 'name'=>$result['file_name'],'size'=>bits_size($result['size']),'file_on_disk_name'=>$result['file_on_disk_name'] ) );
		
		end($files);
						
		$result['key'] = key($files);
		
		//vreau sa ascund numele fisierului de public
		unset($result['file_on_disk_name']);
		
		$this->session->set_userdata($this->input->get('type'), $files);
		die(json_encode($result));
	}	
	
	/**
	 * Sterge fisierul
	 * @return unknown_type
	 */
	function delete_file(){
		$type		= $this->input->post('type');
		$file_key	= $this->input->post('file_key');
		
		//verific daca tipul dat e bun
		$type 		= end(explode('upload-',$type));
		if ( ! $type ){
			die('invalid_type');
		}
		
		if( ! key_exists($type,$this->allowed)){
			die('invalid_type');
		}
		
		//verific daca am primit keia
		if( ! is_numeric( $file_key ) ){
			die('invalid_file_name');
		}
		
		//verific daca exista in sessiune vroun fisier pt tipul dat
		$files = $this->session->userdata($type);	
		if( ! $files ){
			die('invalid_file_name');
		}
		
		//verific daca exista keia data in arrayul de fisiere
		if( ! isset($files[$file_key]) ){
			die('invalid_file_name');
		}
		
		$file_name = $files[$file_key]['file_on_disk_name'];
				
		//sterg din sessiune
		unset($files[$file_key]);
				
		$this->session->set_userdata($type,$files);
		
		//sterg de pe disc 		
		if( ! file_exists(MY_TEMP_PATH.'/' . $file_name)){
			die('deleted');
			die('file_not_exist');
		}
		
		unlink(MY_TEMP_PATH.'/'.$file_name);
			
		die('deleted');
	}
	
}
