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
 * @property Performers $performers
 * @property performers_photos $performers_photos
 * @property Studios $studios
 * @property Fms $fms
 * @property Payments $payments
 * @property Watchers $watchers
 * @property Chart $chart
 * @property Charts $charts
 */
Class Performers_controller extends MY_Studio{
	
	function __construct(){
		parent::__construct();
		$this->load->model('performers');
		
		if($this->user->status == 'pending'){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Your account is in pending and you are not allowed to register performers!')));		
			redirect();
		}
	}
	
	/**
	 * Studio vede lista cu performeri
	 * @return unknown_type
	 */
	function index(){		
        $filters = FALSE;
		$statuses = array(
				'pending'  => lang('Pending'),
                'approved' => lang('Approved'),
                'rejected' => lang('Rejected')
		);
				
        if(isset($statuses[$this->input->post('status')])) $filters['status'] =  $this->input->post('status');
        if(isset($statuses[$this->input->post('photo_id_status')])) $filters['photo_id'] =  $this->input->post('photo_id_status');
        if(isset($statuses[$this->input->post('contract_status')])) $filters['contract'] =  $this->input->post('contract_status');
        
        $data['meta_refresh']			= TRUE;
        $data['status']					= array_merge(array('status'=>lang('Performers status')),$statuses);
        $data['contract_status']		= array_merge(array('status'=>lang('Contract Status')),$statuses);
        $data['photo_id_status']		= array_merge(array('status'=>lang('Photo ID Status')),$statuses);

        $performers     = $this->studios->get_multiple_performers_by_studio_id($this->user->id, $filters);
        
        $data['studio_performers'] = NULL;
		if(is_array($performers) && count($performers)){
			foreach($performers as $performer){
				$result = $this->performers->get_performer_rate($performer->id);
				if($result->rating > 0){
					$performer->rating = $result->rating;
				}else{
					$performer->rating = '0';
				}
				
				$data['studio_performers'][] = $performer;
			}
		}
        $data['description'] 	       = SETTINGS_SITE_DESCRIPTION;
        $data['keywords'] 		       = SETTINGS_SITE_KEYWORDS;
        $data['pageTitle'] 		       = lang('My Performers').' - '.SETTINGS_SITE_TITLE;
        $data['_categories']	       = FALSE;
        $data['_sidebar']		       = FALSE;
        $data['_signup_header']	       = FALSE;
        $data['page']			       = 'performers';		
    
        $this->load->view('template', $data);
	}
		
	// ------------------------------------------------------------------------	
	/**
	 * Adauga performer
	 * @author Baidoc
	 */
	function register(){
		$this->load->library('form_validation');
		$this->load->model('performers');	
		
		$register = $this->session->userdata('register');
		
		//nu are in sessiune nimic
		if( ! $register ){
			$this->step = 'step1';			
		} else {
			
			$this->load->model('performers');
			
			$performer = $this->performers->get_one_by_id($register['performer_id']);
			
			//performerul a fost sters/rejectat -> trimitem performeru la step 1 back
			if( ! $performer || $performer->status == 'rejected'){
				$this->session->unset_userdata('register');
				redirect('register');
			}
			
			$this->register_user = $performer;
			
			$this->step = 'step'.$register['step'];
		}

		
		$step  = $this->step;
		$this->form_validation->set_error_delimiters(NULL,NULL);
		return $this->$step();				
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
		$this->form_validation->set_rules('email',						lang('email'),					'trim|required|valid_email|purify|min_length[3]|max_length[64]');
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
			$data['page'] 			= 'performers/register_step_1';
			
			$data['contract']		= ($this->session->userdata('contract'))?$this->session->userdata('contract'):FALSE;
			$data['photo_id']		= ($this->session->userdata('photo_id'))?$this->session->userdata('photo_id'):FALSE;
									
			$this->load->config('regions');
			$data['countries']				= prepare_dropdown($this->config->item('countries'),lang('choose your country..'),TRUE);
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Register Performer Step 1').' - '.SETTINGS_SITE_TITLE;
			
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
											$this->user->id											
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
			
			$this->load->model('contracts');
							
			foreach( $this->good_contracts as $contract ){	
				$name = generate_unique_name(BASEPATH.'../uploads/' . $performer_id . '/others/',$contract['name']);
				
				//move the contract to his place
				rename(BASEPATH . '../'.MY_TEMP_PATH.'/' . $contract['file_on_disk_name'], BASEPATH.'../uploads/performers/' . $performer_id . '/others/' . $name);
				$this->contracts->add($name,'pending',NULL,$performer_id);
			}

			//adaug buletinu
			$this->load->model('performers_photo_ids');			
			foreach( $this->good_photo_ids as $photo_id ){	
				$name = generate_unique_name('uploads/performers/' . $performer_id . '/others/',$photo_id['name']);
				
				//move the contract to his place
				rename(BASEPATH . '../'.MY_TEMP_PATH.'/' . $photo_id['file_on_disk_name'], BASEPATH.'../uploads/performers/' . $performer_id . '/others/' . $name);
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
            			'studio', 
            			$this->user->id,
            			'performer', 
            			$performer_id, 
            			'register', 
            			'Studio has added a new performer to his/her account.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);	
										
			
			//sterg contractul din sessiune 
			$this->session->unset_userdata('contract');
			$this->session->unset_userdata('photo_id');
			
				
			if($status== 'pending'){
				$email_content = $this->load->view('emails/performers/register_pending_'.$this->config->item('lang_selected'),array(),TRUE);
				$email_subject = lang('Confirmation email.');
				$template		= 'performers_register_pending';
			}else{
				$email_content	= $this->load->view('emails/performers/register_welcome_'.$this->config->item('lang_selected'),array(),TRUE);
				$email_subject	= lang('Welcome email.');
				$template		= 'performers_register_welcome';
			}
				
			$activation_link = main_url(PREFORMERS_URL.'/activate?time=' . time() . '&username=' . $this->input->post('username') . '&secure_code=' . md5( time() . $hash ) );
				
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
			redirect(current_url());
		}
	}	

	// -----------------------------------------------------------------------------------------		
	/**
	 * Step 3 -> selectare categorii
	 * @return unknown_type
	 */
	function step2(){
		
		//STEP 3 Validation
		$this->form_validation->set_rules('category',					lang('category'), 				'required|check_categories');
		$this->form_validation->set_rules('subcategory',				lang('subcategory'), 			'numeric');
		
		if($this->form_validation->run() === FALSE){
			$data['_categories']	= TRUE;
			$data['_sidebar']		= FALSE;
			$data['_signup_header']	= FALSE;
			$data['page'] 			= 'performers/register_step_2';
	
			$this->load->model('categories');
			
			$data['cat'] 					= $this->categories->get_all_categories();
			
			
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Register Performer Step 2').' - '.SETTINGS_SITE_TITLE;
			
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

			//updatez register stepu
			$this->performers->update($this->register_user->id,array('register_step'=>3));
				
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
			redirect(current_url());			
		}			
	}
	
	
	/*
	 * Pricings
	 */
	function step3(){
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
			$data['page'] 					= 'performers/register_step_3';
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Register Performer Step 3').' - '.SETTINGS_SITE_TITLE;
			$data['performer']				= $this->register_user;
			
			$this->load->view('template', $data);	
		}
		else
		{	
			
			$this->performers->update($this->register_user->id,array('register_step'=>4));
			
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
				redirect(current_url());				
			}
			else 
			{
				$this->session->set_userdata('register',array('step' => 4,'performer_id' => $this->register_user->id));			
				redirect(current_url());				
			}	
		}			
	}
	// -----------------------------------------------------------------------------------------		
	/**
	 * Stepul de adaugare detalii despre profil
	 * @return unknown_type
	 */
	function step4(){
		
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
		$this->form_validation->set_rules('avatar',						lang('avatar'),					'trim|required|performer_avatar');	
		$this->form_validation->set_rules('day', 						lang('day'), 			 		'trim|required|strip_tags|numeric|purify|max_length[2]');
		$this->form_validation->set_rules('month', 						lang('month'), 					'trim|required|strip_tags|numeric|purify|max_length[2]');
		$this->form_validation->set_rules('year', 						lang('year'), 					'trim|required|strip_tags|numeric|purify|max_length[4]|birthday');
		$this->form_validation->set_rules('lang', 						lang('lang'),	 				'required|check_language');
				
		if($this->form_validation->run() === FALSE){
			$data['_categories']	= TRUE;
			$data['_sidebar']		= FALSE;
			$data['_signup_header']	= FALSE;
			$data['page'] 			= 'performers/register_step_4';
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
			$data['pageTitle'] 				= lang('Register Performer Step 4').' - '.SETTINGS_SITE_TITLE;
			
			$data['avatar']					= ($this->session->userdata('avatar'))?$this->session->userdata('avatar'):FALSE;
			
			$data['languages']				= $this->supported_languages->get_supported_languages();
			$data['gender'] 				= prepare_dropdown($this->performers_profile->get_enum_values('gender'),			lang('select gender'));
			$data['sexual_prefference'] 	= prepare_dropdown($this->performers_profile->get_enum_values('sexual_prefference'),lang('select sexual prefference'));
			$data['ethnicity'] 				= prepare_dropdown($this->performers_profile->get_enum_values('ethnicity'),			lang('select ethnicity'));
			$data['height'] 				= prepare_dropdown($this->performers_profile->get_enum_values('height'),			lang('select height'));
			$data['weight'] 				= prepare_dropdown($this->performers_profile->get_enum_values('weight'),			lang('select weight'));
			$data['hair_color'] 			= prepare_dropdown($this->performers_profile->get_enum_values('hair_color'),		lang('select hair color'));
			$data['hair_length'] 			= prepare_dropdown($this->performers_profile->get_enum_values('hair_length'),		lang('select hair lenght'));
			$data['eye_color'] 				= prepare_dropdown($this->performers_profile->get_enum_values('eye_color'),			lang('select eye color'));			
			$data['build'] 					= prepare_dropdown($this->performers_profile->get_enum_values('build'),				lang('select build'));
			$data['cup_size']				= prepare_dropdown($this->performers_profile->get_enum_values('cup_size'),			lang('select cup size'),FALSE,TRUE);				

			$this->load->view('template',$data);		
			
		}
		else
		{			
			$this->load->helper('directories');
			$photo = $this->good_avatar[0];
				
			$name  = generate_unique_name('uploads/performers/' . $this->register_user->id . '/', $photo['name']);
			$path  = BASEPATH . '../uploads/performers/' . $this->register_user->id . '/' . $name;
			$spath = BASEPATH . '../uploads/performers/' . $this->register_user->id . '/small/' . $name;
			$mpath = BASEPATH . '../uploads/performers/' . $this->register_user->id . '/medium/' . $name;
			
			///mut pozele in directoarele lor
			rename(BASEPATH . '../'.MY_TEMP_PATH.'/' . $photo['file_on_disk_name'], $path);
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

				$this->session->set_flashdata('msg', array( 'success' => FALSE,  'message' => lang('An error occured')));
				redirect(current_url());
			}
						
			$this->db->trans_begin();
			$this->load->model('performers_photos');
			$this->performers_photos->add($this->register_user->id,$name,lang('Avatar'),0,1);			
			
			//Adauga limbile la un performer
			$languages = $this->input->post('lang');
			foreach ($languages as $language){
				$this->performers->add_performers_languages(
												$this->register_user->id,
												$language
				);
			}
			
			//updatez register stepu
			$this->performers->update($this->register_user->id,array('avatar'=>$name,'register_step'=>6));
									
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

			//nu am reusit sa adaug in db userul
			if($this->db->trans_status() == FALSE){
				
				//fac rollback la date
				$this->db->trans_rollback();
				
				$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('An error occured')));
				//redirectionez pe pagina de unde a venit
				redirect(current_url());
			}
			
			$this->db->trans_commit();			

			//sterg sessiunea de register
			$this->session->unset_userdata('register');
			$this->session->unset_userdata('avatar');
												
			$data['performer'] = $this->input->post('performer');
			
			$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Account created successfully')));				
			redirect('performers');					
					
		}
	}
	
	/**
	 * View performer account
	 * @author Baidoc
	 */
	function account($performer_id = FALSE){		
		if( ! $performer_id){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('invalid performer')));
			redirect('performers');
		}
		
		$performer = $this->performers->get_one_by_id($performer_id);
		
		if( ! $performer){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('invalid performer')));
			redirect('performers');
		}
		
		if( $performer->studio_id !== $this->user->id){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('performer does not belong to your studio')));
			redirect('performers');
		}
		
		$this->load->model('supported_languages');
		$this->load->model('payments');
		$this->load->model('payment_methods');
		$this->load->model('performers_languages');
		$this->load->model('countries');		
		$this->load->model('watchers');		
		$this->load->model('chat_logs');		
		$this->load->model('chart');		
		$this->load->library('charts');		
		$this->load->helper('earnings');		
		$this->load->helper('credits');		
		
		$this->load->library('form_validation');
		
		//set default dates
		$data['interval_time'] = make_interval_time($performer->register_date);
		$intervals = array_keys($data['interval_time']);
		
		$total_sessions_time_interval = $chat_logs_interval = $payments_interval = $sessions_interval =  $intervals[0];
		
		//set type of chat in selected language
		$data['chat_types'] = array(
			'nude' => lang('Nude'),
			'private' => lang('Private'),
			'true_private' => lang('True Private'),
			'peek' => lang('Peek'),
			'photos' => lang('Photos'),
			'premium_video' => lang('Videos'),
		);
		
		
		//PAYMENTS STATISTICS
		
		if($this->input->post('payments_interval') != ''){
			$payments_interval = $this->input->post('payments_interval');
		}
		
		list($start, $stop) = explode('~', $payments_interval, 2);
		
		$data['payments'] = $this->payments->get_multiple_by_performer_id($performer->id, FALSE, FALSE, array('start' => $start, 'stop' => $stop), FALSE);
		
		
		//SESSIONS STATISTICS
		
		if($this->input->post('sessions_interval') != ''){
			$sessions_interval = $this->input->post('sessions_interval');
		}
		
		
		list($start, $stop) = explode('~', $sessions_interval, 2);
		$data['sessions'] = $this->watchers->get_multiple_by_performer_id($performer->id, FALSE, FALSE, array('start' => $start, 'stop' => $stop, 'type'=>array('private', 'nude', 'true_private', 'peek', 'photos', 'premium_video','gift','free','admin_action')), array(), FALSE);
		
		
		//CHAT LOGS STATISTICS
		
		if($this->input->post('chat_logs_interval') != ''){
			$chat_logs_interval = $this->input->post('chat_logs_interval');
		}
		
		list($start, $stop) = explode('~', $chat_logs_interval, 2);
		$data['chat_logs'] = $this->chat_logs->get_multiple_by_performer_id($performer->id, FALSE, FALSE, array('start' => $start, 'stop' => $stop, 'type'=>array('private', 'nude', 'true_private', 'peek', 'photos', 'premium_video','gift','free','admin_action')), array(), FALSE);;
		
		
		// TOTAL SESSIONS TIME STATISTICS
		
		if($this->input->post('total_sessions_time_interval') != ''){
			$total_sessions_time_interval = $this->input->post('total_sessions_time_interval');
		}
		list($start, $stop) = explode('~', $chat_logs_interval, 2);
		$data['chart_watchers'] = $this->charts->get_chart_data('watchers', strtotime($start), strtotime($stop), $performer->id);
		$data['chart_earnings'] = $this->charts->get_chart_data('earnings', strtotime($start), strtotime($stop), $performer->id);
		$data['chart_totals'] = $this->charts->get_chart_data('totals', strtotime($start), strtotime($stop), $performer->id);
		
		
		//SET DATA TO AUTOCOMPLATE TIME INTERVAL DROPDOWNS
		$data['payments_interval'] = $payments_interval;
		$data['sessions_interval'] = $sessions_interval;
		$data['chat_logs_interval'] = $chat_logs_interval;
		$data['total_sessions_time_interval'] = $total_sessions_time_interval;
		
		
		$this->form_validation->set_rules('firstname', 	lang('first name'), 'trim|required|min_length[3]|max_length[30]|strip_tags|purify');
		$this->form_validation->set_rules('lastname', 	lang('last name'), 	'trim|required|min_length[3]|max_length[30]|strip_tags|purify');
		$this->form_validation->set_rules('phone', 		lang('phone'), 		'trim|required|min_length[8]|max_length[15]|strip_tags|purify');
		$this->form_validation->set_rules('address', 	lang('address'), 	'trim|required|min_length[3]|max_length[80]|strip_tags|purify');
		$this->form_validation->set_rules('city', 		lang('city'), 		'trim|required|min_length[2]|max_length[40]|strip_tags|purify');
		$this->form_validation->set_rules('zip', 		lang('zip'), 		'trim|required|min_length[2]|max_length[40]|strip_tags|purify');
		$this->form_validation->set_rules('state', 		lang('state'), 		'trim|required|min_length[2]|max_length[40]|strip_tags|purify');
		$this->form_validation->set_rules('country', 	lang('country'), 	'trim|required|valid_country');
		$this->form_validation->set_rules('languages', 	lang('languages'), 	'required|check_language');
				
		$countries = $this->countries->get_all();

		if(is_array($countries)){
			foreach($countries as $country){
				$data['countries'][$country->code] = $country->name;
			}
		}
		
		$data['performers_languages']	= extract_values_by_property($this->performers_languages->get_multiple_by_performer_id($performer->id), 'language_code');
		if($this->form_validation->run() === FALSE){
			$data['languages']				= $this->supported_languages->get_supported_languages();			

			$data['performer']				= $performer;
			$data['page']					= 'performers/account';
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= $performer->nickname.'\'s '.lang('account').' - '.SETTINGS_SITE_TITLE;	
			$this->load->view('template', $data);				
		}
		else
		{
			
			
			$performer_update = array(
								'first_name'		=> $this->input->post('firstname'),
								'last_name'			=> $this->input->post('lastname'),
								'phone'				=> $this->input->post('phone'),
								'address'			=> $this->input->post('address'),
								'city'				=> $this->input->post('city'),
								'zip'				=> $this->input->post('zip'),
								'state'				=> $this->input->post('state'),
								'country'			=> $this->input->post('country'),
							);
			
			if($this->input->post('password') != ''){
				$salt = $this->config->item('salt');
				$performer_update['password'] = hash('sha256', $salt . $performer->hash . $this->input->post('password'));
			}
			
			
			//ma asigur ca actiunea nu are loc doar daca toate queryurile au avut loc, folosest tranzactii
			$this->db->trans_begin();
			
			//construiesc arrayurile de regiuni ce trebuie adugate/sterse
			$add_languages 		= array_diff($this->input->post('languages'),$data['performers_languages']);
			$remove_languages	= array_diff($data['performers_languages'],$this->input->post('languages'));

			
			if(sizeof($add_languages) > 0 ){
				foreach($add_languages as $language) $this->performers_languages->add($performer->id,$language);
			}
			if(sizeof($remove_languages) > 0){
				foreach($remove_languages as $language) $this->performers_languages->remove($performer->id,$language);
			}
			
			$this->performers->update($performer->id, $performer_update);
			
			if($this->db->trans_status() == FALSE){
    			$this->db->trans_rollback();

				$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('database error. please try again later')));				
				redirect(current_url());					
    			
			}

			$this->db->trans_commit();
			$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('personal details saved')));
			$this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'performer', 
            			$performer->id, 
            			'edit_account', 
            			'Studio has edited a performer\'s account.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
			redirect(current_url());					
			
		}
		
			
		
	}

	/**
	 * Editeaza performer
	 * @param $performer_id
	 * @return unknown_type
	 */
	function edit($performer_id = FALSE){
		if( ! $performer_id){		
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('invalid performer')));
			redirect('performers');			
		}
		
		$performer = $this->performers->get_one_by_id($performer_id);
		
		if( ! $performer){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('invalid performer')));
			redirect('performers');						
		}
		
		if( $performer->studio_id !== $this->user->id){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('performer does not belong to your studio')));
			redirect('performers');			
		}		
		
		$this->session->set_userdata('performer_id',$performer->id);
		redirect('performer/'.$performer->id);
	}	
	
	
	/**
	 * Listeaza platile performerului
	 * @param unknown_type $performer_id
	 * @author Baidoc
	 */
	function earnings($performer_id = FALSE){
		if( ! $performer_id){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('invalid performer')));
			redirect('performers');
		}
		
		$performer = $this->performers->get_one_by_id($performer_id);
		
		if( ! $performer){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('invalid performer')));
			redirect('performers');
		}
		
		if( $performer->studio_id !== $this->user->id){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('performer does not belong to your studio')));
			redirect('performers');
		}
		
		$this->session->set_userdata('performer_id',$performer->id);
		redirect('performer/my_earnings');		
	}
	
	/**
	 * Spioneaza o sesiune de chat
	 * @param $performer_id
	 */
	function spy($performer_id = FALSE){
		if( ! $performer_id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('invalid performer')));
			redirect('performers');
		}
		
		$performer = $this->performers->get_one_by_id($performer_id);
		
		if( ! $performer){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('invalid performer')));
			redirect('performers');						
		}
		
		if( $performer->studio_id !== $this->user->id){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('performer does not belong to your studio')));
			redirect('performers');			
		}	

		if( ! $performer->is_online ){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('performer is currently offline')));
			redirect('performers');						
		}
		
		$this->load->model('fms');
		$fms = $this->fms->get_one_by_id($performer->fms_id);
		if ( ! $fms ){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('performer is currently offline')));
			redirect('performers');				
		}
		
		
		$this->load->model('watchers');
		$params['uniqId']		= $this->watchers->generate_one_unique_id();
				
		$params['pasword']		= $this->user->password;
		$params['userId']		= 's' . $this->user->id;
		$params['userName']		= $this->user->username;
		
		$params['rtmp']					= $fms->fms;
		$params['performerId']			= $performer->id;
		$params['sessionType']			= 'spy';
		$params['performerNick']		= $performer->nickname;		
		$params['performerNickColor']	= '0x129400';
		$params['nickColor']			= '0x129400';
		$params['sitePath']				= site_url();
		$params['redirectLink']			= site_url();

		$data['params']		= $params;
		$data['width']		= 940;
		$data['height']		= 560;
		$data['swf']		= 'spy.swf';
		
		$data['allow_fullscreen']	 = TRUE;
		
		$this->output->set_header("HTTP/1.1 200 OK");
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
		 
		$this->load->view('performers/spy',$data);
	}	
	
	##################################################################################################
	################################### PERFORMER DOCUMENTs ##########################################
	##################################################################################################
	
	/*
	* Adauga un photo id
	*/
	function add_photo_id($performer_id = FALSE){
		
		$this->im_in_modal = TRUE;
		$this->load->model('performers_photo_ids');
		
		$approved_photo_ids = $this->performers_photo_ids->get_multiple_by_performer_id($performer_id,array('status'=>'approved'),TRUE);
		if( $approved_photo_ids ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Performer already have an approved photo ID')));
			redirect('performers');
		}
	
		$total_photo_ids = $this->performers_photo_ids->get_multiple_by_performer_id($performer_id,FALSE,TRUE);
		if( $total_photo_ids > 9 ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Performer exceeded the maximum allowed photo ID number')));
			redirect('performers');
		}
	
		$this->load->library('form_validation');	
		$this->form_validation->set_rules('photo_id',	lang('photo_id'),		'trim|required|performer_photo_id');
	
		if( $this->form_validation->run() === FALSE ){
			$data['photo_id']		= ($this->session->userdata('photo_id'))?$this->session->userdata('photo_id'):FALSE;	
			$this->load->view('performers/photo_ids/add-modal', $data);
		} else {
				
			$this->load->helper('directories');
				
			foreach( $this->good_photo_ids as $photo_id ){
				$name = generate_unique_name('uploads/performers/' . $performer_id . '/others/',$photo_id['name']);
	
				//move the contract to his place
				@rename(MY_TEMP_PATH.'/' . $photo_id['file_on_disk_name'], 'uploads/performers/' . $performer_id . '/others/' . $name);
				$this->performers_photo_ids->add($name,'pending',$performer_id);
			}
				
			$this->load->model('performers');
			$this->performers->update($performer_id, array('photo_id_status'=>'pending'));
			$this->session->unset_userdata('photo_id');
	
			$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Photo ID added')));
			redirect('performers');
		}
	}

	/**
	* Adauga un contract
	*/
	function add_contract($performer_id = FALSE){
		
		$this->im_in_modal = TRUE;
		$this->load->model('contracts');
		
		$approved_contracts = $this->contracts->get_multiple_by_performer_id($performer_id,array('status'=>'approved'),TRUE);
		if( $approved_contracts ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Performer already have an approved contract')));
			redirect('performer/contracts');
		}
	
		$total_contracts = $this->contracts->get_multiple_by_performer_id($performer_id,FALSE,TRUE);
		if( $total_contracts > 9 ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Performer exceeded the maximum allowed contract number')));
			redirect('performer/contracts');
		}
	
		$this->load->library('form_validation');
	
		$this->form_validation->set_rules('contract',		lang('contract'),	'trim|required|performer_contract');
	
		if( $this->form_validation->run() === FALSE ){
			$data['contract']				= ($this->session->userdata('contract'))?$this->session->userdata('contract'):FALSE;

			$this->load->view('performers/contracts/add-modal', $data);				
		} else {
				
			$this->load->helper('directories');
			$this->load->model('contracts');
			foreach( $this->good_contracts as $contract ){
				$name = generate_unique_name('uploads/performers/' . $performer_id . '/others/',$contract['name']);
	
				//move the contract to his place
				@rename(MY_TEMP_PATH.'/' . $contract['file_on_disk_name'],'uploads/performers/' . $performer_id . '/others/' . $name);
				$this->contracts->add($name,'pending',NULL,$performer_id);
			}
				
			$this->load->model('performers');
			$this->performers->update($performer_id, array('contract_status'=>'pending'));
			$this->session->unset_userdata('contract');
				
			$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Contract added')));
			redirect('performers');
		}
	}	
}
