<?php
class Affiliates_controller extends MY_Admin {
	
	function __construct() {
		parent::__construct();
		$this->load->model('affiliates');
		$this->load->library('form_validation');
		$this->load->helper('filters');
		$this->load->helper('utils');
	}

	/**
	 * Listare affiliati
	 * @return unknown_type
	 */
	function index(){			
		$filters	= purify_filters($this->input->get('filters'),'affiliates');
		$order		= purify_orders($this->input->get('orderby'),'affiliates');
		
		$data['filters']	= array2url($filters,'filters');
		$data['order_by']	= $this->input->get('orderby');

		$filters['status'] = '!= rejected';

		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('affiliates/page/');
		$config['uri_segment'] 	= 3;
		$config['total_rows']   = $this->affiliates->get_all($filters, TRUE);
		$config['per_page']		= 20;
		$this->admin_pagination->initialize($config);
		$data['pagination']     = $this->admin_pagination->create_links();

		$data['affiliates']		= $this->affiliates->get_all($filters, FALSE, implode_order($order), $this->uri->segment(3), $config['per_page']);
		
		$data['page'] = 'affiliates';
		$data['breadcrumb'][lang('Affiliates')]	= 'current';
		$data['page_head_title']		= lang('Affiliates'); 
		
		$this->load->view('template', $data);
	}
	
	function account($username = FALSE){
		
		if(!$username){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This username is invalid')));
			redirect('affiliates');
		}
		
		$affiliate = $this->affiliates->get_all(array('username'=>$username));
		if( ! is_array($affiliate) || count($affiliate) <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This affiliate does not exist!')));
			redirect('affiliates');
		}
		
		$affiliate = $affiliate[0];
		$data['affiliate'] = $affiliate;
		$data['status'] = array(lang('Select Status'),		'approved'=>lang('approved'), 'pending'=>lang('pending'), 'rejected'=>lang('rejected'));
		$this->form_validation->set_rules('password',		lang('password'),		'trim|min_length[3]|max_length[25]');
		$this->form_validation->set_rules('site_name',		lang('site name'),	'trim|required');
		$this->form_validation->set_rules('site_url',		lang('site url'),		'trim|required|min_length[3]');
		$this->form_validation->set_rules('first_name',		lang('first name'),	'trim|required|min_length[3]');
		$this->form_validation->set_rules('last_name',		lang('last name'),	'trim|required|min_length[3]');
		$this->form_validation->set_rules('email',			lang('email'),		'trim|required|min_length[3]|valid_email');
		$this->form_validation->set_rules('phone',			lang('phone'),		'trim|required');
		
		if($this->form_validation->run() == FALSE){
			
			$data['breadcrumb'][lang('Affiliates')] = base_url().'affiliates';
			
			if($affiliate->id > 0){
				$data['page_head_title'] = $affiliate->username.' '.lang('account');
				$data['breadcrumb'][$affiliate->username.' '.lang('account')] = 'current';
			}
			
			$data['page'] = 'affiliate_edit';
			$this->load->view('template', $data);
			return;
		}
		
		
		if($affiliate->id > 0){
			$rows['id']			= $affiliate->id;
		}
				
		//If password is not empty 
		if($this->input->post('password')){
			
			$hash				= $affiliate->hash;
			//Encrypt password
			$salt				= $this->config->item('salt');
			$rows['password']	= hash('sha256',($salt . $hash . $this->input->post('password') ));
		
		}
		
		$rows['site_name'] = $this->input->post('site_name');
		$rows['site_url'] = $this->input->post('site_url');
		$rows['first_name'] = $this->input->post('first_name');
		$rows['last_name'] = $this->input->post('last_name');
		$rows['email'] = $this->input->post('email');
		$rows['phone'] = $this->input->post('phone');
		$rows['address'] = $this->input->post('address');
		$rows['city'] = $this->input->post('city');
		$rows['zip'] = $this->input->post('zip');
		$rows['state'] = $this->input->post('state');
		$rows['status'] = $this->input->post('status');
		
		
		if($this->affiliates->save($rows)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Affiliate account was saved successfully!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'affiliate', 
            			$affiliate->id, 
            			'edit_account', 
            			'Admin edited an affiliate account', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		} else {
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Affiliate account was not saved! Please try again!')));
		}
		redirect('affiliates');
		
	}
	
