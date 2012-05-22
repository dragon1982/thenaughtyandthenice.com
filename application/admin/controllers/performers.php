<?php
/**
 * @property Performers $performers
 * @property Status $status
 * @property System_log $system_log
 * @property Payments $payments
 */
class Performers_controller extends MY_Admin {
	public $fms_list;
	
	// ----------------------------------------------------------------------------------
	/**
	* Constructor
	 * @author Baidoc
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('performers');
		$this->load->library('form_validation');
		$this->load->helper('generic_helper');
		$this->load->helper('filters');
		$this->load->helper('utils');
	}
	
	// ----------------------------------------------------------------------------------
	/**
	 * Performer listing
	 * @author Baidoc
	 */
	function index() {
		$filters	= purify_filters($this->input->get('filters'));
		$order		= purify_orders($this->input->get('orderby'));
				
		$this->load->model('status');
		$data['filters']	= array2url($filters,'filters');

		$filters['status'] = '!= rejected';
		$filters['join']['studios'] = 'id = studio_id, left';
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('performers/page/');
		$config['uri_segment'] 	= 3;
		$config['total_rows']   = $this->performers->get_all($filters, TRUE);
		$config['per_page']		= 20;
		$this->admin_pagination->initialize($config);
		$data['pagination']     = $this->admin_pagination->create_links();
	
		
		$data['contracts'] = array();
		$data['photo_ids'] = array();
		
		$data['performers']		= $this->performers->get_all($filters, FALSE, implode_order($order), $this->uri->segment(3), $config['per_page']);
		
		foreach($data['performers'] as $performer) {
			$data['contracts'][$performer->performers_id] = $this->status->get_all_by_performer_id('contracts', $performer->performers_id, FALSE, FALSE, TRUE);
			$data['photo_ids'][$performer->performers_id] = $this->status->get_all_by_performer_id('performers_photo_id', $performer->performers_id, FALSE, FALSE, TRUE);
		}
				
		$data['order_by']	= $this->input->get('orderby');
		$data['page'] = 'performers';
		$data['breadcrumb'][lang('Performers')]	= 'current';
		$data['page_head_title']				= lang('Performers'); 
		
		$this->load->view('template', $data);
	}
	
	// ----------------------------------------------------------------------------------	
	/**
	 * Chat logs
	 * @param unknown_type $username
	 * @param unknown_type $date
	 * @param unknown_type $page_nr
	 * @author Baidoc
	 */
	function chat_logs($username = FALSE, $date = 'all', $page_nr = 0) {
		
		if(strlen($username) == 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This username is invalid')));
		}
		
		$performer = $this->performers->get_all(array('username'=>$username));
		if( ! is_array($performer) || count($performer) <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This performer does not exist!')));
		}
		
		$performer = $performer[0];
		
		$this->load->model('chat_logs');
		$this->load->library('admin_pagination');
		if($date != 'all'){
			$filters['add_date'] = array('BETWEEN'=>array(strtotime($date.' 00:00:00'), strtotime($date.' 23:59:59')));
		}
		$filters['performer_id'] = $performer->id;
		
		$config['base_url']     = site_url('performers/chat_logs/'.$username.'/'.$date);
		$config['uri_segment'] 	= 6;
		$config['total_rows']   = $this->chat_logs->get_all($filters, TRUE);
		$config['per_page']		= 20;
		$this->admin_pagination->initialize($config);
		$data['pagination']     = $this->admin_pagination->create_links();
	
	
		
		$data['chat_logs']		= $this->chat_logs->get_all($filters, FALSE, 'add_date DESC', $this->uri->segment(6), $config['per_page']);
		
		$data['date'] = $date;
		$data['performer'] = $performer;
		
		$data['page'] = 'performers_chat_logs';
		
		$data['breadcrumb'][lang('Performers')]	= 'current';
		$data['page_head_title']				= lang('Performers'); 
		
		$this->load->view('template', $data);
	}
	
