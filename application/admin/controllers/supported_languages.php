<?php
/**
 * 
 * @property Supported_languages $supported_languages
 *
 */
class Supported_languages_controller extends MY_Admin {
	
	function __construct() {
		parent::__construct();
		$this->load->model('supported_languages');
		$this->load->library('form_validation');
	}
	
	// ------------------------------------------------------------------------	
	/**
	 * Returneaza lista de useri filtrata
	 * @param unknown_type $filters_str
	 * @param unknown_type $order_by
	 * @param unknown_type $order_type
	 * @param unknown_type $page_nr
	 * @author Baidoc
	 */
	function index() {
		$this->load->library('admin_pagination');
		
		$data['languages']		= $this->supported_languages->get_all();

		$data['page'] = 'supported_languages';
		$data['breadcrumb'][lang('Supported languages')]	= 'current';
		$data['page_head_title']			= lang('Supported languages'); 
		
		$this->load->view('template', $data);
	}
	

	function add(){
		$this->load->model('countries');
		
		$countries = $this->countries->get_all();
		
		
		$this->form_validation->set_rules('country', lang('Country'), 'required|trim|strip_tags|purify');
		
		if($this->form_validation->run() == FALSE){
			foreach($countries as $country){
				$data['countries'][$country->code] = $country->name;
			}
			$data['page'] = 'add_supported_language';
			$data['breadcrumb'][lang('Add supported language')]	= 'current';
			$data['page_head_title']			= lang('Add supported language'); 
			
			$this->load->view('template', $data);
			return;
		}
		
		$countries = create_array_by_property($countries, 'code');

		$code = $this->input->post('country');
		
		$rows['code'] = $code;
		$rows['title'] = $countries[$code]->name;
		
		if($this->supported_languages->save($rows)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('This language was successfully deleted!')));
		}else{
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This language cannt be added! Please try again!')));
		}
		redirect(site_url('supported_languages'));
		
	}

	
	// ------------------------------------------------------------------------	
	/**
	 * Delete supported language 
	 * @param integer $id
	 * @author CagunA
	 */
	function delete($id = FALSE) {
		$this->load->library('user_agent');
		$referer = $this->agent->referrer();
		
		if($id <= 0){
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('Invalid id!')));
			redirect($referer);
		}
		
		if($this->supported_languages->get_all(array('id' => $id), TRUE) != 1){
			$this->session->set_flashdata('msg', array('type' => 'warning', 'message' => lang('This language does not exist!')));
			redirect($referer);
		}
		
		if($this->supported_languages->delete($id)){
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('This language was successfully deleted!')));
			$this->system_log->add(
            			'admin',
            			$this->user->id,
            			'other', 
            			$id, 
            			'delete_supported_language', 
            			'Admin deleted user account.', 
            			time(), 
            			ip2long($this->input->ip_address())
			);
		}else{
			$this->session->set_flashdata('msg', array('type' => 'error', 'message' => lang('This language cannt be deleted! Please try again!')));
		}
		redirect($referer);
	}
	
	
}