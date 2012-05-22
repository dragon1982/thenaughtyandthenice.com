<?php
class Home_controller extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		//$this->access->restrict('affiliates');
		$this->load->model('affiliates');
	}
	
	function index() {
		$this->access->restrict('affiliates');
		$data['page'] 					= 'home';
		$data['description']			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords']				= SETTINGS_SITE_KEYWORDS;
		$data['page_title']				= lang('Wellcome to your account ').' - '.SETTINGS_SITE_TITLE;
		
		$this->load->library('charts');
		$this->load->model('ad_traffic');
		
		if(strlen($this->input->post('start_date')) == 0){
			$start_date = strtotime('- 1 month', strtotime(date('Y-m-d 00:00:00')));
		}else{
			$start_date = strtotime($this->input->post('start_date').' 00:00:00');
		}
		
		if(strlen($this->input->post('end_date')) == 0){
			$end_date = strtotime(date('Y-m-d 23:59:59'));
		}else{
			$end_date = strtotime($this->input->post('end_date').' 23:59:59');
		}
		
		
		if($start_date > $end_date){
			$start_date = strtotime('- 1 month', strtotime(date('Y-m-d')));
			$end_date = strtotime(date('Y-m-d 23:59:59'));
		}
		
		if((($end_date - $start_date) / 86400 + 1) < 14){
			$end_date = $end_date + (7*24*3600); //7 days
			$start_date = $start_date - (7*24*3600); //7 days
		}
		
		$data['start_date'] = date('d-m-Y', $start_date);
		$data['end_date'] = date('d-m-Y', $end_date);
		
		$data['earning'] = $this->ad_traffic->get_earning_by_affiliate_id($this->user->id);
		
		$data['chart_affiliates'] = $this->charts->get_affiliates_chart_data($start_date, $end_date, $this->user->id);
		
		
		$this->load->view('template', $data);
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Scoate din sesiune id-ul userului si reidirecteaza catre login
	 * @return unknown_type
	 */
	function logout() {
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('type');
		redirect('login');
	}
	
	
	/*
	 * Acvtiveaza affiliate din pending
	 */
	function activate(){
		$username 		= $this->input->get('username');
		$secure_code 	= $this->input->get('secure_code');
		$time			= $this->input->get('time');
						
		if ( strtotime('+1 day',$time) < time() || $time > time() ) {//verific timp						
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Invalid/expired activation code')));
			redirect();			
		}
			
		$this->load->model('affiliates');
		$affiliate = $this->affiliates->get_by_username($username);
		
		if( ! $affiliate){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message' => lang('Invalid username')));
			redirect();	
		}

		if( $affiliate->status !== 'pending' ){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message' => lang('Account is not in pending. You cannot activate ')));
			redirect();				
		}
		
		if(md5($time . $affiliate->hash) !== $secure_code){		
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Invalid activation code')));
			redirect();	
		}
		
		//begin the transaction
		$this->db->trans_begin();		
		
		$this->affiliates->save(array('id'=>$affiliate->id, 'status'=>'approved'));
		
		$this->system_log->add(
            		'affiliate', 
            		$affiliate->id,
            		'affiliate', 
            		$affiliate->id, 
            		'register', 
            		'Affiliate activated the account.', 
            		time(), 
            		ip2long($this->input->ip_address())
		);				
		
		//nu am reusit sa adaug in db userul
		if($this->db->trans_status() == FALSE){
			
			//fac rollback la date
			$this->db->trans_rollback();

			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('An error occured')));
			//redirectionez pe pagina de unde a venit
			redirect();
		}
		$this->db->trans_commit();
		
		$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Account activated successfully')));
		$this->session->set_userdata(
							array(
								'id'	=> $affiliate->id,
								'type' 	=> 'affiliate'
							)		
		);
		redirect();
	}
	
	
	
		
	/**
	* Functie de resetare parola -> step 1
	*/
	function forgot_password() {
		
		$this->access->restrict('logged_out');
		
		$this->load->helper(array('form', 'url', 'emails'));
		$this->load->library('form_validation');
		
		
		$this->form_validation->set_rules('username',	lang('username'), 	'required|min_length[3]');
		$this->form_validation->set_rules('email', 		lang('email'), 		'required|valid_email|mail_belog_to_user[affiliates]');
		
		if ($this->form_validation->run() === FALSE) {	
			$data['page']	= 'forgot_password';
			$data['description']			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords']				= SETTINGS_SITE_KEYWORDS;
			$data['page_title']				= lang('Forgot Password').' - '.SETTINGS_SITE_TITLE;
			$this->load->view('template-modal', $data);				
			
			
		} else {
			
			$this->load->library('email');
			$email = $this->input->post('email');
			$username = $this->input->post('username');
			
			$this->email->from('noreply@modenacam.com');
			$this->email->to($email);
			$this->email->subject('Forgot password');						
			
			$this->load->model('affiliates');
			//selectez userul din DB
			$affiliate = $this->affiliates->get_by_username($username);
			
			$reset_password_link = site_url('reset_password/?time=' . time() . '&username=' . $username . '&secure_code=' . md5( time() . $affiliate->hash ) );
			
			$email_content = $this->load->view('emails/forgot_password_'.$this->config->item('lang_selected'), array(), TRUE);
			
			$replaced_variables = get_avaiable_variabiles('forgot_password', TRUE);
			$replace_value = array($affiliate->username,  $affiliate->email, $affiliate->first_name, $affiliate->last_name, $affiliate->site_name, $affiliate->site_url, $reset_password_link,  main_url(), WEBSITE_NAME);
			
			$email_content = preg_replace($replaced_variables, $replace_value, $email_content);
			
			$this->email->message($email_content);
			if($this->email->send()){
				
				$this->session->set_flashdata('msg',array('success'=>TRUE, 'message'=>lang('Please check your mail to reset your password')));
				redirect();	
			} else {
				$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('Failed to send the confirmation email. Please retry')));
				redirect();
			}									
		}
		
	} 
	
	/**
	* Functie de resetare parola - step 2 - confirmare cod de resetare 
	*/
	function reset_password(){
			
		$this->access->restrict('logged_out');
		
		$email_time = $this->input->get('time') ;
		$email_username = $this->input->get('username') ;
		$email_secure_code = $this->input->get('secure_code') ;
		$this->load->model('affiliates');
		$affiliate = $this->affiliates->get_by_username($email_username);
		
		
		if ( strtotime('+1 day',$email_time) < time() || $email_time > time() ) {//verific timp						
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Invalid/expired token')));
			redirect();			
		}
			
		if( ! $affiliate){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message' => lang('Invalid username')));
			redirect();	
		} 
		
		if(md5($email_time . $affiliate->hash) !== $email_secure_code){		
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Invalid/expired token')));
			redirect();	
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('password',lang('Password'),'required|min_length[3]');
		$this->form_validation->set_rules('rep_password',lang('Repeat Password'),'required|min_length[3]|matches[password]');
		
		if($this->form_validation->run() === FALSE){
			
			$data['page']					= 'reset_password';
			$data['description']			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords']				= SETTINGS_SITE_KEYWORDS;
			$data['page_title']		        = lang('Reset Password').' - '.SETTINGS_SITE_TITLE;
			$data['form_link']				= site_url('reset_password?time='.$email_time.'&username='.$email_username.'&secure_code='.$email_secure_code);
			$this->load->view('template', $data);	
			return;
			
		}
		
		$salt = $this->config->item('salt');
	
		$data = array(
			'id'=>$affiliate->id,
			'password'=>hash('sha256', $salt . $affiliate->hash . $this->input->post('password'))
		);
		$this->affiliates->save($data);
		$this->system_log->add(
					'affiliate', 
					$affiliate->id,
					'affiliate', 
					$affiliate->id, 
					'reset_password', 
					'Affiliate has reseted password.', 
					time(), 
					ip2long($this->input->ip_address())
		);
		$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Password saved, you can login.')));
		redirect('login');			
	}	
	
	
}