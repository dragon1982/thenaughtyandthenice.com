<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Authentication Class
 *
 * Built on Mathew Davies' ReduxAuth
 * @copyright	Copyright (c) 1 June 2008, Mathew Davies
 * @see			http://code.google.com/p/reduxauth/
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 */

class Access
{
	var $CI;
	var $salt;
	
	/**
	 * Constructor
	 *
	 * Loads the configuration options and assigns them to
	 * class variables available throughout the library.
	 *
	 * @access	public
	 * @param	void
	 * @return	void
	 */
	function __construct()
	{
		$this->CI =& get_instance();
		$auth = $this->CI->config->item('salt');
		
		/* Config Variables */
		$this->salt = $auth;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Login
	 *
	 * Verifies a user based on username and password
	 *
	 * @access	public
	 * @param	string username, password
	 * @return	bool
	 */
	function login($type, $username, $password)
	{
		$this->CI->load->model('failure_logins');
		
		$ip = ip2long($this->CI->input->ip_address());
		$login = $this->CI->failure_logins->get_one_by_ip($ip);

		if($login && $login->failed_logins > 3)
		{
			$now = time();
			$wait = $now - 20;

			$this->CI->failed_logins = $login->failed_logins;
			
			if($login->last_failure > $wait)
			{							
				return 'TIMEOUT';
			}
			
		} else {
			if( ! $login){
				$login = new stdClass();
				$this->CI->failed_logins = 0;
			} else {
				$this->CI->failed_logins = $login->failed_logins;
			}
		}
		
		if($type == 'user'){

			$this->CI->load->model('users');
			$result = $this->CI->users->get_one_by_username($username);
			
						
			if ($result) // Result Found
			{			

				if ($result->status == 'rejected')
				{
					return 'REJECT';
				}
				if ($result->status == 'pending')
				{
					return 'PENDING';
				}			
				
				$password = hash('sha256',$this->salt.$result->hash.$password); // Hash input password
				
				
				if ($password === $result->password) // Passwords match?
				{
					$this->CI->session->sess_destroy();
					$this->CI->session->set_userdata(
							array(
								'id'	=> $result->id,
								'type' 	=> $type
							)
					);
					
					$this->CI->system_log->add(
            			'user', 
            			$result->id,
            			'user', 
            			$result->id, 
            			'login', 
            			'User has logged in.', 
            			time(), 
            			ip2long($this->CI->input->ip_address())
					);

					$this->CI->failure_logins->delete_failures_by_ip($ip);
					$this->CI->users->log($result->id, $ip);

					return TRUE;
				}

			}
			return FALSE;
		}
		// PERFORMER AUTH
		elseif($type == 'performer')
		{
			$this->CI->load->model('performers');
								
			if( ! $result = $this->CI->performers->get_one_by_username($username) ){
				return FALSE;
			}

			if($result->status == 'rejected'){
				return 'REJECT';
			}

			if ($result->status == 'pending')
			{
				return 'PENDING';
			}
			
			if( hash( 'sha256', $this->salt.$result->hash.$password ) === $result->password ){
				
				$this->CI->system_log->add(
            			'performer', 
            			$result->id,
            			'performer', 
            			$result->id, 
            			'login', 
            			'Performer has logged in.', 
            			time(), 
            			ip2long($this->CI->input->ip_address())
				);
				
				if($result->register_step <= 5){
					
					$this->CI->session->set_userdata(
							'register',array('step'=>$result->register_step,'performer_id'=>$result->id)
					);
					
					redirect('register');
				}
				
				
				
				$this->CI->session->sess_destroy();
				$this->CI->session->set_userdata(array(
						'id' 	=> $result->id,
						'type' 	=> $type
				));
				
				$this->CI->failure_logins->delete_failures_by_ip($ip);
				
				return TRUE;
			}
	
			return FALSE;
		}
		// STUDIO AUTH
		elseif($type == 'studio')
		{
			
			$this->CI->load->model('studios');

			if( ! $result = $this->CI->studios->get_one_by_username($username)){
				return FALSE;
			}
			
			if($result->status == 'rejected'){
				return 'REJECT';
			}
			
			if ($result->status == 'pending')
			{
				return 'PENDING';
			}	
		
			if(	hash('sha256',$this->salt . $result->hash . $password )=== $result->password ){
											
				$this->CI->session->sess_destroy();
				$this->CI->session->set_userdata(array(
					'id' 	=> $result->id,
					'type' 	=> $type
				));
				$this->CI->system_log->add(
            			'studio', 
            			$result->id,
            			'studio', 
            			$result->id, 
            			'login', 
            			'Studio has logged in.', 
            			time(), 
            			ip2long($this->CI->input->ip_address())
				);
				
				$this->CI->failure_logins->delete_failures_by_ip($ip);
				
				return TRUE;
			}
				
			
			return FALSE;
		}
		// AFFILIATE AUTH
		elseif($type == 'affiliate')
		{
			
			$this->CI->load->model('affiliates');

			if( ! $result = $this->CI->affiliates->get_by_username($username)){
				return FALSE;
			}
			
			if ($result->status == 'rejected')
			{
				return 'REJECT';
			}
			if ($result->status == 'pending')
			{
				return 'PENDING';
			}			
			
			if(	hash('sha256',$this->salt . $result->hash . $password )=== $result->password ){
								
				$this->CI->session->sess_destroy();
				$this->CI->session->set_userdata(array(
					'id' 	=> $result->id,
					'type' 	=> $type
				));
				$this->CI->system_log->add(
            			'affiliate', 
            			$result->id,
            			'affiliate', 
            			$result->id, 
            			'login', 
            			'User has logged in.', 
            			time(), 
            			ip2long($this->CI->input->ip_address())
				);
				
				$this->CI->failure_logins->delete_failures_by_ip($ip);
				
				return TRUE;
			}
				
			return FALSE;
		}
		// ADMIN AUTH 
	 	elseif($type == 'admin')
	 	{
		
			$this->CI->load->model('admins');
			
			if( ! $result = $this->CI->admins->get_one_by_username($username) ){			
				return FALSE;
			}
			
			if ($result->status == 'rejected')
			{
				return 'REJECT';
			}
			if ($result->status == 'pending')
			{
				return 'PENDING';
			}
				
			$password = hash('sha256', $this->salt . $result->hash . $password); // Hash input password

			if ($password === $result->password) // Passwords match?
			{
				$this->CI->session->sess_destroy();
				$this->CI->session->set_userdata(array('id'=> $result->id));
				$this->CI->session->set_userdata(array('type'=>$type));
				$this->CI->system_log->add(
            			'admin', 
            			$result->id,
            			'admin', 
            			$result->id, 
            			'login', 
            			'Admin has logged in.', 
            			time(), 
            			ip2long($this->CI->input->ip_address())
				);
				
				$this->CI->failure_logins->delete_failures_by_ip($ip);
				
				return TRUE;
			}
					
			
			return FALSE;						
		}		
	}

	// --------------------------------------------------------------------

	/**
	 * Logged In
	 *
	 * Checks to see if a visitor is logged into the site
	 *
	 * @access	public
	 * @param	void
	 * @return	bool
	 */
	function logged_in ()
	{
		return $var = ($this->CI->session->userdata('id')) ? TRUE : FALSE; 
	}

	// --------------------------------------------------------------------

	/**
	 * Logout
	 *
	 * Destroys the user's session
	 *
	 * @access	public
	 * @return	void
	 */
	function logout ()
	{
		$this->CI->session->unset_userdata('id');
		$this->CI->session->sess_destroy();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Returns User Object
	 *
	 * @access	public
	 * @return	object	user object
	 */
	function get_account($account_type = 'user')
	{		
				

		if ( ! $this->logged_in())
		{
			$account			= new stdClass;
			$account->id		= -1;
		}
		else
		{
            
			$type = $this->CI->session->userdata('type');
			$id = $this->CI->session->userdata('id');
			
			if($type != $account_type){
				$account			= new stdClass;
				$account->id		= -1;
				return $account;
			}			
						
			$account = $this->get_logged_account($id,$account_type);	
			
			if( ! $account){
				$account			= new stdClass;
				$account->id		= -1;
			}


		}
		return $account;
	}

	// --------------------------------------------------------------------
	/**
	 * Returneaza sessiunea activa (daca exista a userului)
	 * @param $id
	 * @return unknown_type
	 */
	function get_active_session($id = 0){
		$this->CI->load->model('watchers');
		$session = $this->CI->watchers->get_one_active_by_user_id($id);
		if(! $session){
			return 0;
		}
		if($session->duration == 0){
			return 0;
		}
		if($session->duration < 60){
			return  $session->fee_per_minute;
		}
		return $session->user_paid_chips;		
	}

	// --------------------------------------------------------------------
	/**
	 * Returneaza obiect cu accountul logat
	 * @param $id
	 * @param $type
	 * @return object
	 */
	function get_logged_account($id = 0,$type = FALSE){
		if( ! $id || ! $type){ 
			return FALSE;
		}
		$this->CI->load->model($type.'s');

		switch($type){
			case 'user':
				$logged_user = $this->CI->users->get_one_by_id($id,TRUE);
				if(! $logged_user) return FALSE;
				$logged_user->type='users';			
				return $logged_user;
			case 'performer':
				$logged_performer = $this->CI->performers->get_one_by_id($id);
				$logged_performer->type='performer';
				return $logged_performer;				
			case 'studio':
				$logged_studio = $this->CI->studios->get_one_by_id($id);
				$logged_studio->type='studio';				
				return $logged_studio;			
			case 'affiliate':
				$logged_studio = $this->CI->affiliates->get_by_id($id);
				$logged_studio->type='affiliate';				
				return $logged_studio;			
			case 'admin':
				$logged_admin = $this->CI->admins->get_by_id($id);
				$logged_admin->type='admin';
				return $logged_admin;
			default:
				return FALSE;
				
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Protect a controller / function
	 *
	 * @access	public
	 * @param	string	user group
	 */
	function restrict($userGroup = FALSE)
	{
		if($userGroup == 'logged_out')		
		{

			if ($this->CI->user->id > 0)
			{
				redirect();
			}
		}
		elseif($userGroup == 'users')
		{
			if ($this->CI->user->id < 0){	
				$this->CI->session->set_flashdata('msg',array('success'=>FALSE,'message'=>'You must be logged in to access this page!'));
				redirect('','check');
			}
			if(!isset($this->CI->user->status)){
				$this->CI->session->unset_userdata('id');
				$this->CI->session->set_flashdata('msg',array('success'=>FALSE,'message'=>'Your session has expired.'));
				redirect('','check');
			}
			if(isset($this->CI->user->status) && $this->CI->user->status !== 'approved'){
				$this->CI->session->unset_userdata('id');
				$this->CI->session->set_flashdata('msg',array('success'=>FALSE,'message'=>'Acount canceled'));
				redirect('','check');
			}
		}
		elseif($userGroup == 'performers'){
			if ($this->CI->user->id < 0)
			{
				redirect('login');
			}			
		}
		
		elseif($userGroup == 'studios'){			
			if ($this->CI->user->id < 0)
			{
				redirect('login');
			}
		}
		elseif($userGroup == 'affiliates'){
			if ($this->CI->user->id < 0)
			{
				redirect('login');
			}
		}
		elseif($userGroup == 'admins'){
			if ($this->CI->user->id < 0)
			{
				redirect('login');
			}
			
			if($this->CI->user->type != 'admin'){
				redirect('login');
			}
		}				
	}
}

/* End of file Access.php */
/* Location: ./application/libraries/Access.php */