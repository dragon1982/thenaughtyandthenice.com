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
 * @property Performers_videos $performers_videos
 * @property Watchers $watchers
 * @property System_logs $system_logs
 */

class Home_controller extends MY_Controller {

	/*
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('performers');
		$this->load->model('categories');
		$this->load->config('filters');
		$this->load->helper('filters');
		
		//purifica filtrele
		$_GET['filters'] = purify_filters(isset($_GET['filters'])?$_GET['filters']:NULL);
	}
		
	/*
	 * Prima pagina
	 */
	function index() {

		$this->load->library('pagination');	
		$this->load->helper('text');
		
		$filters = $this->input->get('filters');
		//seteaza filtrele pentru pagina actuala
		$settings = initialize_filters($filters,$order_by = NULL,'online-listing');
		
		$config['per_page']		= 10;			
		$config['base_url'] 	= site_url('performers/page/');	
		$config['total_rows']   = $this->performers->get_multiple_performers($settings['filters'],$this->pagination->per_page,(int)$this->uri->segment(3),$settings['order_by'],TRUE);
		$this->pagination->initialize($config);
		
		$data['performers'] 			= $this->performers->get_multiple_performers($settings['filters'],$this->pagination->per_page,(int)$this->uri->segment(3),$settings['order_by']);
		$data['pagination']				= $this->pagination->create_links();
		$data['categories'] 			= $this->categories->get_all_categories();
		
		$data['performers_random']		= $this->performers->get_multiple_performers(array(),10,FALSE,array('rand'=>TRUE));		
		$data['performers_in_private']	= $this->performers->get_multiple_performers(array('is_in_private'=>1),5,FALSE,array('rand'=>TRUE));
			
		$this->load->model('performers_videos');
		$data['videos_free'] 			= $this->performers_videos->get_multiple_videos(array('type'=>0),4,0,FALSE,TRUE);
		$data['videos_paid']			= $this->performers_videos->get_multiple_videos(array('type'=>1),4,0,FALSE,TRUE);
				
		if( sizeof($data['videos_paid']) > 0 && $this->user->id){
			$this->load->model('watchers');
			$performer_videos = extract_values_by_property($data['videos_paid'] , 'video_id');
			$paid_videos =   $this->watchers->get_multiple_by_performer_id(FALSE,FALSE,FALSE,array('type'=>'premium_video','user_id'=>$this->user->id,'performer_videos'=>$performer_videos),FALSE);
			mark_paid_videos($data['videos_paid'],$paid_videos);
		}
				
		$data['_categories']			= true;
		$data['meta_refresh']			= true;
		$data['_sidebar']				= false;
		$data['_signup_header']			= true;
		$data['page'] 					= 'performers';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Online Models').' - '.SETTINGS_SITE_TITLE;
		
		$this->load->model('fms');
		$this->fms_list = create_array_by_property($this->fms->get_multiple(),'fms_id');
				
		$search = prepare_search_options();
		$data = array_merge($data, $search);
		
		$this->load->view('template', $data);
		
	}
		