	function delete($id = FALSE){
		
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		
		if($id <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid id!')));
			redirect($referer);
		}
		
		if($this->affiliates->get_all(array('id' => $id), TRUE) != 1){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('This affiliate does not exist!')));
			redirect($referer);
		}
		
		$rows['id'] = $id;
		$rows['status'] = 'rejected';
		
		if($this->affiliates->save($rows)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Affiliate account was successfully deleted!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'affiliate', 
            			$id, 
            			'delete_account', 
            			'Admin deleted an affiliate account', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		}else{
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Affiliate account cannt be deleted! Please try again!')));
		}
		redirect($referer);
	}
	
	
	function signups($username = false, $filters_str = 'filters', $order_by = 'id', $order_type = 'asc', $page_nr = '0'){
		if( ! $username ){
			redirect('affiliates');			
		}
		
		$affiliate = $this->affiliates->get_all(array('username'=>$username));
		
		if( sizeof($affiliate) == 0 ){
			redirect('affiliates');
		}
		
		$affiliate = $affiliate[0];
		
		$this->load->model('users');
		
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
		
		$filters['join']['users_detail'] = 'user_id = id, left';
		$filters['users_detail.affiliate_id'] = $affiliate->id;
		
		
		
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('affiliates/signups/'.$username.'/'.$filters.'/'.$order_by.'/'.$order_type.'/');;
		$config['uri_segment'] 	= 7;
		$config['total_rows']   = $this->users->get_all($filters, TRUE);
		$config['per_page']		= 20;
		
		$this->admin_pagination->initialize($config);
		
		$data['affiliate']						= $affiliate;
		$data['pagination']     				= $this->admin_pagination->create_links();
		$data['users']						= $this->users->get_all($filters, FALSE, $order_by.' '.$order_type, $this->uri->segment(5), $config['per_page']);
		$data['order_by'] 						= $order_by;
		$data['order_type'] 					= $order_type;
		$data['filters']						= $filters_str;
		$data['filters_array']					= $filters;
		$data['page']							= 'affiliate_signups';
		$data['breadcrumb'][lang('Affiliates')]	= site_url('affiliates');
		$data['breadcrumb'][lang('Signups')]	= 'current';
		$data['page_head_title']			= lang('Affiliate signups'); 
		
		$this->load->view('template', $data);
	}
	
	function traffic($username = false, $start_date = FALSE, $end_date = FALSE){
		if( ! $username ){
			redirect('affiliates');			
		}
		
		$affiliate = $this->affiliates->get_all(array('username'=>$username));
		
		if( sizeof($affiliate) == 0 ){
			redirect('affiliates');
		}
		
		$affiliate = $affiliate[0];
		
		$this->load->helper('credits');
		$this->load->model('ad_traffic');
		
		if(!$start_date){
			$start_date = strtotime(date('Y-m-d 00:00:00', time()-60*60*24*30));
		}else{
			$start_date = strtotime($start_date);
		}
		
		if(!$end_date){
			$end_date = strtotime(date('Y-m-d 23:59:59'));
		}else{
			 $end_date = strtotime($end_date);
		}
		
		$data['affiliate']	= $affiliate;
		$traffic			= $this->ad_traffic->get_by_affiliate_id($affiliate->id, $start_date, $end_date);
		$ad_zones			= '';
		
		if(is_array($traffic) && count($traffic) > 0){
			foreach($traffic as $row){
				$action = $row->action ;
				
				$ad_zones[$row->ad_id]->$action = $row->actions;
				$ad_zones[$row->ad_id]->earnings += $row->earning;
				$ad_zones[$row->ad_id]->name = ($row->name != '') ? $row->name : lang('Direct link');
			}
		}
		$data['start_date']						= $start_date;
		$data['end_date']						= $end_date;
		$data['ad_zones']						= $ad_zones;
		$data['page']							= 'affiliate_traffic';
		$data['breadcrumb'][lang('Affiliates')]	= site_url('affiliates');
		$data['breadcrumb'][lang('Traffic')]	= 'current';
		$data['page_head_title']			= lang('Affiliate traffic'); 
		
		$this->load->view('template', $data);
	}
	
	
	function payments($username = FALSE, $filters_str = 'filters', $order_by = 'id', $order_type = 'asc', $page_nr = '0') {
		
		if( ! $username ){
			redirect('affiliates');			
		}
		
		$affiliate = $this->affiliates->get_all(array('username'=>$username));
		
		if( sizeof($affiliate) == 0 ){
			redirect('affiliates');
		}
		
		$affiliate = $affiliate[0];
		
		$this->load->model('payments');
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

		$filters['affiliate_id'] = $affiliate->id;
		
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('affiliates/payments/'.$username.'/'.$filters.'/'.$order_by.'/'.$order_type.'/');;
		$config['uri_segment'] 	= 7;
		$config['total_rows']   = $this->payments->get_all($filters, TRUE);
		$config['per_page']		= 20;
		
		$this->admin_pagination->initialize($config);
		
		$data['affiliate']						= $affiliate;
		$data['pagination']     				= $this->admin_pagination->create_links();
		$data['payments']						= $this->payments->get_all($filters, FALSE, $order_by.' '.$order_type, $this->uri->segment(5), $config['per_page']);
		$data['order_by'] 						= $order_by;
		$data['order_type'] 					= $order_type;
		$data['filters']						= $filters_str;
		$data['filters_array']					= $filters;
		$data['page']							= 'affiliate_payments';
		$data['breadcrumb'][lang('Affiliates')]	= site_url('affiliates');
		$data['breadcrumb'][lang('Payments')]	= 'current';
		$data['page_head_title']			= lang('Affiliate payments'); 
		
		$this->load->view('template', $data);
	}
	
	
	
	function ads($username = FALSE, $filters_str = 'filters', $order_by = 'id', $order_type = 'asc', $page_nr = '0') {
		
		if( ! $username ){
			redirect('affiliates');			
		}
		
		$affiliate = $this->affiliates->get_all(array('username'=>$username));
		
		if( sizeof($affiliate) == 0 ){
			redirect('affiliates');
		}
		
		$affiliate = $affiliate[0];
		
		$this->load->model('ad_zones');
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

		$filters['affiliate_id'] = $affiliate->id;
		
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('affiliates/payments/'.$username.'/'.$filters.'/'.$order_by.'/'.$order_type.'/');;
		$config['uri_segment'] 	= 7;
		$config['total_rows']   = $this->ad_zones->get_all($filters, TRUE);
		$config['per_page']		= 20;
		
		$this->admin_pagination->initialize($config);
		
		$data['affiliate']						= $affiliate;
		$data['pagination']     				= $this->admin_pagination->create_links();
		$data['ad_zones']						= $this->ad_zones->get_all($filters, FALSE, $order_by.' '.$order_type, $this->uri->segment(5), $config['per_page']);
		$data['order_by'] 						= $order_by;
		$data['order_type'] 					= $order_type;
		$data['filters']						= $filters_str;
		$data['filters_array']					= $filters;
		$data['page']							= 'affiliate_ad_zones';
		$data['breadcrumb'][lang('Affiliates')]	= site_url('affiliates');
		$data['breadcrumb'][lang('Ads')]	= 'current';
		$data['page_head_title']			= lang('Affiliate ads'); 
		
		$this->load->view('template', $data);
	}
	
}