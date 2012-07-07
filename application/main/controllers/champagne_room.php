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

		$data['champagne_rooms'] 	= TRUE;
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

}