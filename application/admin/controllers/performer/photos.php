<?php 

class Photos_controller extends MY_Admin {
	
	function __construct() {
		parent::__construct();
		$this->load->model('performers');
		$this->load->library('form_validation');
		$this->load->helper('generic_helper');
		$this->load->library('image_lib');
	}
	
	function view($username = 0) {
		
		$this->load->model('performers_photos');
		
		if(strlen($username) == 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This username is invalid')));
		}
		
		$performer = $this->performers->get_all(array('username'=>$username));
		if( ! is_array($performer) || count($performer) <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This performer does not exist!')));
		}
		
		$performer = $performer[0];
		
		$data['performer'] 				= $performer;
		$data['photos']					= $this->performers_photos->get_multiple_by_performer_id($performer->id);
				
		$this->form_validation->set_rules('title', lang('title'), 'trim|required|min_length[2]|max_length[30]|strip_tags|purify');
		
		if($this->form_validation->run() == FALSE){
			
			$data['breadcrumb']['Performers'] = base_url().'performers';
			
			if($performer->id > 0){
				$data['page_head_title'] = $performer->username.'\'s photos';
				$data['breadcrumb'][$performer->username.'\'s photos'] = 'current';
			}
			$data['page'] = 'performers_photo_edit';
			$this->load->view('template', $data);
			
		} else {
			
			# Iau extensia fisierului uploadat
			$ext 			= end(explode(".", $_FILES['image']['name']));
			$upload_path 	= 'uploads/performers/' . $performer->id;
			
			# Verfic ca numele pozei sa fie unic
			$image_name = md5(uniqid(rand(), true));
			while (file_exists($upload_path . $image_name . '.' . $ext)) {
            	$image_name = md5(uniqid(rand(), true));
       		}
       		$full_name = $image_name . '.' . $ext;
       		# Setez directoarele 
			
			$spath 			= 'uploads/performers/' . $performer->id . '/small/' . $full_name;
            $mpath 			= 'uploads/performers/' . $performer->id . '/medium/' . $full_name;
			
			$config['upload_path'] 		= $upload_path;
        	$config['allowed_types'] 	= 'jpeg|jpg|gif|png';
        	$config['max_size'] 		= '5120';
        	$config['file_name'] 		= $image_name;
        	$this->load->library('upload', $config);
        	
			if (getimagesize($_FILES['image']['tmp_name']) == FALSE) {
            	$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This is not a valid image.')));
            	redirect(current_url());
        	}
       		if ( ! $this->upload->do_upload('image')) {
            	$this->session->set_flashdata('msg', array('type' => 'error', 'message' => $this->upload->display_errors()));
            	redirect(current_url());
       		} else {
       			# Copiem poza si in directoarele cu thumbnail-uri
       			copy($upload_path . '/' . $full_name, $spath);
            	copy($upload_path . '/' . $full_name, $mpath);
            
            	# Resize thumbnail
            	$this->image_lib->clear();
            	$this->image_lib->initialize(array(
                	'image_library'  => 'gd2',
                	'source_image'   => $spath,
                	'create_thumb'   => FALSE,
                	'maintain_ratio' => TRUE,
                	'width'          => 150,
                	'height'         => 116
            	));
            	$this->image_lib->resize();

            	# Resize thumbnail
            	$this->image_lib->clear();
            	$this->image_lib->initialize(array(
                	'image_library'  => 'gd2',
                	'source_image'   => $mpath,
                	'create_thumb'   => FALSE,
                	'maintain_ratio' => TRUE,
                	'width'          => 338,
                	'height'         => 260 
            	));
            	$this->image_lib->resize();
            	
           		$this->performers_photos->add($performer->id, $full_name, $this->input->post('title'));
            	$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Image uploaded succesfully!')));
            	redirect(current_url());
        	}
		}
	}
	
	function delete_photo($photo_id = FALSE) {
		$this->load->library('user_agent');
		
		if ( ! $photo_id) {
            $this->session->set_flashdata('msg', array('type' => 'error','message' => lang('Photo ID is missing'),));
            redirect($this->agent->referrer());
        }    	
        
        $photo = $this->performers_photos->get_one_by_id($photo_id); 
               
        if ( ! $photo) {
            $this->session->set_flash_data('msg', array( 'type' => 'error', 'message' => lang('Invalid photo')));
            redirect($this->agent->referrer());
        }

        $this->db->trans_begin();
		$this->performers_photos->delete_photo_by_id($photo_id);

        if ($this->db->trans_status() == FALSE) {
        	
            $this->db->trans_rollback();
                        
            $this->session->set_flashdata('msg', array( 'type' => 'error',  'message' => lang('An error occured')));                        
            redirect($this->agent->referrer());
        }

        $this->db->trans_commit();
        $this->session->set_flashdata('msg', array( 'type' => 'success',  'message' => lang('Photo has been succesfully deleted.')));
        redirect($this->agent->referrer());
    }
} 