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
 */
Class Settings_controller extends MY_Studio_Edit{
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
			
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Incarca personal details
	 */
	function index(){
		$this->personal_details();
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Edit personal details
	 * @return unknown_type
	 */
	function personal_details(){
		$this->load->model('supported_languages');
		$this->load->model('performers_languages');		
		$this->load->model('countries');		
		$this->load->library('form_validation');
				
		$countries = $this->countries->get_all();
		if(is_array($countries)){
			foreach($countries as $country){
				$data['countries'][$country->code] = $country->name;
			}
		}
		
		$this->form_validation->set_rules('firstname', 	lang('first name'), 'trim|required|min_length[3]|max_length[30]|strip_tags|purify');
		$this->form_validation->set_rules('lastname', 	lang('last name'), 	'trim|required|min_length[3]|max_length[30]|strip_tags|purify');
		$this->form_validation->set_rules('phone', 		lang('phone'), 		'trim|required|min_length[8]|max_length[15]|strip_tags|purify');
		$this->form_validation->set_rules('address', 	lang('address'), 	'trim|required|min_length[3]|max_length[80]|strip_tags|purify');
		$this->form_validation->set_rules('city', 		lang('city'), 		'trim|required|min_length[2]|max_length[40]|strip_tags|purify');
		$this->form_validation->set_rules('zip', 		lang('zip'), 		'trim|required|min_length[2]|max_length[40]|strip_tags|purify');
		$this->form_validation->set_rules('state', 		lang('state'), 		'trim|required|min_length[2]|max_length[40]|strip_tags|purify');
		$this->form_validation->set_rules('country', 	lang('country'), 	'trim|required|valid_country');
		$this->form_validation->set_rules('languages', 	lang('languages'), 	'required|check_language');

		
		$data['performers_languages']	= extract_values_by_property($this->performers_languages->get_multiple_by_performer_id($this->performer->id), 'language_code');
		
		if($this->form_validation->run() === FALSE){
			$data['languages']				= $this->supported_languages->get_supported_languages();			
			
			$data['_sidebar']				= TRUE;
			$data['_performer_menu']		= TRUE;
			$data['page'] 					= 'performers/personal_details';
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= $this->performer->nickname.'\s '.lang('presonal details').' '.SETTINGS_SITE_TITLE;
			$data['performer']				= $this->performer;
			
			$this->load->view('template', $data);				
		}
		else
		{
			//ma asigur ca actiunea nu are loc doar daca toate queryurile au avut loc, folosest tranzactii
			$this->db->trans_begin();
			
			//construiesc arrayurile de regiuni ce trebuie adugate/sterse
			$add_languages 		= array_diff($this->input->post('languages'),$data['performers_languages']);
			$remove_languages	= array_diff($data['performers_languages'],$this->input->post('languages'));

			
			if(sizeof($add_languages) > 0 ){
				foreach($add_languages as $language) $this->performers_languages->add($this->performer->id,$language);
			}
			if(sizeof($remove_languages) > 0){
				foreach($remove_languages as $language) $this->performers_languages->remove($this->performer->id,$language);
			}
			
			$this->performers->update(
							$this->performer->id,
							array(
								'first_name'		=> $this->input->post('firstname'),
								'last_name'			=> $this->input->post('lastname'),
								'phone'				=> $this->input->post('phone'),
								'address'			=> $this->input->post('address'),
								'city'				=> $this->input->post('city'),
								'zip'				=> $this->input->post('zip'),
								'state'				=> $this->input->post('state'),
								'country'			=> $this->input->post('country'),
							)
			);
			
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
            			$this->performer->id, 
            			'edit_account', 
            			'Studio has edited a performer\'s account.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
			redirect(current_url());					
			
		}
		
		
	}

	// -----------------------------------------------------------------------------------------		
	/**
	 * Editeaza profil
	 * @return unknown_type
	 */
	function profile(){
		$this->load->library('form_validation');
		$this->load->model('performers_profile');
		
		$this->form_validation->set_rules('description', 		lang('description'), 		'trim|required|min_length[3]|max_length[255]|strip_tags|purify');
		$this->form_validation->set_rules('what_turns_me_on', 	lang('turn on'), 			'trim|required|min_length[3]|max_length[255]|strip_tags|purify');
		$this->form_validation->set_rules('what_turns_me_off', 	lang('turn off'), 			'trim|required|min_length[3]|max_length[255]|strip_tags|purify');
		$this->form_validation->set_rules('day', 				lang('day'), 		 		'trim|required|strip_tags|numeric|max_length[2]');
		$this->form_validation->set_rules('month', 				lang('month'), 				'trim|required|strip_tags|numeric|max_length[2]');
		$this->form_validation->set_rules('year', 				lang('year'), 				'trim|required|strip_tags|numeric|max_length[4]|birthday');		
		$this->form_validation->set_rules('gender', 			lang('gender'), 			'required|valid_enum_value[gender]');
		$this->form_validation->set_rules('ethnicity', 			lang('ethnicity'), 			'required|valid_enum_value[ethnicity]');
		$this->form_validation->set_rules('sexual_prefference', lang('sexual preference'), 	'required|valid_enum_value[sexual_prefference]');
		$this->form_validation->set_rules('height', 			lang('height'), 			'required|valid_enum_value[height]');
		$this->form_validation->set_rules('weight', 			lang('weight'), 			'required|valid_enum_value[weight]');
		$this->form_validation->set_rules('hair_color', 		lang('hair color'), 		'required|valid_enum_value[hair_color]');
		$this->form_validation->set_rules('hair_length', 		lang('hair length'), 		'required|valid_enum_value[hair_length]');
		$this->form_validation->set_rules('eye_color', 			lang('eye color'), 			'required|valid_enum_value[eye_color]');
		$this->form_validation->set_rules('cup_size', 			lang('cup_size'),			'required|valid_enum_value[cup_size]');
		$this->form_validation->set_rules('build', 				lang('build'), 				'required|valid_enum_value[build]');
		
		if($this->form_validation->run() === FALSE){
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
			
			$data['days']					= $zi;
			$data['months']					= $luna;
			$data['years']					= $an;
			$data['gender'] 				= prepare_dropdown($this->performers_profile->get_enum_values('gender'));
			$data['ethnicity'] 				= prepare_dropdown($this->performers_profile->get_enum_values('ethnicity'));
			$data['sexual_prefference'] 	= prepare_dropdown($this->performers_profile->get_enum_values('sexual_prefference'));			
			$data['height'] 				= prepare_dropdown($this->performers_profile->get_enum_values('height'));
			$data['weight'] 				= prepare_dropdown($this->performers_profile->get_enum_values('weight'));
			$data['hair_color'] 			= prepare_dropdown($this->performers_profile->get_enum_values('hair_color'));
			$data['hair_length'] 			= prepare_dropdown($this->performers_profile->get_enum_values('hair_length'));
			$data['eye_color'] 				= prepare_dropdown($this->performers_profile->get_enum_values('eye_color'));
			$data['cup_size']				= prepare_dropdown($this->performers_profile->get_enum_values('cup_size'));				
			$data['build'] 					= prepare_dropdown($this->performers_profile->get_enum_values('build'));
			
			$data['_sidebar']		= TRUE;
			$data['_performer_menu']= TRUE;
			$data['page'] 			= 'performers/profile';
			$data['description'] 	= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 		= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 		= $this->performer->nickname.'\s '.lang('profile').' - '.SETTINGS_SITE_TITLE;
			$data['performer']		= $this->performers_profile->get_one_by_id($this->performer->id);
			
			$this->load->view('template', $data);
			
		}
		else 
		{
			
			
			//Adauga profilul la un performer
			$birthday = mktime(0, 0, 0, $this->input->post('month'), $this->input->post('day'), $this->input->post('year'));
			if(! $this->performers_profile->update(
											$this->performer->id,
											array(
												'birthday'				=> $birthday,
												'gender'				=> $this->input->post('gender'),
												'description'			=> $this->input->post('description'),
												'what_turns_me_on'		=> $this->input->post('what_turns_me_on'),
												'what_turns_me_off'		=> $this->input->post('what_turns_me_off'),
												'sexual_prefference'	=> $this->input->post('sexual_prefference'),
												'ethnicity'				=> $this->input->post('ethnicity'),
												'height'				=> $this->input->post('height'),
												'weight'				=> $this->input->post('weight'),
												'hair_color'			=> $this->input->post('hair_color'),
												'hair_length'			=> $this->input->post('hair_length'),
												'eye_color'				=> $this->input->post('eye_color'),
												'cup_size'				=> $this->input->post('cup_size'),				
												'build'					=> $this->input->post('build')
											)
									)
			){
				$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=>lang('database error. please try again later')));				
				redirect(current_url());					
			}
			else
			{
				$this->session->set_flashdata('msg', array('success'=>TRUE,'message'=>lang('profile details saved')));
				$this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'performer', 
            			$this->performer->id, 
            			'edit_profile', 
            			'Studio has edited a performer\'s profile.', 
            			time(), 
            			ip2long($this->input->ip_address())
				);
				redirect(current_url());									
			}
							
		}	
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Editeaza preturile pentru chat
	 * @return unknown_type
	 */
	function pricing(){
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('true_private_chips_price',	lang('true private chips price'), 	'trim|required|valid_price[true_private]');
		$this->form_validation->set_rules('private_chips_price',		lang('private chips price'), 		'trim|required|valid_price[private]');
		$this->form_validation->set_rules('nude_chips_price',			lang('nude chips price'), 			'trim|required|valid_price[nude]');
		$this->form_validation->set_rules('peek_chips_price',			lang('peek chips price'), 			'trim|required|valid_price[peek]');
		$this->form_validation->set_rules('paid_photo_gallery_price',	lang('paid photo gallery price'),	'trim|required|valid_price[photos]');		;
		
		if($this->form_validation->run() === FALSE){
			
			
			$data['_sidebar']				= TRUE;
			$data['_performer_menu']		= TRUE;
			$data['page'] 					= 'performers/pricing';
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= $this->performer->nickname.'\s '.lang('pricing').' - '.SETTINGS_SITE_TITLE;
			$data['performer']				= $this->performer;
			
			$data['true_private_chips_price']	= $this->performer->true_private_chips_price;
			$data['private_chips_price']		= $this->performer->private_chips_price;
			$data['nude_chips_price']			= $this->performer->nude_chips_price;
			$data['peek_chips_price']			= $this->performer->peek_chips_price;
			$data['paid_photo_gallery_price'] 	= $this->performer->paid_photo_gallery_price;	
			
			$this->load->view('template', $data);	
		}
		else
		{				
			//daca nu poate face update in abza de date
			if( ! $this->performers->update(
					$this->performer->id,
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
				$this->session->set_flashdata('msg', array('success'=>TRUE,'message'=>lang('pricings saved')));
				$this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'performer', 
            			$this->performer->id, 
            			'edit_account', 
            			'Studio has edited a performer\'s pricing.', 
            			time(), 
            			ip2long($this->input->ip_address())
				);
				redirect(current_url());				
			}	
		}
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Schimba parola
	 * @return unknown_type
	 */
	function password(){
		$this->load->library('form_validation'); 
		
		$this->form_validation->set_rules('new_password', 		lang('new password'), 		'trim|required|min_length[3]');
		$this->form_validation->set_rules('confirm_password', 	lang('confirm password'),   'trim|required|min_length[5]|matches[new_password]');
		
		if($this->form_validation->run() === FALSE){
			$data['_sidebar']				= TRUE;
			$data['_performer_menu']		= TRUE;
			$data['page'] 					= 'performers/password';
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= $this->performer->nickname.'\s '.lang('change password').' - '.SETTINGS_SITE_TITLE;

			$this->load->view('template', $data);	
		}
		else
		{
			$salt = $this->config->item('salt');
			if( ! $this->performers->update(
					$this->performer->id,											
					array('password'=>hash('sha256', ($salt . $this->performer->hash . $this->input->post('new_password') ) ))
				)
			){
				$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=> lang('database error. please try again later')));
				redirect(current_url());					
			}
			else 
			{
				$this->session->set_flashdata('msg', array('success'=>TRUE,'message' => lang('password changed successfully')));
				$this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'performer', 
            			$this->performer->id, 
            			'change_password', 
            			'Studio has changed a performer\'s password.', 
            			time(), 
            			ip2long($this->input->ip_address())
				);
				redirect(current_url());					
			}			
		}
	}
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Editeaza zonele banate
	 * @return unknown_type
	 */
	function banned_zones(){
		
		$this->load->library('form_validation');
		
		$this->load->model('banned_countries');
		$this->load->model('banned_states');
		
		$this->load->config('regions');
		
		$this->form_validation->set_rules('countries[]',lang('countries'),	'valid_country');
		$this->form_validation->set_rules('states[]',	lang('states'),		'valid_state');
		
		$this->load->config('regions');
		$data['countries']			= $this->config->item('countries');
		$data['states']				= $this->config->item('states');
		$data['banned_countries']	= extract_values_by_property($this->banned_countries->get_multiple_by_performer_id($this->performer->id),'country_code');
		$data['banned_states'] 		= extract_values_by_property($this->banned_states->get_multiple_by_performer_id($this->performer->id),'state_code');
		
		if($this->form_validation->run() === FALSE){
			
			$data['_sidebar']				= TRUE;
			$data['_performer_menu']		= TRUE;
			$data['page'] 					= 'performers/banned_zones';
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= $this->performer->nickname.'\s '.lang('banned zones').' - '.SETTINGS_SITE_TITLE;

			$this->load->view('template', $data);	
		}
		else
		{
			if(! $this->input->post('countries')) $_POST['countries'] = array();
			if(! $this->input->post('states')) $_POST['states'] = array();
			
			//construiesc arrayurile de regiuni ce trebuie adugate/sterse
			$add_countries 		= array_diff($this->input->post('countries'),$data['banned_countries']);
			$remove_countries 	= array_diff($data['banned_countries'],$this->input->post('countries'));			

			$add_states			= array_diff($this->input->post('states'),$data['banned_states']);
			$remove_states		= array_diff($data['banned_states'],$this->input->post('states'));
			
			//ma asigur ca actiunea nu are loc doar daca toate queryurile au avut loc, folosest tranzactii
			$this->db->trans_begin();

			if(sizeof($add_countries) > 0){
				foreach($add_countries as $country) $this->banned_countries->add($this->performer->id,$country); 	
			}
						
			if(sizeof($add_states) > 0){
				foreach($add_states as $state) $this->banned_states->add($this->performer->id,$state);				
			}
			
			if(sizeof($remove_countries) > 0){
				foreach($remove_countries as $country) $this->banned_countries->remove($this->performer->id,$country);				
			}
			
			if(sizeof($remove_states) > 0){
				foreach($remove_states as $state) $this->banned_states->remove($this->performer->id,$state);								
			}
			
			if($this->db->trans_status() == FALSE){
				
				 $this->db->trans_rollback();
				//a aparut o eroare 
				$this->session->set_flashdata('msg', array('success' => FALSE, 'message' => lang('database error. please try again later')));
				redirect(current_url());			
			}

			$this->db->trans_commit();
			$this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'performer', 
            			$this->performer->id, 
            			'edit_account', 
            			'Studio has edited a performer\'s banned zones.', 
            			time(), 
            			ip2long($this->input->ip_address())
				);
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('changes done successfully')));
			redirect(current_url());						
		}						
	}


	// -----------------------------------------------------------------------------------------		
	/**
	 * Editeaza categoriile
	 * @return unknown_type
	 */
	function categories(){
		$this->load->model('categories');
		$this->load->model('performers_categories');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('categories[]',lang('category'), 'required|valid_item[Categories.id]');

		$data['performer_categories'] 	= extract_values_by_property($this->performers_categories->get_multiple_by_performer_id($this->performer->id),'category_id');
		
		if($this->form_validation->run() === FALSE){
			$data['categories'] 			= $this->categories->get_all_categories();

			$data['_sidebar']				= TRUE;
			$data['_performer_menu']		= TRUE;
			$data['page'] 					= 'performers/categories';
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= $this->performer->nickname.'\s '.lang('categories').' - '.SETTINGS_SITE_TITLE;
			
			
			$this->load->view('template', $data);
		} else {
			
			//ma asigur ca actiunea nu are loc doar daca toate queryurile au avut loc, folosest tranzactii
			$this->db->trans_begin();
			
			//construiesc arrayurile de regiuni ce trebuie adugate/sterse
			$add_categories 		= array_diff($this->input->post('categories'),$data['performer_categories']);
			$remove_categories		= array_diff($data['performer_categories'],$this->input->post('categories'));
	
			if(sizeof($add_categories) > 0 ){
				foreach($add_categories as $category) $this->performers_categories->add($this->performer->id,$category);
			}
			if(sizeof($remove_categories) > 0){
				foreach($remove_categories as $category) $this->performers_categories->remove($this->performer->id,$category);
			}
						
			if($this->db->trans_status() == FALSE){
    			$this->db->trans_rollback();

				$this->session->set_flashdata('msg',array('success' => FALSE, 'message' => lang('database error. please try again later')));
				redirect(current_url());					
    			
			}
			
			$this->db->trans_commit();
			$this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'performer', 
            			$this->performer->id, 
            			'edit_account', 
            			'Studio has edited a performer\'s categories.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
			$this->session->set_flashdata('msg',array('success' => TRUE, 'message' => lang('categories saved')));
			redirect(current_url());	
		}
	
	}

    /**
     * Oralul performerilor.
     * @author Bogdan
     * @return none
     */
    function schedule() {
		
		$this->load->model('performers_schedules');
		$this->load->helper('schedule');
		
        $data['_sidebar']        	= TRUE;
        $data['_performer_menu'] 	= TRUE;
        $data['page']            	= 'performers/schedule';
        $data['description']     	= SETTINGS_SITE_DESCRIPTION;
        $data['keywords']        	= SETTINGS_SITE_KEYWORDS;
        $data['pageTitle']       	= $this->performer->nickname.'\s '.lang('schedule').' - '.SETTINGS_SITE_TITLE;
		$data['schedule'] 			= render_schedule($this->performers_schedules->get($this->performer->id));
	
        $this->load->view('template', $data);
    }

    /**
     * Functie pt updatarea orarului prin ajax.
     * @author Bogdan
     * @return none
     */
    function update_schedule() {
        if (!$this->input->post()) {
            die('FAIL');
        }
        $performer_id = $this->performer->id;
        $action       = $this->input->post('action');
        $day_of_week  = $this->input->post('day_of_week');
        $hour         = $this->input->post('hour');
        $response     = 'SUCCESS';
        if ($hour > 24 || $hour < 0 || $day_of_week > 7 || $day_of_week < 0) 
            die('FAIL');
        $this->load->model('performers_schedules');
        $this->db->trans_begin();
        if ($action === 'add') {
            $this->performers_schedules->add_hour($performer_id, $day_of_week, $hour);
        } elseif ($action === 'delete') {
            $this->performers_schedules->delete_hour($performer_id, $day_of_week, $hour);
        }
        if (!$this->db->trans_status()) {
            $this->db->trans_rollback();
            $response = 'FAIL';
        }
        $this->db->trans_commit();
        die($response);
    }

}