	/**
	* Functie de resetare parola -> step 1
	*/
	function forgot_password() {
		
		$this->im_in_modal = TRUE;
		
		$this->access->restrict('logged_out');
		
		$this->load->helper(array('form', 'url', 'emails'));
		$this->load->library('form_validation');
		
		
		$this->form_validation->set_rules('username',	lang('username'), 	'required|min_length[3]');
		$this->form_validation->set_rules('email', 		lang('email'), 		'required|valid_email|mail_belog_to_user[users]');
		
		if ($this->form_validation->run() === FALSE) {								
			$data['page']	= 'forgot_password';
			$this->load->view('template-modal',$data);			
		} else {			
			$this->load->library('email');
			$email = $this->input->post('email');
			$username = $this->input->post('username');
			$this->email->from(SUPPORT_EMAIL,SUPPORT_NAME);
			$this->email->to($email);
			$this->email->subject(lang('Forgot password'));
												
			$this->load->model('users');
			//selectez userul din DB
			$user = $this->users->get_one_by_username($username);
			
			$reset_password_link	 = site_url('reset-password?time=' . time() . '&username=' . $username . '&secure_code=' . md5( time() . $user->hash ) );
			$email_content = $this->load->view('emails/forgot_password_'.$this->config->item('lang_selected'), array(), TRUE);
			
			$replaced_variables = get_avaiable_variabiles('forgot_password', TRUE);
			$replace_value = array($user->username,  $user->email,  $reset_password_link,  main_url(), WEBSITE_NAME);
			
			$email_content = preg_replace($replaced_variables, $replace_value, $email_content);
			
			$this->email->message($email_content);
			if($this->email->send()){
				$this->session->set_flashdata('msg',array('success'=>TRUE, 'message'=>lang('Please check your mail to reset your password')));
				redirect();	
			} else {
				$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('Failed to send the confirmation email. Please retry')));
				redirect();
			}									
		}
		
	} 
	
	/**
	* Functie de resetare parola - step 2 - confirmare cod de resetare 
	*/
	function reset_password(){
			
		$this->access->restrict('logged_out');
		
		
		$email_time = $this->input->get('time') ;
		$email_username = $this->input->get('username') ;
		$email_secure_code = $this->input->get('secure_code') ;
		$this->load->model('users');
		$username = $this->users->get_one_by_username($email_username);
		
		$this->im_in_modal = TRUE;
		
		if ( strtotime('+1 day',$email_time) < time() || $email_time > time() ) {//verific timp						
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Invalid/expired token')));
			redirect();			
		}
			
		if( ! $username){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message' => lang('Invalid username')));
			redirect();	
		} 
		
		if(md5($email_time . $username->hash) !== $email_secure_code){		
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Invalid/expired token')));
			redirect();	
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('password',		lang('Password'),			'required|min_length[3]');
		$this->form_validation->set_rules('rep_password',	lang('Repeat Password'),	'required|min_length[3]|matches[password]');
		
		if($this->form_validation->run() === FALSE){
			
			$data['page']					= 'reset_password';
			$data['description']			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords']				= SETTINGS_SITE_KEYWORDS;
			$data['page_title']				= lang('Reset Password');
			$data['pageTitle'] 				= lang('Reset Password').' - '.SETTINGS_SITE_TITLE;
			
						
			$this->load->view('template',$data);
		} else {
			$salt = $this->config->item('salt');
						
			$this->users->update($username->id,array('password' => hash('sha256', $salt . $username->hash . $this->input->post('password'))));
			
			$this->system_log->add(
            			'user', 
            			$username->id,
            			'user', 
            			$username->id, 
            			'reset_password', 
            			'User has reseted password.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
			$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Password saved, you can login.')));
			redirect();			
		}	
	}	
	
	
	/**
	* Schimba limba
	* @param unknown_type $lang
	* @author Baidoc
	*/
	function language($lang = FALSE){
		if( ! $lang ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid language')));
			redirect();
		}
		
		$languages = $this->config->item('lang_avail');
		
		if( ! isset( $languages[$lang]) ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid language')));
			redirect();				
		}
		
		$this->lang_detect->changeLang($lang);
		
		redirect();
	}
			
	// -----------------------------------------------------------------------------------------	
	/**
	 * Acvtiveaza userul din pending
	 */
	function activate(){
		$username 		= $this->input->get('username');
		$secure_code 	= $this->input->get('secure_code');
		$time			= $this->input->get('time');
						
		if ( strtotime('+1 day',$time) < time() || $time > time() ) {//verific timp						
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Invalid/expired activation code')));
			redirect();			
		}
			
		$this->load->model('users');
		$username = $this->users->get_one_by_username($username);
		
		if( ! $username){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message' => lang('Invalid username')));
			redirect();	
		}

		if( $username->status !== 'pending' ){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message' => lang('Account is not in pending. You cannot reactivate ')));
			redirect();				
		}
		
		if(md5($time . $username->hash) !== $secure_code){		
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Invalid activation code')));
			redirect();	
		}
		
		//begin the transaction
		$this->db->trans_begin();		
		
		$this->users->update($username->id,array('status'=>'approved'));
		
		$this->system_log->add(
            		'user', 
            		$username->id,
            		'user', 
            		$username->id, 
            		'register', 
            		'User activated the account.', 
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
		
		$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Account activated successfully')));
		$this->session->set_userdata(
							array(
								'id'	=> $username->id,
								'type' 	=> 'user'
							)		
		);
		redirect();
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * APELAT de catre FMS, returneaza numarul minim/maxim de credite ce poat fii tipuite de catre un user
	 * @return unknown_type
	 */
	function tip(){
		$user_id 	= substr($this->input->get('userId'),1);
		$password	= $this->input->get('pasword');
		$unique_id	= $this->input->get('uniqId');
		
		if( $user_id < 1 ){
			die('allow=false&notLogged=true');
		}
				
		if( $this->user->id != $user_id ){
			die('allow=false&notLogged=true');
		}
		
		if( $this->user->password != $password ){
			die('allow=false&notLogged=true');
		}
		
		$this->load->model('watchers');
		$session = $this->watchers->get_one_by_unique_id($unique_id);
		
		$max = $this->user->credits; 
		if( $session ){
			$max -= $session->user_paid_chips + ($session->fee_per_minute*2); 
		}
				
		if( $max  < 2 ){
			die('allow=false&noChips=true');	
		}
		
		die('allow=true&min=1&max=' . $max . '&noChips=false&notLogged=false');
		
	}		
}