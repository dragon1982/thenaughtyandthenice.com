<?php
/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Email $email
 * @property CI_Form_validation $form_validation
 * @property CI_URI $uri
 * @property Firephp $fireph
 * @property CI_DB_active_record $db
 * @property Users $users
 * @property Credits $credits
 * @property Performers $performers
 * @property System_logs $system_logs
 * @property Messages $messages
 * @property Watchers $watchers
 */

Class User_controller extends MY_Users{
	
	//constructor
	function __construct(){
		parent::__construct();
		$this->load->model('users');
		$this->load->model('categories');		
	}
	
	// ------------------------------------------------------------------------
	/**
	 * Pagina de MY_Account
	 * @return unknown_type
	 */	
	function index() {
		$data['_categories']	= FALSE;
		$data['_sidebar']		= FALSE;
		$data['_signup_header']	= FALSE;
		$data['page'] 			= 'user/my_account';
		
		$this->load->model('messages');
		$data['unread_msgs']	= $this->messages->get_all_received_by_user_id($this->user->id,'user',FALSE,FALSE,TRUE,TRUE);
		$data['description'] 	= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 		= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 		= lang('My account').' - '.SETTINGS_SITE_TITLE;
		$this->load->view('template', $data);
	}
	
		
	
	// ------------------------------------------------------------------------
	/**
	 * Formular de adaugare credite pentru user
	 * @return unknown_type
	 */
	function add_credits(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('package',	lang('package'),	'trim|required|valid_pack');
		$this->form_validation->set_rules('processor',	lang('procesor'),	'trim|valid_processor');
		
		$this->load->config('packages');
		$data['packages']	= $this->config->item('packages');
		
		if( $this->form_validation->run() === FALSE ){
			$this->load->config('packages');
			$data['categories']				= $this->categories->get_all_categories();
			$data['_categories']			= TRUE;
			$data['_sidebar']				= FALSE;
			$data['_signup_header']			= TRUE;
			$data['page'] 					= 'user/add_credits';
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Add Credits').' - '.SETTINGS_SITE_TITLE;
			
			$this->load->view('template', $data);
			return;
		}
				
		require_once APPEXPATH . 'third_party/payment.php';
		$payment = Payment::get_instance($this->user,$this->input->post('processor'));
		$pay = $payment->auth(array(
								'amount'	=> $data['packages'][$this->input->post('package')]['value'],
								'currency'	=> SETTINGS_SHOWN_CURRENCY,
								'ip'		=> ip2long($this->input->ip_address())
							)
		);
		
		$this->load->library('user_agent');
				
		if($pay['success'] == FALSE){
			$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('An error occured')));
			//redirectionez pe pagina de unde a venit
			redirect($this->agent->referrer());			
		}
		
		$this->load->model('credits');
		$this->load->model('ad_traffic');
		
		$user_details =  $this->users->get_one_by_id_and_full_details($this->user->id);
		//incep tranzactia
		$this->db->trans_begin();
		
  		$this->credits->add($data['packages'][$this->input->post('package')]['value'],SETTINGS_SHOWN_CURRENCY,$data['packages'][$this->input->post('package')]['credits'],'CHIPS',time(),'credit',$pay['invoice_id'],'approved',$this->user->id);
		$this->credits->add_credits_detail($pay['log_table'],$pay['log_id']);
		$this->users->add_credits($this->user->id,$data['packages'][$this->input->post('package')]['credits']);
		
		if($user_details->affiliate_id > 0){
			$rows['affiliate_id'] = $user_details->affiliate_id;
			$rows['ad_id'] = $user_details->affiliate_ad_id;
			$rows['date'] = time();
			$rows['action'] = 'transaction';
			$rows['earnings'] = convert_value_to_chips(($data['packages'][$this->input->post('package')]['value'] * SETTINGS_TRANSACTION_PERCENTAGE) / 100);
			$this->ad_traffic->save($rows);
						
			if($rows['earnings'] > 0 ){
				$this->load->model('affiliates');
				$this->affiliates->add_credits($user_details->affiliate_id,$rows['earnings']);
			}
		}
		
		
		$credits_amount = $data['packages'][$this->input->post('package')]['credits'];
		//nu am reusit sa adaug in db tranzactia
		if($this->db->trans_status() == FALSE){
			
			//fac rollback la date
			$this->db->trans_rollback();
			
			$this->load->model('developers');
			//fac un log cu in care scriu ca $user_idu nu a primit $x credite , conform logului $x din tabela $y
			lost_updates($this->user->id,$pay['log_table'],$pay['log_id'],$data['packages'][$this->input->post('package')]['credits']);

			$this->load->library('user_agent');
			
			$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('An error occured')));
			//redirectionez pe pagina de unde a venit
			redirect($this->agent->referrer());
		}
		
		$this->db->trans_commit();	
		
		$this->system_log->add(
            			'user', 
            			$this->user->id,
            			'user', 
            			$this->user->id, 
            			'add_credits', 
            			sprintf('User bought %s credits. Credits before: %s - Credits after: %s',$credits_amount, $this->user->credits, ($this->user->credits + $credits_amount)), 
            			time(), 
            			ip2long($this->input->ip_address())
		);

		if($user_details->affiliate_id > 0){
			$this->system_log->add(
							'user', 
							$this->user->id,
							'affiliate', 
							$user_details->affiliate_id, 
							'add_credits', 
							sprintf('User bought %s credits. Credits before: %s - Credits after: %s, and affiliate earn %s .',$credits_amount, $this->user->credits, ($this->user->credits + $credits_amount), $rows['earnings']), 
							time(), 
							ip2long($this->input->ip_address())
			);
		}
		
		$this->session->set_flashdata('msg',array('success'=>TRUE, 'message'=>lang('Credits added to your account')));
		
		//redirectionez pe pagina de unde a venit
		redirect($this->agent->referrer());				
	}
	
	/**
	 * Plateste access pentru galeria photo a unui performer
	 * @param $performer_id
	 * @return unknown_type
	 */
	function buy_gallery($performer_id = FALSE){
		
		$this->im_in_modal = TRUE;
		
		if( ! $performer_id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid performer ID')));
			redirect();
		}
		
		$this->load->model('performers');
		$performer = $this->performers->get_one_by_id($performer_id);
		
		if( ! $performer ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid performer ID')));
			redirect();
		}
		
		$this->load->model('watchers');
		
		//userul deja a platit pentru a vedea aceasta gallerie, redirect
		$has_paid = $this->watchers->get_multiple_by_performer_id($performer->id,1,0,array('type'=>'photos','user_id'=>$this->user->id),FALSE,TRUE);
		if( $has_paid ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>sprintf(lang('You already have access to %s private photo gallery'),$performer->nickname)));
			redirect($performer->nickname);				
		}	
			
		//nu are destule credite
		if( $performer->paid_photo_gallery_price > $this->user->credits ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('you have unsufficient funds in your account to subscribe to this paid photo gallery!')));
			redirect('add-credits');			
		}

		//are sessiune deschisa si nus sigur daca mis asigurati banii pentru galeria foto
		if( $this->watchers->get_one_active_session_by_user_id($this->user->id) ){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=> lang('please close all your chat sessions before you can subscribe to a photo gallery!')));
			redirect();															
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('leave_me_alone',lang('leave'),'trim|required');
		
		if( $this->form_validation->run() === FALSE ){	
			
			//requestul nu e din ajax
			if( ! $this->input->is_ajax_request() ){			
				redirect($performer->nickname);							
			}
							
			$data['performer'] = $performer;
			$this->load->view('confirmations/buy-photo-gallery',$data);
			return;
		}
		
		$total_amount = $performer->paid_photo_gallery_price;
		
		//banii siteului
		$website_amount		= round( $total_amount * $performer->website_percentage / 100 , 2 );

		//banii performerului
		$performer_amount 	= $total_amount - $website_amount;
				
		$studio_amount 		= 0;
		
		if( $performer->studio_id ){
			
			$this->load->model('studios');
			$studio = $this->studios->get_one_by_id($performer->studio_id);
			$studio_amount = round( $performer_amount * $studio->percentage / 100 ,2);
			$performer_amount -= $studio_amount; 			 
		}
		
		$this->db->trans_begin();
		
		$watcher = array(
			'start_date'		=> time(),
			'end_date'			=> time(),
			'show_is_over'		=> 1,
			'type'				=> 'photos',
			'ip'				=> ip2long($this->input->ip_address()),
			'fee_per_minute'	=> 0,
			'unique_id'			=> $this->watchers->generate_one_unique_id(),
			'user_id'			=> $this->user->id,
			'username'			=> $this->user->username,
			'user_paid_chips'	=> $performer->paid_photo_gallery_price,
			'performer_chips'	=> $performer_amount,
			'studio_chips'		=> $studio_amount,
			'site_chips'		=> $website_amount,
			'studio_id'			=> $performer->studio_id,
			'performer_id'		=> $performer->id,		
		);		
		
  		$this->watchers->add($watcher);
		
		$this->users->add_credits($this->user->id,-$performer->paid_photo_gallery_price);
		$this->performers->add_credits($performer->id,$performer_amount);
		if($performer->studio_id){
			$this->studios->add_credits($performer->studio_id,$studio_amount+$performer_amount);
		}
		
		//nu am reusit sa adaug in db userul
		if($this->db->trans_status() == FALSE){
			
			//fac rollback la date
			$this->db->trans_rollback();
			
			$this->load->model('developers');
			//fac un log cu in care scriu ca $user_idu nu a primit $x credite , conform logului $x din tabela $y
			lost_updates($this->user->id,$pay['log_table'],$pay['log_id'],$data['packages'][$this->input->post('package')]['credits']);

			$this->load->library('user_agent');
			
			$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('An error occured')));
			//redirectionez pe pagina de unde a venit
			redirect($this->agent->referrer());
		}
		
		$this->db->trans_commit();	
		
		$this->system_log->add(
            			'user', 
            			$this->user->id,
            			'user', 
            			$this->user->id, 
            			'add_credits', 
            			sprintf('Brought credits for performer %s galleru. Paid %s',$performer->id,$performer->paid_photo_gallery_price), 
            			time(), 
            			ip2long($this->input->ip_address())
		);

		$this->session->set_flashdata('msg',array('success'=>TRUE, 'message'=>sprintf(lang('You have paid %s for %s private photo gallery.'),print_amount_by_currency($performer->paid_photo_gallery_price),$performer->nickname)));
		$this->session->set_flashdata('open_modal_pictures',1);
		
		//redirectionez pe pagina de unde a venit
		redirect($performer->nickname .'?tab=pictures');		
	}
	
	
	##################################################################################################
	####################################### FAVORITES  ###############################################
	##################################################################################################
	
	// ------------------------------------------------------------------------	
	/**
	 * Sterge un performer din lista de favorite
	 * @param $nickname
	 * @author Baidoc
	 * @return unknown_type
	 */
	function remove_favorite($nickname = FALSE){
		$this->load->library('user_agent');
		if( ! $nickname){
			$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('invalid performer')));
			redirect($this->agent->referrer());		
		}
		
		$this->load->model('performers');

		if ( ! $this->performers->valid_performer($nickname) ) {
			$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('invalid performer')));			
			redirect($this->agent->referrer());			
		}
		
		$performer = $this->performers->get_one_by_nickname($nickname);
		
		if( ! $performer){
			$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('performer does not exist')));												
			redirect($this->agent->referrer());
		}
		if( ! $this->users->duplicate_favorite_performer($this->user->id, $performer['performer']->id)){
			$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>sprint_f(lang('%s is not in your favorite list'),$performer['performer']->nickname)));
			redirect($this->agent->referrer());			
		}
		
		$this->users->remove_favorite_performer($this->user->id, $performer['performer']->id);

		$this->session->set_flashdata('msg',array('success'=>TRUE,'message'=> sprintf(lang('%s has been removed from your favorite list'),$performer['performer']->nickname)));		
		redirect($this->agent->referrer());
	}
	

	// ------------------------------------------------------------------------
	/**
	 * Adauga un performer in lista de favorite
	 * @param $nickname
	 * @return unknown_type
	 */
	function add_favorite($nickname = FALSE){
		$this->load->library('user_agent');
		if( ! $nickname){
			$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('invalid performer')));
			redirect($this->agent->referrer());		
		}
		
		$this->load->model('performers');

		if ( ! $this->performers->valid_performer($nickname) ) {
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=> lang('invalid performer')));
			redirect($this->agent->referrer());			
		}
		
		$performer = $this->performers->get_one_by_nickname($nickname);
		if( ! $performer){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=> lang('performer does not exist')));						
			redirect($this->agent->referrer());
		}
		
		$duplicate_favorite_performer = $this->users->duplicate_favorite_performer($this->user->id, $performer['performer']->id);
		if ($duplicate_favorite_performer) {
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=> lang('performer is already in your favorites')));						
			redirect($this->agent->referrer());
		}
		
		$this->users->add_favorite_performer($this->user->id, $performer['performer']->id,time());

		$this->session->set_flashdata('msg',array('success'=>TRUE, 'message'=>sprintf(lang('%s has been added to your favorites'),$performer['performer']->nickname)));
		redirect($this->agent->referrer());
	}	
	
	// ------------------------------------------------------------------------
	/**
	 * Listeaza performerii favoriti
	 * @return unknown_type
	 */
	function favorites() {
		$this->load->helper('performers');
		$this->load->helper('filters');
		$this->load->model('performers');
		$this->load->library('session');
		
						
		$this->load->library('pagination');
		$config['base_url']     = site_url('favorites/page/');
		$config['uri_segment'] 	= 3;
		$config['per_page']		= 20;		
		$config['total_rows']   = $this->performers->get_multiple_favorite_performers_by_user_id($this->user->id, add_country_filters(),FALSE, FALSE, TRUE);
		$this->pagination->initialize($config);
		$data['pagination']     = $this->pagination->create_links();
		$data['categories'] 	= $this->categories->get_all_categories();
			
		$data['performers'] 	= $this->performers->get_multiple_favorite_performers_by_user_id($this->user->id,add_country_filters(),$this->pagination->per_page,(int)$this->uri->segment(3));
		$data['events'] = array();

		$this->load->model('fms');
		$this->fms_list = create_array_by_property($this->fms->get_multiple(),'fms_id');
		
		$data['_categories']				= TRUE;
		$data['_sidebar']					= FALSE;
		$data['_signup_header']				= TRUE;
		$data['page'] 						= 'user/favorites';
		$data['description'] 				= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 					= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 					= lang('Favorites Models').' - '.SETTINGS_SITE_TITLE;
	
		if( ! $data['performers']) {
			$data['performers'] = false;
		}
		$this->load->view('template', $data);
	}	
		
	##################################################################################################
	######################################### SETTINGS  ##############################################
	##################################################################################################	
	// ------------------------------------------------------------------------	
	/**
	 * Schimbare parola
	 * @author Baidoc
	 */
	function settings(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('old_password',		lang('old password'),		'trim|required|old_password_verification');
		$this->form_validation->set_rules('new_password',		lang('new password'),		'trim|required');

		if($this->form_validation->run() === FALSE){
						
			$data['_categories']			= FALSE;
			$data['_sidebar']				= TRUE;
			$data['_signup_header']			= FALSE;
			$data['page'] 					= 'user/user_settings';
			
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('My settings').' - '.SETTINGS_SITE_TITLE;
		
			$this->load->view('template', $data);

		} else {

			//iau tokenul general din config		
			$salt = $this->config->item('salt');
			
			if( ! $this->users->update($this->user->id,array('password'=>hash('sha256', $salt . $this->user->hash . $this->input->post('new_password'))))){
				$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('Database error. Please retry')));
				redirect('settings');
			}
			$this->system_log->add(
	            			'user', 
	            			$this->user->id,
	            			'user', 
	            			$this->user->id, 
	            			'change_password', 
	            			'User changed password.', 
	            			time(), 
	            			ip2long($this->input->ip_address())
			);
			$this->session->set_flashdata('msg',array('success'=>TRUE, 'message'=> lang('Password changed successfuly')));
			redirect('settings');
		}
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Activare/dezactivare newsletter
	 * @author Baidoc
	 */
	function newsletter(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('newsletter',lang('newsletter'),'trim|required|valid_newsletter_option');
		
		if($this->form_validation->run() === FALSE){
			
			$data['newsletter']				= array(
				1 => lang('Active'),
				0 => lang('Inactive')
			);
			
			$data['user']					= $this->users->get_one_by_id_and_full_details($this->user->id);
			$data['_categories']			= FALSE;
			$data['_sidebar']				= TRUE;
			$data['_signup_header']			= FALSE;
			$data['page'] 					= 'user/newsletter';
			
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Newsletter settings').' - '.SETTINGS_SITE_TITLE;
		
			$this->load->view('template', $data);
		} else {

			$newsletter = $this->input->post('newsletter');
	
			$user = $this->users->get_one_by_id_and_full_details($this->user->id);
	
			if($user->newsletter == $newsletter)
			{
				$this->session->set_flashdata('msg',array('success'=>TRUE, 'message'=>lang('Changes saved.')));
				redirect('newsletter');
			}
				
	
			if( ! $this->users->update_details($this->user->id,array('newsletter'=>$newsletter)))
			{//cannot save changes
				$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('database error. please retry')));
				redirect('newsletter');
			}
	
			if( $newsletter){
				$this->session->set_flashdata('msg',array('success'=>TRUE, 'message'=> lang('newsletter enabled')));
			} else {
				$this->session->set_flashdata('msg',array('success'=>TRUE, 'message'=> lang('newsletter disabled')));
			}
			
			$this->system_log->add(
            	'user', 
            	$this->user->id,
            	'user', 
            	$this->user->id, 
            	'newsletter', 
            	'User turned newsletter on: '.$newsletter, 
            	time(), 
            	ip2long($this->input->ip_address())
			);
	
			redirect('newsletter');
		}
	}

	// ------------------------------------------------------------------------	
	/**
	 * Canceluire cont 
	 * @author Baidoc
	 */
	function cancel_account(){
		
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('account', lang('account'), 'trim|required');

		if($this->form_validation->run() === FALSE){			
			$data['_categories']			= FALSE;
			$data['_sidebar']				= TRUE;
			$data['_signup_header']			= FALSE;
			$data['page'] 					= 'user/cancel_account';
			
			$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
			$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
			$data['pageTitle'] 				= lang('Cancel account').' - '.SETTINGS_SITE_TITLE;
		
			$this->load->view('template', $data);
		} else {
		
			if( ! $this->users->update($this->user->id,array('status'=>'rejected'))){
				$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('database error. please retry')));
				redirect('account');	
			}
			
			//set the cancelation date
			$this->users->update_details($this->user->id,array('cancel_date'=>time()));
		
			//sending emails
			$this->load->helper('emails');
				
			$data['username']	= $this->user->username;
			$content = $this->load->view('emails/costumer_cancel_'.$this->config->item('lang_selected'),array(),TRUE);
			$replaced_variables = get_avaiable_variabiles('costumer_cancel', true);
			
			$replace_value = array( $this->user->username,   $this->user->email,  main_url(), WEBSITE_NAME);
			
			$content = preg_replace($replaced_variables, $replace_value, $content);
			
			
			$this->load->library('email');
			$this->email->clear();
			$this->email->to($this->user->email,$this->user->username);
			$this->email->from(SUPPORT_EMAIL,SUPPORT_NAME);
			$this->email->subject(WEBSITE_NAME,lang('account canceled'));
			$this->email->message($content);
			$this->email->send();
			
			$this->system_log->add(
	            			'user', 
	            			$this->user->id,
	            			'user', 
	            			$this->user->id, 
	            			'delete_account', 
	            			'User has canceled the account.', 
	            			time(), 
	            			ip2long($this->input->ip_address())
			);
			
			$this->session->set_flashdata('msg',array('success'=>TRUE, 'message'=> lang('account canceled')));
			$this->session->unset_userdata('id');
			redirect();
		}
			
	}	

	// ------------------------------------------------------------------------	
	/**
	 * Returneaza numarul de chipsuri in realtime + timpul ramas
	 * @author Baidoc
	 * @return unknown_type
	 */
	function update_chips(){
		$remaining_time = FALSE;
		if( $this->active_session ){
			if( in_array($this->active_session->type,array('nude','private','peek') ) )
			{
				if($this->active_session->fee_per_minute > 0)
					$remaining_time = sec2hms( $this->user->credits / $this->active_session->fee_per_minute * 60 );				
			} 
		}
		
		$this->output->set_header("HTTP/1.1 200 OK");
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
				
		$data['json'] = array('credits'=>print_amount_by_currency($this->user->credits),'rem_time'=>$remaining_time);
		$this->load->view('json',$data);
	}	
	
	##################################################################################################
	######################################## STATISTICS  #############################################
	##################################################################################################

	// ------------------------------------------------------------------------	
	/**
	 * Listeaza sessiunile din chat pentru un user_id
	 * @param $start
	 * @param $stop
	 * @author Baidoc
	 * @return unknown_type
	 */
	function statement($start='All', $stop='All'){

		$filters = array();		
		$data['start']	= $start;
		$data['stop']	= $stop;
		
		if(strtolower($start) !== 'all'){
			$filters['start']=strtotime($start.' 00:00:00');
		}
		if(strtolower($stop) !== 'all'){
			$filters['stop']=strtotime($stop.' 23:59:59');
		}
		
		$this->load->helper('credits');
		$this->load->model('watchers');
		$this->load->library('pagination');
		$config['base_url'] 	= site_url('statement/'.$start.'/'.$stop.'/page/');
		$config['per_page'] 	= 15;
		$config['uri_segment'] 	= 5;
		$config['total_rows'] 	= $this->watchers->get_multiple_by_user_id($this->user->id, FALSE, FALSE, $filters, FALSE,TRUE);
		$this->pagination->initialize($config);
		
		$data['watchers'] 				= $this->watchers->get_multiple_by_user_id($this->user->id, $this->pagination->per_page, (int)$this->uri->segment(5), $filters, array('performers'=>TRUE));
		$data['number']					= $config['total_rows'];			
		$data['pagination']				= $this->pagination->create_links();
		
		$data['_categories']			= FALSE;
		$data['_sidebar']				= FALSE;
		$data['_signup_header']			= FALSE;
		$data['page'] 					= 'user/statements';
		
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('My statements').' - '.SETTINGS_SITE_TITLE;		
		$this->load->view('template', $data);
	}

	// ------------------------------------------------------------------------	
	/**
	 * Listeaza liniile din tabela credits pentru un user_id
	 * @param $start
	 * @param $stop
	 * @author Baidoc
	 * @return unknown_type
	 */
	function payments($start='All', $stop='All'){
		$filters['status']	= 'approved';
		
		$data['start'] 		= $start;
		$data['stop']  		= $stop;
		
		$this->load->library('pagination');
		if(strtolower($start) !== 'all'){
			$filters['start']=strtotime($start.' 00:00:00');
		}
		if(strtolower($stop) !== 'all'){
			$filters['stop']=strtotime($stop.' 23:59:59');
		}
		
		$this->load->model('credits');
		$this->load->library('pagination');
		$config['base_url'] 	= site_url('payments/'.$start.'/'.$stop.'/page/');
		$config['total_rows'] 	= $this->credits->get_multiple_by_user_id($this->user->id, FALSE, FALSE, $filters,TRUE);
		$config['per_page'] 	= 15;
		$config['uri_segment'] 	= 5;
		$this->pagination->initialize($config);

		$data['credits'] 				= $this->credits->get_multiple_by_user_id($this->user->id, $this->pagination->per_page, (int)$this->uri->segment(5), $filters);
		$data['number']					= $config['total_rows'];			
		$data['pagination']				= $this->pagination->create_links();
		
		$data['_categories']			= FALSE;
		$data['_sidebar']				= FALSE;
		$data['_signup_header']			= FALSE;
		$data['page'] 					= 'user/payments';
		
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('My payments').' - '.SETTINGS_SITE_TITLE;
		$this->load->view('template', $data);
		
	}
		
	
	// ------------------------------------------------------------------------	
	/**
	 * scoate din sesiune id - logout
	 */
	function logout() {
		$this->system_log->add(
            			'user', 
            			$this->user->id,
            			'user', 
            			$this->user->id, 
            			'logout', 
            			'User has logged out.', 
            			time(), 
            			ip2long($this->input->ip_address())
		);
		$this->session->unset_userdata('id');

		session_start();
		if(isset($_SESSION['chatHistory'])) unset($_SESSION['chatHistory']);
		if(isset($_SESSION['tsChatBoxes'])) unset($_SESSION['tsChatBoxes']);
		if(isset($_SESSION['openChatBoxes'])) unset($_SESSION['openChatBoxes']);

		redirect();
	}
}