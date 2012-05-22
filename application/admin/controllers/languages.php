<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Email $email
 * @property CI_Form_validation $form_validation
 * @property CI_URI $uri
 * @property Firephp $firephp
 * @property CI_DB_active_record $db
 * @property supported_languages $supported_languages
 */
Class Languages_controller extends MY_Admin{

	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('supported_languages');		
	}
	
	/*
	 * Listare FMSuri
	 */
	function index(){
		$data['supported_languages']	= $this->supported_languages->get_all();
		$data['page'] 					= 'supported_languages/'.__FUNCTION__;
		$data['breadcrumb'][lang('Supported languages')] = 'current';
		$data['page_head_title']		= lang('Supported languages'); 
		
		$this->load->view('template', $data);		
	}
	
	
	/**
	 * Adauga FMS
	 */
	function add(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('code',					lang('code'),	'trim|required');
		$this->form_validation->set_rules('title',					lang('title'),	'trim|required');
		
		if( $this->form_validation->run() === FALSE ){
			$data['page'] 	= 'supported_languages/'.__FUNCTION__;
			$data['breadcrumb'][lang('Supported languages')] = 'current';
			$data['page_head_title']	= lang('Supported languages'); 
			$this->load->view('template', $data);				
		} else {
			$this->supported_languages->save(
							array(
								'code'	=> $this->input->post('code'),	
								'title'	=> $this->input->post('title')
							)
						);
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('languge added')));
			redirect('languages');
		}
	}
	
	
	/*
	 * Editeaza FMS
	 */
	function edit($id = FALSE){
		if( ! $id ){
			$this->session->set_flashdata('msg', array('success' => FALSE, 'message' => lang('Invalid language id')));
			redirect('languages');
		}
		
		$supported_language = $this->supported_languages->get_by_id($id);		
		if( ! $supported_language ){
			$this->session->set_flashdata('msg', array('success' => FALSE, 'message' => lang('Invalid language id')));
			redirect('languages');			
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('code',					lang('code'),	'trim|required');
		$this->form_validation->set_rules('title',					lang('title'),	'trim|required');
		
		if( $this->form_validation->run() === FALSE ){
			$data['supported_language'] = $supported_language;
			$data['page'] 	= 'supported_languages/'.__FUNCTION__;
			$data['breadcrumb'][lang('Supported languages')] = 'current';
			$data['page_head_title']	= lang('Supported languages'); 
			
			$this->load->view('template', $data);							
		} else {
			$this->supported_languages->save(
							array(
								'id'	=> $supported_language->id,
								'code'	=> $this->input->post('code'),	
								'title'	=> $this->input->post('title')
							)
						);
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('language updated successfully')));
			redirect('languages');
		}
	}
	
	/*
	 * Sterge FMS
	 */
	function delete($id = FALSE){
		if( ! $id ){
			$this->session->set_flashdata('msg', array('success' => FALSE, 'message' => lang('Invalid languages id')));
			redirect('languages');			
		}
		
		$supported_language = $this->supported_languages->get_by_id($id);		
		if( ! $supported_language ){
			$this->session->set_flashdata('msg', array('success' => FALSE, 'message' => lang('language does not exist')));
			redirect('languages');			
		}
		
		$this->supported_languages->delete($id);
	
		$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('language deleted')));
		redirect('languages');		
	}
}