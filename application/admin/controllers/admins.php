<?php
class Admins_controller extends MY_Admin {
	
	function __construct() {
		parent::__construct();
		$this->load->model('admins');
		$this->load->library('form_validation');
		$this->load->helper('filters');
		$this->load->helper('utils');		
	}
	
	function index() {
		$filters	= purify_filters($this->input->get('filters'),'admins');
		$order		= purify_orders($this->input->get('orderby'),'admins');
		
		$data['order_by']	= $this->input->get('orderby');
						
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('admins/page/');
		$config['uri_segment'] 	= 3;
		$config['total_rows']   = $this->admins->get_all($filters, TRUE);
		$config['per_page']		= 20;
		$this->admin_pagination->initialize($config);
		$data['pagination']     = $this->admin_pagination->create_links();

		$data['admins']			= $this->admins->get_all($filters, FALSE, implode_order($order), $this->uri->segment(3), $config['per_page']);
		
		$data['page'] = 'admins';		
		$data['breadcrumb'][lang('Admins')]	= 'current';
		$data['page_head_title']		= lang('Admins'); 
		
		$this->load->view('template', $data);
	}
	
	function add_or_edit($id = 0){
		
		if($id > 0){
			$admin = $this->admins->get_by_id($id);
			$data['admin'] = $admin;
			
			$this->form_validation->set_rules('username', lang('username'), 'required|trim|min_length[3]|max_length[25]|alpha_dash|update_unique[admins.username.'.$admin->id.']|strip_tags|purify');
		}else{
			$this->form_validation->set_rules('username', lang('username'), 'required|trim|min_length[3]|max_length[25]|alpha_dash|Unique[admins.username]|strip_tags|purify');
		}
		
		$this->form_validation->set_rules('password', lang('password'), 'trim|min_length[3]|max_length[25]');
		
		if($this->form_validation->run() == FALSE){
			
			$data['breadcrumb'][lang('Admins')] = base_url().'admins';
			
			if($id > 0){
				$data['page_head_title'] = lang('Edit admin account');
				$data['breadcrumb'][lang('Edit admin account')] = 'current';
			}else{
				$data['page_head_title'] = lang('Add admin account');
				$data['breadcrumb'][lang('Add admin account')] = 'current';
			}
			
			$data['page'] = 'admins_add_or_edit';
			$this->load->view('template', $data);
			return;
		}
		
		
		if($id > 0){
			$rows['id']				= $admin->id;
		}
				
		//If password is not empty 
		if($this->input->post('password')){
			
			//If edit admin account, set id and hash
			if($id > 0){
				$hash				= $admin->hash;
				
			//Else, generate a new hash
			}else{
				$hash				= generate_hash('admins');
				$rows['hash']		= $hash;
			}
			
			//Encrypt password
			$salt				= $this->config->item('salt');
			$rows['password']	= hash('sha256',($salt . $hash . $this->input->post('password') ));
		
		}
		
		$rows['username'] = $this->input->post('username');
		
		
		if($this->admins->save($rows)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Admin account was saved successfully!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'admin', 
            			($id > 0) ? $id : NULL, 
            			($id > 0) ? 'edit_admin' : 'add_admin', 
            			($id > 0) ? 'Admin edited an admin account.' : 'Admin added a new admin account', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		}else{
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Admin account was not saved! Please try again!')));
		}
		
		redirect('admins');
		
	}
	
	function delete($id = FALSE){
		
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		
		if($id <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid id!')));
			redirect($referer);
		}
				
		if($this->admins->get_all(array('id' => $id), TRUE) != 1){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('This admin does not exist!')));
			redirect($referer);
		}
		
		if($this->admins->delete($id)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Admin account was successfully deleted!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'admin', 
            			$id, 
            			'delete_admin', 
            			'Admin deleted an admin account', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		}else{
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Admin account cannt be deleted! Please try again!')));
		}
		
		redirect($referer);
	}
	
}