<?php
/**
 * @property Payment_methods $payment_methods
 * @property Performers $performers
 * @property Status $status
 *
 */
class Payment_methods_controller extends MY_Admin {
	
	function __construct() {
		parent::__construct();
		$this->load->model('performers');
		$this->load->library('form_validation');
		$this->load->helper('generic_helper');
	}

	function index() {
		$this->view();
	}
	
	/**
	 * Adauga o metoda de plata
	 * @return unknown_type
	 */
	function add() {
		$this->load->model('payment_methods');
		
		$this->form_validation->set_rules('name', 				lang('name'), 				'trim|required|strip_tags|purify|min_length[3]|max_length[40]|Unique[payment_methods.name]');
		$this->form_validation->set_rules('minimum_amount', 	lang('minimum amount'),		'trim|required|strip_tags|purify|min_length[1]|max_length[6]|numeric');
		$this->form_validation->set_rules('status', 			lang('status'), 			'required|strip_tags|purify');
		$this->form_validation->set_rules('add_field',			lang('Field'),				'trim|valid_post_field');
		
		//daca a intervenit o eroare de validare server-side, trimit field-urile adaugate de acesta la view, pentru a nu le pierde
		$old_fields = array();
		foreach($_POST as $key => $value) { 						
			if(substr($key,0,5) == "field" && $value != "") {
				$this->form_validation->set_rules($key, $value, 'trim|valid_post_field');
				array_push($old_fields, $value);
			}
		}

		$data['old_fields'] 						= $old_fields;
		$data['currency'] 							= array('' => lang('Select Currency'), 'euro' => 'euro', 'dollar' => 'dollar');
		$data['status'] 							= array('' => lang('Select Status'), 'approved' => lang('approved'), 'rejected' => lang('rejected'));
		$data['title'] 								= lang('Add payment method').' - '.SETTINGS_SITE_TITLE;
		$data['breadcrumb'][lang('Add Payment Method')]	= 'current';
		$data['page_head_title']					= lang('Add Payment Method'); 
		$data['page'] 								= 'payments/payment_methods';
		$data['current_page']						= 'add';
		
		if($this->form_validation->run() == FALSE) {
			
			$this->load->view('template', $data);
			
		} else {
			//caut field-urile adaugate de admin pentru a le serializa, acestea incep cu field_#
			//@TODO creeaza lang de field-uri adaugate de admin
			$fields = array();
			
			foreach($_POST as $key => $value) { 
				if(substr($key,0,5) == "field" && $value != "") {
					array_push($fields, $value);
				}
			}
			
			//adaug si campul add_field daca a ramas completat la metoda de plata
			if ($this->input->post('add_field') != "") {
				array_push($fields, $this->input->post('add_field'));
			}
			
			$rows['name'] = $this->input->post('name');
			$rows['minim_amount'] = $this->input->post('minimum_amount');
			$rows['status'] = $this->input->post('status');
			$rows['fields'] = serialize($fields);
			
			if($this->payment_methods->save($rows)){
				$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Payment method was saved successfully!')));
				$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'other', 
            			NULL, 
            			'add_payment_method', 
            			'Admin has added a new payment method.', 
            			time(), 
            			ip2long($this->input->ip_address())
				);
			} else {
				$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Payment method was not saved! Please try again!')));
			}
			redirect(current_url());
		}		
	}
	/**
	 * Afiseaza toate metodele de plata existente
	 * @return unknown_type
	 */
	function view() {
		$this->load->model('payment_methods');
		
		$data['breadcrumb'][lang('Your Payment Methods')]	= 'current';
		$data['page_head_title']							= lang('Your Payment Methods'); 
		$data['page'] 										= 'payments/view_payment_methods';
		$data['payment_methods']							= $this->payment_methods->get_all();
		$data['current_page']								= 'view';
		
		$this->load->view('template', $data);
		
	}
	
	/**
	 * Editeaza o metoda de plata data prin ID
	 * @param $payment_id
	 * @return unknown_type
	 */
	function edit($payment_id = FALSE) {
		$this->load->model('payment_methods');
		
		if ( ! $payment_id) {
            $this->session->set_flashdata('msg', array('type' => 'error','message' => lang('Invalid Payment'),));
            redirect('payment-methods');
        }    	
        
        $payment = $this->payment_methods->get_by_id($payment_id); 
               
        if ( ! $payment) {
            $this->session->set_flashdata('msg', array( 'type' => 'error', 'message' => lang('Invalid Payment')));
            redirect('payment-methods');
        }
		
		$this->load->model('payment_methods');
		
		$this->form_validation->set_rules('name', 				lang('name'), 				'trim|required|strip_tags|purify|min_length[3]|max_length[40]|update_unique[payment_methods.name.'.$payment_id.']');
		$this->form_validation->set_rules('minimum_amount', 	lang('minimum amount'),		'trim|required|strip_tags|purify|min_length[1]|numeric');
		$this->form_validation->set_rules('status', 			lang('status'), 			'required|strip_tags|purify');
		
		//daca a intervenit o eroare de validare, trimit field-urile adaugate de acesta la view, pentru a nu le pierde
		$old_fields = array();
		foreach($_POST as $key => $value) { 
				if(substr($key,0,5) == "field" && $value != "") {
					array_push($old_fields, $value);
				}
			}
			
		$data['payment']  									= $payment; 
		$data['old_fields'] 								= $old_fields;
		$data['currency'] 									= array('' => lang('Select Currency'), 'euro' => 'euro', 'dollar' => 'dollar');
		$data['status'] 									= array('' => lang('Select Status'), 'approved' => lang('approved'), 'rejected' => lang('rejected'));
		$data['title'] 										= lang('Edit payment method').' - '.SETTINGS_SITE_TITLE;
		$data['breadcrumb'][lang('Edit Payment Method')]	= 'current';
		$data['page_head_title']							= lang('Edit Payment Method'); 
		$data['page'] 										= 'payments/edit_payment_methods';
		$data['current_page']								= 'edit';
			
		if($this->form_validation->run() == FALSE) {
			
			$this->load->view('template', $data);
			
		} else {
			//caut field-urile adaugate de admin pentru a le serializa, acestea incep cu field_#
			//@TODO adauga in lang field-uri noi sau editate
			$fields = array();
			
			foreach($_POST as $key => $value) { 
				if(substr($key,0,5) == "field" && $value != "") {
					array_push($fields, $value);
				}
			}
			
			$rows['id']				= $payment_id;
			$rows['name'] 			= $this->input->post('name');
			$rows['minim_amount'] 	= $this->input->post('minimum_amount');
			$rows['status'] 		= $this->input->post('status');
			$rows['fields'] 		= serialize($fields);
			
			$this->db->trans_begin();
			$this->payment_methods->update_performer_accounts($payment_id);
			$this->payment_methods->save($rows);
			if($this->db->trans_status() == FALSE){
				$this->db->trans_rollback();
				$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Payment method was not saved! Please try again!')));				
			} else {
				$this->db->trans_commit();
				$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'other', 
            			NULL, 
            			'edit_payment_method', 
            			'Admin has edited a payment method.', 
            			time(), 
            			ip2long($this->input->ip_address())
				);
				$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Payment method edited successfully!')));
			}
			redirect(current_url());
		}		
	}				
	
	/**
	 * Sterge o metoda de plata data prin ID
	 * @param $payment_id
	 * @return unknown_type
	 */
	function delete($payment_id = FALSE) {
		$this->load->library('user_agent');
		$this->load->model('payment_methods');
		
		if ( ! $payment_id) {
            $this->session->set_flashdata('msg', array('type' => 'error','message' => lang('Invalid Payment'),));
            redirect('payment-methods');
        }
        
        $payment = $this->payment_methods->get_by_id($payment_id); 
               
        if ( ! $payment) {
            $this->session->set_flashdata('msg', array( 'type' => 'error', 'message' => lang('Invalid Payment')));
            redirect('payment-methods');
        }
        $this->db->trans_begin();  
        $this->payment_methods->update_performer_accounts($payment_id);
        $this->payment_methods->delete($payment_id);
        if($this->db->trans_status() == FALSE){
        	$this->db->trans_rollback();
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('An error has occured! Please try again!')));
		} else {
			$this->db->trans_commit();
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Payment method deleted successfully!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'other', 
            			NULL, 
            			'delete_payment_method', 
            			'Admin has deleted a payment method.', 
            			time(), 
            			ip2long($this->input->ip_address())
				);	
		}
        redirect('payment-methods');
    }
}
