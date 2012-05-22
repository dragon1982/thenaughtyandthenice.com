<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
 * @property Watchers $watchers
 * @property System_logs $system_logs
 */
Class Photo_controller extends CI_Controller{

	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('performers_photos');
		$this->user = $this->access->get_account();
	}
	
	/*
	 * Afiseaza poza mare
	 */
	function index($photo_id = FALSE){
		if( ! $photo_id ){
			return;
		}
		
		$photo = $this->performers_photos->get_one_by_id($photo_id);
		
		//nu am gasit poza
		if( ! $photo ){
			return;
		}

		//poza nu e cu plata, nu trebuie servita prin acest serviciu
		if( ! $photo->is_paid ){
			return;
		}
		
		$is_logged = (($this->session->userdata('id') == $photo->performer_id && $this->session->userdata('type') == 'performer') || ($this->session->userdata('performer_id') == $photo->performer_id) || $this->session->userdata('type') == 'admin')?TRUE:FALSE;
		if( $this->user->id < 1 && ! $is_logged ){
			return;
		}
		
		$this->load->model('watchers');
		$has_paid = $this->watchers->get_multiple_by_performer_id($photo->performer_id,1,0,array('type'=>'photos','user_id'=>$this->user->id),FALSE,TRUE);
		
		
		//nu a platit galeria foto
		if( ! $has_paid  && ! $is_logged ){
			return;
		}
		
		$this->load->image('uploads/performers/' . $photo->performer_id . '/paid/' . $photo->name_on_disk);
	}
	
	
	/*
	 * Afiseaza thumb al pozei
	 */
	function thumb($photo_id = FALSE){
		if( ! $photo_id ){
			return;
		}

		$photo = $this->performers_photos->get_one_by_id($photo_id);
		
		//nu am gasit poza
		if( ! $photo ){
			return;
		}
		
		//poza nu e cu plata, nu trebuie servita prin acest serviciu
		if( ! $photo->is_paid ){
			return;
		}

		
		$this->output->set_header("HTTP/1.1 200 OK");
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");		
				
		$this->load->image('uploads/performers/' . $photo->performer_id . '/paid/small/' . $photo->name_on_disk);		
	}
}