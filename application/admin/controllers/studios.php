<?php
class Studios_controller extends MY_Admin {
	
	// ------------------------------------------------------------------------
	/**
	 * Constructor
	 * @author Baidoc
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('studios');
		$this->load->library('form_validation');
		$this->load->helper('filters');
		$this->load->helper('utils');
	}
	
	// ------------------------------------------------------------------------
	/**
	 * Listare studiouri filtrate
	 * @author Baidoc
	 */
	function index() {
		
		$filters	= purify_filters($this->input->get('filters'),'studios');
		$order		= purify_orders($this->input->get('orderby'),'studios');

		$data['filters']	= array2url($filters,'filters');
		$data['order_by']	= $this->input->get('orderby');
		
		$filters['status'] = '!= rejected';
		$this->load->library('admin_pagination');
		$this->load->model('status');
		
		$config['base_url']     = site_url('studios/page/');
		$config['uri_segment'] 	= 3;
		$config['total_rows']   = $this->studios->get_all($filters, TRUE);
		$config['per_page']		= 20;
		
		$this->admin_pagination->initialize($config);
		
		$data['pagination']     				= $this->admin_pagination->create_links();
		$data['studios']						= $this->studios->get_all($filters, FALSE, implode_order($order), $this->uri->segment(3), $config['per_page']);
		
		$data['page'] 							= 'studios';
		$data['breadcrumb'][lang('Studios')]	= 'current';
		$data['page_head_title']				= lang('Studios');
		
		$this->load->view('template', $data);
	}
	
