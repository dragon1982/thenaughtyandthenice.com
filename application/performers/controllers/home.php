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
 * @property payments $payments
 */
Class Home_controller extends MY_Performer{
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('performers');
		$this->load->helper('earnings_helper');
		$this->load->model('messages');
	}

	// -----------------------------------------------------------------------------------------	
	/**
	 * Performer deafult page
	 * @return unknown_type
	 */
	function index() {
		$this->load->model('watchers');		
		$this->load->helper('chart');		
		$data['_sidebar']			= FALSE;
		$data['_signup_header']		= TRUE;
		$data['page'] 				= 'performerMyAccount';
		$data['description'] 		= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 			= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 			= lang('My account').' - '.SETTINGS_SITE_TITLE;
		$data['performer']			= $this->user;
		$data['video_access']		= $this->watchers->count_chat_access($this->user->id);

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
		
		$data['chart_watchers'] = $this->charts->get_chart_data('watchers', $start_date, $end_date, $this->user->id);
		$data['chart_earnings'] = $this->charts->get_chart_data('earnings', $start_date, $end_date, $this->user->id);
		$data['chart_totals'] = $this->charts->get_chart_data('totals', $start_date, $end_date, $this->user->id);
		
		$this->load->view('template', $data);	
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Performer starts broadcasting
	 * @return unknown_type
	 */
	function broadcast(){						
		//performerul nu indelipneste toate conditiile sa mearga online
		if( $reason =  $this->performers->cannot_go_online($this->user) ){											
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=> $reason));
			redirect();
		}
		
		$this->load->model('fms');
		
		if( ! $data['fms'] = $this->fms->get_one_by_lowest_traffic() ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid FMS. Please contact admin')));
				
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Broadcast').' - '.SETTINGS_SITE_TITLE;
		
		
			$this->load->view('no_fms_error', $data);
			return;
		}
		

		$data['fmle']					= (($this->input->post('fmle') == 1)?TRUE:FALSE);
		$data['_sidebar']				= FALSE;
		$data['_performer_menu']		= TRUE;
		$data['page'] 					= 'broadcast';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Broadcast').' - '.SETTINGS_SITE_TITLE;
		
		$this->load->view('template', $data);				
	}
	
	// -----------------------------------------------------------------------------------------
	/*
	 * Download fmle settings
	 */
	function fmle(){
		$data['url'] 	= $this->input->get('url');
		$data['stream']	= $this->input->get('stream');
		$data['fms_id']	= $this->input->get('fms_id');
		
		$this->load->model('watchers');
		$this->load->helper('download');		
		$content = $this->load->view('fms/fmle',$data,TRUE);
		$name = 'settings.xml';
				
		force_download($name, $content);		
	}
	
	// -----------------------------------------------------------------------------------------	
	/*
	 * Performerul merge live, e in popup acum
	 */	
	function live(){
		$this->load->model('fms');
		if( ! $data['fms'] = $this->fms->get_one_by_lowest_traffic() ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid FMS. Please contact admin')));
			
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Broadcast').' - '.SETTINGS_SITE_TITLE;
		
		
			$this->load->view('no_fms_error', $data);
			return;
		}
		
		if( $this->user->is_online ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('You are already online!')));
				
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Broadcast').' - '.SETTINGS_SITE_TITLE;
			
			
			$this->load->view('no_fms_error', $data);
			return;				
		}
		
		if($data['fms']->current_hosted_performers >= $data['fms']->max_hosted_performers){
			$this->load->library('email');
		
			$this->email->from(SUPPORT_EMAIL,SUPPORT_EMAIL);
			$this->email->to(SUPPORT_EMAIL);
			
			$this->email->subject('FMS is overloaded ');
			$this->email->message('FMS is overloaded. Please add another FMS servers.');
			$this->email->send();								
		}		
				
		$this->load->model('watchers');
		$data['unique_id']				= $this->watchers->generate_one_unique_id();
		$data['performer']				= $this->user;
		$data['fmle']					= ( ! $this->input->get('fmle'))?FALSE:TRUE;
		$this->load->view('live_broadcast/embed',$data);		
	}

	 
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Afiseaza castigurile pentru un performer cu filtre pe data (interval)
	 * @param $start
	 * @param $stop
	 * @return unknown_type
	 */
	function earnings($start = FALSE, $stop = FALSE){
		
		$this->load->model('watchers');
		$filters = array();
	
		$options = make_interval_time(mktime(0,0,0,date('m',$this->user->register_date),1,date('Y',$this->user->register_date)));

		if( $start ){
			$filters['start'] 	= $start;
			$filters['stop']	= $stop;
		} else {
			end($options);
			list($filters['start'],$filters['stop']) 	= explode('~',key($options));
		}
				
		if( ! isset ( $options[$filters['start'] . '~' . $filters['stop']])){	
			redirect('my_earnings');						
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
				
		$filters['type']	= array('private','true_private','peek','nude','free','premium_video','photos','gift','admin_action');
		
		$config['base_url'] 	= site_url('my_earnings/'.$filters['start'].'/'.$filters['stop'].'/page/');
		$config['total_rows'] 	= $this->watchers->get_multiple_by_performer_id($this->user->id, FALSE, FALSE, $filters, $joins, TRUE);
		$config['per_page'] 	= 20;
		$config['uri_segment'] 	= 5;
		$this->pagination->initialize($config);

		$data['watchers'] 	= $this->watchers->get_multiple_by_performer_id($this->user->id, $this->pagination->per_page, (int)$this->uri->segment(5), $filters, $joins);
		$data['number']		= $config['total_rows'];
		$data['pagination']	= $this->pagination->create_links();
		
		$data['_payments_sidebar']		= TRUE;
		$data['_performer_menu']		= TRUE;
		$data['page'] 					= 'my_earnings';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Earnings').' - '.SETTINGS_SITE_TITLE;
		
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
		$config['base_url'] 	= site_url('my_payments/page/');	
		$config['total_rows'] 	= $this->payments->get_multiple_by_performer_id($this->user->id, FALSE, FALSE, FALSE, TRUE);
		$config['per_page'] 	= 10;
		$config['uri_segment'] 	= 3;
		$this->pagination->initialize($config);

		$data['credits'] 	= $this->payments->get_multiple_by_performer_id($this->user->id, $this->pagination->per_page, (int)$this->uri->segment(3), FALSE);
		$data['number']		= $config['total_rows'];
		$data['pagination']	= $this->pagination->create_links();
		
		$data['_payments_sidebar']		= TRUE;
		$data['_performer_menu']		= TRUE;
		$data['page'] 					= 'my_payments';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Payments').' - '.SETTINGS_SITE_TITLE;
		
		$this->load->view('template', $data);			
	}
	
	
	/**
	 * Vede detaliile de plata 
	 * @param unknown_type $payment_id
	 * @author Baidoc
	 */
	function payment_details($payment_id = FALSE){
		$this->load->model('payments');

		if ( ! $payment = $this->payments->get_one_by_id($payment_id)){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid payment!')));
			redirect();
		}
		
		if( $payment->performer_id !== $this->user->id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid payment!')));
			redirect();			
		}
		
		$this->load->model('watchers');
		
		$filters['type']		= array('private','true_private','peek','nude','premium_video','photos','gift','admin_action');
		$filters['performer_id']= $this->user->id;
		$filters['start']		= $payment->from_date;
		$filters['stop']		= $payment->to_date;
		
		$data['summary']		= $this->watchers->get_multiple_summaries($filters);
		
		$joins['performers'] 	= 'performers';
		$filters['start']		= date('Y-m-d',$payment->from_date);
		$filters['stop']		= date('Y-m-d',$payment->to_date);
		$data['watchers'] 		= $this->watchers->get_multiple_by_performer_id($this->user->id,FALSE, FALSE , $filters, $joins);
		$data['payment']		= $payment;
			
		$data['_payments_sidebar']		= TRUE;
		$data['_performer_menu']		= TRUE;
		$data['page'] 					= 'payment_summary';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Payment Summary').' - '.SETTINGS_SITE_TITLE;
		
		$this->load->view('template', $data);		
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * 
	 * @return unknown_type
	 */
	function rules(){
		$data['_payments_sidebar']		= TRUE;
		$data['_performer_menu']		= TRUE;
		$data['page'] 					= 'rules';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Rules').' - '.SETTINGS_SITE_TITLE;
		
		$this->load->view('template', $data);			
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * 
	 * @return unknown_type
	 */
	function contact(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
		
		$this->form_validation->set_rules('subject',lang('subject'),'trim|required|min_length[2]|max_length[255]|purify');
		$this->form_validation->set_rules('message',lang('message'),'trim|required|min_length[2]|max_length[1500]|purify');
		
		if($this->form_validation->run() === FALSE){
			$data['_payments_sidebar']		= FALSE;
			$data['_performer_menu']		= TRUE;
			$data['page'] 					= 'contact';
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Contact').' - '.SETTINGS_SITE_TITLE;
			
			$this->load->view('template', $data);						
		}
		else
		{
			$this->load->library('email');
			$this->email->from($this->user->email);
			$this->email->to(SUPPORT_EMAIL);
			$this->email->subject($this->input->post('subject'));
			$this->email->message($this->input->post('message'));
			if ($this->email->send()) {
				$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Message Sent')));
			} else {
				$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Error sending message')));
			}		
			redirect(current_url());	
		}
	}	
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * 
	 * @return unknown_type
	 */
	function faq(){
		$data['_payments_sidebar']		= TRUE;
		$data['_performer_menu']		= TRUE;
		$data['page'] 					= 'faq';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('FAQ').' - '.SETTINGS_SITE_TITLE;
		
		$this->load->view('template', $data);		
	}

	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Scoate din sesiune id-ul userului si reidirecteaza catre login
	 * @return unknown_type
	 */
	function logout() {
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('type');
		
		$this->system_log->add(
            			'performer', 
            			$this->user->id,
            			'performer', 
            			$this->user->id, 
            			'logout', 
            			'Performer has logged out.', 
            			time(), 
            			ip2long($this->input->ip_address())
		);
		redirect('login');
	}
	
}