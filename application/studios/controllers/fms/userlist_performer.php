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
 * @property Studios $studios
 * @property Watchers $watchers
 * @property System_logs $system_logs
 * @property Fms $fms
 */

class Userlist_performer_controller extends CI_Controller{
	
	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		
		$this->load->helper('generic');
		$this->load->model('performers');
		$this->load->model('studios');
		$this->load->model('fms');
				 
		//file logger
		$this->file_log = APPPATH.'logs/userlist_performer.txt';
		
		//params from fms
		$this->params   = array(
						'userId'		=> 'user_id',
						'random'		=> 'random',
						'performer'		=> 'performer',
						'pasword'		=> 'password',
		);
		
	}
	
	/*
	 * Returneaza lista de useri din chat
	 */
	function index(){
		$data 		= $this->fms->generate_params($this->params,TRUE);	 
		
		$studio 	= $this->studios->get_one_by_id($data['user_id']);
		
		if( ! $studio ){
			die('INVALID STUDIO'.$data['user_id']);			
		}
		
		if( $studio->password !== $data['password'] ){
			die('INVALID PASSWORD');
		}
		
		$this->load->model('watchers');
		$filters['show_is_over'] 	= 0;
		$filters['type']			= array('private','nude','free','peek');
		$joins['users']				= TRUE;		
		$data['userlist'] 			= $this->watchers->get_multiple_by_performer_id($data['performer'],FALSE,FALSE,$filters,$joins);
		
		$this->load->view('fms/userlist_for_performers',$data);
	}
}