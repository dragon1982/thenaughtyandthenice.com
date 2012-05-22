<?php
/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Email $email
 * @property CI_Form_validation $form_validation
 * @property CI_URI $uri
 * @property Firephp $firephp
 * @property CI_DB_active_record $db
 * @property Affiliates $affiliates
 * @property Users $users
 * @property Users_details $users_details
 */

Class Register_controller extends MY_Controller{
	
	/**
	 * Constructor
	 */
	function __construct(){		
		parent::__construct();
		$this->access->restrict('logged_out');
		$this->load->model('users');
	}
	
	/**
	 * Functia de register user
	 * @return unknown_type
	 */
	function index(){
	
		$this->im_in_modal = TRUE;
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters(NULL,NULL);
		
		$this->form_validation->set_rules('username',			lang('username'),				'trim|required|alpha_numeric|min_length[4]|max_length[25]|Unique[users.username]|not_restricted|strip_tags|purify');
		$this->form_validation->set_rules('email',				lang('email'),					'trim|required|valid_email|unique_email[users]||max_length[64]');
		$this->form_validation->set_rules('repeat_email',		lang('repeat email'),			'trim|required|matches[email]');
		$this->form_validation->set_rules('password',			lang('password'),				'trim|required|min_length[5]');
		$this->form_validation->set_rules('repeat_password',	lang('repeat password'),		'trim|required|matches[password]');
		

		if($this->form_validation->run() === FALSE){		
			$data['description']			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords']				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle']				= lang('User register').' - '.SETTINGS_SITE_TITLE;
			$this->load->view('become_member', $data);
		} else {
			$this->load->library('ip2location');
			$this->load->model('affiliates');			
			$this->load->model('ad_traffic');			
						
			//colect data
			$hash 			= generate_hash('users');
			$salt 			= $this->config->item('salt');
			$status 		= ($this->users->require_verification())?'pending':'approved';
			$password		= hash('sha256',$salt.$hash.$this->input->post('password'));
			
			//begin the transaction
			$this->db->trans_begin();
			//add the user into database
			$user_id = $this->users->add(
											$this->input->post('username'),
											$password,
											$hash,
											$this->input->post('email'),
											$status,
											NULL,
											0
										);
			$affiliate_id = $this->affiliates->get_affiliate_from_cookie($this->input->cookie('affiliate_id'));
			$affiliate_ad_id = $this->affiliates->get_affiliate_from_cookie($this->input->cookie('affiliate_ad_id'));
			$this->users->add_users_detail(
						$user_id,
						ip2long($this->input->ip_address()),
						time(),						
						$this->ip2location->getCountryShort($this->input->ip_address()),
						TRUE,
						$affiliate_id,
						$affiliate_ad_id
			);
			
			if($affiliate_id > 0){
				$rows['date'] = time();
				$rows['affiliate_id'] = $affiliate_id;
				$rows['ad_id'] = $affiliate_ad_id;
				$rows['action'] = 'register';
				
				$this->ad_traffic->save($rows);
				
				
				//delete cookies
				$this->load->helper('cookie');
				
//				delete_cookie('affiliate_id');
//				delete_cookie('affiliate_ad_id');
			}
			
			
			//nu am reusit sa adaug in db userul
			if($this->db->trans_status() == FALSE){
				
				//fac rollback la date
				$this->db->trans_rollback();

				$this->load->library('user_agent');
				
				$this->session->set_flashdata('msg',array('type'=>'error','message'=>lang('An error occured')));
				//redirectionez pe pagina de unde a venit
				redirect($this->agent->referrer());
			}
			$this->db->trans_commit();
			$this->system_log->add(
            			'user', 
            			$user_id,
            			'user', 
            			$user_id, 
            			'register', 
            			'New user has registered.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
			
			if($affiliate_id > 0){
				$this->system_log->add(
						'user', 
						$user_id,
						'affiliate', 
						$affiliate_id, 
						'register', 
						'New user has registered from affiliate ads.', 
						time(), 
						ip2long($this->input->ip_address())
			);
		}
			
			$this->load->helper('emails');
			
			$data['link'] = site_url('activate?time=' . time() . '&username=' . $this->input->post('username') . '&secure_code=' . md5( time() . $hash ) );
			
			if($status === 'pending'){
				$email_content = $this->load->view('emails/register_pending_'.$this->config->item('lang_selected'), array(), TRUE);
				$email_subject = lang('Confirmation email.');
				$replaced_variables = get_avaiable_variabiles('register_pending', true);
			}else{
				$email_content = $this->load->view('emails/register_welcome_'.$this->config->item('lang_selected'), array(), TRUE);
				$email_subject = lang('Confirmation email.');
				$replaced_variables = get_avaiable_variabiles('register_welcome', true);
			}
			
			
			$replace_value = array($this->input->post('username'),  $this->input->post('email'), $this->input->post('password'), $data['link'], main_url(), WEBSITE_NAME);
			
			$email_content = preg_replace($replaced_variables, $replace_value, $email_content);
			
			
			//activation email
			$this->load->library('email');
			$this->email->from(SUPPORT_EMAIL,SUPPORT_NAME);
			$this->email->to($this->input->post('email'));
			$this->email->subject($email_subject);
			$this->email->message($email_content);
			$this->email->send();
			
			//user creat cu success
			if($status === 'pending'){
				$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('A confirmation email has been sent')));
				redirect();	
			} else {
				$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Account created successfully')));
				redirect();			
			}
			
			
		}
	}
	
	function checkUniqueUsername($user){
		$dbUser = $this->db->where('username',$user)->get('users')->row();
		if(is_object($dbUser)){
			echo 'true';
		} else {
			echo 'false';
		}
	}
}