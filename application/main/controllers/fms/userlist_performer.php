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
	
	private $user_type;
	
	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		
		$this->load->helper('generic');
		$this->load->model('performers');
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
		//sa pot face diferenta pe viitor intre user/admin/studio
		$saved_user = $this->input->get_post('userId');
		
		$data = $this->fms->generate_params($this->params,TRUE);
		
		$user = $this->get_login_credentials($saved_user,$data['user_id']);
		if( ! $user ){
			die('Invalid credentials');
		}	
		
		$performer 	= $this->performers->get_one_by_id($data['performer']);
		
		if( ! $performer ){
			die('INVALID PERFORMER');
		}		
		
		//daca e perforemr verific si daca e chiar videoul lui
		if( $this->user_type == 'performer' && $user->id != $performer->id){
			die('INVALID PERFORMER');						
		}
		
		//daca e studio iau performerul pt studiou respectiv
		if( $this->user_type == 'studio' ){
								
			//performerul nu apaartine studioului
			if( $performer->studio_id != $user->id ){
				die('INVALID PERFORMER');							
			}
		}
		
		$this->load->model('performers_ping');
		
		//sa nu fac chiar in continu update iau doar daca pingu e in primele 20 sec
		if( date('s') <= 20 ){
			$this->performers_ping->add_ping($performer->id,time());
		}
				
		$this->load->model('watchers');
		$filters['show_is_over'] 	= 0;
		$filters['type']			= array('private','nude','free','peek','true_private');
		$joins['users']				= TRUE;		
		$data['userlist'] 			= $this->watchers->get_multiple_by_performer_id($performer->id,FALSE,FALSE,$filters,$joins);
		
		$this->output->set_header("HTTP/1.1 200 OK");
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
				
		$this->load->view('fms/userlist_for_performers',$data);
	}
	
	/**
	* Returneaza detaliile userului logat
	* @param $saved_user
	* @param $user_id
	* @return object
	*/
	protected function get_login_credentials($saved_user,$user_id){
		if(substr($saved_user,0,1) == 'a'){
			$user_id = substr($user_id,1);				
			$this->user_type = 'admin';
			$this->load->model('admins');
			return $this->admins->get_one_by_id($user_id);
		}
	
		if(substr($saved_user,0,1) == 's'){
			$user_id = substr($user_id,1);				
			$this->user_type = 'studio';
			$this->load->model('studios');
			return $this->studios->get_one_by_id($user_id);
		}
		
		$this->user_type = 'performer';
		$this->load->model('performers');
		return $this->performers->get_one_by_id($user_id);
	}	
}