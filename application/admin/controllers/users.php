<?php
/**
 * 
 * @property Users $users
 *
 */
class Users_controller extends MY_Admin {
	
	function __construct() {
		parent::__construct();
		$this->load->model('users');
		$this->load->library('form_validation');
		$this->load->helper('filters');
		$this->load->helper('utils');
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * Returneaza lista de useri filtrata
	 * @author Baidoc
	 */
	function index() {
		$filters	= purify_filters($this->input->get('filters'),'users');
		$order		= purify_orders($this->input->get('orderby'),'users');
				
		//caguna a facut in model niste avioane de validari:)
		$this->ignore_rest = 1;
		
		$data['filters']	= array2url($filters,'filters');
		$data['order_by']	= $this->input->get('orderby');
		
		$filters['status'] = '!= rejected';
		$filters['join']['users_detail'] = 'user_id = id, left';
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('users/page/');
		$config['uri_segment'] 	= 3;
		$config['total_rows']   = $this->users->get_all($filters, TRUE);
		$config['per_page']		= 20;
		
		$this->admin_pagination->initialize($config);
		
		$data['pagination']     = $this->admin_pagination->create_links();
		$data['users']			= $this->users->get_all($filters, FALSE,implode_order($order) , $this->uri->segment(3), $config['per_page']);

		$data['page'] = 'users';
		$data['breadcrumb'][lang('Users')]	= 'current';
		$data['page_head_title']			= lang('Users'); 
		
		$this->load->view('template', $data);
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * Vizualizare / editare detalii cont
	 * @param unknown_type $username
	 * @author Baidoc
	 */	
	function account($username = 0){
		
		if(strlen($username) == 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This username is invalid')));
			redirect('users');
		}
		
		$user = $this->users->get_all(array('username'=>$username));
		if( ! is_array($user) || count($user) <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This user does not exist!')));
			redirect('users');
		}
		
		$user = $user[0];
		$data['user'] = $this->users->get_one_by_id_and_full_details($user->id);
		$data['status'] = array(lang('Select Status'), 'approved'=>'approved', 'pending'=>'pending', 'rejected'=>'rejected');
		$this->form_validation->set_rules('password', 	lang('password'), 	'trim|min_length[3]|max_length[25]');
		$this->form_validation->set_rules('email',		lang('email'),		'trim|required|valid_email|purify|min_length[3]|max_length[60]');
		
		if($this->form_validation->run() == FALSE){
			
			$data['breadcrumb'][lang('Users')] = base_url().'users';
			
			$data['page_head_title'] = $user->username . '\'s '. lang('account');
			$data['breadcrumb'][$user->username . '\'s '. lang('account')] = 'current';

			$data['page'] = 'users_edit';
			$this->load->view('template', $data);
			return;
		}
		
		$rows['id']				= $user->id;
				
		//If password is not empty 
		if($this->input->post('password')){
			
			//If edit user account, set id and hash
			if($user->id > 0){
				$hash				= $user->hash;
				
			//Else, generate a new hash
			} else {
				$hash				= generate_hash('users');
				$rows['hash']		= $hash;
			}
			
			//Encrypt password
			$salt					= $this->config->item('salt');
			$rows['password']		= hash('sha256',($salt . $hash . $this->input->post('password') ));
		
		}
		
		$rows['email']			= $this->input->post('email');
		$rows['status']			= $this->input->post('status');
		
		if($this->users->save($rows)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('User account was saved successfully!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'user', 
            			$user->id, 
            			'edit_account', 
            			'Admin edited user account.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		} else {
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('User account was not saved! Please try again!')));
		}
		
		redirect('users/account/' . $user->username);
		
	}
	
	
	// ------------------------------------------------------------------------	
	/**
	 * Listare sessiuni chat user
	 * @param unknown_type $username
	 * @param unknown_type $filters_str
	 * @param unknown_type $order_by
	 * @param unknown_type $order_type
	 * @param unknown_type $page_nr
	 * @author Baidoc
	 */
	function sessions($username = FALSE,$order_by = 'id', $order_type = 'asc', $page_nr = '0') {
		
		if( ! $username ){
			redirect('users');			
		}
		
		$user = $this->users->get_all(array('username'=>$username));
		
		if( sizeof($user) == 0 ){
			redirect('users');
		}
		
		$user = $user[0];
		
		$this->load->model('watchers_old');
		$this->load->helper('credits');
		$filters = FALSE;


		$filters['user_id'] = $user->id;
		
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('users/sessions/'.$username.'/'.$order_by.'/'.$order_type.'/');
		$config['uri_segment'] 	= 6;
		$config['total_rows']   = $this->watchers_old->get_all($filters, TRUE);
		$config['per_page']		= 20;
		
		$this->admin_pagination->initialize($config);
		
		$data['user']							= $user;
		$data['pagination']     				= $this->admin_pagination->create_links();
		$data['sessions']						= $this->watchers_old->get_all($filters, FALSE, $order_by.' '.$order_type, $this->uri->segment(6), $config['per_page']);
		$data['order_by'] 						= $order_by;
		$data['order_type'] 					= $order_type;
		$data['filters_array']					= $filters;
		$data['page']	= 'user_sessions';
		$data['breadcrumb'][lang('Users')]	= site_url('users');
		$data['breadcrumb'][lang('Sessions')]	= 'current';
		$data['page_head_title']			= lang('User sessions'); 
		
		$this->load->view('template', $data);
	}
	
	
	// ------------------------------------------------------------------------
	/**
	 * Listare plati user
	 * @param unknown_type $username
	 * @param unknown_type $filters_str
	 * @param unknown_type $order_by
	 * @param unknown_type $order_type
	 * @param unknown_type $page_nr
	 * @author Baidoc
	 */
	function payments($username = FALSE, $order_by = 'id', $order_type = 'asc', $page_nr = '0') {
		
		if( ! $username ){
			redirect('users');			
		}
		
		$user = $this->users->get_all(array('username'=>$username));
		
		if( sizeof($user) == 0 ){
			redirect('users');
		}
		
		$user = $user[0];
		
		$this->load->model('credits');
		$this->load->helper('credits');
		$filters = FALSE;

		$filters['user_id'] = $user->id;
		
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('users/payments/'.$username.'/'.$order_by.'/'.$order_type.'/');;
		$config['uri_segment'] 	= 6;
		$config['total_rows']   = $this->credits->get_all($filters, TRUE);
		$config['per_page']		= 20;
		
		$this->admin_pagination->initialize($config);
		
		$data['user']							= $user;
		$data['pagination']     				= $this->admin_pagination->create_links();
		$data['payments']						= $this->credits->get_all($filters, FALSE, $order_by.' '.$order_type, $this->uri->segment(6), $config['per_page']);
		$data['order_by'] 						= $order_by;
		$data['order_type'] 					= $order_type;
		$data['filters_array']					= $filters;
		$data['page']							= 'user_payments';
		$data['breadcrumb'][lang('Users')]		= site_url('users');
		$data['breadcrumb'][lang('Payments')]	= 'current';
		$data['page_head_title']				= lang('User payments'); 
		
		$this->load->view('template', $data);
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * Sterge user 
	 * @param unknown_type $id
	 * @author Baidoc
	 */
	function delete($id = FALSE) {
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		
		if($id <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid id!')));
			redirect($referer);
		}
		
		if($this->users->get_all(array('id' => $id), TRUE) != 1){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('This user does not exist!')));
			redirect($referer);
		}
		
		$rows['id'] = $id;
		$rows['status'] = 'rejected';
		
		if($this->users->save($rows)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('User account was successfully deleted!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'user', 
            			$id, 
            			'delete_account', 
            			'Admin deleted user account.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		}else{
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('User account cannt be deleted! Please try again!')));
		}
		
