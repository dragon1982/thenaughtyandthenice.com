<?php
/**
 * @property Performers $performers
 * @property Status $status
 * @property System_log $system_log
 */
class Newsletter_controller extends MY_Admin {
	
	function __construct() {
		parent::__construct();
		$this->load->model('newsletter_cron');
		$this->load->model('affiliates');
		$this->load->model('performers');
		$this->load->model('studios');
		$this->load->model('users');
		$this->load->library('form_validation');
		$this->load->helper('generic_helper');
	}
	
	function index() {
		
		$data['account_types'] = array('all' => lang('All'),'affiliates'=>lang('Affiliates'), 'performers'=>lang('Performers'), 'studios'=>lang('Studios'), 'users'=>lang('Users'));

		$data['account_status'] = array('all'=>lang('All'));
		$avaiable_status = $this->users->get_enums_field('status');
		$data['account_status'] = array_merge($data['account_status'], $avaiable_status);


		
		$this->form_validation->set_rules('subject', lang('Email Subject'), 'trim|required|purify');
		$this->form_validation->set_rules('body', lang('Email body'), 'required');
		
		if($this->form_validation->run() == FALSE){
		
			
			$data['page'] = 'newsletter';

			$data['breadcrumb'][lang('Newsletter')]	= 'current';
			$data['page_head_title']				= lang('Newsletter'); 

			$this->load->view('template', $data);
			return;
		}
		
		$account_type	= $this->input->post('account_type');
		$account_status = $this->input->post('account_status');
		$subject		= $this->input->post('subject');
		$body			= $this->input->post('body');
		
		if(!isset($data['account_types'][$account_type])){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid acount type!')));
			redirect('newsletter');
		}
		
		if(!isset($data['account_status'][$account_status])){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid acount status!')));
			redirect('newsletter');
		}
		
		$where = array();
		if($account_status != 'all'){
			$where['status'] = $data['account_status'][$account_status];
		}
		
                if($account_type == 'users'){
                    $where['join']['users_detail'] = 'user_id = id, left';
                    $where['users_detail.newsletter'] = '1';
                }
		
		if($account_type == 'all'){
			unset($data['account_types']['all']);
			
			foreach($data['account_types'] as $type => $type_name){
				$recipients[] = $this->$type->get_all($where);
			}
		}else{
			$recipients[] = $this->$account_type->get_all($where);
		}
		
		
		$n['email_subject'] = $subject;
		$n['email_body'] = $body;
		$n['add_date'] = time();
		$i = 0;
		foreach($recipients as $recipint){
			if(is_array($recipint)){
				foreach($recipint as $account){
					if(is_object($account)){
                                            if($account_type == 'users'){
                                                $n['recipient_email'] = $account->users_email;
                                            }else{
						$n['recipient_email'] = $account->email;
                                            }
                                            $this->newsletter_cron->save($n);
                                            $i++;
					}
				}
			}elseif(is_object($recipint)){
                                 if($account_type == 'users'){
                                     $n['recipient_email'] = $recipint->users_email;
                                 }else{
                                    $n['recipient_email'] = $recipint->email;
                                 }
				$this->newsletter_cron->save($n);
				$i++;
			}
		}
		
		$this->session->set_flashdata('msg', array('type' => 'success', 'message' => sprintf(lang('Newsletter was saved and will be sent to %s accounts!'),$i)));
		redirect('newsletter');	
	}	
}