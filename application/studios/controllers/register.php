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
 * @property Studios $studios
 */
Class Register_controller extends MY_Controller{
	
	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->access->restrict('logged_out');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
		$this->load->model('payment_methods');

	}
	
	
	/**
	 * Functia de register studio
	*/
	
	function index(){
		//STEP 1 Validation
		
		$this->form_validation->set_rules('username',					lang('username'),				'trim|required|min_length[3]|max_length[25]|alpha_dash|Unique[studios.username]|not_restricted|strip_tags|purify');
		$this->form_validation->set_rules('password',					lang('password'),				'trim|required|min_length[3]|max_length[64]');		
		$this->form_validation->set_rules('email',						lang('email'),					'trim|required|valid_email|unique_email[studios]|min_length[3]|max_length[60]');
		$this->form_validation->set_rules('firstname', 					lang('firstname'), 				'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('lastname', 					lang('lastname'),				'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('address', 					lang('address'), 				'trim|required|strip_tags|purify|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('city', 						lang('city'), 					'trim|required|strip_tags|purify|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('zip', 						lang('zip'), 					'trim|required|strip_tags|purify|min_length[3]|max_length[10]');
		$this->form_validation->set_rules('state', 						lang('state'), 					'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('country', 					lang('country'), 				'trim|required|strip_tags|valid_country');
		$this->form_validation->set_rules('phone', 						lang('phone'), 					'trim|required|purify|numeric|min_length[8]|max_length[16]');
		$this->form_validation->set_rules('percentage', 				lang('percentage'), 			'trim|required|purify|numeric|valid_studio_percentage');
		$this->form_validation->set_rules('tos',						lang('tos'),					'trim|required|strip_tags|check_tos');
		$this->form_validation->set_rules('contract',					lang('contract'),				'trim|required|performer_contract');
		
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
		
		
		if($this->form_validation->run() === FALSE){

			$data['_categories']			= TRUE;
			$data['_sidebar']				= FALSE;
			$data['_signup_header']			= FALSE;
			$data['page'] 					= 'register';
			
			$data['payment_methods']		= prepare_dropdown_objects($this->payment_method_list,lang('Choose payment method'),'name',FALSE);
			$data['selected_method']		= $selected_method;			
						
			$data['contract']				= ($this->session->userdata('contract'))?$this->session->userdata('contract'):FALSE;
			
			$this->load->config('regions');
			$data['countries']				= prepare_dropdown($this->config->item('countries'),lang('Choose your country'), TRUE);
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Studio register').' - '.SETTINGS_SITE_TITLE;
			
			$this->load->view('template',$data);
		} 
		else 
		{
			$this->load->library('ip2location');
						
			//colect data
			$hash 			= generate_hash('studios');
			$salt 			= $this->config->item('salt');
					
			
			//begin the transaction
			$this->db->trans_begin();
						
			//add the user into database			
			$contract_status = 'pending'; //am setat pe pending implicit
			
			$fields = unserialize($payment_method->fields);
			
			foreach($fields as $field){
				$payment_field = strtolower(str_replace(' ', '_', $field));
				$account[$payment_field] = $this->input->post($payment_field. '_'.$payment_method->id);
			}
			$payment = $this->input->post('payment_method');
			$release = $this->input->post('rls_amount_'.$payment);			
			$serialized_acount = serialize($account);
			
			$status 		= ($this->studios->require_verification())?'pending':'approved';
				
			$studio_id = $this->studios->add(
											$this->input->post('username'),
											hash('sha256',($salt . $hash . $this->input->post('password') )),
											$hash,
											$this->input->post('email'),
											$this->input->post('firstname'),
											$this->input->post('lastname'),
											$status,
											time(),
											ip2long($this->input->ip_address()),
											$contract_status,
											$this->input->post('address'),
											$this->input->post('state'),
											$this->input->post('city'),
											$this->input->post('zip'),
											$this->input->post('phone'),
											$this->input->post('country'),
											$payment,
											$serialized_acount,
											$this->input->post('percentage'),
											$release
											
			);	
			$this->load->helper('directories');
			
			generate_directory('studio',$studio_id);
			
			//adaug contractele
			$this->load->model('contracts');							
			foreach( $this->good_contracts as $contract ){	
				$name = generate_unique_name('uploads/studio/' . $studio_id . '/',$contract['name']);
				
				//move the contract to his place
				rename(BASEPATH . '../'.MY_TEMP_PATH.'/' . $contract['file_on_disk_name'],'uploads/studios/' . $studio_id . '/' . $name);
				$this->contracts->add($name,'pending',$studio_id);
			}
						
			//nu am reusit sa adaug in db userul
			if($this->db->trans_status() == FALSE){
				
				//fac rollback la date
				$this->db->trans_rollback();

				$this->load->library('user_agent');
				
				$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('An error occured')));
				//redirectionez pe pagina de unde a venit
				redirect($this->agent->referrer());
			}
			
			$this->db->trans_commit();
			$this->system_log->add(
            			'studio', 
            			$studio_id,
            			'studio', 
            			$studio_id, 
            			'register', 
            			'New studio has registered.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);		
						
				
			$this->session->unset_userdata('contract');
			
			$this->load->helper('emails');
				
			if($status== 'pending'){
				$email_content = $this->load->view('emails/register_pending_'.$this->config->item('lang_selected'),array(),TRUE);
				$email_subject = lang('Confirmation email.');
				$template		= 'register_pending';
				$replaced_variables = get_avaiable_variabiles($template, TRUE);
				
			}else{
				$email_content	= $this->load->view('emails/register_welcome_'.$this->config->item('lang_selected'),array(),TRUE);
				$email_subject	= lang('Welcome email.');
				$template		= 'register_welcome';
				$replaced_variables = get_avaiable_variabiles($template, TRUE);				
			}
									
			
			$replace_value = array($this->input->post('username'),$this->input->post('password'), $this->input->post('email'),$this->input->post('firstname'), $this->input->post('lastname'),  main_url(), WEBSITE_NAME,  site_url('login') );
			
			$activation_link = site_url('activate?time=' . time() . '&username=' . $this->input->post('username') . '&secure_code=' . md5( time() . $hash ) );
				
			$this->load->helper('emails');
				
			$replaced_variables = get_avaiable_variabiles($template, TRUE);
			$replace_value = array($this->input->post('username'), $this->input->post('password'), $this->input->post('email'), $this->input->post('firstname'),$this->input->post('lastname'),   $activation_link,  main_url(), WEBSITE_NAME,  site_url('login') );
				

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
				redirect('login');
			} else {
				$this->session->set_userdata(array('id'=>$studio_id,'type'=>'studio'));
				redirect('login');	
			}			
		}
	}
	
}
