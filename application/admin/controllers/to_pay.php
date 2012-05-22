<?php
/**
 * @property Payments $payments
 * @property System_log $system_log
 */
class To_pay_controller extends MY_Admin {
	
	function __construct() {
		parent::__construct();
		$this->load->model('payments');
		$this->load->library('form_validation');
		$this->load->helper('generic_helper');
	}
	
	function index() {
		redirect(site_url('to_pay/studios'));
	}
	
	
	
	function performers($filters_str = 'filters', $order_by = 'id', $order_type = 'asc', $page_nr = '0'){
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
		
		$filters['join']['performers'] = 'id = performer_id, left';
		$filters['studio_id'] 		= 'IS NULL';
		$filters['performer_id'] 	= '> 0';
		if(!isset($filters['status'])){
			$filters['status'] 			= 'pending';
		}
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('to_pay/performers/'.$filters_str.'/'.$order_by.'/'.$order_type.'/');
		$config['uri_segment'] 	= 6;
		$config['total_rows']   = $this->payments->get_all($filters, TRUE);
		$config['per_page']		= 20;
		$this->admin_pagination->initialize($config);
		$data['pagination']     = $this->admin_pagination->create_links();
	
		
		
		$data['function']		= 'performers';
		$data['payments']		= $this->payments->get_all($filters, FALSE, $order_by.' '.$order_type, $this->uri->segment(6), $config['per_page']);
		if(is_array($data['payments'])){
			foreach($data['payments'] as $key => $payment){
				$data['payments'][$key]->payment_details = $this->payments->get_studio_payments($payment->payments_studio_id, $payment->payments_paid_date, 'pending');
			}
		}
		
		$data['order_by'] 			= $order_by;
		$data['order_type'] 		= $order_type;
		$data['filters']			= $filters_str;
		$data['filters_array']		= $filters;
		
		$data['page'] = 'payments';
		
		$data['breadcrumb'][lang('To Pay Performers')]	= 'current';
		$data['page_head_title']				= lang('To Pay Performers'); 
		$this->load->view('template', $data);
	}
	
	function studios($filters_str = 'filters', $order_by = 'id', $order_type = 'asc', $page_nr = '0'){
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
		
		$filters['join']['studios'] = 'id = studio_id, left';
		$filters['join']['performers'] = 'id = performer_id, left';
		$filters['studio_id'] = '> 0';
		$filters['performer_id'] = 'IS NULL';
		if(!isset($filters['status'])){
			$filters['status'] 			= 'pending';
		}
		
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('to_pay/studios/'.$filters_str.'/'.$order_by.'/'.$order_type.'/');
		$config['uri_segment'] 	= 6;
		$config['total_rows']   = $this->payments->get_all($filters, TRUE);
		$config['per_page']		= 20;
		$this->admin_pagination->initialize($config);
		$data['pagination']     = $this->admin_pagination->create_links();
	
		
		$data['function']		= 'studios';
		$data['payments']		= $this->payments->get_all($filters, FALSE, $order_by.' '.$order_type, $this->uri->segment(6), $config['per_page']);

		if(is_array($data['payments'])){
			foreach($data['payments'] as $key => $payment){
				$data['payments'][$key]->payment_details = $this->payments->get_studio_payments($payment->payments_studio_id, $payment->payments_paid_date, 'pending');
			}
		}
		
		
		$data['order_by'] 			= $order_by;
		$data['order_type'] 		= $order_type;
		$data['filters']			= $filters_str;
		$data['filters_array']		= $filters;
		
		$data['page'] = 'payments';
		
		$data['breadcrumb'][lang('To Pay Studios')]	= 'current';
		$data['page_head_title']				= lang('To Pay Studios'); 
		$this->load->view('template', $data);
	}
	
	function affiliates($filters_str = 'filters', $order_by = 'id', $order_type = 'asc', $page_nr = '0'){
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
		
		$filters['join']['affiliates'] = 'id = affiliate_id, left';
		$filters['affiliate_id'] = '> 0';
		if(!isset($filters['status'])){
			$filters['status'] 			= 'pending';
		}
		
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('to_pay/affiliates/'.$filters_str.'/'.$order_by.'/'.$order_type.'/');
		$config['uri_segment'] 	= 6;
		$config['total_rows']   = $this->payments->get_all($filters, TRUE);
		$config['per_page']		= 20;
		$this->admin_pagination->initialize($config);
		$data['pagination']     = $this->admin_pagination->create_links();
	
		$data['function']		= 'affiliates';
		$data['payments']		= $this->payments->get_all($filters, FALSE, $order_by.' '.$order_type, $this->uri->segment(6), $config['per_page']);		
		
		$data['order_by'] 			= $order_by;
		$data['order_type'] 		= $order_type;
		$data['filters']			= $filters_str;
		$data['filters_array']		= $filters;
		
		$data['page'] = 'payments';
		
		$data['breadcrumb'][lang('To Pay Affiliates')]	= 'current';
		$data['page_head_title']				= lang('To Pay Affiliates'); 
		$this->load->view('template', $data);
	}
	
	function update_status(){
		
		
		$payment_id = $this->input->post('id');
		$payment_status = $this->input->post('status');
		
		if($payment_id <= 0){
			die('error');
		}
		
		if($payment_status != 'pending' && $payment_status != 'paid' && $payment_status != 'rejected'){
			die('error');
		}
		
		$rows['id'] = $payment_id;
		$rows['status'] = $payment_status;
		
		$this->payments->save($rows);
		die('succes');
	}
	
	function payment_details($payment_id = FALSE){
	
		if($payment_id <= 0){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid payment!')));
			redirect();
		}
		
		if ( ! $payment = $this->payments->get_by_id($payment_id)){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid payment!')));
			redirect();
		}
	
		$this->load->model('performers');
		$performer = $this->performers->get_by_id($payment->performer_id);
		if( ! $performer ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid payment!')));
			redirect();				
		}

		
	
		$this->load->model('watchers');
	
		$filters['type']		= array('private','true_private','peek','nude','premium_video','photos','gift','admin_action');
		$filters['performer_id']= $payment->performer_id;
		$filters['start']		= $payment->from_date;
		$filters['stop']		= $payment->to_date;
	
		$group_by['type']		= TRUE;
		$data['summary']		= $this->watchers->get_multiple_summaries($filters,$group_by);
	
		$joins['performers'] 	= 'performers';
		$filters['start']		= date('Y-m-d',$payment->from_date);
		$filters['stop']		= date('Y-m-d',$payment->to_date);
		$data['watchers'] 		= $this->watchers->get_multiple_by_performer_id($payment->performer_id,FALSE, FALSE , $filters, $joins);
		$data['payment']		= $payment;
			
		$data['_payments_sidebar']		= FALSE;
		$data['_performer_menu']		= FALSE;
		$data['performer']				= $performer;
		$data['page'] 					= 'payment_summary';
		
		
		$data['breadcrumb'][lang('Payment Summary')]	= 'current';
		$data['page_head_title']						= lang('Payment Summary'); 
	
		$this->load->view('template', $data);
	}
	
}