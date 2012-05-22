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
Class Analytics_controller extends MY_Admin {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	}
	

	function index(){
		
		$file_path = BASEPATH.'../assets/txt/analytics.txt';
		
		$data['code']		= '';
		if(is_file($file_path)){
			$data['code']		= file_get_contents($file_path);
		}
		
		$this->form_validation->set_rules('code', lang('analytics code'), 'trim');
		
		if($this->form_validation->run() == FALSE){	
		
			$data['page']									= 'analytics_templates';
			$data['breadcrumb'][lang('Analytics code')]		= 'current';
			$data['page_head_title']						= lang('Analytics code');
			$data['page_title']								= lang('Analytics code');


			$this->load->view('template', $data);
			return;	
		}
		
		if(!is_writable($file_path)){
			$this->session->set_flashdata('msg',array('type' => 'error','message'=>sprintf(lang('The %s is not writable. Please set CHMOD 777 for this file!'),$file_path)));
			redirect(current_url());
		}
		
		$fp = fopen($file_path, 'w');
		fwrite($fp, $this->input->post('code'));
		fclose($fp);
		
		$this->session->set_flashdata('msg',array('type' => 'success','message'=>lang('The code was succesfully saved!')));
		redirect(current_url());
	}
	
}
