<?php
/**
* @property CI_Loader $load
* @property System_logs $system_logs
*/
class System_logs_controller extends MY_Admin{
	
	/**
	 * Constructor
	 * @author Baidoc
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('system_log');
		$this->load->helper('filters');
		$this->load->helper('utils');		
	}
	
	/**
	 * Listare system logs
	 * @author Baidoc
	 */
	function index(){	
		$filters	= purify_filters($this->input->get('filters'),'system_logs');
		$order		= purify_orders($this->input->get('orderby'),'system_logs');
				
		$data['filters']	= array2url($filters,'filters');
		$data['order_by']	= $this->input->get('orderby');

		//verific daca are filtru pe data in acest caz trebuie sa fol between
		if( isset($filters['date']) ){
			if(strtotime($filters['date']) == 0){
				unset($filters['date']);
			} else {
				$selected_date = strtotime($filters['date']);
				$filters['date'] = array(
					'BETWEEN'=> array($selected_date,strtotime('+1 day',$selected_date))
				);
			}
		}
		
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('system_logs/page/');
		$config['uri_segment'] 	= 3;
		$config['total_rows']   = $this->system_log->get_all($filters, TRUE);
		$config['per_page']		= 20;
		$this->admin_pagination->initialize($config);
		$data['pagination']     = $this->admin_pagination->create_links();
		
		$data['system_logs']	= $this->system_log->get_all($filters, FALSE,implode_order($order), $this->uri->segment(3), $config['per_page']);
		$data['actor']			= prepare_dropdown($this->system_log->get_enum_values('actor'), lang('Select Actor'));
		$data['action_on']		= prepare_dropdown($this->system_log->get_enum_values('action_on'), lang('Select Action on'));
		$data['action']			= prepare_dropdown($this->system_log->get_enum_values('action'), lang('Select Action'));
		
		$this->load->library('ip2location');		
		$data['page'] = 'system_logs/index';		
		$data['breadcrumb'][lang('System logs')]	= 'current';
		$data['page_head_title']		= lang('System logs');
		
		$this->load->view('template', $data);
	}
	
} 