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
 * @property performers $performers
 * @property contracts $contracts
 * @property performers_photo_ids $performers_photo_ids
 */
class Photo_id_controller extends MY_Performer{
	
	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('performers_photo_ids');
	}
	
	/*
	 * Listeaza photo idurile
	 */
	function index(){
		$data['photo_ids']				= $this->performers_photo_ids->get_multiple_by_performer_id($this->user->id);
        $data['description'] 	       = SETTINGS_SITE_DESCRIPTION;
        $data['keywords'] 		       = SETTINGS_SITE_KEYWORDS;
        $data['pageTitle'] 		       = lang('My Photo id\'s').' - '.SETTINGS_SITE_TITLE;
		$data['_performer_menu']		= TRUE;
        $data['_sidebar']		       = TRUE;
        $data['page']			       = 'photo_ids/index';		
    
        $this->load->view('template', $data);	
	}
	
	/*
	 * Adauga un photo id
	 */
	function add(){
		$approved_photo_ids = $this->performers_photo_ids->get_multiple_by_performer_id($this->user->id,array('status'=>'approved'),TRUE);			
		if( $approved_photo_ids ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('You already have an approved photo ID')));
			redirect('photo_id');
		}
		
		$total_photo_ids = $this->performers_photo_ids->get_multiple_by_performer_id($this->user->id,FALSE,TRUE);
		if( $total_photo_ids > 9 ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('You exceeded the maximum allowed photo ID number')));
			redirect('photo_id');
		}		
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('photo_id',	lang('photo_id'),		'trim|required|performer_photo_id');
				
		if( $this->form_validation->run() === FALSE ){				
	        $data['description'] 	       = SETTINGS_SITE_DESCRIPTION;
	        $data['keywords'] 		       = SETTINGS_SITE_KEYWORDS;
	        $data['pageTitle'] 		       = lang('Add Photo id').' - '.SETTINGS_SITE_TITLE;
        	$data['_sidebar']		       = TRUE;	        
			$data['_performer_menu']		= TRUE;			
	        $data['page']			       = 'photo_ids/add';		
	        
			$data['photo_id']		= ($this->session->userdata('photo_id'))?$this->session->userdata('photo_id'):FALSE;
	        	    
	        $this->load->view('template', $data);			
		} else {
			
			$this->load->helper('directories');
			
			foreach( $this->good_photo_ids as $photo_id ){	
				$name = generate_unique_name('uploads/performers/' . $this->user->id . '/others/',$photo_id['name']);
				
				//move the contract to his place
				@rename(MY_TEMP_PATH.'/' . $photo_id['file_on_disk_name'], 'uploads/performers/' . $this->user->id . '/others/' . $name);
				$this->performers_photo_ids->add($name,'pending',$this->user->id);
			}	
			
			$this->load->model('performers');
			$this->performers->update($this->user->id, array('photo_id_status'=>'pending'));			
			$this->session->unset_userdata('photo_id');
						
			$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Photo ID added')));
			redirect('photo_id');			
		}	
	}
	
	/*
	 * Sterge un photo id
	 */
	function delete($photo_id = FALSE){
		if( ! $photo_id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid photo ID')));
			redirect('photo_id');
		}
		
		$photo_id = $this->performers_photo_ids->get_one_by_id($photo_id);
		if( ! $photo_id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid photo ID')));
			redirect('photo_id');
		}
		
		if( $photo_id->performer_id != $this->user->id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Cannot delete a photo ID that is not yours')));
			redirect('photo_id');	
		}
		
		if( $photo_id->status == 'approved' ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Cannot delete an approved photo ID')));
			redirect('photo_id');				
		}
		
		if( ! $this->performers_photo_ids->delete_by_id($photo_id->id) ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Could not delete the photo ID')));
			redirect('photo_id');												
		}
		
		@unlink('uploads/performers/' . $this->user->id . '/others/' . $photo_id->name_on_disk);		
		$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('photo ID removed.')));
		redirect('photo_id');			
	}
}