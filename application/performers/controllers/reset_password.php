<?php
Class Reset_password_controller extends MY_Controller{
	
	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('performers');	
		$this->access->restrict('logged_out');		
	}
	
	/**
	 * Functia de resetare de parola
	 */
	function index(){
		$email_time = $this->input->get('time') ;
		$email_username = $this->input->get('username') ;
		$email_secure_code = $this->input->get('secure_code') ;
		
		//returneaza un performer dupa username
		$username = $this->performers->get_one_by_username($email_username);
		
		
		$this->im_in_modal = TRUE;
		
		if ( strtotime('+1 day',$email_time) < time() || $email_time > time() ) {//verific timp						
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Invalid/expired token')));
			redirect('login');			
		}
			
		if( ! $username){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message' => lang('Invalid username')));
			redirect('login');	
		} 
		
		if(md5($email_time . $username->hash) !== $email_secure_code){		
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Invalid/expired token')));
			redirect('login');
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('password',		lang('Password'),'required|min_length[3]');
		$this->form_validation->set_rules('rep_password',	lang('Repeat Password'),'required|min_length[3]|matches[password]');
				
		if($this->form_validation->run() === FALSE){
			
			$data['title']					= lang('Reset password').' - '.SETTINGS_SITE_TITLE;
			$data['description']			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords']				= SETTINGS_SITE_KEYWORDS;
			$data['page']					= 'reset_password';
			$data['pageTitle']				= lang('Reset password');
			$data['page_title']				= lang('Reset password');
						
			$this->load->view('template',$data);			
		} else {
			$salt = $this->config->item('salt');
			
			$data = array(
				'password'=>hash('sha256', $salt . $username->hash . $this->input->post('password'))
			);
			
			$this->performers->update($username->id,$data);
			$this->system_log->add(
            			'performer', 
            			$username->id,
            			'performer', 
            			$username->id, 
            			'reset_password', 
            			'Performer has reseted password.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
			$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Password saved, you can login.')));			
			redirect('login');		
		}			
	}
}