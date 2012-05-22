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
 * @property Users $users
 * @property affiliates $affiliates
 * @property Watchers $watchers
 * @property Payment_methods $payment_methods
 */
Class Settings_controller extends MY_Affiliate{
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('affiliates');
		$this->load->library('form_validation');
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * PErformer deafult page
	 * @return unknown_type
	 */
	function index(){			
		$this->change_password();
	}
	
	
	// -------------------------------------------------------------------------------------	
	/**
	 * Schimba parola
	 * @author Baidoc
	 */
	function change_password(){
		$this->form_validation->set_rules('old_password',	lang('old password'),		'trim|required|xss_clean|purify|old_password_verification');
		$this->form_validation->set_rules('password',		lang('password'),			'trim|required|xss_clean|purify');
		$this->form_validation->set_rules('rep_password',	lang('repeat password'),	'trim|required|xss_clean|purify|matches[password]');
		
		if($this->form_validation->run() == FALSE){

			$data['_sidebar']				= TRUE;
			$data['_sidebar_title'] 		= lang('Settings');
			$data['_sidebar_page']			= 'settings_menu';

			$data['page']					= 'change_password';
			$data['description']			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords']				= SETTINGS_SITE_KEYWORDS;
			$data['page_title']				= lang('Change password').' - '.SETTINGS_SITE_TITLE;

			$this->load->view('template', $data);
			return;
		}
		
		$hash 			= $this->user->hash;
		$salt 			= $this->config->item('salt');
		
		$new_password = hash('sha256',($salt . $hash . $this->input->post('password') ));
		
		$rows['password']	= $new_password;
				
		if($this->affiliates->update($this->user->id,$rows)){
			$this->session->set_flashdata('msg', array('success'=>TRUE, 'message'=>lang('Password was updated successfully')));
			$this->system_log->add(
            			'affiliate', 
            			$this->user->id,
            			'affiliate', 
            			$this->user->id, 
            			'edit_account', 
            			'Affiliate has changed password.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		}else{
			$this->session->set_flashdata('msg', array('success'=>FALSE, 'message'=>lang('Password was not updated! Please try again!')));
		}
		
		redirect('settings/change_password');
		
	}
	
	// -------------------------------------------------------------------------------------
	/**
	 * Editare detalii personale
	 * @author Baidoc
	 */
	function personal_details(){
		$this->load->model('countries');
		$countries = $this->countries->get_all();
		if(is_array($countries) && count($countries) > 0){
			foreach($countries as $country){
				$data['countries'][$country->code] = $country->name;
			}
		}
		
		$this->form_validation->set_rules('first_name',			lang('first name'),			'trim|required|xss_clean|purify');
		$this->form_validation->set_rules('last_name',			lang('last name'),			'trim|required|xss_clean|purify');
		$this->form_validation->set_rules('address',			lang('address'),			'trim|required|xss_clean|purify');
		$this->form_validation->set_rules('city',				lang('city'),				'trim|required|xss_clean|purify');
		$this->form_validation->set_rules('zip',				lang('zip'),				'trim|required|xss_clean|purify');
		$this->form_validation->set_rules('country',			lang('country'),			'trim|required|xss_clean|purify');
		$this->form_validation->set_rules('phone',				lang('phone'),				'trim|required|xss_clean|purify');
		
		if($this->form_validation->run() == FALSE){

			$data['_sidebar']				= TRUE;
			$data['_sidebar_title'] 		= lang('Settings');
			$data['_sidebar_page']			= 'settings_menu';

			$data['page']					= 'personal_details';
			$data['description']			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords']				= SETTINGS_SITE_KEYWORDS;
			$data['page_title']				= lang('Personal details').' - '.SETTINGS_SITE_TITLE;

			$this->load->view('template', $data);
			return;
		}
		
		$rows['first_name']				= $this->input->post('first_name');
		$rows['last_name']				= $this->input->post('last_name');
		$rows['address']				= $this->input->post('address');
		$rows['city']					= $this->input->post('city');
		$rows['zip']					= $this->input->post('zip');
		$rows['country_code']			= $this->input->post('country');
		$rows['phone']					= $this->input->post('phone');
		
		if($this->affiliates->update($this->user->id,$rows)){
			$this->session->set_flashdata('msg', array('success'=>TRUE, 'message'=>lang('Personal details was updated successfully')));
			$this->system_log->add(
            			'affiliate', 
            			$this->user->id,
            			'affiliate', 
            			$this->user->id, 
            			'edit_account', 
            			'Affiliate has changed personal details.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);			
		}else{
			$this->session->set_flashdata('msg', array('success'=>FALSE, 'message'=>lang('Personal details were not updated! Please try again!')));
		}
		
		redirect('settings/personal_details');
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
		
			$data['_sidebar']				= TRUE;
			$data['_sidebar_title'] 		= lang('Settings');
			$data['_sidebar_page']			= 'settings_menu';
			
			$data['current_method']		= $this->payment_methods->get_one_by_id($this->user->payment);
			$data['payment_methods']	= prepare_dropdown_objects($this->payment_method_list,FALSE,'name',FALSE);
			 
			$data['page'] 				= 'payment_method';
			$data['description'] 		= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 			= SETTINGS_SITE_KEYWORDS;
			$data['page_title']			= lang('Payment details').' - '.SETTINGS_SITE_TITLE;
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
			
			$this->affiliates->update($this->user->id, array('account' => $serialized_acount, 'payment' => $payment, 'release' =>$release));
			
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
				'affiliate', 
				$this->user->id,
				'affiliate', 
				$this->user->id,
				'edit_payment_details', 
				'Performer changed payment to '.$payment, 
				time(),
				ip2long($this->input->ip_address())
			);
			
			redirect('settings/payment');
				
		}
	}
}