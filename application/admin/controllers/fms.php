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
 * @property Fms $fms
 * @property Performers_videos $performers_videos
 */
Class FMS_controller extends MY_Admin{

	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('fms');		
	}
	
	/*
	 * Listare FMSuri
	 */
	function index(){
		$data['fmss']	= $this->fms->get_multiple();
		$data['page'] 	= 'fms/'.__FUNCTION__;
		$data['breadcrumb'][lang('Fms')] = 'current';
		$data['page_head_title']	= lang('Fms'); 
		
		$this->load->view('template', $data);		
	}
	
	
	/**
	 * Adauga FMS
	 */
	function add(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name',					lang('name'),					'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('max_hosted_performers',	lang('max hoster performers'),	'trim|required|numeric|max_length[4]');
		$this->form_validation->set_rules('status',					lang('status'),					'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('fms',					lang('FMS'),					'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('fms_for_video',			lang('FMS for video'), 			'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('fms_for_preview',		lang('FMS for preview'),		'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('fms_for_delete',			lang('FMS for delete'),			'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('fms_test',				lang('FMS for test'),			'trim|required|max_length[255]|xss_clean');
		
		if( $this->form_validation->run() === FALSE ){
			$data['page'] 	= 'fms/'.__FUNCTION__;
			$data['breadcrumb'][lang('Fms')] = 'current';
			$data['page_head_title']	= lang('Fms'); 
			$data['status']	= array('active'=>lang('active'),'inactive'=>lang('inactive'));
			$this->load->view('template', $data);				
		} else {
			$this->fms->add(
							$this->input->post('name'),
							$this->input->post('max_hosted_performers'),
							$this->input->post('status'),
							$this->input->post('fms'),
							$this->input->post('fms_for_video'),
							$this->input->post('fms_for_preview'),
							$this->input->post('fms_for_delete'),
							$this->input->post('fms_test')
						);
			$this->session->set_flashdata('msg',array('type'=>'success','message'=>lang('FMS added')));
			redirect('fms');
		}
	}
	
	
	/*
	 * Editeaza FMS
	 */
	function edit($id = FALSE){
		if( ! $id ){
			$this->session->set_flashdata('msg', array('type' => 'errpr', 'message' => lang('Invalid FMS id')));
			redirect('fms');
		}
		
		$fms = $this->fms->get_one_by_id($id);		
		if( ! $fms ){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid FMS id')));
			redirect('fms');			
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name',					lang('name'),					'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('max_hosted_performers',	lang('max hoster performers'),	'trim|required|numeric|max_length[6]|xss_clean');
		$this->form_validation->set_rules('status',					lang('status'),					'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('fms',					lang('FMS'),					'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('fms_for_video',			lang('FMS for video'), 			'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('fms_for_preview',		lang('FMS for preview'),		'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('fms_for_delete',			lang('FMS for delete'),			'trim|required|max_length[255]|xss_clean');		
		$this->form_validation->set_rules('fms_test',				lang('FMS for test'),			'trim|required|max_length[255]|xss_clean');
		
		if( $this->form_validation->run() === FALSE ){
			$data['fms'] = $fms;
			$data['status']	= array('active'=>'active','inactive'=>'inactive');
			$data['page'] 	= 'fms/'.__FUNCTION__;
			$data['breadcrumb'][lang('Fms')] = 'current';
			$data['page_head_title']	= lang('Fms'); 		
			$this->load->view('template', $data);							
		} else {
			$this->fms->update($fms->fms_id,
								array(
									'name'					=> $this->input->post('name'),
									'max_hosted_performers' => $this->input->post('max_hosted_performers'),
									'status'				=> $this->input->post('status'),
									'fms'					=> $this->input->post('fms'),
									'fms_for_video'			=> $this->input->post('fms_for_video'),
									'fms_for_preview'		=> $this->input->post('fms_for_preview'),
									'fms_for_delete'		=> $this->input->post('fms_for_delete'),			
									'fms_test'				=> $this->input->post('fms_test') 
								)
						);
			$this->session->set_flashdata('msg',array('type'=>'success','message'=>lang('FMS updated successfully')));
			redirect('fms');
		}
	}
	
	/*
	 * Sterge FMS
	 */
	function delete($id = FALSE){
		if( ! $id ){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid FMS id')));
			redirect('fms');			
		}
		
		$fms = $this->fms->get_one_by_id($id);		
		if( ! $fms ){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('FMS does not exist')));
			redirect('fms');			
		}
		
		$this->load->model('performers_videos');
		$this->db->trans_start();
		
		$this->fms->delete_by_id($id);
		$this->performers_videos->delete_by_fms_id($fms->fms_id);
		
		if($this->db->trans_status() === FALSE){
			$this->db->rollback();

			$this->session->set_flashdata('msg',array('type'=>'error','message'=>lang('An error occured.')));
			redirect('fms');					
		}
		
		$this->db->trans_commit();
				
		$this->session->set_flashdata('msg',array('type'=>'success','message'=>lang('FMS deleted')));
		redirect('fms');		
	}
}