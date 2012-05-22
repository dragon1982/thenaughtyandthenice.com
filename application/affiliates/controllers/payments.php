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
 * @property Payments $payments
 * @property Categories $categories
 * @property Ad_zones $ad_zones
 * @property Ad_traffic $ad_traffic
 */
Class Payments_controller extends MY_Affiliate {
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->load->helper('earnings_helper');
		$this->load->library('form_validation');
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * PErformer deafult page
	 * @return unknown_type
	 */
	function index($start = FALSE, $stop = FALSE){		
		$this->load->model('payments');
				
		$this->load->library('pagination');
		$config['base_url'] 	= site_url('payments/page/');	
		$config['total_rows'] 	= $this->payments->get_multiple_by_affiliate_id($this->user->id, FALSE, FALSE, TRUE);
		$config['per_page'] 	= 10;
		$config['uri_segment'] 	= 3;
		$this->pagination->initialize($config);

		$data['credits'] 	= $this->payments->get_multiple_by_affiliate_id($this->user->id, $this->pagination->per_page, (int)$this->uri->segment(3));
		$data['pagination']	= $this->pagination->create_links();
		
		$data['page'] 			= 'payments';
		$data['description'] 	= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 		= SETTINGS_SITE_KEYWORDS;
		$data['page_title']		= lang('Your payments').' - '.SETTINGS_SITE_TITLE;
		
		$this->load->view('template', $data);
	}
}