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
Class Settings_controller extends MY_Studio{
	
	// ------------------------------------------------------------------------		
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('','');	
	}
	
	function index() {
		$this->personal_details();
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * Studio isi schimba detaliile personale
	 * @return unknown_type
	 */
	function personal_details(){
		
		$this->form_validation->set_rules('firstname', 	lang('first name'), 'trim|required|min_length[3]|max_length[30]|strip_tags|purify');
		$this->form_validation->set_rules('lastname', 	lang('last name'), 	'trim|required|min_length[3]|max_length[30]|strip_tags|purify');
		$this->form_validation->set_rules('phone', 		lang('phone'), 		'trim|required|min_length[8]|max_length[15]|strip_tags|numeric|purify');
		$this->form_validation->set_rules('address', 	lang('address'), 	'trim|required|min_length[3]|max_length[80]|strip_tags|purify');
		$this->form_validation->set_rules('city', 		lang('city'), 		'trim|required|min_length[2]|max_length[40]|strip_tags|purify');
		$this->form_validation->set_rules('zip', 		lang('zip'), 		'trim|required|min_length[2]|max_length[40]|strip_tags|purify');
		$this->form_validation->set_rules('state', 		lang('state'), 		'trim|required|min_length[2]|max_length[40]|strip_tags|purify');
		$this->form_validation->set_rules('country', 	lang('country'), 	'trim|required|valid_country');

		if($this->form_validation->run() === FALSE){
			$this->load->config('regions');
			$data['countries']			= $this->config->item('countries');
			$data['states']				= $this->config->item('states');
			$data['description'] 		= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 			= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 			= lang('Personal details').' - '.SETTINGS_SITE_TITLE;
			$data['_settings_sidebar'] 	= TRUE;
			$data['page'] 				= 'settings/personal_details';

			$this->load->view('template', $data);
		}
		else
		{
			if( ! $this->studios->update(
							$this->user->id,
							array(	
								'first_name'			=> $this->input->post('firstname'),
								'last_name'				=> $this->input->post('lastname'),
								'phone'					=> $this->input->post('phone'),
								'address'				=> $this->input->post('address'),
								'city'					=> $this->input->post('city'),
								'zip'					=> $this->input->post('zip'),
								'state'					=> $this->input->post('state'),
								'country_code'			=> $this->input->post('country'),
							)
				)
			){
				$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('database error. please try again later')));
				redirect(current_url());					
			}
			else 
			{
				$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('personal details saved')));
				$this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'studio', 
            			$this->user->id, 
            			'edit_account', 
            			'Studio has edited account.', 
            			time(), 
            			ip2long($this->input->ip_address())
				);		
				redirect(current_url());
			}	
		}		
	}
	
// -----------------------------------------------------------------------------------------		
	/**
	 * Editeaza metoda de plata
	 * @return unknown_type
	 */
	function payment(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters(NULL,NULL);
		
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
		
		if( $this->form_validation->run() === FALSE ){
			$data['_settings_sidebar'] 	= TRUE;
							
			$data['payment_methods']	= prepare_dropdown_objects($this->payment_method_list,FALSE,'name',FALSE);
			$data['selected_method']	= $selected_method;		
		
			$data['page'] 				= 'payment_method';
			$data['description'] 		= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 			= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 			= lang('Payments settings').' - '.SETTINGS_SITE_TITLE;
			$this->load->view('template', $data);
		} else {
			$fields = unserialize($payment_method->fields);
			
			foreach($fields as $field){
				$payment_field = strtolower(str_replace(' ', '_', $field));
				$account[$payment_field] = $this->input->post($payment_field. '_'.$payment_method->id);
			}
			$payment = $this->input->post('payment_method');
			$release = $this->input->post('rls_amount_'.$payment);
			$serialized_acount = serialize($account);
			
			$this->db->trans_begin();
			
			$this->studios->update($this->user->id, array('account' => $serialized_acount, 'payment' => $payment, 'release' =>$release));
			
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

			$this->session->set_flashdata('msg', array('success'=>TRUE, 'message'=>lang('Payment method edited succesfully.')));
			$this->system_log->add(
				'studio', 
				$this->user->id,
			    'studio', 
				$this->user->id,
			    'edit_payment_details', 
		        'Studio changed payment to '.$payment, 
				time(),
				ip2long($this->input->ip_address())
			);
			redirect('settings/payment');			
		}
	}
	
	
	// ------------------------------------------------------------------------	
	/**
	 * Studio schimba parola
	 */
	function password(){ 		
		
		$this->form_validation->set_rules('old_password', 		lang('old password'), 		'trim|required|purify|old_password_verification');
		$this->form_validation->set_rules('new_password', 		lang('new password'), 		'trim|required|min_length[5]|purify');
		$this->form_validation->set_rules('confirm_password', 	lang('confirm password'),   'trim|required|min_length[5]|matches[new_password]|purify');
		
		if($this->form_validation->run() === FALSE){
			$data['description'] 		= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 			= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 			= lang('Change password').' - '.SETTINGS_SITE_TITLE;
			$data['_settings_sidebar'] 	= TRUE;
			$data['page'] 				= 'settings/password';
			
			$this->load->view('template', $data);
		}
		else
		{
			$salt = $this->config->item('salt');
			if( ! $this->studios->update(
					$this->user->id,	
					array('password'=>hash('sha256', ($salt . $this->user->hash . $this->input->post('new_password') ) ))
				)
			){
				$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('database error. please try again later')));
				redirect(current_url());					
			}
			else 
			{
				$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('password changed successfully')));
				$this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'studio', 
            			$this->user->id, 
            			'change_password', 
            			'Studio has changed password.', 
            			time(), 
            			ip2long($this->input->ip_address())
				);	
				redirect(current_url());					
			}			
		}		
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * Studio schimba procentaju
	 */
	function percentage(){
		
		$this->form_validation->set_rules('percentage',	lang('percentage'),'trim|required|valid_studio_percentage');
		
		if($this->form_validation->run() === FALSE){
			$data['description'] 		= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 			= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 			= lang('Percentage settings').' - '.SETTINGS_SITE_TITLE;
			$data['_settings_sidebar'] 	= TRUE;
			$data['page'] 				= 'settings/percentage';

			$this->load->view('template', $data);
		}
		else 
		{
			if( ! $this->studios->update(
						$this->user->id,
						array('percentage'=>$this->input->post('percentage'))
					)
			){
				$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('database error. please try again later')));
				redirect(current_url());				
			}	
			else
			{
				$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('percentage saved')));
				$this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'studio', 
            			$this->user->id, 
            			'edit_account', 
            			sprintf('Studio has changed percentage from %s to %s.',$this->user->percentage, $this->input->post('percentage')), 
            			time(), 
            			ip2long($this->input->ip_address())
				);	
				redirect(current_url());									
			}
		}
	}	
}