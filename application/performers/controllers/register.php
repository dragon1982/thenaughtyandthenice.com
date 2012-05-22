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
 * @property Performers $performers
 * @property Performers_photos $performers_photos
 * @property Contracts	$contracts
 */

Class Register_controller extends MY_Registration {
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Constructor
	 */
	function __construct(){		
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->model('performers');	
		
		$step  = $this->step;
		$this->form_validation->set_error_delimiters(NULL,NULL);
		return $this->$step();	
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Register performer
	 * @return unknown_type
	 */
	function index(){								
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Register step 1
	 * @return unknown_type
	 */
	function step1(){
				
		//STEP 1 Validation
		$this->form_validation->set_rules('username',					lang('username'),				'trim|required|min_length[3]|max_length[25]|alpha_dash|Unique[performers.username]|not_restricted|strip_tags|purify');
		$this->form_validation->set_rules('nickname',					lang('nickname'),				'trim|required|min_length[3]|max_length[25]|alpha_dash|Unique[performers.nickname]|not_restricted|strip_tags|purify');
		$this->form_validation->set_rules('password',					lang('password'),				'trim|required|min_length[3]|max_length[64]');
		$this->form_validation->set_rules('email',						lang('email'),					'trim|required|valid_email|unique_email[performers]|min_length[3]|max_length[60]');
		$this->form_validation->set_rules('firstname', 					lang('firstname'), 				'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('lastname', 					lang('lastname'),				'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('address', 					lang('address'), 				'trim|required|strip_tags|purify|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('city', 						lang('city'), 					'trim|required|strip_tags|purify|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('zip', 						lang('zip'), 					'trim|required|strip_tags|purify|min_length[3]|max_length[10]');
		$this->form_validation->set_rules('state', 						lang('state'), 					'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('country', 					lang('country'), 				'trim|required|strip_tags|valid_country');
		$this->form_validation->set_rules('phone', 						lang('phone'), 					'trim|required|purify|numeric|min_length[8]|max_length[16]');
		$this->form_validation->set_rules('tos',						lang('tos'),					'trim|required|strip_tags|check_tos');
		$this->form_validation->set_rules('contract',					lang('contract'),				'trim|required|performer_contract');
		$this->form_validation->set_rules('photo_id',					lang('photo_id'),				'trim|required|performer_photo_id');
		
		
		if($this->form_validation->run() === FALSE){
			$data['_categories']	= TRUE;
			$data['_sidebar']		= FALSE;
			$data['_signup_header']	= FALSE;
			$data['page'] 			= 'register_step_1';
			
			$data['contract']		= ($this->session->userdata('contract'))?$this->session->userdata('contract'):FALSE;
			$data['photo_id']		= ($this->session->userdata('photo_id'))?$this->session->userdata('photo_id'):FALSE;
			
			$this->load->config('regions');
			$data['countries']				= prepare_dropdown($this->config->item('countries'),lang('Choose your country'),TRUE);
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Performer register step 1').' - '.SETTINGS_SITE_TITLE;
			
			$this->load->view('template',$data);			
		} 
		else 
		{
			
			$this->load->library('ip2location');
						
			//colect data
			$hash 			= generate_hash('performers');
			$salt 			= $this->config->item('salt');
			$status 		= ($this->performers->require_verification())?'pending':'approved';
			
			//begin the transaction
			$this->db->trans_begin();
						
			//add the user into database
			$time = time();
			$ip = $this->input->ip_address();
			
			$performer_id = $this->performers->add(
											$this->input->post('username'),
											hash('sha256',($salt . $hash . $this->input->post('password') )),
											$hash,
											$this->input->post('email'),
											$this->input->post('nickname'),
											$this->input->post('firstname'),
											$this->input->post('lastname'),
											$status,
											$time,
											ip2long($ip),
											$this->input->post('address'),
											$this->input->post('state'),
											$this->input->post('city'),
											$this->input->post('zip'),
											$this->input->post('phone'),
											$this->input->post('country'),
											$this->ip2location->getCountryShort($ip)
											
			);
										
			$this->performers->add_performers_profile(
											$performer_id,
											NULL,
											NULL,
											NULL,
											NULL,
											NULL,
											NULL,
											NULL,
											NULL,
											NULL,
											NULL,
											NULL,
											NULL,
											0
			);
			
			//genereaza directoarele pentru performer
			$this->load->helper('directories');
			generate_directory('performer',$performer_id);
			
			//adaug contractele
			$this->load->model('contracts');							
			foreach( $this->good_contracts as $contract ){	
				$name = generate_unique_name('uploads/performers/' . $performer_id . '/others/',$contract['name']);
				
				//move the contract to his place
				@rename(BASEPATH . '../'.MY_TEMP_PATH.'/' . $contract['file_on_disk_name'], BASEPATH.'../uploads/performers/' . $performer_id . '/others/' . $name);
				$this->contracts->add($name,'pending',$performer_id);
			}
			
			
			//adaug buletinu
			$this->load->model('performers_photo_ids');			
			foreach( $this->good_photo_ids as $photo_id ){	
				$name = generate_unique_name('uploads/performers/' . $performer_id . '/others/',$photo_id['name']);
				
				//move the contract to his place
				@rename(BASEPATH . '../'.MY_TEMP_PATH.'/' . $photo_id['file_on_disk_name'], BASEPATH.'../uploads/performers/' . $performer_id . '/others/' . $name);
				$this->performers_photo_ids->add($name,'pending',$performer_id);
			}			

			//nu am reusit sa adaug in db userul
			if($this->db->trans_status() == FALSE){
				
				//sterg directoru
				delete_directory('performer',$performer_id);
				
				//fac rollback la date
				$this->db->trans_rollback();

				$this->load->library('user_agent');
				
				$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('An error occured')));				
				//redirectionez pe pagina de unde a venit
				redirect($this->agent->referrer());
			}			
			
			$this->db->trans_commit();
			$this->system_log->add(
            			'performer', 
            			$performer_id,
            			'other', 
            			NULL, 
            			'register', 
            			'Performer has registered.', 
            			$time, 
            			ip2long($this->input->ip_address())
			);				

			//sterg contractul din sessiune 
			$this->session->unset_userdata('contract');
			$this->session->unset_userdata('photo_id');
			
			
			//verific daca ce mail trebuie sa trimit
			$status = ($this->performers->require_verification())?'pending':'approved';
			
			
			if($status== 'pending'){
				$email_content = $this->load->view('emails/register_pending_'.$this->config->item('lang_selected'),array(),TRUE);
				$email_subject = lang('Confirmation email.');
				$template		= 'register_pending';
			}else{
				$email_content	= $this->load->view('emails/register_welcome_'.$this->config->item('lang_selected'),array(),TRUE);
				$email_subject	= lang('Welcome email.');
				$template		= 'register_welcome';
			}
			
			$activation_link = site_url('activate?time=' . time() . '&username=' . $this->input->post('username') . '&secure_code=' . md5( time() . $hash ) );
			
			$this->load->helper('emails');
			$replaced_variables = get_avaiable_variabiles($template, TRUE);
			$replace_value = array($this->input->post('username'), $this->input->post('password'), $this->input->post('email'), $this->input->post('firstname'),$this->input->post('lastname'),  $this->input->post('nickname'), $activation_link,  main_url(), WEBSITE_NAME,  site_url('login') );
			
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
			}	
			$this->session->set_userdata('register',array('step'=>2,'performer_id'=>$performer_id));
			redirect('register');
		}
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Step 2 -> adaugare detalii de plata
	 * @return unknown_type
	 */
	function step2(){

		
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
			$data['page'] 					= 'register_step_2';
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Performer register step 2').' - '.SETTINGS_SITE_TITLE;
			$data['payment_methods']		= prepare_dropdown_objects($this->payment_method_list,lang('Choose payment method'),'name',FALSE);
			$data['selected_method']		= $selected_method;			

			$this->load->view('template',$data);			
		} 
		else 
		{
			$fields = unserialize($payment_method->fields);
			
			foreach($fields as $field){
				$payment_field = strtolower(str_replace(' ', '_', $field));
				$account[$payment_field] = $this->input->post($payment_field. '_'.$payment_method->id);
			}
			$payment = $this->input->post('payment_method');
			$release = $this->input->post('rls_amount_'.$payment);			
			$serialized_acount = serialize($account);
			
			$this->db->trans_begin();
			
			$this->performers->update($this->register_user->id, array('account' => $serialized_acount, 'payment' => $payment, 'release' =>$release, 'register_step'=>3));
			
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
			$this->session->set_userdata('register',array('step'=>3,'performer_id'=>$this->register_user->id));
			redirect('register');			
		}		
	}
	
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Step 3 -> selectare categorii
	 * @return unknown_type
	 */
	function step3(){
		
		//STEP 3 Validation
		$this->form_validation->set_rules('category',					lang('category'), 				'required|check_categories');
		
		if($this->form_validation->run() === FALSE){
			$data['_categories']	= TRUE;
			$data['_sidebar']		= FALSE;
			$data['_signup_header']	= FALSE;
			$data['page'] 			= 'register_step_3';
	
			$this->load->model('categories');
			
			$data['cat'] 					= $this->categories->get_all_categories();
			
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Performer register step 3').' - '.SETTINGS_SITE_TITLE;
			
			$this->load->view('template',$data);
		} 
		else
		{

			$this->db->trans_begin();
			
			//Adauga categoriile la un performer
			$categories = $this->input->post('category');
			foreach ($categories as $category){
				$this->performers->add_performers_categories(
												$this->register_user->id,
												$category
				);
			}

			$this->performers->update($this->register_user->id,array('register_step'=>4));
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

			$this->session->set_userdata('register',array('step' => 4,'performer_id' => $this->register_user->id));
			redirect('register');			
		}			
	}
	
	/**
	 * Setari preturi
	 */
	function step4(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('true_private_chips_price',	lang('true private chips price'), 	'trim|required|valid_price[true_private]');
		$this->form_validation->set_rules('private_chips_price',		lang('private chips price'), 		'trim|required|valid_price[private]');
		$this->form_validation->set_rules('nude_chips_price',			lang('nude chips price'), 			'trim|required|valid_price[nude]');
		$this->form_validation->set_rules('peek_chips_price',			lang('peek chips price'), 			'trim|required|valid_price[peek]');
		$this->form_validation->set_rules('paid_photo_gallery_price',	lang('paid photo gallery price'),	'trim|required|valid_price[photos]');		
		
		if($this->form_validation->run() === FALSE){
			//iau preturil curente din $this->user si prepoulez fieldurile	
			
			$data['true_private_chips_price']	= $this->register_user->true_private_chips_price;
			$data['private_chips_price']		= $this->register_user->private_chips_price;
			$data['nude_chips_price']			= $this->register_user->nude_chips_price;
			$data['peek_chips_price']			= $this->register_user->peek_chips_price;
			$data['paid_photo_gallery_price'] 	= $this->register_user->paid_photo_gallery_price;
			
			$data['_categories']	= TRUE;
			$data['_sidebar']		= FALSE;
			$data['_signup_header']	= FALSE;
			$data['page'] 					= 'register_step_4';
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Performer register step 4').' - '.SETTINGS_SITE_TITLE;
			$data['performer']				= $this->register_user;
			
			$this->load->view('template', $data);	
		}
		else
		{	
			
			$this->performers->update($this->register_user->id,array('register_step'=>5));
			
			//daca nu poate face update in baza de date
			if( ! $this->performers->update(
					$this->register_user->id,
					array(
						'true_private_chips_price'	=> $this->input->post('true_private_chips_price'),
						'private_chips_price'		=> $this->input->post('private_chips_price'),
						'peek_chips_price'			=> $this->input->post('peek_chips_price'),					
						'nude_chips_price'			=> $this->input->post('nude_chips_price'),
						'paid_photo_gallery_price'	=> $this->input->post('paid_photo_gallery_price')
					)
				)
			){//databse error
				$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=>lang('database error. please try again later')));
				redirect('register');				
			}
			else 
			{
				$this->session->set_userdata('register',array('step' => 5,'performer_id' => $this->register_user->id));			
				redirect('register');				
			}		
		}	
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Stepul de adaugare detalii despre profil
	 * @return unknown_type
	 */
	function step5(){					
		$this->load->model('performers_profile');
		
		//STEP 4 Validation
		$this->form_validation->set_rules('gender', 					lang('gender'), 				'trim|required|strip_tags|purify|min_length[1]|valid_enum_value[gender]');
		$this->form_validation->set_rules('description', 				lang('description'), 			'trim|required|strip_tags|purify|max_length[255]');
		$this->form_validation->set_rules('what_turns_me_on', 			lang('what_turns_me_on'), 		'trim|required|strip_tags|purify|max_length[255]');
		$this->form_validation->set_rules('what_turns_me_off', 			lang('what_turns_me_off'), 		'trim|required|strip_tags|purify|max_length[255]');
		$this->form_validation->set_rules('sexual_prefference', 		lang('sexual_prefference'), 	'trim|required|strip_tags|purify|min_length[1]|valid_enum_value[sexual_prefference]');
		$this->form_validation->set_rules('ethnicity', 					lang('ethnicity'), 				'trim|required|strip_tags|purify|min_length[1]|valid_enum_value[ethnicity]');
		$this->form_validation->set_rules('height', 					lang('height'), 				'trim|required|strip_tags|purify|min_length[1]|valid_enum_value[height]');
		$this->form_validation->set_rules('weight', 					lang('weight'), 				'trim|required|strip_tags|purify|min_length[1]|valid_enum_value[weight]');
		$this->form_validation->set_rules('hair_color', 				lang('hair_color'), 			'trim|required|strip_tags|purify|min_length[1]|valid_enum_value[hair_color]');
		$this->form_validation->set_rules('hair_length', 				lang('hair_length'), 			'trim|required|strip_tags|purify|min_length[1]|valid_enum_value[hair_length]');
		$this->form_validation->set_rules('eye_color', 					lang('eye_color'), 				'trim|required|strip_tags|purify|min_length[1]|valid_enum_value[eye_color]');
		$this->form_validation->set_rules('build', 						lang('build'), 					'trim|required|strip_tags|purify|min_length[1]|valid_enum_value[build]');
		$this->form_validation->set_rules('cup_size', 					lang('cup_size'),				'trim|required|strip_tags|purify|min_length[1]|valid_enum_value[cup_size]');
		$this->form_validation->set_rules('avatar',						lang('avatar'),					'trim|performer_avatar');
		$this->form_validation->set_rules('day', 						lang('day'), 			 		'trim|required|strip_tags|numeric|purify|max_length[2]');
		$this->form_validation->set_rules('month', 						lang('month'), 					'trim|required|strip_tags|numeric|purify|max_length[2]');
		$this->form_validation->set_rules('year', 						lang('year'), 					'trim|required|strip_tags|numeric|purify|max_length[4]|birthday');
		$this->form_validation->set_rules('lang', 						lang('lang'),	 				'required|check_language');
				
		if($this->form_validation->run() === FALSE){
			$data['_categories']	= TRUE;
			$data['_sidebar']		= FALSE;
			$data['_signup_header']	= FALSE;
			$data['page'] 			= 'register_step_5';
			$an['-']		= lang('Year');
			$luna['-']		= lang('Month');
			$zi['-']		= lang('Day');
			for($i=1995;$i>=1950;$i--){
				$an[$i]=$i;
			}
			for($i=1;$i<=12;$i++){
				$luna[$i]=$i;
			}
			for($i=1;$i<=31;$i++){
				$zi[$i]=$i;
			}
						
			$this->load->model('supported_languages');
			
			$data['days']					= $zi;
			$data['months']					= $luna;
			$data['years']					= $an;
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Performer register step 5').' - '.SETTINGS_SITE_TITLE;
			
			$data['avatar']					= ($this->session->userdata('avatar'))?$this->session->userdata('avatar'):FALSE;

			
			$data['languages']				= $this->supported_languages->get_supported_languages();
			$data['gender'] 				= prepare_dropdown($this->performers_profile->get_enum_values('gender'),lang('select gender'),FALSE,TRUE);
			$data['sexual_prefference'] 	= prepare_dropdown($this->performers_profile->get_enum_values('sexual_prefference'),lang('select sexual prefference'),FALSE,TRUE);
			$data['ethnicity'] 				= prepare_dropdown($this->performers_profile->get_enum_values('ethnicity'),lang('select ethnicity'),FALSE,TRUE);
			$data['height'] 				= prepare_dropdown($this->performers_profile->get_enum_values('height'),lang('select height'),FALSE,TRUE);
			$data['weight'] 				= prepare_dropdown($this->performers_profile->get_enum_values('weight'),lang('select weight'),FALSE,TRUE);
			$data['hair_color'] 			= prepare_dropdown($this->performers_profile->get_enum_values('hair_color'),lang('select hair color'),FALSE,TRUE);
			$data['hair_length'] 			= prepare_dropdown($this->performers_profile->get_enum_values('hair_length'),lang('select hair lenght'),FALSE,TRUE);
			$data['eye_color'] 				= prepare_dropdown($this->performers_profile->get_enum_values('eye_color'),lang('select eye color'),FALSE,TRUE);
			$data['build'] 					= prepare_dropdown($this->performers_profile->get_enum_values('build'),lang('select build'),FALSE,TRUE);
			$data['cup_size']				= prepare_dropdown($this->performers_profile->get_enum_values('cup_size'),lang('select cup size'),FALSE,TRUE);

			$this->load->view('template',$data);		
			
		}
		else
		{
			
			$this->load->helper('directories');
			
			if(isset($this->good_avatar[0])){
				
				$photo = $this->good_avatar[0];

				if(is_array($photo) && count($photo) > 0){
					$name  = generate_unique_name('uploads/performers/' . $this->register_user->id . '/', $photo['name']);
					$path  = BASEPATH . '../uploads/performers/' . $this->register_user->id . '/' . $name;
					$spath = BASEPATH . '../uploads/performers/' . $this->register_user->id . '/small/' . $name;
					$mpath = BASEPATH . '../uploads/performers/' . $this->register_user->id . '/medium/' . $name;

					///mut pozele in directoarele lor
					rename(MY_TEMP_PATH.'/' . $photo['file_on_disk_name'], $path);
					copy($path, $spath);
					copy($path, $mpath);

					# Resize thumbnail
					$this->image_lib->clear();
					$this->image_lib->initialize(array(
						'image_library'  => 'gd2',
						'source_image'   => $spath,
						'create_thumb'   => FALSE,
						'maintain_ratio' => FALSE,
						'width'          => 150,
						'height'         => 116
					));
					$this->image_lib->crop_delete();

					# Resize profile pic
					$this->image_lib->clear();
					$this->image_lib->initialize(array(
						'image_library'  => 'gd2',
						'source_image'   => $mpath,
						'create_thumb'   => FALSE,
						'maintain_ratio' => FALSE,
						'width'          => 338,
						'height'         => 260 
					));
					$this->image_lib->crop_delete();


					# Resize profile pic
					$this->image_lib->clear();
					$this->image_lib->initialize(array(
						'image_library'  => 'gd2',
						'source_image'   => $path,
						'create_thumb'   => FALSE,
						'maintain_ratio' => TRUE,
						'width'          => 800,
						'height'         => 600 
					));
					$this->image_lib->resize();                

					if( ! file_exists($spath) || ! file_exists($mpath) || ! file_exists($path) ){
						@unlink($spath);
						@unlink($mpath);
						@unlink($path);
						$this->load->library('user_agent');
						$this->session->set_flashdata('msg', array( 'success' => FALSE,  'message' => lang('An error occured')));
						redirect(current_url());
					}
				}
			}
			
			
			$this->db->trans_begin();
			if(isset($photo['name'])){
				$this->load->model('performers_photos');
				$this->performers_photos->add($this->register_user->id,$name,'Avatar',0,1);
			}else{
				$name = null;
			}
			//Adauga limbile la un performer
			$languages = $this->input->post('lang');
			foreach ($languages as $language){
				$this->performers->add_performers_languages(
												$this->register_user->id,
												$language
				);
			}
					
			//Adauga profilul la un performer
			$birthday = mktime(0, 0, 0, $this->input->post('month'), $this->input->post('day'), $this->input->post('year'));
			$this->performers_profile->update($this->register_user->id,
									array(
											'gender'			=> $this->input->post('gender'),
											'description'		=> $this->input->post('description'),
											'what_turns_me_on'	=> $this->input->post('what_turns_me_on'),
											'what_turns_me_off'	=> $this->input->post('what_turns_me_off'),
											'sexual_prefference'=> $this->input->post('sexual_prefference'),
											'ethnicity'			=> $this->input->post('ethnicity'),
											'height'			=> $this->input->post('height'),
											'weight'			=> $this->input->post('weight'),
											'hair_color'		=> $this->input->post('hair_color'),
											'hair_length'		=> $this->input->post('hair_length'),
											'eye_color'			=> $this->input->post('eye_color'),
											'build'				=> $this->input->post('build'),
											'cup_size'			=> $this->input->post('cup_size'),
											'birthday'			=> $birthday
									)
			);

			$this->performers->update($this->register_user->id,array('avatar'=>$name,'register_step'=>6));

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

			//sterg sessiunea de register
			$this->session->unset_userdata('register');
			$this->session->unset_userdata('avatar');
	
			$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Account created successfully')));				
			redirect('login');					
	
		}
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Verifica un username daca exista in baza de date
	 * @param $username
	 * @return unknown_type
	 */
	function check_unique_username($username = FALSE){
		if( ! $username ){
			exit('false');	
		}
				
		$user = $this->performers->get_one_by_username($username);
		if( ! $user){
			exit('false');
		} 
		exit('true');
	}
	
	/**
	 * Functie pentru ajax care returneaza campurile folosite la metoda selectata de performer
	 * @return unknown_type
	 */
	function get_selected_payment_fields($payment_id = FALSE) {
		if($payment_id == FALSE) die();
		$this->load->model('payment_methods');
		$payment = $this->payment_methods->get_one_by_id($payment_id);
		$data['payment_details'] = $payment;
		die($this->load->view('payment_methods/payment_fields',$data , TRUE));
	}
}