	/**
	 * Lisatre detalii cont
	 * @param unknown_type $username
	 * @author Baidoc
	 */
	function account($username = 0){
		
		if(strlen($username) == 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This username is invalid')));
			redirect('performers');
		}
		
		$performer = $this->performers->get_all(array('username'=>$username));
		if( ! is_array($performer) || count($performer) <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This performer does not exist!')));
			redirect('performers');
		}
		
		$performer = $performer[0];
		$data['performer'] = $performer;
		$data['status'] = array(lang('Select Status'), 'approved'=>lang('approved'), 'pending'=>lang('pending'), 'rejected'=>lang('rejected'));
		$data['online_type'] = array('Select Type', 'free'=>lang('free'), 'nude'=>lang('nude'), 'private'=>lang('private'));
		$this->form_validation->set_rules('password',					lang('password'), 					'trim|min_length[3]|max_length[25]');
		$this->form_validation->set_rules('nickname',					lang('nickname'),					'trim|required|min_length[3]|max_length[25]|alpha_dash|update_unique[performers.nickname.'.$performer->id.']|strip_tags|purify');
		$this->form_validation->set_rules('email',						lang('email'),						'trim|required|valid_email|purify|min_length[3]|max_length[60]');
		$this->form_validation->set_rules('status',						lang('status'),						'trim|required');
		$this->form_validation->set_rules('first_name', 				lang('firstname'), 					'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('last_name', 					lang('lastname'),					'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('address', 					lang('address'), 					'trim|required|strip_tags|purify|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('city', 						lang('city'), 						'trim|required|strip_tags|purify|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('zip', 						lang('zip'), 						'trim|required|strip_tags|purify|min_length[3]|max_length[10]');
		$this->form_validation->set_rules('state', 						lang('state'), 						'trim|required|strip_tags|purify|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('phone', 						lang('phone'), 						'trim|required|purify|numeric|min_length[8]|max_length[16]');
		$this->form_validation->set_rules('true_private_chips_price',	lang('true private chips price'),	'trim|required|valid_price[true_private]');
		$this->form_validation->set_rules('private_chips_price',		lang('private chips price'), 		'trim|required|valid_price[private]');
		$this->form_validation->set_rules('nude_chips_price',			lang('nude chips price'), 			'trim|required|valid_price[nude]');
		$this->form_validation->set_rules('peek_chips_price',			lang('peek chips price'), 			'trim|required|valid_price[peek]');
		$this->form_validation->set_rules('max_nude_watchers',			lang('max nude watchers'), 			'trim|required|purify|numeric');
		
		if($this->form_validation->run() == FALSE){
			
			$data['breadcrumb']['Performers'] = base_url().'performers';
			
			if($performer->id > 0){
				$data['page_head_title'] = $performer->username.'\'s ' . lang('account');
				$data['breadcrumb'][$performer->username.'\'s '. lang('account')] = 'current';
			}
			$this->load->config('regions');
			$data['countries'] = prepare_dropdown($this->config->item('countries'), FALSE, TRUE);
			$data['page'] = 'performers_edit';
			$this->load->view('template', $data);
			return;
		} else {
		
		
		if($performer->id > 0){
			$rows['id']				= $performer->id;
		}
				
		//If password is not empty 
		if($this->input->post('password')){
			
			//If edit admin account, set id and hash
			if($performer->id > 0){
				$hash				= $performer->hash;
				
			//Else, generate a new hash
			}else{
				$hash				= generate_hash('performers');
				$rows['hash']		= $hash;
			}
			
			//Encrypt password
			$salt					= $this->config->item('salt');
			$rows['password']		= hash('sha256',($salt . $hash . $this->input->post('password') ));
		
		}
		
		$rows['email'] 						= $this->input->post('email');
		$rows['nickname'] 					= $this->input->post('nickname');
		$rows['first_name'] 				= $this->input->post('first_name');
		$rows['last_name'] 					= $this->input->post('last_name');
		$rows['address']					= $this->input->post('address');
		$rows['city'] 						= $this->input->post('city');
		$rows['zip'] 						= $this->input->post('zip');
		$rows['state'] 						= $this->input->post('state');
		$rows['country'] 					= $this->input->post('country');
		$rows['phone'] 						= $this->input->post('phone');
		$rows['is_online'] 					= $this->input->post('is_online');
		$rows['is_online_hd'] 				= $this->input->post('is_online_hd');
		//$rows['is_imported_category_id'] 	= ($this->input->post('is_imported_category_id') != '')? $this->input->post('is_imported_category_id') : null;
		$rows['true_private_chips_price'] 	= $this->input->post('true_private_chips_price');
		$rows['private_chips_price'] 		= $this->input->post('private_chips_price');
		$rows['nude_chips_price'] 			= $this->input->post('nude_chips_price');
		$rows['peek_chips_price'] 			= $this->input->post('peek_chips_price');
		$rows['paid_photo_gallery_price']	= $this->input->post('paid_photo_gallery_price');
		$rows['website_percentage'] 		= $this->input->post('website_percentage');
		$rows['status'] 					= $this->input->post('status');
		$rows['max_nude_watchers'] 			= $this->input->post('max_nude_watchers');
		
		
		
		if($this->performers->save($rows)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Performer account was saved successfully!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'performer', 
            			$performer->id, 
            			'edit_account', 
            			'Admin edited performer account information.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		} else {
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Performer account was not saved! Please try again!')));
		}         
		redirect(current_url());
		
		}
	}
	
	/**
	 * Editeaza profilul unui performer
	 * @param $username
	 * @return unknown_type
	 */
	function profile($username = 0){
		
		$this->load->model('performers_profile');
		if(strlen($username) == 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This username is invalid')));
			redirect('performers');
		}
		
		$performer = $this->performers->get_all(array('username'=>$username));
		if( ! is_array($performer) || count($performer) <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This performer does not exist!')));
			redirect('performers');
		}
		
		$performer = $performer[0];
		
			$an['-']		= lang('Year');
			$luna['-']		= lang('Month');
			$zi['-']		= lang('Day');
			for($i=1995;$i>=1950;$i--){
				$an[$i]=$i;
			}
			for($i=1;$i<=12;$i++){
				$luna[$i]=$i;
			}
			for($i=1;$i<=31;$i++){
				$zi[$i]=$i;
			}
			
		$data['days']					= $zi;
		$data['months']					= $luna;
		$data['years']					= $an;
		$data['performer'] 				= $performer;
		$data['profile'] 				= $this->performers_profile->get_one_by_id($performer->id);
		$data['gender'] 				= prepare_dropdown($this->performers_profile->get_enum_values('gender'),			lang('Select gender'),				FALSE, TRUE);
		$data['ethnicity'] 				= prepare_dropdown($this->performers_profile->get_enum_values('ethnicity'),			lang('Select ethnicity'),			FALSE, TRUE);
		$data['sexual_prefference'] 	= prepare_dropdown($this->performers_profile->get_enum_values('sexual_prefference'),lang('Select sexual prefference'),	FALSE, TRUE);			
		$data['height'] 				= prepare_dropdown($this->performers_profile->get_enum_values('height'),			lang('Select height'),				FALSE, TRUE);
		$data['weight'] 				= prepare_dropdown($this->performers_profile->get_enum_values('weight'),			lang('Select weight'),				FALSE, TRUE);
		$data['hair_color'] 			= prepare_dropdown($this->performers_profile->get_enum_values('hair_color'),		lang('Select hair color'),			FALSE, TRUE);
		$data['hair_length'] 			= prepare_dropdown($this->performers_profile->get_enum_values('hair_length'),		lang('Select hair length'),			FALSE, TRUE);
		$data['eye_color'] 				= prepare_dropdown($this->performers_profile->get_enum_values('eye_color'),			lang('Select eye'),					FALSE, TRUE);
		$data['build'] 					= prepare_dropdown($this->performers_profile->get_enum_values('build'),				lang('Select build'),				FALSE, TRUE);
		
		$this->form_validation->set_rules('description', 		lang('description'), 		'trim|required|min_length[3]|max_length[255]|strip_tags|purify');
		$this->form_validation->set_rules('what_turns_me_on', 	lang('turn on'), 			'trim|required|min_length[3]|max_length[255]|strip_tags|purify');
		$this->form_validation->set_rules('what_turns_me_off', 	lang('turn off'), 			'trim|required|min_length[3]|max_length[255]|strip_tags|purify');
		$this->form_validation->set_rules('day', 				lang('day'), 		 		'trim|required|strip_tags|numeric|purify|max_length[2]');
		$this->form_validation->set_rules('month', 				lang('month'), 				'trim|required|strip_tags|numeric|purify|max_length[2]');
		$this->form_validation->set_rules('year', 				lang('year'), 				'trim|required|strip_tags|numeric|purify|max_length[4]|birthday');		
		$this->form_validation->set_rules('gender', 			lang('gender'), 			'required|valid_enum_value[gender]');
		$this->form_validation->set_rules('ethnicity', 			lang('ethnicity'), 			'required|valid_enum_value[ethnicity]');
		$this->form_validation->set_rules('sexual_prefference', lang('sexual preference'), 	'required|valid_enum_value[sexual_prefference]');
		$this->form_validation->set_rules('height', 			lang('height'), 			'required|valid_enum_value[height]');
		$this->form_validation->set_rules('weight', 			lang('weight'), 			'required|valid_enum_value[weight]');
		$this->form_validation->set_rules('hair_color', 		lang('hair color'), 		'required|valid_enum_value[hair_color]');
		$this->form_validation->set_rules('hair_length', 		lang('hair length'), 		'required|valid_enum_value[hair_length]');
		$this->form_validation->set_rules('eye_color', 			lang('eye color'), 			'required|valid_enum_value[eye_color]');
		$this->form_validation->set_rules('build', 				lang('build'), 				'required|valid_enum_value[build]');
		
		if($this->form_validation->run() == FALSE){
			
			$data['breadcrumb']['Performers'] = base_url().'performers';
			
			if($performer->id > 0){
				$data['page_head_title'] = $performer->username.'\'s '. lang('profile');
				$data['breadcrumb'][$performer->username.'\'s ' . lang('profile')] = 'current';
			}
			$data['page'] = 'performers_profile_edit';
			$this->load->view('template', $data);
			return;
		} else {
			//Update profil
			$birthday = mktime(0, 0, 0, $this->input->post('month'), $this->input->post('day'), $this->input->post('year'));
			if(! $this->performers_profile->update(
											$performer->id,
											array(
												'birthday'				=> $birthday,
												'gender'				=> $this->input->post('gender'),
												'description'			=> $this->input->post('description'),
												'what_turns_me_on'		=> $this->input->post('what_turns_me_on'),
												'what_turns_me_off'		=> $this->input->post('what_turns_me_off'),
												'sexual_prefference'	=> $this->input->post('sexual_prefference'),
												'ethnicity'				=> $this->input->post('ethnicity'),
												'height'				=> $this->input->post('height'),
												'weight'				=> $this->input->post('weight'),
												'hair_color'			=> $this->input->post('hair_color'),
												'hair_length'			=> $this->input->post('hair_length'),
												'eye_color'				=> $this->input->post('eye_color'),
												'build'					=> $this->input->post('build')
											)
									)
			){
				$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Performer update was not saved! Please try again!')));					
			}
			else
			{
				$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Performer account was successfully updated!')));	
				$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'performer', 
            			$performer->id, 
            			'edit_profile', 
            			'Admin edited performer profile information.', 
            			time(), 
            			ip2long($this->input->ip_address())
				);         												
			}
	
		redirect(current_url());
		
		}
	}
	
	/**
	 * Delete account
	 * @param unknown_type $id
	 * @author Baidoc
	 */
	function delete($id = FALSE){
		
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		
		if($id <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid id!')));
			redirect($referer);
		}
		
		if($this->performers->get_all(array('id' => $id), TRUE) != 1){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('This performer does not exist!')));
			redirect($referer);
		}
		
		
		$rows['id'] = $id;
		$rows['status'] = 'rejected';
		
		if($this->performers->save($rows)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Performer account was successfully suspended!')));
		}else{
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Please try again!')));
		}
		$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'performer', 
            			$id, 
            			'delete_account', 
            			'Admin suspended performer account.', 
            			time(), 
            			ip2long($this->input->ip_address())
		);         
		redirect($referer);
	}
	
	/**
	 * Adauga credite la un performer
	 * @author Baidoc
	 */
	function add_credits() {	
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		$this->load->model('watchers_old');
		
		$this->form_validation->set_rules('amount', 	lang('amount'), 	'trim|required|purify|numeric|min_length[1]');
		$this->form_validation->set_rules('id',			lang('Performer ID'), 'trim|required');
		if( $this->form_validation->run() == FALSE )  {
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => validation_errors()));
			redirect($referer);
			
		} else {
			$amount = $this->input->post('amount');
			$performer_id = $this->input->post('id');
			$performer = $this->performers->get_by_id($performer_id);
			
			$this->db->trans_begin();
						
			//banii performerului
			$performer_amount 	= $amount;
			
			$studio_amount 		= 0;
			
			if( $performer->studio_id ){
				$this->load->model('studios');
				$studio = $this->studios->get_by_id($performer->studio_id);
				$studio_amount = round( $performer_amount * $studio->percentage / 100 ,2);
				$performer_amount -= $studio_amount;
				$this->studios->add_credits( $performer->studio_id, $studio_amount);				
			}
						
			$this->performers->add_credits($performer_id, $performer_amount);
			
			$this->load->model('watchers');
			$data = array(
				'start_date'		=> time(),
				'end_date'			=> time(),
				'show_is_over'		=> 1,
				'type'				=> 'admin_action',
				'performer_chips'	=> $performer_amount,
				'studio_chips'		=> $studio_amount,
				'performer_id'		=> $performer_id,
				'studio_id'			=> $performer->studio_id,
				'unique_id'			=> $this->watchers->generate_one_unique_id() 			
			);
			$this->watchers_old->save($data);
						
						
			$this->system_log->add(
       			'admin', 
            	$this->user->id,
            	'performer', 
            	$performer_id, 
            	($this->input->post('amount') > 0)?'add_credits':'remove_credits', 
				$amount .' credits',				
            	time(),
            	ip2long($this->input->ip_address())
			);
			
			if($this->db->trans_status() === FALSE){
				
				$this->db->trans_rollback();
				$this->session->set_flashdata('msg',array('success'=>FALSE, 'message'=>lang('An error occured')));
				
				//redirectionez pe pagina de unde a venit
				redirect($referer);				
			}

			$this->db->trans_commit();
				
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Credits updated succesfully!')));		
			redirect($referer);
		}
		
	}
	
	function contract_status($performer_id = FALSE) {		
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		
		if($performer_id <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid id!')));
			redirect('performers');
		}
		
		if($this->performers->get_all(array('id' => $performer_id), TRUE) != 1){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('This performer does not exist!')));
			redirect($referer);
		}
		
		$this->load->model('status');
		$this->load->library('pagination');
		
		$data['page'] = 'performer_status/contract_status';
		$data['title'] = lang('Contract Status');
		
		$config['base_url'] 	= site_url('/performers/contract_status/' . $performer_id . '/page/');	
		$config['total_rows'] 	= $this->status->get_all_by_performer_id('contracts', $performer_id, FALSE, FALSE, TRUE);
		$config['per_page'] 	= 5;
		$config['uri_segment'] 	= 5;
		$this->pagination->initialize($config);
		$data['pagination']		= $this->pagination->create_links();
		$data['contracts'] 		= $this->status->get_all_by_performer_id('contracts', $performer_id, $this->pagination->per_page, (int)$this->uri->segment(5));
		$data['performer'] 		= $this->performers->get_by_id($performer_id);
		
		$this->load->view('performer_status/template', $data);
	}
	
	function photo_status($performer_id = FALSE) {
		
		$this->output->enable_profiler(FALSE);
		
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		
		if($performer_id <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid id!')));
			redirect('performers');
		}
		
		if($this->performers->get_all(array('id' => $performer_id), TRUE) != 1){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('This performer does not exist!')));
			redirect($referer);
		}
		
		$this->load->model('status');
		$this->load->library('pagination');
		
		$data['page'] = 'performer_status/photo_id_status';
		$data['title'] = lang('Photo ID Status');
		
		$config['base_url'] 	= site_url('/performers/photo_id_status/' . $performer_id . '/page/');	
		$config['total_rows'] 	= $this->status->get_all_by_performer_id('performers_photo_id', $performer_id, FALSE, FALSE, TRUE);
		$config['per_page'] 	= 5;
		$config['uri_segment'] 	= 5;
		$this->pagination->initialize($config);
		$data['pagination']		= $this->pagination->create_links();
		$data['photo_ids'] 		= $this->status->get_all_by_performer_id('performers_photo_id', $performer_id, $this->pagination->per_page, (int)$this->uri->segment(5));
		$data['performer'] 		= $this->performers->get_by_id($performer_id);
		
		$this->load->view('performer_status/template', $data);
	}
	

	/**Schimba statusul contractului sau al photo_id-ului unui performer
	 * 
	 * @param $type - care status vrem sa-l schimbe performers_contracts sau performers_photo_id
	 * @param $change_to - in ce dorim sa schimbam statusul
	 * @param $status_id - ID-ul statusului care dorim sa-l schimbam
	 * @return unknown_type
	 */
	function update_status($type = FALSE, $change_to, $status_id, $performer_id) {
		
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		$this->load->model('status');
		
		//Setez numele coloanei care trebuie modificata din tabelul performers in functie de statusul pe care admin-ul il schimba
		if($type == 'contracts') {
			$status_type = 'contract_status';
			$template_type = 'contracts';
			$email_subject = sprintf(lang('Your contract was %s'), $change_to);
		} else if($type == 'performers_photo_id') {
			$status_type = 'photo_id_status';
			$template_type = 'photo_id';
			$email_subject = sprintf(lang('Your photo ID was %s'), $change_to);
		} 

		$this->status->set_status($type, $change_to, $status_id);
		
		//Verific care este statusul partial(contract, photo_id) al unui performer si modific si statusul din tabela performers		
		if($this->status->verify_status($type, 'approved', $performer_id)) {
			$this->performers->update_performer_status($performer_id, $status_type, 'approved');
		} else if($this->status->verify_status($type, 'pending', $performer_id)) {
			$this->performers->update_performer_status($performer_id, $status_type, 'pending');
		} else {
			$this->performers->update_performer_status($performer_id, $status_type, 'rejected');
		}
		
		
		//Verific care este statusul general al performerului si fac update
		$performer = $this->performers->get_by_id($performer_id);
		/*		
		if($performer->contract_status == 'approved' && $performer->photo_id_status == 'approved') {
			$this->performers->update_performer_status($performer_id, 'status', 'approved');
		} else if ($performer->contract_status == 'pending' || $performer->photo_id_status == 'pending') {
			$this->performers->update_performer_status($performer_id, 'status', 'pending');
		} else {
			$this->performers->update_performer_status($performer_id, 'status', 'rejected');
		}
		*/
		
		$email_content = $this->load->view('emails/performers_'.$template_type.'_'.$change_to.'_'.$this->config->item('lang_selected'),array(),TRUE);
		$template		= 'admin_performers_'.$template_type.'_'.$change_to;
		
		$performer = $this->performers->get_by_id($performer_id);
		
		$this->load->helper('emails');
			
		$replaced_variables = get_avaiable_variabiles($template, TRUE);
		$replace_value = array($performer->username, $performer->email, $performer->first_name, $performer->last_name, main_url(), WEBSITE_NAME,  main_url('performer/login') );

		$email_content = preg_replace($replaced_variables, $replace_value, $email_content);

		

		//activation email
		$this->load->library('email');
		$this->email->from(SUPPORT_EMAIL,SUPPORT_NAME);
		$this->email->to($performer->email);
		$this->email->subject($email_subject);
		$this->email->message($email_content);
		$this->email->send();
			
			
		$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'performer', 
            			$performer_id, 
            			$type.'_status', 
            			'Admin changed performer\'s ' . $type . ' status '.$status_id . ' to '.$change_to, 
            			time(), 
            			ip2long($this->input->ip_address())
		);
		redirect($referer);
	}
	
	function photos($username = FALSE) {
		$this->load->library('user_agent');
		$this->load->library('image_lib');
		$this->load->library('pagination');
		$this->load->model('performers_photos');
		
		if(strlen($username) == FALSE){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This username is invalid')));
			redirect($this->agent->referer);
		}
		
		$performer = $this->performers->get_all(array('username'=>$username));
		if( ! is_array($performer) || count($performer) <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This performer does not exist!')));
			redirect($this->agent->referer);
		}
		
		$performer = $performer[0];
		
		//Pagination 		
		
		$config['base_url'] 	= site_url('/performers/photos/' . $username . '/page/');	
		$config['total_rows'] 	= $this->performers_photos->count_all_by_performer_id($performer->id);
		$config['per_page'] 	= 15;
		$config['uri_segment'] 	= 5;
		$this->pagination->initialize($config);
		$data['pagination']		= $this->pagination->create_links();
		
		$data['performer'] 		= $performer;
		$data['photos']			= $this->performers_photos->get_multiple_by_performer_id($performer->id, $this->pagination->per_page, (int)$this->uri->segment(5));		
		$this->form_validation->set_rules('title', lang('title'), 'trim|required|min_length[2]|max_length[30]|strip_tags|purify');
		
		
		if($this->form_validation->run() == FALSE){
			
			$data['breadcrumb'][lang('Performers')] = base_url().'performers';
			
			if($performer->id > 0){
				$data['page_head_title'] = $performer->username.'\'s ' . lang('photos');
				$data['breadcrumb'][$performer->username.'\'s ' . lang('photos')] = 'current';
			}
			$data['page'] = 'performers_photo_edit';
			$this->load->view('template', $data);
			
		} else {
			
			# Iau extensia fisierului uploadat
			$ext 			= end(explode(".", $_FILES['image']['name']));
			$upload_path 	= 'uploads/performers/' . $performer->id;
			
			# Verfic ca numele pozei sa fie unic
			$image_name = md5(uniqid(rand(), true));
			while (file_exists($upload_path . $image_name . '.' . $ext)) {
            	$image_name = md5(uniqid(rand(), true));
       		}
       		$full_name = $image_name . '.' . $ext;
       		# Setez directoarele 
			
			$spath 			= 'uploads/performers/' . $performer->id . '/small/' . $full_name;
            $mpath 			= 'uploads/performers/' . $performer->id . '/medium/' . $full_name;
			
			$config['upload_path'] 		= $upload_path;
        	$config['allowed_types'] 	= 'jpeg|jpg|gif|png';
        	$config['max_size'] 		= '5120';
        	$config['file_name'] 		= $image_name;
        	$this->load->library('upload', $config);
        	
			if (getimagesize($_FILES['image']['tmp_name']) == FALSE) {
            	$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This is not a valid image.')));
            	redirect(current_url());
        	}
       		if ( ! $this->upload->do_upload('image')) {
            	$this->session->set_flashdata('msg', array('type' => 'error', 'message' => $this->upload->display_errors()));
            	redirect(current_url());
       		} else {
       			# Copiem poza si in directoarele cu thumbnail-uri
       			copy($upload_path . '/' . $full_name, $spath);
            	copy($upload_path . '/' . $full_name, $mpath);
            
            	# Resize thumbnail
            	$this->image_lib->clear();
            	$this->image_lib->initialize(array(
                	'image_library'  => 'gd2',
                	'source_image'   => $spath,
                	'create_thumb'   => FALSE,
                	'maintain_ratio' => FALSE,
                	'width'          => 150,
                	'height'         => 116
            	));
            	$this->image_lib->crop_delete();

            	# Resize thumbnail
            	$this->image_lib->clear();
            	$this->image_lib->initialize(array(
                	'image_library'  => 'gd2',
                	'source_image'   => $mpath,
                	'create_thumb'   => FALSE,
                	'maintain_ratio' => FALSE,
                	'width'          => 338,
                	'height'         => 260 
            	));
            	$this->image_lib->crop_delete();
            	
           		$this->performers_photos->add($performer->id, $full_name, $this->input->post('title'));
            	$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Image uploaded succesfully!')));
            	$this->system_log->add(
            					'admin', 
            					$this->user->id,
            					'performer', 
            					$performer->id, 
            					'add_photo', 
            					'Admin uploaded a photo to a performer account.', 
            					time(), 
            					ip2long($this->input->ip_address())
            	);
            	redirect(current_url());
        	}
		}
	}
	
	function delete_photo($photo_id = FALSE) {
		$this->load->library('user_agent');
		$this->load->model('performers_photos');
		
		if ( ! $photo_id) {
            $this->session->set_flashdata('msg', array('type' => 'error','message' => lang('Photo ID is missing'),));
            redirect($this->agent->referrer());
        }    	
        
        $photo = $this->performers_photos->get_one_by_id($photo_id); 
               
        if ( ! $photo) {
            $this->session->set_flashdata('msg', array( 'type' => 'error', 'message' => lang('Invalid photo')));
            redirect($this->agent->referrer());
        }
        
        @unlink(BASEPATH . '../uploads/performers/' . $photo->performer_id . '/' . $photo->name_on_disk);
        @unlink(BASEPATH . '../uploads/performers/' . $photo->performer_id . '/small/' . $photo->name_on_disk);
        @unlink(BASEPATH . '../uploads/performers/' . $photo->performer_id . '/medium/' . $photo->name_on_disk);
       
        $this->db->trans_begin();
		$this->performers_photos->delete_photo_by_id($photo_id);

        if ($this->db->trans_status() == FALSE) {
        	
            $this->db->trans_rollback();
                        
            $this->session->set_flashdata('msg', array( 'type' => 'error',  'message' => lang('An error occured!')));                        
            redirect($this->agent->referrer());
        }

        $this->db->trans_commit();
        $this->session->set_flashdata('msg', array( 'type' => 'success',  'message' => lang('Photo has been succesfully deleted.')));
        $this->system_log->add(
            				'admin', 
            				$this->user->id,
            				'performer', 
            				$photo->performer_id, 
            				'delete_photo', 
            				'Admin deleted a photo from a performer account.', 
            				time(), 
            				ip2long($this->input->ip_address())
		);
        redirect($this->agent->referrer());
    }
    
    
	function edit_photo($photo_id = FALSE) {
		
		$this->load->library('user_agent');
		$this->load->model('performers_photos');
		$this->output->enable_profiler(FALSE);
		
		if ( ! $photo_id) {
            $this->session->set_flashdata('msg', array('type' => 'error','message' => lang('Photo ID is missing'),));
            redirect($this->agent->referrer());
        }    	
        
        $photo = $this->performers_photos->get_one_by_id($photo_id); 
               
        if ( ! $photo) {
            $this->session->set_flashdata('msg', array( 'type' => 'error', 'message' => lang('Invalid photo')));
            redirect($this->agent->referrer());
        }
        
		$data['photo'] = $photo;
		$data['title'] = lang('Performers').' - '.SETTINGS_SITE_TITLE;
		
		$this->form_validation->set_rules('title', lang('title'), 'trim|required|min_length[2]|max_length[30]|strip_tags|purify');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('photo_edit_window', $data);
		} else {
			
			
			$rows['title'] = $this->input->post('title');
			
            $this->performers_photos->update($photo_id,$rows);
			$this->session->set_flashdata('msg', array( 'type' => 'success_title', 'message' => lang('Changes saved')));
			$this->system_log->add(
						'admin', 
						$this->user->id,
						'performer', 
						$photo->performer_id, 
						'edit_photo', 
						'Admin edited a photo from a performer account.', 
						time(), 
						ip2long($this->input->ip_address())
			);  
            	
           
		            
			redirect(current_url());	
		}
	}
	
	
	function videos($username = FALSE) {
		
		$this->load->library('user_agent');
		$this->load->library('image_lib');
		$this->load->library('pagination');
		$this->load->helper('text');
		$this->load->model('performers_videos');
		$this->load->model('fms');
		
		if(strlen($username) == FALSE){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This username is invalid')));
			redirect($this->agent->referer);
		}
		
		$performer = $this->performers->get_all(array('username'=>$username));
		if( ! is_array($performer) || count($performer) <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This performer does not exist!')));
			redirect($this->agent->referer);
		}
		$this->fms_list = create_array_by_property($this->fms->get_multiple(),'fms_id');
		$performer = $performer[0];
	
		//Pagination 		
		$config['base_url'] 	= site_url('/performers/videos/' . $username . '/page/');	
		$config['total_rows'] 	= $this->performers_videos->get_multiple_by_performer_id($performer->id, FALSE, FALSE, TRUE);
		$config['per_page'] 	= 15;
		$config['uri_segment'] 	= 5;
		$this->pagination->initialize($config);
		$data['pagination']		= $this->pagination->create_links();
		
		$data['performer'] 		= $performer;
		$data['videos']			= $this->performers_videos->get_multiple_by_performer_id($performer->id, $this->pagination->per_page, (int)$this->uri->segment(5));		
		
		$data['page']							= 'performer_videos';
		$data['breadcrumb'][lang('Performers')]	= site_url('performers');
		$data['breadcrumb'][lang('videos')]	= 'current';
		$data['page_head_title']			= lang('Performer videos'); 
		
		
		$this->load->view('template', $data);
		
	}
	
	
	function view_video($video_id = false){
		$this->load->library('user_agent');
		$this->load->model('fms');
		$this->im_in_modal = TRUE;
		
		if($video_id <= 0){
			$this->session->set_flashdata('msg',array('type'=>'error','message'=>lang('Invalid video id!')));
			redirect($this->agent->referrer());
		}
		$this->load->model('performers_videos');
		$video = $this->performers_videos->get_one_by_id($video_id);
		
		if(!is_object($video)){
			$this->session->set_flashdata('msg',array('type'=>'error','message'=>lang('This video does not exist!')));
			redirect($this->agent->referrer());
		}
		
		$this->fms_list = create_array_by_property($this->fms->get_multiple(),'fms_id');
		
		$data['video'] = $video;
		
		$this->load->view('performer_video_view', $data);
		
	}
	
	
	function edit_video($video_id = FALSE){
		$this->load->library('user_agent');
		$this->load->library('form_validation');
		$this->load->model('fms');
		//$this->im_in_modal = TRUE;
		$data['types']					= array(0=>lang('free'),1=>lang('paid'));
		$this->video_types				= $data['types'];
		
		if($video_id <= 0){
			$this->session->set_flashdata('msg',array('type'=>'error','message'=>lang('Invalid video id!')));
			redirect($this->agent->referrer());
		}
		$this->load->model('performers_videos');
		$video = $this->performers_videos->get_one_by_id($video_id);
		
		if(!is_object($video)){
			$this->session->set_flashdata('msg',array('type'=>'error','message'=>lang('This video does not exist!')));
			redirect($this->agent->referrer());
		}
		
		$this->form_validation->set_rules('description', lang('description'), 'trim|required|min_length[1]|max_length[255]|strip_tags|purify');
		
		if($this->form_validation->run() == FALSE){
			
			$data['video'] = $video;
			
			
			$this->load->view('performer_video_edit', $data);
			return;
		}
		
		$row['is_paid']	= $this->input->post('type');
		$row['price']		= $this->input->post('price');
		$row['description'] = $this->input->post('description');
		
		if($this->performers_videos->update($video_id, $row)){
			$this->session->set_flashdata('msg',array('type'=>'success','message'=>lang('Data was saved successffuly!')));
		}else{
			$this->session->set_flashdata('msg',array('type'=>'success','message'=>lang('An error occured!')));
		}
		redirect(current_url());
		
		
	}
        
	// ---------------------------------------------------------------------	
	/**
	 * Listare sessiuni de watchers
	 * @param $username
	 * @param $order_by
	 * @param $order_type
	 * @param $page_nr
	 * @return unknown_type
	 */
	function sessions($username = FALSE, $order_by = 'id', $order_type = 'desc', $page_nr = '0') {
		if( ! $username ){
			redirect('performers');			
		}
		
		$performer = $this->performers->get_all(array('username'=>$username));	
		if( sizeof($performer) == 0 ){
			redirect('performers');
		}
		$performer = $performer[0];
		
		$this->types	= array('all','private','true_private','peek','nude','free','premium_video','photos','gift','admin_action');
		$this->load->model('payments');
		$payments  = $this->payments->get_all(array('performer_id'=>$performer->id));
		$data['payments'] = prepare_payment_list($payments);
		
		$this->load->model('watchers_old');
		$this->load->helper('credits');
	
		$filters['performer_id'] = $performer->id;
		if(key_exists((string)$this->input->get('type'),$this->types) && (int)$this->input->get('type')){
			$filters['type']	= $this->types[$this->input->get('type')];
		}
		
		if(key_exists((string)$this->input->get('period'),$payments)){
			$filters['start_date'] 	= $payments[$this->input->get('period')]->start_date;
			$filters['end_date'] 	= $payments[$this->input->get('period')]->end_date;
			$filters['filter_id']	= $payments[$this->input->get('period')]->id;
		}		
		
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('performers/sessions/'.$username.'/'.$order_by.'/'.$order_type.'/');
		$config['uri_segment'] 	= 6;
		$config['total_rows']   = $this->watchers_old->get_all($filters, TRUE);
		$config['per_page']		= 20;
		
		$this->admin_pagination->initialize($config);
		
		$data['performer']						= $performer;
		$data['pagination']     				= $this->admin_pagination->create_links();
		$data['sessions']						= $this->watchers_old->get_all($filters, FALSE, $order_by.' '.$order_type, $this->uri->segment(6), $config['per_page']);
		$data['order_by'] 						= $order_by;
		$data['order_type'] 					= $order_type;
		$data['filters_array']					= $filters;
		$data['page']							= 'performer_sessions';
		$data['breadcrumb'][lang('Performers')]	= site_url('performers');
		$data['breadcrumb'][lang('Sessions')]	= 'current';
		$data['page_head_title']			= lang('Performer sessions'); 
		
		$this->load->view('template', $data);
	}
	
	// ---------------------------------------------------------------------
	/**
	 * Listare plati
	 * @param $username
	 * @param $order_by
	 * @param $order_type
	 * @param $page_nr
	 * @return unknown_type
	 */
	function payments($username = FALSE, $order_by = 'id', $order_type = 'asc', $page_nr = '0') {
		if( ! $username ){
			redirect('performers');			
		}
		
		$performer = $this->performers->get_all(array('username'=>$username));
		
		if( sizeof($performer) == 0 ){
			redirect('performers');
		}
		
		$performer = $performer[0];
		
		$this->load->model('payments');
		$this->load->helper('credits');
		$filters = FALSE;


		$filters['performer_id'] = $performer->id;
		
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('performers/payments/'.$username.'/'.$order_by.'/'.$order_type.'/');
		$config['uri_segment'] 	= 6;
		$config['total_rows']   = $this->payments->get_all($filters, TRUE);
		$config['per_page']		= 20;
		
		$this->admin_pagination->initialize($config);
		
		$data['performer']						= $performer;
		$data['pagination']     				= $this->admin_pagination->create_links();
		$data['payments']						= $this->payments->get_all($filters, FALSE, $order_by.' '.$order_type, $this->uri->segment(6), $config['per_page']);
		$data['order_by'] 						= $order_by;
		$data['order_type'] 					= $order_type;
		$data['filters_array']					= $filters;
		$data['page']							= 'performer_payments';
		$data['breadcrumb'][lang('Performers')]	= site_url('performers');
		$data['breadcrumb'][lang('Payments')]	= 'current';
		$data['page_head_title']			= lang('Performer payments'); 
		
		$this->load->view('template', $data);
	}
	
	/**
	* Spioneaza o sesiune de chat
	* @param $performer_id
	*/
	function spy($performer_id = FALSE){
		if( ! $performer_id ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('invalid performer')));
			redirect('performers');
		}
				
		$performer = $this->performers->get_all(array('id'=>$performer_id));
		
		
			
		if( sizeof($performer) == 0){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('invalid performer')));
			redirect('performers');
		}
		
		$performer = $performer[0];
		
		if( ! $performer->is_online ){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('performer is currently offline')));
			redirect('performers');
		}
	
		$this->load->model('fms');
		$fms = $this->fms->get_one_by_id($performer->fms_id);
		if ( ! $fms ){
			$this->session->set_flashdata('msg', array('success' => TRUE, 'message' => lang('performer is currently offline')));
			redirect('performers');
		}
	
	
		$this->load->model('watchers');
		$params['uniqId']		= $this->watchers->generate_one_unique_id();
	
		$params['pasword']		= $this->user->password;
		$params['userId']		= 'a' . $this->user->id;
		$params['userName']		= $this->user->username;
	
		$params['rtmp']					= $fms->fms;
		$params['performerId']			= $performer->id;
		$params['sessionType']			= 'spy';
		$params['performerNick']		= $performer->nickname;
		$params['performerNickColor']	= '0x129400';
		$params['nickColor']			= '0x129400';
		$params['sitePath']				= main_url();
		$params['redirectLink']			= site_url();
	
		$data['params']		= $params;
		$data['width']		= 940;
		$data['height']		= 560;
		$data['swf']		= 'spy.swf';
	
		$data['allow_fullscreen']	 = TRUE;
	
		$this->output->set_header("HTTP/1.1 200 OK");
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
			
		$this->load->view('performers/spy',$data);
	}	
}