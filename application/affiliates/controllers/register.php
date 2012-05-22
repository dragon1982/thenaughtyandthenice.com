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
 * @property Ip2location $ip2location
 * @property EM $em
 */
Class Register_controller extends MY_Controller {
	
	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
		$this->access->restrict('logged_out');
		$this->load->model('affiliates');
		$this->load->library('form_validation');
	}
	
	function index() {
		
		$this->load->helper('emails');
		$this->load->config('regions');
		
		$this->form_validation->set_rules('site_name',		lang('site name'),				'trim|required|xss_clean|purify');
		$this->form_validation->set_rules('site_url',		lang('site url'),				'trim|required|prep_url|Unique[affiliates.site_url]');
		$this->form_validation->set_rules('username',		lang('username'),				'trim|required|alpha_dash|min_length[3]|max_length[25]|Unique[affiliates.username]');
		$this->form_validation->set_rules('email',			lang('email'),					'trim|required|valid_email|unique_email[affiliates]');
		$this->form_validation->set_rules('password',		lang('password'),				'trim|required|min_length[6]');
		$this->form_validation->set_rules('rep_password',	lang('repeat password'),		'trim|required|min_length[6]|matches[password]');		
		$this->form_validation->set_rules('first_name',		lang('firstname'), 				'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('last_name', 		lang('lastname'),				'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('address', 		lang('address'), 				'trim|required|strip_tags|purify|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('city', 			lang('city'), 					'trim|required|strip_tags|purify|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('zip', 			lang('zip'), 					'trim|required|strip_tags|purify|min_length[3]|max_length[10]');
		$this->form_validation->set_rules('state', 			lang('state'), 					'trim|purify');			
		$this->form_validation->set_rules('country', 		lang('country'), 				'trim|required|strip_tags|valid_country');		
		$this->form_validation->set_rules('phone', 			lang('phone'), 					'trim|required|purify|numeric|min_length[8]|max_length[16]');
		$this->form_validation->set_rules('tos',			lang('terms & conditions'),		'trim|required|check_tos');
		
		$this->load->model('payment_methods');
		
		//returneaza toate metodele de plata
		$this->payment_method_list 	= $this->payment_methods->get_all_approved();
				 
		$this->form_validation->set_rules('payment_method',		lang('payment_method'),		 'required|valid_pament_method');
		
		$selected_method 			= $this->input->post('payment_method');

		if($payment_method = $this->payment_methods->get_method_by_id($this->payment_method_list,$selected_method)){

			$fields = unserialize($payment_method->fields);
			
			foreach($fields as $field){
				$field_name = strtolower(str_replace(' ', '_', $field)) . '_'.$payment_method->id;
				$this->form_validation->set_rules($field_name,	lang($field),	'trim|required|purify');
			}
			$this->form_validation->set_rules('rls_amount_'.$selected_method, lang('Release amount'),	'trim|required|numeric|valid_release_amount');
		}
		
		
		if($this->form_validation->run() == FALSE){
			$data['countries']				= prepare_dropdown($this->config->item('countries'),lang('Choose your country'),TRUE);		
			$data['payment_methods']		= prepare_dropdown_objects($this->payment_method_list,lang('Choose payment method'),'name',FALSE);
			$data['selected_method']		= $selected_method;	
			$data['page']	 				= 'register';
			$data['description']			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords']				= SETTINGS_SITE_KEYWORDS;
			$data['page_title']				= lang('Register').' - '.SETTINGS_SITE_TITLE;
			$this->load->view('template', $data);
			return;
		}
		
		
		$this->load->library('ip2location');
						
		//colect data
		$token 			= generate_token('affiliates');
		$hash 			= generate_hash('affiliates');
		$salt 			= $this->config->item('salt');
		$status 		= ($this->affiliates->require_verification())?'pending':'approved';
		$ip				= $this->input->ip_address();	
		$password		= hash('sha256',$salt . $hash . $this->input->post('password'));
		
			
		$fields = unserialize($payment_method->fields);

		foreach($fields as $field){
			$payment_field = strtolower(str_replace(' ', '_', $field));
			$account[$payment_field] = $this->input->post($payment_field. '_'.$payment_method->id);
		}
		$payment = $this->input->post('payment_method');
		$release = $this->input->post('rls_amount_'.$payment);			
		$serialized_acount = serialize($account);
		
		
		$rows['site_name']					= $this->input->post('site_name');
		$rows['site_url']					= $this->input->post('site_url');
		$rows['username']					= $this->input->post('username');
		$rows['password']					= $password;
		$rows['email']						= $this->input->post('email');
		$rows['first_name']					= $this->input->post('first_name');
		$rows['last_name']					= $this->input->post('last_name');
		$rows['address']					= $this->input->post('address');
		$rows['city']						= $this->input->post('city');
		$rows['zip']						= $this->input->post('zip');
		$rows['phone']						= $this->input->post('phone');
		$rows['register_date']				= time();
		$rows['register_ip']				= ip2long($ip);
		$rows['payment']					= $payment;
		$rows['release']					= $release;
		$rows['account']					= $serialized_acount;
		$rows['register_country_code']		= $this->ip2location->getCountryShort($ip);
		$rows['status']						= $status;
		$rows['hash']						= $hash;
		$rows['token']						= $token;
		$rows['status']						= (EMAIL_ACTIVATION)? 'pending' : 'approved';
		$rows['country_code']				= $this->input->post('country');
		$rows['state']						= $this->input->post('state');
		$rows['percentage']					= SETTINGS_TRANSACTION_PERCENTAGE;
		
		if($new_id = $this->affiliates->save($rows)){
			$this->em->set('success', lang('Affiliate account was created succesfully!'));
			$this->system_log->add(
            			'affiliate', 
            			NULL,
            			'other', 
            			NULL, 
            			'register', 
            			'Affiliate has registered.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
			
			
			if($rows['status'] == 'pending'){
				$email_content = $this->load->view('emails/register_pending_'.$this->config->item('lang_selected'),array(),TRUE);
				$email_subject = lang('Confirmation email.');
			}else{
				$email_content = $this->load->view('emails/register_welcome_'.$this->config->item('lang_selected'),array(),TRUE);
				$email_subject = lang('Welcome email.');
			}
			
			$activation_link = site_url('home/activate?time=' . time() . '&username=' . $rows['username'] . '&secure_code=' . md5( time() . $rows['hash'] ) );
			
			$replaced_variables = get_avaiable_variabiles('register_welcome', TRUE);
			$replace_value = array($rows['username'], $rows['password'], $rows['email'], $rows['first_name'], $rows['last_name'], $rows['site_name'], $rows['site_url'], $activation_link,  main_url(), WEBSITE_NAME,  site_url('login') );
			
			$email_content = preg_replace($replaced_variables, $replace_value, $email_content);
			
				
			//activation email
			$this->load->library('email');
			$this->email->from(SUPPORT_EMAIL,SUPPORT_NAME);
			$this->email->to($rows['email']);
			$this->email->subject($email_subject);
			$this->email->message($email_content);
			$this->email->send();
			
			if($rows['status'] == 'pending'){
				$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('A confirmation email has been sent.')));				
			}
			redirect('login');	
		}else{
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=> lang('Affiliate account was not created. Please try again!')));
		}
		
		redirect('register');
	}
	
}

