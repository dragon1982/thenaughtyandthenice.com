<?php
class Champagne_rooms_controller extends MY_Admin {

    private $types = array('girl' => 'Girl','girl/girl' => 'Girl / Girl', 'girl/boy' => 'Girl / Boy');
    
	function __construct() {
		parent::__construct();
		$this->load->model('champagne_rooms');
		$this->load->library('form_validation');
		$this->load->helper('filters');
		$this->load->helper('utils');
	}
	
	function index() {
		$filters	= purify_filters($this->input->get('filters'),'champagne_rooms');
		$order		= purify_orders($this->input->get('orderby'),'champagne_rooms');
	
		//caguna a facut in model niste avioane de validari:)
		$this->ignore_rest = 1;
		
		$data['filters']	= array2url($filters,'filters');
		$data['order_by']	= $this->input->get('orderby');
		
		//$filters['status'] = '!= rejected';
		$filters['join']['performers'] = 'id = performer_id, left';
		$this->load->library('admin_pagination');
		
		$config['base_url']     = site_url('champagne_rooms/page/');
		$config['uri_segment'] 	= 3;
		$config['total_rows']   = $this->champagne_rooms->get_all($filters, TRUE);
		$config['per_page']		= 20;
		
		$this->admin_pagination->initialize($config);

		$data['pagination']     = $this->admin_pagination->create_links();
		$data['champagne_rooms']= $this->champagne_rooms->get_all($filters, FALSE,implode_order($order) , $this->uri->segment(3), $config['per_page']);

		$data['page'] = 'champagne_rooms/index';
		$data['breadcrumb'][lang('Champagne_rooms')]	= 'current';
		$data['page_head_title']			= lang('champagne_rooms'); 
                $data['types'] = $this->types;
		$this->load->view('template', $data);
	}
        
	function add_or_edit($id = 0){

		if($id > 0){
			$champagne_room = $this->champagne_rooms->get_by_id($id);
			$data['champagne_room'] = $champagne_room;
                }
                
                $data['types'] = $this->types;
                
		$this->form_validation->set_rules('title', lang('title'), 'required|trim|min_length[2]|max_length[100]|strip_tags|purify');
                $this->form_validation->set_rules('is_private', lang('private'), 'callback_boolean_check');
                $this->form_validation->set_rules('type', lang('is_private'), 'trim|callback_type_check|purify');
		$this->form_validation->set_rules('ticket_price', lang('ticket_price'), 'trim|is_numeric|min_length[1]|max_length[10]|strip_tags|purify');
		$this->form_validation->set_rules('min_tickets', lang('min_tickets'), 'trim|is_natural|min_length[1]|max_length[10]|strip_tags|purify');
                $this->form_validation->set_rules('max_tickets', lang('max_tickets'), 'trim|is_natural|min_length[1]|max_length[10]|strip_tags|purify');
                $this->form_validation->set_rules('join_in_session', lang('join_in_session'), 'callback_boolean_check');
                $this->form_validation->set_rules('duration', lang('duration'), 'trim|is_natural|min_length[1]|max_length[10]|strip_tags|purify');
                $this->form_validation->set_rules('status', lang('status'), 'callback_boolean_check');

		if($this->form_validation->run() == FALSE){

			$data['breadcrumb'][lang('Champagne rooms')] = base_url().'champagne_rooms';
			
			if($id > 0){
				$data['page_head_title'] = lang('Edit champagne room');
				$data['breadcrumb'][lang('Edit champagne room')] = 'current';
			}else{
				$data['page_head_title'] = lang('Add champagne room');
				$data['breadcrumb'][lang('Add champagne room')] = 'current';
			}
			
			$data['page'] = 'champagne_rooms/add_or_edit';
			$this->load->view('template', $data);
			return;
		}
		
		if($id > 0){
			$rows['id']			= $champagne_room->id;
		}
				
		$rows['title'] = $this->input->post('title');
		$rows['is_private'] = $this->input->post('is_private');
                $rows['type'] = $this->input->post('type');
                $rows['ticket_price'] = $this->input->post('ticket_price');
                $rows['min_tickets'] = $this->input->post('min_tickets');
                $rows['max_tickets'] = $this->input->post('max_tickets');
                $rows['join_in_session'] = $this->input->post('join_in_session');
                $rows['duration'] = $this->input->post('duration')*60;
                $rows['status'] = $this->input->post('status');

		if($this->champagne_rooms->save($rows)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Champagne room was saved successfully!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'other', 
            			NULL, 
            			($id > 0) ? 'edit champagne room' : 'add champagne room', 
            			($id > 0) ? 'Admin edited a champagne_room' : 'Admin added a new champagne_room', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		}else{
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Champagne room was not saved! Please try again!')));
		}
		redirect('champagne_rooms');
		
	}

        function delete($id = FALSE) {
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		
		if($id <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid id!')));
			redirect($referer);
		}
		
		if(!$this->champagne_rooms->get_by_id($id)){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('This champagne room does not exist!')));
			redirect($referer);
		}
		
		if($this->champagne_rooms->delete($id)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Champagne room was successfully deleted!')));
			$this->system_log->add(
            			'admin', 
            			$this->user->id,
            			'user', 
            			$id, 
            			'delete_champagne_room', 
            			'Admin deleted champagne room.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		}else{
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Champagne room cannot be deleted! Please try again!')));
		}
		
		redirect($referer);
	}
        
        public function type_check($value)
        {
            $type = trim($value);
            if(in_array($type,array_keys($this->types))) return true;
            else {
                $this->form_validation->set_message('type_check', 'Please select a valid $select Type value');
                return false;
            }
        }
        
        public function boolean_check($selectValue)
        {
            $selectValue = intval(trim($selectValue));
            if($selectValue != 0 && $selectValue != 1)
            {
                $this->form_validation->set_message('boolean_check', 'Please select a valid value');
                return false;
            }
            else 
            {
                return true;
            }
        }
}