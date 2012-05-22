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
 * @property Payments $payments
 * @property Performers $performers
 */
class Home_controller extends MY_Studio
{

	// ------------------------------------------------------------------------	
	/**
	 * incarca modele,librari,helpere
	 * @author Baidoc
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('studios');
		$this->load->helper('generic');
		$this->load->helper('earnings_helper');
	}

	
	// ------------------------------------------------------------------------	
	/**
	 * Sumar cont studio
	 * @return unknown_type
	 */	
	function index() {
		
		$this->load->model('news');

		$data['news'] 					= $this->news->get_last_5_by_to('studios');
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('My Account').' - '.SETTINGS_SITE_TITLE;
		$performers 					= $this->studios->get_multiple_performers_by_studio_id($this->user->id);
		$data['number_of_performers']	= count($performers);
		$data['_categories']			= FALSE;
		$data['_sidebar']				= FALSE;
		$data['_signup_header']			= FALSE;
		$data['page']					= 'account';
		
		$this->load->model('contracts');
		$data['approved_contracts']		= $this->contracts->get_multiple_by_studio_id($this->user->id,array('status'=>'approved'),TRUE);
		if( ! $data['approved_contracts'] ){
			$data['contracts']				= $this->contracts->get_multiple_by_studio_id($this->user->id,FALSE,TRUE);
			$data['contracts_pending']		= $this->contracts->get_multiple_by_studio_id($this->user->id,array('status'=>'pending'),TRUE);	
		}
		

		$this->studios->get_multiple_performers_summary($performers, $data);
		
		$this->load->model('country');
		$this->load->model('watchers');
		
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
		
		$data['chart_watchers'] = $this->charts->get_chart_data('watchers', $start_date, $end_date, FALSE, $this->user->id);
		$data['chart_earnings'] = $this->charts->get_chart_data('earnings', $start_date, $end_date, FALSE, $this->user->id);
		$data['chart_totals'] = $this->charts->get_chart_data('totals', $start_date, $end_date, FALSE, $this->user->id);
		
		$this->load->view('template', $data);
		
	}
	
	
		
