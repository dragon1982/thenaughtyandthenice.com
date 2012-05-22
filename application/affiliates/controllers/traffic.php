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
 * @property Users $users
 * @property Performers $performers
 * @property Watchers $watchers
 * @property Credits $credits
 * @property Categories $categories
 * @property Ad_zones $ad_zones
 * @property Ad_traffic $ad_traffic
 */
Class Traffic_controller extends MY_Affiliate {
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('affiliates');
		$this->load->model('ad_zones');
		$this->load->model('ad_traffic');
		$this->load->library('form_validation');
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * PErformer deafult page
	 * @return unknown_type
	 */
	function index($start_date = FALSE, $end_date = FALSE){		
		//$this->output->enable_profiler();
		
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
		
		
		$this->load->helper('credits');
		
		$traffic  = $this->ad_traffic->get_by_affiliate_id($this->user->id, $start_date, $end_date);
		
		$ad_zones = array();
		
		if(is_array($traffic) && count($traffic) > 0){
			foreach($traffic as $row){
				$action = $row->action ;
				
				$ad_zones[$row->ad_id]->$action = $row->actions;
				$ad_zones[$row->ad_id]->earnings += $row->earning;
				$ad_zones[$row->ad_id]->name = ($row->name != '') ? $row->name : lang('Direct link');
			}
		}
		
		
		$data['start']					= $start_date;
		$data['end']					= $end_date;
		
		
		$data['ad_zones']				= $ad_zones;
		$data['page']					= 'ad_traffic';
		$data['description']			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords']				= SETTINGS_SITE_KEYWORDS;
		$data['page_title']				= lang('Your ad zones traffic').' - '.SETTINGS_SITE_TITLE;

		$this->load->view('template', $data);
		return;
	}
}