	// ------------------------------------------------------------------------
	/**
	 * Editare/vizualizare cont studio
	 * @param unknown_type $username
	 * @author Baidoc
	 */
	function account($username = 0){
		
		if(strlen($username) == 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This username is invalid')));
		}
		
		$studio = $this->studios->get_all(array('username'=>$username));
		if(!is_array($studio) || count($studio) <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This studio does not exist!')));
		}
		
		$studio = $studio[0];
		$data['studio'] = $studio;
		$data['status'] = array(lang('Select Status'), 'approved'=>lang('approved'), 'pending'=>lang('pending'), 'rejected'=>lang('rejected'));
		$this->form_validation->set_rules('password', 		lang('password'), 		'trim|min_length[3]|max_length[25]');
		$this->form_validation->set_rules('email',			lang('email'),			'trim|required|valid_email|purify|min_length[3]|max_length[60]');
		$this->form_validation->set_rules('first_name', 	lang('firstname'), 		'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('last_name', 		lang('lastname'),		'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('address', 		lang('address'), 		'trim|required|strip_tags|purify|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('city', 			lang('city'), 			'trim|required|strip_tags|purify|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('zip', 			lang('zip'), 			'trim|required|strip_tags|purify|min_length[3]|max_length[10]');
		$this->form_validation->set_rules('state', 			lang('state'), 			'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('phone', 			lang('phone'), 			'trim|required|strip_tags|purify|numeric|min_length[8]|max_length[16]');
		$this->form_validation->set_rules('percentage', 	lang('percentage'), 	'trim|required|purify|numeric|min_length[1]|max_length[2]');
		
		if($this->form_validation->run() == FALSE){
			
			$data['breadcrumb'][lang('Studios')] = base_url().'studios';
			
			if($studio->id > 0){
				$data['page_head_title'] = $studio->username . '\'s ' . lang('account');
				$data['breadcrumb'][$studio->username . '\'s '.  lang('account')] = 'current';
			}
			
			$data['page'] = 'studios_edit';
			$this->load->view('template', $data);
			return;
		}
			
		if($studio->id > 0){
			$rows['id']			= $studio->id;
		}
				
		//If password is not empty 
		if($this->input->post('password')){
			
			//If edit studio account, set id and hash
			if($studio->id > 0){
				$hash				= $studio->hash;
				
			//Else, generate a new hash
			} else {
				$hash				= generate_hash('studio');
				$rows['hash']		= $hash;
			}
			
			//Encrypt password
			$salt					= $this->config->item('salt');
			$rows['password']		= hash('sha256',($salt . $hash . $this->input->post('password') ));
		
		}
		
		$rows['email'] 				= $this->input->post('email');
		$rows['first_name'] 		= $this->input->post('first_name');
		$rows['last_name'] 			= $this->input->post('last_name');
		$rows['address']			= $this->input->post('address');
		$rows['city'] 				= $this->input->post('city');
		$rows['zip'] 				= $this->input->post('zip');
		$rows['state'] 				= $this->input->post('state');
		$rows['phone'] 				= $this->input->post('phone');
		$rows['percentage'] 		= $this->input->post('percentage');
		$rows['contract_status'] 	= $this->input->post('contract_status');
		$rows['status'] 			= $this->input->post('status');
		
		
		if($this->studios->save($rows)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Studio account was saved successfully!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'studio', 
            			$studio->id, 
            			'edit_account', 
            			'Admin edited studio account.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		} else {
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Studio account was not saved! Please try again!')));
		}
		
		redirect('studios/account/' . $studio->username);
	}
	
	// ------------------------------------------------------------------------
	/**
	 * Schimba statusul contractului unui studio
	 * @param $change_to - in ce dorim sa schimbam statusul
	 * @param $status_id - ID-ul statusului care dorim sa-l schimbam
	 * @return unknown_type
	 */
	function update_status($change_to, $status_id, $studio_id) {
		
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		$this->load->model('status');

		$this->status->set_status('contracts', $change_to, $status_id);
		
		//Verific care este statusul contractului unui studio si modific si statusul din tabela studios
		if($this->status->verify_status('contracts', 'approved', $studio_id, TRUE)) {
			$this->studios->update_studio_status($studio_id, 'contract_status', 'approved');
			//$this->studios->update_studio_status($studio_id, 'status', 'approved');
		} else if($this->status->verify_status('contracts', 'pending', $studio_id, TRUE)) {
			$this->studios->update_studio_status($studio_id, 'status', 'pending');
			//$this->studios->update_studio_status($studio_id, 'contract_status', 'pending');
		} else {
			$this->studios->update_studio_status($studio_id, 'contract_status', 'rejected');
			//$this->studios->update_studio_status($studio_id, 'status', 'rejected');
		}
		
		
		$email_content = $this->load->view('emails/studio_contracts_'.$change_to.'_'.$this->config->item('lang_selected'),array(),TRUE);
		$template		= 'admin_studio_contracts_'.$change_to;
		
		$studio = $this->studios->get_by_id($studio_id);
		
		$this->load->helper('emails');
			
		$replaced_variables = get_avaiable_variabiles($template, TRUE);
		$replace_value = array($studio->username, $studio->email, $studio->first_name, $studio->last_name, main_url(), WEBSITE_NAME,  main_url('studio/login') );

		$email_content = preg_replace($replaced_variables, $replace_value, $email_content);

		$email_subject = sprintf(lang('Your contract was %s'), $change_to);

		//activation email
		$this->load->library('email');
		$this->email->from(SUPPORT_EMAIL,SUPPORT_NAME);
		$this->email->to($studio->email);
		$this->email->subject($email_subject);
		$this->email->message($email_content);
		$this->email->send();
			
		$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'studio', 
            			$studio_id, 
            			'contracts_status', 
						'Admin changed studios\'s contract status '.$status_id . ' to '.$change_to, 
            			time(), 
            			ip2long($this->input->ip_address())
		);
		redirect($referer);
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * Vizualizeaza contractul unui studio
	 * @param unknown_type $studio_id
	 * @author Baidoc
	 */
	function contract_status($studio_id = FALSE) {
		
		$this->output->enable_profiler(FALSE);
		
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		
		if($studio_id <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid id!')));
			redirect('studios');
		}
		
		if($this->studios->get_all(array('id' => $studio_id), TRUE) != 1){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('This studio does not exist!')));
			redirect($referer);
		}
		
				
		$this->load->model('status');
		$this->load->library('pagination');
		
		$data['page'] = 'studio_status/contract_status';
		$data['title'] = lang('Contract Status');
		
		$config['base_url'] 	= site_url('/studios/contract_status/' . $studio_id . '/page/');	
		$config['total_rows'] 	= $this->status->get_all_by_studio_id($studio_id, FALSE, FALSE, TRUE);
		$config['per_page'] 	= 5;
		$config['uri_segment'] 	= 5;
		$this->pagination->initialize($config);
		$data['pagination']		= $this->pagination->create_links();
		$data['contracts'] 		= $this->status->get_all_by_studio_id($studio_id, $this->pagination->per_page, (int)$this->uri->segment(5));
		$data['studio'] 		= $this->studios->get_by_id($studio_id);
		
		$this->load->view('studio_status/template', $data);
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * Sterge un studio
	 * @TODO: nu poate sterge doar sal puna pe rejected
	 * @param unknown_type $id
	 * @author Baidoc
	 */
	function delete($id = FALSE){
		
		$this->load->library('user_agent');
		
		$referer = $this->agent->referrer();
		
		if($id <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid id!')));
			redirect($referer);
		}
		
		if($this->studios->get_all(array('id' => $id), TRUE) != 1){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('This studio does not exist!')));
			redirect($referer);
		}
		
		
		$rows['id'] = $id;
		$rows['status'] = 'rejected';
		
		if($this->studios->save($rows)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Studio account was successfully deleted!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'studio', 
            			$id, 
            			'delete_account', 
            			'Admin deleted studio account.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		}else{
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Studio account cannot be deleted! Please try again!')));
		}
		
		redirect($referer);
	}
	
