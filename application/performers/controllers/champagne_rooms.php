<?php
/**
 * 
 */
Class Champagne_rooms_controller extends MY_Performer{

    private $types = array('girl' => 'Girl','girl/girl' => 'Girl / Girl', 'girl/boy' => 'Girl / Boy');
    private $referer;
	// -----------------------------------------------------------------------------------------		
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
                $this->load->model('champagne_rooms');
		$this->load->library('form_validation');
		$this->referer = $this->agent->referrer();
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * 
	 */
	function index(){
		
		$this->load->library('pagination');
		$config['base_url'] 	= site_url('champagne_rooms/page/');	
		$config['total_rows'] 	= $this->champagne_rooms->get_multiple_by_performer_id($this->user->id, FALSE, FALSE, FALSE, TRUE);
		$config['per_page'] 	= 10;
		$config['uri_segment'] 	= 3;
		$this->pagination->initialize($config);

		$data['champagne_rooms']= $this->champagne_rooms->get_multiple_by_performer_id($this->user->id, $this->pagination->per_page, (int)$this->uri->segment(3), FALSE);
		$data['number']		= $config['total_rows'];
		$data['pagination']	= $this->pagination->create_links();
		
		$data['_champagne_rooms_sidebar']	= TRUE;
		$data['_performer_menu']		= TRUE;
		$data['page'] 				= 'champagne_rooms/index';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 			= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 			= lang('Champagne rooms').' - '.SETTINGS_SITE_TITLE;
		$data['types'] = $this->types;
		$this->load->view('template', $data);			
	}
        
        function view($id = 0){

            $this->load->model('champagne_rooms');
            if(!$data['champagne_room'] = $this->champagne_rooms->get_one_by_id($id)){
               $this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid id!'))); 
               redirect($referer);
            }
            $data['users'] = $this->champagne_rooms->get_users($id);
            $data['_champagne_rooms_sidebar']	= TRUE;
            $data['_performer_menu']		= TRUE;
            $data['page'] 			= 'champagne_rooms/view';
            $data['description'] 		= SETTINGS_SITE_DESCRIPTION;
            $data['keywords'] 			= SETTINGS_SITE_KEYWORDS;
            $data['pageTitle'] 			= lang('Champagne rooms').' - '.SETTINGS_SITE_TITLE;	

            $data['types']     = $this->types;
            $this->load->view('template', $data);
        }
        
	function add_or_edit($id = 0){
                $referer = $this->agent->referrer();

		if($id > 0){
			$data['champagne_room'] = $this->champagne_rooms->get_one_by_id($id);
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
		$this->form_validation->set_rules('day', lang('day'), 'trim|required|numeric|max_length[2]');
		$this->form_validation->set_rules('month', lang('month'), 'trim|required|numeric|max_length[2]');
		$this->form_validation->set_rules('year', lang('year'), 'trim|required|numeric|max_length[4]');
		$this->form_validation->set_rules('hour', lang('Hour'), 'trim|required|numeric|exact_length[2]');
		$this->form_validation->set_rules('min', lang('Minut'), 'trim|required|numeric|exact_length[2]');
		$this->form_validation->set_rules('sec', lang('Second'), 'trim|required|numeric|exact_length[2]');     
		if($this->form_validation->run() == FALSE){
			$an['-']		= lang('Year');
			$luna['-']		= lang('Month');
			$zi['-']		= lang('Day');
			for($i=date('Y')+10;$i>=date('Y');$i--){
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
                        
			if($id > 0){
				$data['page_head_title'] = lang('Edit champagne room');
			}else{
				$data['page_head_title'] = lang('Add champagne room');
			}               
                        $data['_champagne_rooms_sidebar']	= TRUE;
                        $data['_performer_menu']		= TRUE;
                        $data['description'] 		= SETTINGS_SITE_DESCRIPTION;
                        $data['keywords'] 			= SETTINGS_SITE_KEYWORDS;
                        $data['pageTitle'] 			= lang('Champagne rooms').' - '.SETTINGS_SITE_TITLE;	
                        $data['types']     = $this->types;
			$data['page'] = 'champagne_rooms/add_or_edit';
			$this->load->view('template', $data);
			return;
		}
		
		if($id > 0){
                    $rows['id'] = $data['champagne_room']->id;
		}else{
                    $rows['performer_id'] = $this->user->id;
                }
		$rows['title'] = $this->input->post('title');
		$rows['is_private'] = $this->input->post('is_private');
                $rows['type'] = $this->input->post('type');
                $rows['ticket_price'] = $this->input->post('ticket_price');
                $rows['min_tickets'] = $this->input->post('min_tickets');
                $rows['max_tickets'] = $this->input->post('max_tickets');
                $rows['join_in_session'] = $this->input->post('join_in_session');
                $rows['start_time'] = mktime($this->input->post('hour'), $this->input->post('min'), $this->input->post('sec'), $this->input->post('month'), $this->input->post('day'), $this->input->post('year'));	
                $rows['duration'] = $this->input->post('duration')*60;
                $rows['status'] = $this->input->post('status');
                
		if($id = $this->champagne_rooms->save($rows)){
                        $this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Champagne room was saved successfully!')));
		}else{
                        $this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Champagne room was not saved! Please try again!')));
		}
		redirect('champagne_rooms/view/'.$id);
		
	}
        
        function delete($id = FALSE) {
		$this->load->library('user_agent');
		if(strstr($this->referer, 'view')) $referer = 'champagne_rooms';
                else $referer = $this->referer;
		if($id <= 0){
                        $this->session->set_flashdata('msg',array('success'=>false,'message'=>lang('Invalid id!')));
			redirect($referer);
		}
		
		if(!$this->champagne_rooms->get_by_id($id)){
                        $this->session->set_flashdata('msg',array('success'=>false,'message'=>lang('This champagne room does not exist!')));
			redirect($referer);
		}
		
		if($this->champagne_rooms->delete($id)){
                        $this->session->set_flashdata('msg',array('success'=>TRUE,'message'=>lang('Champagne room was successfully deleted!')));
		}else{
                        $this->session->set_flashdata('msg',array('success'=>false,'message'=>lang('Champagne room cannot be deleted! Please try again!')));
		}
		
		redirect($referer);
	}
        
        public function type_check($value)
        {
            $type = trim($value);
            if(in_array($type,array_keys($this->types))) return true;
            else {
                $this->form_validation->set_message('type_check', 'Please select a valid Type value');
                return false;
            }
        }
        
        public function boolean_check($selectValue)
        {
            $selectValue = intval(trim($selectValue));
            if($selectValue != 0 && $selectValue != 1)
            {
                $this->form_validation->set_message('boolean_check', 'Please select a valid value (Yes/No)');
                return false;
            }
            else 
            {
                return true;
            }
        }
}
