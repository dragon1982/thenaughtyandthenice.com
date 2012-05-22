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
Class Emails_templates_controller extends MY_Admin{


	var $templates;
	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->helper('emails');
		$this->load->helper('directory');
		
		$directories = directory_map('application/');
		$this->recurse_output($directories, FALSE);
		$directories = directory_map('extended/');
		$this->recurse_output($directories, TRUE);
		//printR($directories, TRUE);
		
		
		if(isset($this->templates['extended']) && is_array($this->templates['extended']) && count($this->templates['extended'])){
			foreach($this->templates['application'] as $location => $files){
				if(isset($this->templates['extended']) && isset($this->templates['extended'][$location]) && is_array($this->templates['extended'][$location])){
					$this->templates['application'][$location] =  array_merge($this->templates['application'][$location], $this->templates['extended'][$location]);
				}
			}
		}
		$this->templates = $this->templates['application'];
		
	}
	

	function index(){
		
		$data['templates']								= $this->templates;
		$data['page']									= 'emails_templates';
		$data['breadcrumb'][lang('Emails Templates')]	= 'current';
		$data['page_head_title']						= lang('Emails Templates');
		$data['page_title']								= lang('Emails Templates');
		$data['tab']									= 'welcome_email';
		
		$this->load->view('template', $data);
	}
	
	
	
	function edit($app_module = FALSE, $file = FALSE){
		
		//$pattern = '/_'.$this->config->item('lang_selected').'/i';
		
		$file_name = substr($file, 0, -3);
		
		$data['variabiles'] = get_avaiable_variabiles($app_module.'_'.$file_name);
		
		$file_path		= BASEPATH.'../'.$this->templates[$app_module][$file];
		
		$this->form_validation->set_rules('body', 'Email body', 'trim|required');
		
		if($this->form_validation->run() == FALSE){	
		
			$data['email_content']							= file_get_contents($file_path);

			$data['file']									= $file;
			$data['module']									= $app_module;
			$data['templates']								= $this->templates;
			$data['page']									= 'edit_emails_templates';
			$data['breadcrumb'][lang('Emails Templates')]	= site_url('emails_templates');
			$data['breadcrumb'][ucfirst(lang($app_module))]	= site_url('emails_templates');
			$data['breadcrumb'][lang($file)]				= 'current';
			$data['page_head_title']						= lang('Emails Templates');
			$data['tab']									= 'welcome_email';

			$this->load->view('template', $data);
			
			return FALSE;
		}
		
		if(!is_writable($file_path)){
			$this->session->set_flashdata('msg',array('type' => 'error','message'=>sprintf(lang('The %s is not writable. Please set CHMOD 777 for this file!'),$file_path)));
			redirect(current_url());
		}
		
		$fp = fopen($file_path, 'w');
		fwrite($fp, html_entity_decode($this->input->post('body')));
		fclose($fp);
		
		$this->session->set_flashdata('msg',array('type' => 'success','message'=>lang('The template was succesfully saved!')));
		redirect(current_url());
	}
	
	
	/**
	 * Searches within directories for mails directory and return all files from them
	 * @param $input
	 * @param $level
	 * @param $current
	 * @return unknown_type
	 */
	function recurse_output($input, $extended = FALSE,$current = '/', $level = 0, $app_module = '') {
		
		$templates = array();
		
		if($extended){
			$location = 'extended';
		}else{
			$location = 'application';
		}
		
	    foreach($input as $key => $value) {
			if($level == 0){
				$app_module = $key;
			}
			if($key === 'emails'){
				//echo $key.' - '.$value.'</br>';
				if(is_array($value)){
					foreach($value as $file){
						if(is_array($file)){
							foreach($file as $file_file){
								
								$file_name = preg_replace('/\.php/', '', $file_file);
								$this->templates[$location][$app_module][$file_name] = $location.$current.$key.'/'.$file_file;
							}
						}else{
							$file_name = preg_replace('/\.php/', '', $file);

							$this->templates[$location][$app_module][$file_name] = $location.$current.$key.'/'.$file;
						}
					}
				}
			}elseif(is_array($value)){
	            $this->recurse_output($value, $extended,$current.$key.'/', $level+1, $app_module);
	        }
	    }
		
	}
}
?>
