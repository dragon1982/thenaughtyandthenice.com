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
 * @property Watchers $watchers
 */
class Statistics_controller extends MY_Admin {
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {		
		$this->load->model('watchers');
		$this->load->library('charts');
		
		if(strlen($this->input->post('start_date')) == 0){
			$start_date = strtotime('- 1 month', strtotime(date('Y-m-d 00:00:00')));
		}else{
			$start_date = strtotime($this->input->post('start_date').' 00:00:00');
		}
		
		if(strlen($this->input->post('end_date')) == 0){
			$end_date = strtotime(date('Y-m-d 23:59:59'));
		}else{
			$end_date = strtotime($this->input->post('end_date').' 23:59:59');
		}
		
		if($start_date > $end_date){
			$start_date = strtotime('- 1 month', strtotime(date('Y-m-d 00:00:00')));
			$end_date = strtotime(date('Y-m-d 23:59:59'));
		}
		
		if((($end_date - $start_date) / 86400 + 1) < 14){
			$end_date = $end_date + (7*24*3600); //7 days
			$start_date = $start_date - (7*24*3600); //7 days
		}
		
		$data['start_date'] = date('d-m-Y', $start_date);
		$data['end_date'] = date('d-m-Y', $end_date);
		
		
		$data['chart_watchers'] = $this->charts->get_chart_data('watchers', $start_date, $end_date,FALSE, FALSE);
		$data['chart_earnings'] = $this->charts->get_chart_data('earnings', $start_date, $end_date,FALSE, FALSE);
		$data['chart_totals'] = $this->charts->get_chart_data('totals',  $start_date, $end_date,FALSE, FALSE);
		$data['chart_registers'] = $this->charts->get_registers_chart_data($start_date, $end_date);
		$data['chart_affiliates'] = $this->charts->get_affiliates_chart_data($start_date, $end_date);
		$data['chart_payments'] = $this->charts->get_payments_chart_data($start_date, $end_date);
		$data['chart_transactions'] = $this->charts->get_credits_chart_data($start_date, $end_date);
		
		
		$data['page'] = 'statistics';
		
		$data['breadcrumb'][lang('Statistics')]	= 'current';
		$data['page_head_title']				= lang('Statistics'); 
		
		
		//printR($watchers, true);
		$this->load->view('template', $data);
	}
	
	
}