	// ------------------------------------------------------------------------		
	/**
	 * Studio isi vede castigurile
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
			redirect('earnings');						
		}
		
		//pentru preselectare, fortez sa vada ca a primit prin post keyul din array asociat intervalului
		$_POST['paymentDates'] 	= $filters['start'] . '~' . $filters['stop'];
		$data['start_date'] 	= $filters['start'];
		$data['stop_date'] 		= $filters['stop'];
		$filters['type']		= array('private','true_private','peek','nude','free','premium_video','photos','gift','admin_action');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('paymentDates', lang('paymentDates'),'trim|required');
		$this->form_validation->run();
		
		$this->load->library('pagination');
		$config['base_url']	 	= site_url('earnings/'.$filters['start'].'/'.$filters['stop'].'/page/');
		$config['total_rows'] 	= $this->watchers->get_studio_earnings_by_date($this->user->id, FALSE, FALSE, $filters, TRUE);
		$config['per_page'] 	= 20;
		$config['uri_segment'] 	= 5;
		$this->pagination->initialize($config);
																					
		$data['watchers'] 	= $this->watchers->get_studio_earnings_by_date($this->user->id, $this->pagination->per_page ,(int)$this->uri->segment(5), $filters);
		$data['number']		= $config['total_rows'];
			
		$data['pagination']	= $this->pagination->create_links();

		$data['description'] 	= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 		= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 		= lang('Earnings').' - '.SETTINGS_SITE_TITLE;
		$data['page']			= 'earnings';
				
		$data['options'] = $options;
						
		$this->load->view('template', $data);	
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * Detaliile despre castiguri dintr-o anumita perioada
	 * @param unknown_type $performer_id
	 * @param unknown_type $start
	 * @param unknown_type $stop
	 * @author caguna
	 */
	function earnings_detail($performer_id, $start, $stop){
		
		$this->load->model('performers');
		
		$performer = $this->performers->get_one_by_id($performer_id);
		
		if(!is_object($performer)){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid performer!')));
			redirect(site_url('earnings'));
		}
		
		if($performer->studio_id != $this->user->id){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid performer!')));
			redirect(site_url('earnings'));
		}
		
		$this->load->model('watchers');
		
		
		$options = make_interval_time(mktime(0,0,0,date('m',$this->user->register_date),1,date('Y',$this->user->register_date)));
		$filters = array();
		
		
		if( $start ){
			$filters['start'] 	= $start;
			$filters['stop']	= $stop;
		} else {
			end($options);
			list($filters['start'],$filters['stop']) 	= explode('~',key($options));
		}
		
		if( ! isset ( $options[$filters['start'] . '~' . $filters['stop']])){
			redirect('earnings');
		}
		
		$filters['start'] 	= strtotime($filters['start'] .' 00:00:00');
		$filters['stop']	= strtotime($filters['stop'] .' 23:59:59');
		$filters['type']		= array('private','true_private','peek','nude','premium_video','photos','gift','admin_action');
		$filters['performer_id'] = $performer_id;
		
		$group_by['type']		= TRUE;
		$data['summary']		= $this->watchers->get_multiple_summaries($filters,$group_by);
		
		$joins['performers'] 	= 'performers';
		$filters['start']		= date('Y-m-d', $filters['start']);
		$filters['stop']		= date('Y-m-d', $filters['stop']);
		$data['watchers'] 		= $this->watchers->get_multiple_by_performer_id($performer_id,FALSE, FALSE , $filters, $joins);
			
		$data['_payments_sidebar']		= FALSE;
		$data['_performer_menu']		= FALSE;
		$data['performer']				= $performer;
		$data['page'] 					= 'earnings_detail';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Payment Summary').' - '.SETTINGS_SITE_TITLE;
		
		$this->load->view('template', $data);
		return;
		
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * Listeaza platile facutra catre studio
	 * @param $start
	 * @param $stop
	 * @return unknown_type
	 */
	function payments($start = FALSE, $stop = FALSE){
		
		$this->load->model('payments');
		
		$this->load->library('pagination');
		$config['base_url'] 	= site_url('payments/page/');		
		$config['total_rows'] 	= $this->payments->get_multiple_by_studio_id($this->user->id, FALSE, FALSE, TRUE);
		$config['per_page'] 	= 20;
		$config['uri_segment'] 	= 3;
		$this->pagination->initialize($config);

		$data['payments'] 	= $this->payments->get_multiple_by_studio_id($this->user->id, $this->pagination->per_page, (int)$this->uri->segment(3));
		$data['number']		= $config['total_rows'];
		
		foreach($data['payments'] as $payment){
			$data['performer_payments'][$payment->id] = $this->payments->get_studio_payments($this->user->id,$payment->paid_date);
		}
			
		$data['pagination']	= $this->pagination->create_links();
		
		$data['description'] 	= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 		= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 		= lang('Payments').' - '.SETTINGS_SITE_TITLE;
		
		$data['page']			= 'payments';
		
		$this->load->view('template', $data);	
	}
	
	// ------------------------------------------------------------------------
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
	
		$this->load->model('performers');
		$performer = $this->performers->get_one_by_id($payment->performer_id);
		if( ! $performer ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid payment!')));
			redirect();				
		}

		if( $performer->studio_id !== $this->user->id ){
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
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Payment Summary').' - '.SETTINGS_SITE_TITLE;
	
		$this->load->view('template', $data);
	}
		
	// ------------------------------------------------------------------------	
	/**
	 * Studio - faq
	 *
	 * @author	CagunA
	 * @since	Dec 07, 2010
	 */
	function faq(){
		$data['description'] 	= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 		= SETTINGS_SITE_KEYWORDS;
		$data['title'] 			= lang('FAQ').' - '.SETTINGS_SITE_TITLE;

		$this->load->view('studio/faq', $data);
	}

	// -----------------------------------------------------------------------------------------	
	/**
	 *  Studio Contact
	 * 
	 * @return unknown_type
	 */
	function contact(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
		
		$this->form_validation->set_rules('subject',lang('subject'),'trim|required|min_length[2]|max_length[255]|purify');
		$this->form_validation->set_rules('message',lang('message'),'trim|required|min_length[2]|max_length[1500]|purify');
		
		if($this->form_validation->run() === FALSE){
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

	// ------------------------------------------------------------------------		
	/**
	 * Studio spy performer
	 * @param $performer_id
	 * @return unknown_type
	 */
	function spy($performer_id = FALSE){
		if( ! $performer_id ){
			die('Invalid performer ID');
		}
				
		$this->load->model('performers');
		$performer = $this->performers->get_one_by_id($performer_id);
		
		if(! $performer){
			die(lang('Invalid performer ID!'));
		}
		
		if($this->user->id != $performer->studio_id){
			die(lang('You don\'t have access to spy this performer'));
		}

		$data['performer'] = $performer;
		$this->load->view('studio/spy', $data);
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * distruge sesiunea
	 * @author Baidoc
	 * @return unknown_type
	 */
	public function logout() {
		$this->system_log->add(
            			'studio', 
            			$this->user->id,
            			'studio', 
            			$this->user->id, 
            			'logout', 
            			'Studio has logged out.', 
            			time(), 
            			ip2long($this->input->ip_address())
		);
		$this->session->sess_destroy();
		redirect();
	}
	
}