		redirect($referer);
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * Adauga credite
	 */
	function add_credits() {
		$this->load->library('user_agent');
		$this->load->model('credits');
		$referer = $this->agent->referrer();
		
		$this->form_validation->set_rules('amount', 	lang('amount'), 	'trim|required|numeric|min_length[1]|max_length[5]');
		
		if( $this->form_validation->run() == FALSE )  {
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => validation_errors()));
			redirect($referer);
			
		} else {
			$amount = $this->input->post('amount');
			$user_id = $this->input->post('id');

			$this->db->trans_begin();
				
			$this->users->add_credits($user_id,$amount);
			
			$this->load->model('credits');
			$data = array(
				'amount_paid'		=> 0,
				'currency_paid'		=> SETTINGS_REAL_CURRENCY_NAME,
				'amount_received'	=> $amount,
				'currency_received'	=> 'chips',
				'date'				=> time(),
				'type'				=> 'bonus',
				'status'			=> 'approved',  
				'user_id'			=> $user_id
			);
			$credit_id = $this->credits->save($data);
									
			$this->load->model('credits_detail');
			$data = array(
							'credit_id'		=> $credit_id
			);
			$this->credits_detail->save($data);
			
			$this->system_log->add(
            	'admin', 
            	$this->user->id,
            	'user', 
            	$user_id, 
            	($this->input->post('amount') > 0)?'add_credits':'remove_credits', 
            	$amount .' credits',
            	time(), 
            	ip2long($this->input->ip_address())
			);
			
			if($this->db->trans_status() === FALSE){
			
				$this->db->trans_rollback();
				$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('An error occured')));
			
				//redirectionez pe pagina de unde a venit
				redirect($referer);
			}
			
			$this->db->trans_commit();			
						
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Credits updated succesfully!')));
			redirect($referer);
		}
	}
	
}