	// ------------------------------------------------------------------------
	/**
	 * Listare performer
	 * @param unknown_type $username
	 * @param unknown_type $filters_str
	 * @param unknown_type $order_by
	 * @param unknown_type $order_type
	 * @param unknown_type $page_nr
	 * @author Baidoc
	 */
	function performers($username = FALSE, $filters_str = 'filters', $order_by = 'id', $order_type = 'asc', $page_nr = '0'){
		if( ! $username ){
			redirect('studios');			
		}
		
		$studio = $this->studios->get_all(array('username'=>$username));
		
		if( sizeof($studio) == 0 ){
			redirect('studios');
		}
		
		$studio = $studio[0];
		
		$this->load->model('performers');
		$this->load->helper('credits');
		$filters = FALSE;

		if($filters_str && $filters_str != 'filters'){
			$filtersElements = explode('&', $filters_str);
			if(is_array($filtersElements)){
				foreach($filtersElements as $element){
					$conditionAndValue = explode(':', $element);
					if(count($conditionAndValue) > 1){
						$value = preg_replace('/('.$conditionAndValue[0].':)/', '', $element);
						$filters[$conditionAndValue[0]] = $value;
					}
				}
			}
		}

		$filters['studio_id'] = $studio->id;
		
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('studios/payments/'.$username.'/'.$filters.'/'.$order_by.'/'.$order_type.'/');;
		$config['uri_segment'] 	= 7;
		$config['total_rows']   = $this->performers->get_all($filters, TRUE);
		$config['per_page']		= 20;
		
		$this->admin_pagination->initialize($config);
		
		$data['studio']							= $studio;
		$data['pagination']     				= $this->admin_pagination->create_links();
		$data['performers']						= $this->performers->get_all($filters, FALSE, $order_by.' '.$order_type, $this->uri->segment(5), $config['per_page']);
		$data['order_by'] 						= $order_by;
		$data['order_type'] 					= $order_type;
		$data['filters']						= $filters_str;
		$data['filters_array']					= $filters;
		$data['page']							= 'studio_performers';
		$data['breadcrumb'][lang('Studio')]	= site_url('studios');
		$data['breadcrumb'][lang('Payments')]	= 'current';
		$data['page_head_title']			= lang('Studio payments'); 
		
		$this->load->view('template', $data);		
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * Listeaza platile unui studio
	 * @param unknown_type $username
	 * @param unknown_type $filters_str
	 * @param unknown_type $order_by
	 * @param unknown_type $order_type
	 * @param unknown_type $page_nr
	 * @author Baidoc
	 */
	function payments($username = FALSE,  $order_by = 'id', $order_type = 'asc', $page_nr = '0') {
		
		if( ! $username ){
			redirect('studios');			
		}
		
		$studio = $this->studios->get_all(array('username'=>$username));
		
		if( sizeof($studio) == 0 ){
			redirect('studios');
		}
		
		$studio = $studio[0];
		
		$this->load->model('payments');
		$this->load->helper('credits');
		$filters = FALSE;

		$filters['studio_id'] = $studio->id;
		$filters['performer_id'] = 'IS NULL';
		
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('studios/payments/'.$username.'/'.$order_by.'/'.$order_type.'/');;
		$config['uri_segment'] 	= 6;
		$config['total_rows']   = $this->payments->get_all($filters, TRUE);
		$config['per_page']		= 20;
		
		$this->admin_pagination->initialize($config);
		
		$data['studio']							= $studio;
		$data['pagination']     				= $this->admin_pagination->create_links();
		$data['payments']						= $this->payments->get_all($filters, FALSE, $order_by.' '.$order_type, $this->uri->segment(6), $config['per_page']);
		$data['order_by'] 						= $order_by;
		$data['order_type'] 					= $order_type;
		$data['filters_array']					= $filters;
		$data['page']							= 'studio_payments';
		$data['breadcrumb'][lang('Studios')]	= site_url('studios');
		$data['breadcrumb'][lang('Payments')]	= 'current';
		$data['page_head_title']				= lang('Studio payments'); 
		
		
		foreach($data['payments'] as $payment){
			$data['performer_payments'][$payment->id] = $this->payments->get_studio_payments($studio->id,$payment->paid_date);
		}
				
		$this->load->view('template', $data);
	}
	
	
	/**
	* Adauga credite la un performer
	* @author Baidoc
	*/
	function add_credits() {
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		$this->load->model('watchers_old');
	
		$this->form_validation->set_rules('amount', 	lang('amount'), 	'trim|required|purify|numeric|min_length[1]');
		$this->form_validation->set_rules('id',			lang('Studio ID'), 	'trim|required');
		if( $this->form_validation->run() == FALSE )  {
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => validation_errors()));
			redirect($referer);
				
		} else {
			$amount 	= $this->input->post('amount');
			$studio_id 	= $this->input->post('id');
			$studio 	= $this->studio->get_by_id($studio_id);
				
			$this->db->trans_begin();
				
			$this->studios->add_credits($studio_id, $amount);
				
			$this->load->model('watchers');
			$data = array(
					'start_date'		=> time(),
					'end_date'			=> time(),
					'show_is_over'		=> 1,
					'type'				=> 'admin_action',
					'studio_chips'		=> $amount,
					'studio_id'			=> $studio_id,
					'unique_id'			=> $this->watchers->generate_one_unique_id() 			
			);
			$this->watchers_old->save($data);
	
			$this->system_log->add(
	       		'admin', 
				$this->user->id,
	            'studio', 
				$studio_id,
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