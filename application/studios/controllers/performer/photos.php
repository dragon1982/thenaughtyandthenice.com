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
 */

Class Photos_controller extends MY_Studio_Edit{
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->load->helper('performers');		
        $this->load->model('performers_photos');
	}


	// -----------------------------------------------------------------------------------------	
	/**
	 * Listare poze pentru un performer
	 * @return unknown_type
	 */
	function index(){
        $data['_sidebar']        = TRUE;
        $data['_performer_menu'] = TRUE;
        $data['page']            = 'performers/photos/index';
        $data['description']     = SETTINGS_SITE_DESCRIPTION;
        $data['keywords']        = SETTINGS_SITE_KEYWORDS;
        $data['pageTitle']       = $this->performer->nickname.'\'s '.lang('Photos').' - '.SETTINGS_SITE_TITLE;
		
		$photos = $this->performers_photos->get_multiple_by_performer_id($this->performer->id);
		$data['photos']			 = get_performer_photos($photos,FALSE,'is_paid');
		$data['paid_photos']	 = get_performer_photos($photos,TRUE,'is_paid');
        $this->load->view('template', $data);
        
	}
		
    /**
     * Adauga poza performer.
     * @return none
     */
    function add() {
        $this->load->library('form_validation');

		$this->form_validation->set_rules('title',          lang('title'),          'trim|max_length[30]|strip_tags|purify');
        $this->form_validation->set_rules('photo',          lang('photo'),          'trim|required|performer_photo');
 		$this->form_validation->set_rules('is_paid',		lang('gallery'),		'trim|required');
 		
        if (!$this->form_validation->run()) {
            $data['_sidebar']        = TRUE;
            $data['_performer_menu'] = TRUE;
            $data['page']            = 'performers/photos/add';
            $data['description']     = SETTINGS_SITE_DESCRIPTION;
            $data['keywords']        = SETTINGS_SITE_KEYWORDS;
            $data['pageTitle']       = $this->performer->nickname.'\'s '.lang('Add Photo').' - '.SETTINGS_SITE_TITLE;
                    
			$data['is_paid']		 = array(0=>lang('Free gallery'),1=>lang('Paid gallery'));    
			        
            $data['photos']          = ($this->session->userdata('photos')) ? $this->session->userdata('photos') : FALSE;
            $this->load->view('template', $data);
        } else {
        	if($this->input->post('is_paid') == 1){
        		$this->add_paid();
        	}
        	$this->add_free();
        }
    }

  	/**
     * Adauga o poza free
     * @return unknown_type
     */
    private function add_free(){
		//iau poza adaugata
		$photo = $this->good_photos[0];
		
		$this->load->helper('directories');
	
		$name  = generate_unique_name('uploads/performers/' . $this->performer->id . '/', $photo['name']);
		$path  = 'uploads/performers/' . $this->performer->id . '/' . $name;
		$spath = 'uploads/performers/' . $this->performer->id . '/small/' . $name;
		$mpath = 'uploads/performers/' . $this->performer->id . '/medium/' . $name;
			
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
			$this->load->library('user_agent');
			$this->session->set_flashdata('msg', array( 'success' => FALSE,  'message' => lang('An error occured')));
			redirect($this->agent->referrer());
		}
			            
		$this->db->trans_begin();            
		$this->performers_photos->add($this->performer->id, $name, $this->input->post('title'));
	
		if ($this->db->trans_status() == FALSE) {
			
			$this->db->trans_rollback();
			
			$this->load->library('user_agent');
	        $this->session->set_flashdata('msg', array( 'success' => FALSE,  'message' => lang('An error occured')));
			redirect($this->agent->referrer());
		}
	
		$this->db->trans_commit();
		$this->system_log->add(
	            	'studio', 
	            	$this->performer->id,
	            	'performer', 
	            	$this->user->id, 
	            	'add_photo', 
	            	'Performer uploaded photo', 
	            	time(), 
	            	ip2long($this->input->ip_address())
		);		
		$this->session->unset_userdata('photos');
		$this->session->set_flashdata('msg', array( 'success' => TRUE,  'message' => lang('Photo added!')));		
		redirect('performer/photos');          	
    }
    
    /**
     * Adauga o poza paid
     * @return unknown_type
     */
    private function add_paid(){
		//iau poza adaugata
		$photo = $this->good_photos[0];
		
		$this->load->helper('directories');
	
		$name  = generate_unique_name('uploads/performers/' . $this->performer->id . '/paid/', $photo['name']);
		$path  = 'uploads/performers/' . $this->performer->id . '/paid/' . $name;
		$spath = 'uploads/performers/' . $this->performer->id . '/paid/small/' . $name;
			
		///mut pozele in directoarele lor
		rename(BASEPATH . '../'.MY_TEMP_PATH.'/' . $photo['file_on_disk_name'], $path);
		copy($path, $spath);
			            
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
			'source_image'   => $path,
			'create_thumb'   => FALSE,
			'maintain_ratio' => TRUE,
			'width'          => 800,
			'height'         => 600 
		));
		$this->image_lib->resize();            
			
		if( ! file_exists($spath) || ! file_exists($path) ){
			@unlink($spath);
			@unlink($path);
			$this->load->library('user_agent');
			$this->session->set_flashdata('msg', array( 'success' => FALSE,  'message' => lang('An error occured')));
			redirect($this->agent->referrer());
		}
			            
		$this->db->trans_begin();            
		$this->performers_photos->add($this->performer->id, $name, $this->input->post('title'),1);
	
		if ($this->db->trans_status() == FALSE) {
			
			$this->db->trans_rollback();
			
			$this->load->library('user_agent');
	        $this->session->set_flashdata('msg', array( 'success' => FALSE,  'message' => lang('An error occured')));
			redirect($this->agent->referrer());
		}
	
		$this->db->trans_commit();
		$this->system_log->add(
	            	'studio', 
	            	$this->performer->id,
	            	'performer', 
	            	$this->user->id, 
	            	'add_photo', 
	            	'Performer uploaded a paid photo ', 
	            	time(), 
	            	ip2long($this->input->ip_address())
		);		
		$this->session->unset_userdata('photos');
		$this->session->set_flashdata('msg', array( 'success' => TRUE,  'message' => lang('Photo added!')));		
		redirect('performer/photos');            	    	
    }
    
    /**
     * Editeaza poza performer.
     * @param photo_id
     * @return none
     */
    function edit( $photo_id = FALSE ){
        if ( ! $photo_id) {
            $this->session->set_flashdata('msg', array( 'success' => FALSE, 'message' => lang('Invalid photo ID')));
            redirect('performer/photos');
        }

        $photo = $this->performers_photos->get_one_by_id($photo_id);
        if ( ! $photo) {
            $this->session->set_flashdata('msg', array( 'success' => FALSE,'message' => lang('Invalid photo')));
            redirect('performer/photos');
        }

        if ($photo->performer_id !== $this->performer->id) {
            $this->session->set_flashdata('msg', array( 'success' => FALSE, 'message' => lang('You are trying to edit a photo that does not belong to you.')));
            redirect('performer/photos');
        }

        $this->load->library('form_validation');
		$this->form_validation->set_rules('title', 		lang('title'), 		'trim|max_length[30]|strip_tags|purify');
        $this->form_validation->set_rules('is_paid',	lang('gallery'),	'trim|required|valid_photo_type');		
		
        if (!$this->form_validation->run()) {
            $data['_sidebar']        = TRUE;
            $data['_performer_menu'] = TRUE;
            $data['page']            = 'performers/photos/edit';
            $data['description']     = SETTINGS_SITE_DESCRIPTION;
            $data['keywords']        = SETTINGS_SITE_KEYWORDS;
            $data['pageTitle']       = $this->performer->nickname.'\'s '.lang('Edit Photo').' - '.SETTINGS_SITE_TITLE;
            $data['photo']           = $photo;
            $data['is_paid']		 = array(0=>lang('Free gallery'),1=>lang('Paid gallery'));            
            
            $this->load->view('template', $data);
        } else {
             //sia modificat tipu de poza din free in paid sau invers
            if($this->input->post('is_paid') != $photo->is_paid){
            	
            	if( $photo->main_photo ){
            		$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('You cannot change the type of your main photo')));
            		redirect(current_url());         		
            	}
            	
            	//e paid acum
            	if( $this->input->post('is_paid') ){
            		
            		@unlink('uploads/performers/' . $photo->performer_id . '/medium/' . $photo->name_on_disk);
            		@rename('uploads/performers/' . $photo->performer_id . '/small/' . $photo->name_on_disk, 'uploads/performers/' . $photo->performer_id . '/paid/small/' . $photo->name_on_disk);
            		@rename('uploads/performers/' . $photo->performer_id . '/' . $photo->name_on_disk, 'uploads/performers/' . $photo->performer_id . '/paid/' . $photo->name_on_disk);
            		
            		//verific daca am reusit sa mut fisierele, daca nu sterg poza
            		if( ! file_exists('uploads/performers/' . $photo->performer_id . '/paid/small/' . $photo->name_on_disk) || ! file_exists('uploads/performers/' . $photo->performer_id . '/paid/' . $photo->name_on_disk) ){
            			
            			@unlink('uploads/performers/' . $photo->performer_id . '/paid/' . $photo->name_on_disk);
            			@unlink('uploads/performers/' . $photo->performer_id . '/paid/small/' . $photo->name_on_disk);
            			@unlink('uploads/performers/' . $photo->performer_id . '/small/' . $photo->name_on_disk);
            			@unlink('uploads/performers/' . $photo->performer_id . '/medium/' . $photo->name_on_disk);
            			@unlink('uploads/performers/' . $photo->performer_id . '/medium/' . $photo->name_on_disk);
            			            			
            			$this->performers_photos->delete_photo_by_id($photo->id);
            			
            			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('An error occured, the photo has been deleted')));
            			redirect('performer/photos');
            		}
            	} else {
            		
            		@rename('uploads/performers/' . $photo->performer_id . '/paid/small/' . $photo->name_on_disk,'uploads/performers/' . $photo->performer_id . '/small/' . $photo->name_on_disk);
            		@rename('uploads/performers/' . $photo->performer_id . '/paid/' . $photo->name_on_disk,'uploads/performers/' . $photo->performer_id . '/' . $photo->name_on_disk);
            		@copy('uploads/performers/' . $photo->performer_id . '/' . $photo->name_on_disk, 'uploads/performers/' . $photo->performer_id . '/medium/' . $photo->name_on_disk);

            		//nu exista poza medie
            		if ( ! file_exists('uploads/performers/' . $photo->performer_id . '/medium/' . $photo->name_on_disk) ){
            			@unlink('uploads/performers/' . $photo->performer_id . '/paid/' . $photo->name_on_disk);
            			@unlink('uploads/performers/' . $photo->performer_id . '/paid/small/' . $photo->name_on_disk);
            			@unlink('uploads/performers/' . $photo->performer_id . '/small/' . $photo->name_on_disk);
            			@unlink('uploads/performers/' . $photo->performer_id . '/medium/' . $photo->name_on_disk);
            			@unlink('uploads/performers/' . $photo->performer_id . '/' . $photo->name_on_disk);
            			
            			$this->performers_photos->delete_photo_by_id($photo->photo_id);
            			 
            			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('An error occured, the photo has been deleted')));
            			redirect('performer/photos');				            			            			
            		}
            		
            		# Resize profile pic
            		$this->image_lib->clear();
            		$this->image_lib->initialize(array(
            					'image_library'  => 'gd2',
            					'source_image'   => 'uploads/performers/' . $photo->performer_id . '/medium/' . $photo->name_on_disk,
            					'create_thumb'   => FALSE,
            					'maintain_ratio' => FALSE,
            					'width'          => 338,
            					'height'         => 260 
            		));
            		$this->image_lib->crop_delete();            		
            		
            		if( ! file_exists('uploads/performers/' . $photo->performer_id . '/small/' . $photo->name_on_disk) || ! file_exists('uploads/performers/' . $photo->performer_id . '/' . $photo->name_on_disk) || ! file_exists('uploads/performers/' . $photo->performer_id . '/medium/' . $photo->name_on_disk) ){
            			@unlink('uploads/performers/' . $photo->performer_id . '/paid/' . $photo->name_on_disk);
            			@unlink('uploads/performers/' . $photo->performer_id . '/paid/small/' . $photo->name_on_disk);
            			@unlink('uploads/performers/' . $photo->performer_id . '/small/' . $photo->name_on_disk);
            			@unlink('uploads/performers/' . $photo->performer_id . '/medium/' . $photo->name_on_disk);
            			@unlink('uploads/performers/' . $photo->performer_id . '/' . $photo->name_on_disk);
            			
            			$this->performers_photos->delete_photo_by_id($photo->photo_id);
            			 
            			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('An error occured, the photo has been deleted')));
            			redirect('performer/photos');					            			
            		}
            	}
            }
            
            $this->db->trans_begin();
            
            $this->performers_photos->update($photo_id, array('title' => $this->input->post('title'),'is_paid'=>$this->input->post('is_paid')));
            
            
			if ($this->db->trans_status() == FALSE) {
				
				$this->db->trans_rollback();
				
				$this->load->library('user_agent');
                $this->session->set_flashdata('msg', array( 'success' => FALSE, 'message' => lang('An error occured')));
				redirect($this->agent->referrer());
			}

			$this->db->trans_commit();
			$this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'performer', 
            			$photo->performer_id, 
            			'edit_photo', 
            			'Studio has edited a performer\'s photo '.$photo->photo_id, 
            			time(), 
            			ip2long($this->input->ip_address())
			);	
			
            $this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Photo edited successfully')));			
			redirect('performer/photos');
        }
	}

    /**
     * Sterge poza performer.
     * @param photo_id
     * @return none
     */
    function delete($photo_id=FALSE) {
		if ( ! $photo_id) {
            $this->session->set_flashdata('msg', array('success' => FALSE,'message' => lang('Photo ID is missing'),));
            redirect('performer/photos');
        }    	
        
        $data['photo'] = $this->performers_photos->get_one_by_id($photo_id);        
        if ( ! $data['photo']) {
            $this->session->set_flashdata('msg', array( 'success' => FALSE, 'message' => lang('Invalid photo')));
            redirect('performer/photos');
        }
        
		if ($data['photo']->performer_id !== $this->performer->id) {
            $this->session->set_flashdata('msg', array( 'success' => FALSE, 'message' => lang('You are trying to delete a photo that does not belong to you.'),));
            redirect('performer/photos');
		}
		
		//nu poate sterge poza principala (Avataru)
		if( $data['photo']->main_photo ){
            $this->session->set_flashdata('msg', array( 'success' => FALSE, 'message' => lang('You cannot delete the avatar.'),));
            redirect('performer/photos');			
		}

        $this->db->trans_begin();
		$this->performers_photos->delete_photo_by_id($photo_id);

        if ($this->db->trans_status() == FALSE) {
        	
            $this->db->trans_rollback();
                        
            $this->load->library('user_agent');
            $this->session->set_flashdata('msg', array( 'success' => FALSE,  'message' => lang('An error occured')));                        
            redirect($this->agent->referrer());
        }

        $this->db->trans_commit();
        $this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'performer', 
            			$data['photo']->performer_id, 
            			'delete_photo', 
            			'Studio has deleted a performer\'s photo ' . $data['photo']->photo_id, 
            			time(), 
            			ip2long($this->input->ip_address())
		);	
        redirect('performer/photos');
    }
    
	
    /**
     * Seteaza o poza ca avatar
     * @return unknown_type
     */
	function set_avatar(){
		
		//nu e apelat prin ajax
		if( ! $this->input->is_ajax_request() ){			
			redirect();	
		}
		
		$photo_name = $this->input->post('photo_name');
		$photo_id = $this->input->post('photo_id');
		
		$photo = $this->performers_photos->get_one_by_id($photo_id);
		if( ! $photo ){
			die(json_encode(array('success'=>FALSE,'message'=>lang('invalid photo'))));			
		}
		
		if( $photo->performer_id !== $this->performer->id ){
			die(json_encode(array('success'=>FALSE,'message'=>lang('selected photo is not yours'))));
		}
		
		if( $photo->is_paid ){
			die(json_encode(array('success'=>FALSE,'message'=>lang('You cannot set a paid photo as avatar'))));
		}
				
		$this->db->trans_begin();
		$this->performers_photos->update($photo_id, array('main_photo' => true));
		$this->performers->update($this->user->id, array('avatar' => $photo_name));

        if ($this->db->trans_status() == FALSE) {
        	
            $this->db->trans_rollback();
                        
			die(json_encode(array('success'=>FALSE,'message'=>lang('An error occured'))));            
        }

        $this->db->trans_commit();
        $this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'performer', 
            			$this->performer->id, 
            			'edit_photo', 
            			'Studio changed performer avatar to '.$photo_id, 
            			time(), 
            			ip2long($this->input->ip_address())
		);	
		die(json_encode(array('success'=>TRUE,'message'=>'')));	
		
	}    
}
