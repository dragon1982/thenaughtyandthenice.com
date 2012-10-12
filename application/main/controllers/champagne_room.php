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
 * @property System_logs $system_logs
 * @property banned_countries $banned_countries
 * @property Messages $messages
 * @property Ratings $ratings
 * @property Watchers $watchers
 * @property Performers_reviews $performers_reviews
 */

class Champagne_room_controller extends MY_Controller{

	public $fms_list;

	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('champagne_rooms');
                $this->load->model('users');
		$this->load->model('performers');		
		$this->load->model('categories');

		$this->load->config('filters');
		$this->load->helper('filters');


		//purifica filtrele
		$_GET['filters'] = purify_filters((isset($_GET['filters'])?$_GET['filters']:NULL));

		$this->load->model('fms');
		$this->fms_list = create_array_by_property($this->fms->get_multiple(),'fms_id');

	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Listare modele
	 * @return unknown_type
	 */
	function index(){

		$this->load->library('pagination');

		$config['per_page']				= 21;
		$config['base_url'] 			= site_url('champagne-room/page/');
		$config['total_rows']   	= 0;
		$this->pagination->initialize($config);

		$data['champagne_room_featured'] 	= $this->champagne_rooms->get_featured();		
		$data['champagne_rooms_featured'] 	= $this->champagne_rooms->get_all_featured();
		$data['champagne_rooms'] 	= $this->champagne_rooms->get_all();

		$data['pagination']				= $this->pagination->create_links();

		$data['pageViewHeight'] 	= 634;

		$data['_sidebar']					= false;
		$data['_signup_header']		= true;
		$data['page'] 						= 'champagne_room/listing';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= 'Champagne Room - '.SETTINGS_SITE_TITLE;

		$search = prepare_search_options();
		$data = array_merge($data, $search);

		$this->load->view('template', $data);
	}
        
        function view($id = null){
            //$this->access->restrict('users'); 
            $champagne_room = $this->champagne_rooms->get_by_id($id);
            if(!$champagne_room) show_404();
            if(!$champagne_room->status) show_404();
            $champagne_room->sold_tickets = $this->champagne_rooms->sold_tickets($id);
            $champagne_room->available_tickets = $champagne_room->max_tickets - $champagne_room->sold_tickets;
            $champagne_room->joined_user = $this->champagne_rooms->joined_user($id,$this->user->id);
            $data = array('champagne_room'=>$champagne_room);
            $data['_sidebar']		= false;
            $data['_signup_header']	= true;
            $data['page'] 		= 'champagne_room/view';
            $data['description'] 	= SETTINGS_SITE_DESCRIPTION;
            $data['keywords'] 		= SETTINGS_SITE_KEYWORDS;
            $data['pageTitle'] 		= 'Champagne Room - '.SETTINGS_SITE_TITLE;

            
            
            $this->load->view('template', $data);
        }
        
        function join(){
            $this->access->restrict('users'); 
            $id = $this->input->post('id');
            $champagne_room = $this->champagne_rooms->get_by_id($id);
            if(!$champagne_room) show_404();
            if(!$champagne_room->status) show_404();
            $champagne_room->sold_tickets = $this->champagne_rooms->sold_tickets($id);
            $champagne_room->available_tickets = $champagne_room->max_tickets - $champagne_room->sold_tickets;
            $champagne_room->joined_user = $this->champagne_rooms->joined_user($id,$this->user->id);
            
            if(!$champagne_room->available_tickets){
                $this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('They are NO more tickets available')));
                redirect('champagne_room/view/'.$id);
            }
            if($champagne_room->joined_user){
                $this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('You already joined')));
                redirect('champagne_room/view/'.$id);
            }
            if($this->user->credits < $champagne_room->ticket_price){
                $this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Not enough '.SETTINGS_SHOWN_CURRENCY)));
                redirect('champagne_room/view/'.$id);
            }
            
            $this->db->trans_begin();
            if(!$this->users->spend_credits($this->user->id, $champagne_room->ticket_price)){
                $this->db->trans_rollback();
                $this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Transaction failed 1')));
                redirect('champagne_room/view/'.$id);
            }
            if(!$this->champagne_rooms->join($champagne_room->id, $this->user->id )){
                $this->db->trans_rollback();
                $this->session->set_flashdata('msg',array('success'=>FALSE,'message' => lang('Transaction failed 2')));
                redirect('champagne_room/view/'.$id);
            }
            $this->db->trans_commit();
            $this->session->set_flashdata('msg',array('success'=>TRUE,'message' => lang('Transaction was done successfully !')));

            $this->system_log->add(
                            'user',
                            $this->user->id,
                            'champagne_room',
                            $champagne_room->id,
                            'champagne_room/join',
                            sprintf('User spent %s credits. User joined champagne room #%s',$champagne_room->ticket_price, $champagne_room->id),
                            time(),
                            ip2long($this->input->ip_address())
            );
            
            redirect('champagne_room/view/'.$id);
        }

}