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
* @property Studios $studios
*/
class Activate_controller extends MY_Controller{
	
	// -----------------------------------------------------------------------------------------	
	/*
	 * Constructor
	 */
	function __construct(){		
		parent::__construct();
		$this->access->restrict('logged_out');
	}
	
	/**
	 * Activare cont
	 * @author Baidoc
	 */
	function index(){
		$username 		= $this->input->get('username');
		$secure_code 	= $this->input->get('secure_code');
		$time			= $this->input->get('time');
		
		if ( strtotime('+1 day',$time) < time() || $time > time() ) {
			//verific timp
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Invalid/expired activation code')));
			redirect('login');
		}
				
		$this->load->model('studios');
		$username = $this->studios->get_one_by_username($username);
		
		if( ! $username){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message' => lang('Invalid username')));
			redirect('login');
		}
		
		if( $username->status !== 'pending' ){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message' => lang('Account is not in pending. You cannot reactivate ')));
			redirect('login');
		}
		
		if(md5($time . $username->hash) !== $secure_code){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Invalid activation code')));
			redirect('login');
		}
		
		//begin the transaction
		$this->db->trans_begin();

		$this->studios->update($username->id,array('status'=>'approved'));

		$this->system_log->add(
        	'studio', 
			$username->id,
           	'studio', 
			$username->id,
            'register', 
            'studio activated the account.', 
			time(),
			ip2long($this->input->ip_address())
		);
		
		//nu am reusit sa adaug in db userul
		if($this->db->trans_status() == FALSE){
					
			//fac rollback la date
			$this->db->trans_rollback();

			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('An error occured')));
			//redirectionez pe pagina de unde a venit
			redirect();
		}
		$this->db->trans_commit();
		
		$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('E-mail address successfully verified.')));
		$this->session->set_userdata(
			array(
				'id'	=> $username->id,
				'type' 	=> 'studio'
			)
		);
		redirect();
	}
}