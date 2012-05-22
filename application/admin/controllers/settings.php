<?php
class Settings_controller extends MY_Admin {
	
	function __construct() {
		parent::__construct();
		$this->load->model('settings');
		$this->load->library('form_validation');
		$this->load->library('Load_settings');
	}
	
	
	
		// index
	function index() {
		
		
		$settings_files = array(
			'./application/admin/config/settings.php',
			'./application/affiliates/config/settings.php',
			'./application/performers/config/settings.php',
			'./application/studios/config/settings.php',
			'./application/main/config/settings.php'
		);

		
		
		// If settings files is writable
		foreach($settings_files as $file){
			if(!is_file($file)){
				$data['disabledForm'] = true;
				$data['err_msg']		= sprintf(lang('File %s not exist! Please create it and set CHMOD 777 rights!'), $file);
				break;
			}
			if(!is_writable($file)) {
				$data['disabledForm'] = true;
				$data['err_msg']		= sprintf(lang('File %s is not writable! Please set CHMOD 777 rights!'), $file);
				break;
			}
		}
		

		if($this->input->post('submit')) {

			if($this->config->item('demo_mode') === true) {
				$this->session->set_flashdata('msg', array('success'=>FALSE, 'message' => lang('Action restricted by demo mode!')));
				redirect(current_url());
			}
			
			foreach ($_POST as $name => $value) {
				$setting = $this->settings->get_by_name($name);

				if(is_object($setting)) {
					
					$row['id'] = $setting->id;

					if($setting->type == 'boolean'){
						$value = (bool)$value;
					}elseif($setting->type == 'integer'){
						$value = (int)$value;
					}

					$row['value'] = $value;
					$this->settings->save($row);
					
				}
			}
			
			//get the new settings to write in files
			$new_settings = $this->settings->get_all();
			
			if($this->load_settings->load($new_settings, $settings_files)){
				$this->session->set_flashdata('msg', array('success'=>TRUE, 'message' => lang('Settings updated!')));
			}else{
				$this->session->set_flashdata('msg', array('success'=>FALSE, 'message' => lang('Failed to save settings!')));
			}

			
			
			redirect(current_url());
			
		} else {
			$data['themes']								= prepare_themes_dropdown();
			$data['currency']							= array('chips' => 'chips', 'euro' => 'euro', 'dollar' => 'dollar');
			
			$data['title'] 								= SETTINGS_SITE_TITLE;
			$data['breadcrumb'][lang('Settings')]		= 'current';
			$data['page_head_title']					= lang('Settings'); 
			$data['page']		= 'settings';
			$data['settings']	= $this->settings->get_all();
			$this->load->view('template', $data);
		}
	}
	
	function index_old() {
		$this->load->helper('file');
		$this->load->model('settings_model');
		
		$data['title'] 								= SETTINGS_SITE_TITLE;
		$data['breadcrumb'][lang('Settings')]		= 'current';
		$data['page_head_title']					= lang('Settings'); 
		$data['page'] 								= 'settings_view';
		$data['themes']								= prepare_themes_dropdown();
		$data['currency']							= array('chips' => 'chips', 'euro' => 'euro', 'dollar' => 'dollar');
		$settings									= $this->settings_model->get_all();
		
		# creez array nou in care index-ul este valoarea campului key (ex: settings_debug, email_activation, enable_memcache, etc.) 
		# din array-ul returnat
		if(is_array($settings) && count($settings) > 0) {
			foreach($settings as $value) {
				$data['settings'][$value->key] = $value;
			}
		}
		
		$this->form_validation->set_rules('settings_debug', 					lang('enable debugging'), 					'required|purify|strip_tags');
		$this->form_validation->set_rules('email_activation', 					lang('email activation'), 					'required|purify|strip_tags');
		$this->form_validation->set_rules('enable_memcache', 					lang('enable memcache'), 					'required|purify|strip_tags');
		$this->form_validation->set_rules('support_email', 						lang('support email'), 						'required|purify|strip_tags|valid_email');
		$this->form_validation->set_rules('support_name', 						lang('support name'), 						'required|purify|strip_tags');
		$this->form_validation->set_rules('website_name', 						lang('website name'), 						'required|purify|strip_tags');
		$this->form_validation->set_rules('settings_default_theme', 			lang('settings default theme'), 			'required|purify|strip_tags');
		$this->form_validation->set_rules('settings_site_description', 			lang('settings site description'), 			'required|purify|strip_tags');
		$this->form_validation->set_rules('settings_site_keywords', 			lang('settings site keywords'), 			'required|purify|strip_tags');
		$this->form_validation->set_rules('settings_site_currency', 			lang('settings site currency'), 			'required|purify|strip_tags');
		$this->form_validation->set_rules('cents_per_credit', 					lang('cents per credit'), 					'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('min_true_private_chips_price',		lang('min true private chips price'), 		'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('max_true_private_chips_price',		lang('max true private chips price'), 		'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('min_private_chips_price', 			lang('min private chips price'), 			'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('max_private_chips_price', 			lang('max private chips price'), 			'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('min_peek_chips_price', 				lang('min peek chips price'), 				'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('max_peek_chips_price', 				lang('max peek chips price'), 				'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('min_nude_chips_price', 				lang('min nude chips price'), 				'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('max_nude_chips_price', 				lang('max nude chips price'), 				'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('min_paid_video_chips_price', 		lang('min paid video chips price'), 		'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('max_paid_video_chips_price', 		lang('max paid video chips price'), 		'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('min_paid_chips_price', 				lang('min paid chips price'), 				'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('max_paid_chips_price', 				lang('max paid chips price'), 				'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('ban_expire_date', 					lang('ban expire date'), 					'required|purify|strip_tags|numeric');
		$this->form_validation->set_rules('settings_transaction_percentage', 	lang('settings transaction percentage'), 	'required|purify|strip_tags|less_than[101]|greater_than[0]');
		$this->form_validation->set_rules('settings_initial_percentage', 		lang('settings initial percentage'), 		'required|purify|strip_tags|less_than[101]|greater_than[0]');
		
		if($this->form_validation->run() == FALSE) {
			
			$this->load->view('template', $data);
			
		} else {
			# Creez textul din fisierele de configurare
			$settings = '<?php';
			$settings .= PHP_EOL;
			$this->db->trans_begin();
			# Iterez prin toate campurile trimise si creez definiitile
			foreach($_POST as $key => $value ) {
				if(is_numeric($value)) {
					$line = "define('" . strtoupper($key) . "', 	" . $value . ");";
				} else {
					$line = "define('" . strtoupper($key) . "', 	'" . $value . "');";
				}
				$settings .= $line;
				$settings .= PHP_EOL;
				
				# Fac update in baza de date
				$this->settings_model->update_where_key($key, $value);
			}
			if($this->db->trans_status() == FALSE) {
				$this->db->trans_rollback();
				$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('An error has occured. Settings not saved!')));
			} else {
				$this->db->trans_commit();
				$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Settings saved successfully!')));
				$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'other', 
            			NULL, 
            			'edit_settings', 
            			'Admin edited website settings.', 
            			time(), 
            			ip2long($this->input->ip_address())
				);
				# Rescrie fisierele de settings
				write_file('./application/admin/config/settings.php', $settings, 'w');
				write_file('./application/affiliates/config/settings.php', $settings, 'w');
				write_file('./application/performers/config/settings.php', $settings, 'w');
				write_file('./application/studios/config/settings.php', $settings, 'w');
				write_file('./application/main/config/settings.php', $settings, 'w');
			}
			redirect(current_url());
		}
	}
	
	
	
}