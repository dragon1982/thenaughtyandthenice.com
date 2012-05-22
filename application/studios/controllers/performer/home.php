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
 * @property Payments $payments
 * @property Studios $studios
 */
Class Home_controller extends MY_Studio_Edit{
	
	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('performers');
		$this->load->model('messages');		
	}
	
	/**
	 * Studio editeaza un performer
	 */
	function index(){		
		$this->load->helper('chart');	
		$data['_categories']	= TRUE;
		$data['_sidebar']		= FALSE;
		$data['_signup_header']	= TRUE;
		$data['page'] 			= 'performerMyAccount';
		$data['description'] 	= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 		= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 		= $this->performer->nickname.'\'s '.lang('account').' - '.SETTINGS_SITE_TITLE;
		$this->performer->unread_messages = $data['unread_number'] = $this->messages->get_all_received_by_user_id($this->user->id, $this->user->type, FALSE, FALSE, TRUE, TRUE);
		$data['performer']		= $this->performer;
		
		$this->load->model('watchers');
		$data['video_access']	= $this->watchers->count_chat_access($this->performer->id);

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
			$start_date = strtotime('- 1 month', strtotime(date('Y-m-d')));
			$end_date = strtotime(date('Y-m-d 23:59:59'));
		}
		if((($end_date - $start_date) / 86400 + 1) < 14){
			$end_date = $end_date + (7*24*3600); //7 days
			$start_date = $start_date - (7*24*3600); //7 days
		}
		
		
		$data['start_date'] = date('d-m-Y', $start_date);
		$data['end_date'] = date('d-m-Y', $end_date);
		
		
		$this->load->library('charts');
		
		$data['chart_watchers'] = $this->charts->get_chart_data('watchers', $start_date, $end_date, $this->performer->id);
		$data['chart_earnings'] = $this->charts->get_chart_data('earnings', $start_date, $end_date, $this->performer->id);
		$data['chart_totals'] = $this->charts->get_chart_data('totals', $start_date, $end_date, $this->performer->id);
		
		
		$this->load->view('template', $data);	
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Afiseaza castigurile pentru un performer cu filtre pe data (interval)
	 * @param $start
	 * @param $stop
	 * @return unknown_type
	 */
	function earnings($start = FALSE, $stop = FALSE){
		$this->load->helper('earnings');
		$this->load->model('watchers');
		$filters = array();

		$options = make_interval_time(mktime(0,0,0,date('m',$this->performer->register_date),1,date('Y',$this->performer->register_date)));
		
		if( $start ){
			$filters['start'] 	= $start;
			$filters['stop']	= $stop;
		} else {
			end($options);
			list($filters['start'],$filters['stop']) 	= explode('~',key($options));
		}
				
		if( ! isset ( $options[$filters['start'] . '~' . $filters['stop']])){	
			redirect('performer/my_earnings');						
		}
			
		$data['options'] 		= $options;
		$data['start_date'] 	= $filters['start'];
		$data['stop_date']		= $filters['stop'];
		$_POST['paymentDates'] 	= $filters['start'] . '~' . $filters['stop'];
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('paymentDates', lang('paymentDates'),'trim|required');
		$this->form_validation->run();
		$joins['performers'] = 'performers';
				
		$config['base_url'] 	= site_url('performer/my_earnings/'.$filters['start'].'/'.$filters['stop'].'/page/');	
		$config['total_rows'] 	= $this->watchers->get_multiple_by_performer_id($this->performer->id, FALSE, FALSE, $filters, $joins, TRUE);
		$config['per_page'] 	= 20;
		$config['uri_segment'] 	= 6;
		$this->pagination->initialize($config);

		$data['watchers'] 	= $this->watchers->get_multiple_by_performer_id($this->performer->id, $this->pagination->per_page, (int)$this->uri->segment(6), $filters, $joins);
		$data['number']		= $config['total_rows'];
		$data['pagination']	= $this->pagination->create_links();
		
		$data['_payments_sidebar']		= TRUE;
		$data['_performer_menu']		= TRUE;
		$data['page'] 					= 'performers/my_earnings';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= $this->performer->nickname.'\'s '.lang('earnings').' - '.SETTINGS_SITE_TITLE;
		
		$this->load->view('template', $data);		
	}
			
	// -----------------------------------------------------------------------------------------	
	/**
	 * Afiseaza  castigurile pentur un performer dupa data (interval)
	 * @param $start
	 * @param $stop
	 * @return unknown_type
	 */
	function payments($start = FALSE, $stop = FALSE){
		$this->load->model('payments');
		
		$this->load->library('pagination');
		$config['base_url'] 	= site_url('performer/my_payments/page/');
		$config['total_rows'] 	= $this->payments->get_multiple_by_performer_id($this->performer->id, FALSE, FALSE, FALSE, TRUE);
		$config['per_page'] 	= 10;
		$config['uri_segment'] 	= 4;
		$this->pagination->initialize($config);
		
		$data['credits'] 	= $this->payments->get_multiple_by_performer_id($this->performer->id, $this->pagination->per_page, (int)$this->uri->segment(4), FALSE);
		$data['number']		= $config['total_rows'];
		$data['pagination']	= $this->pagination->create_links();
		
		$data['_payments_sidebar']		= TRUE;
		$data['_performer_menu']		= TRUE;
		$data['page'] 					= 'performers/my_payments';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= $this->performer->nickname.'\'s '.lang('payments').' - '.SETTINGS_SITE_TITLE;
		
		$this->load->view('template', $data);			
	}	
	
}