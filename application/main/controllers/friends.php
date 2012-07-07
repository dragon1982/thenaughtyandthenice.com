<?php
/**
 */

Class Friends_controller extends MY_Users{

    private $data;
    
	//constructor
	function __construct(){
		parent::__construct();
		$this->load->model('relation');
		$this->load->model('friends');
		$this->data['friends'] = $this->friends->get_data($this->user->id);
		$this->data['description']    = SETTINGS_SITE_DESCRIPTION;
		$this->data['keywords']       = SETTINGS_SITE_KEYWORDS;
	}

	// ------------------------------------------------------------------------	
	
	function index() {
			$data = $this->data;
			$data['page'] = 'friends/list';
			$data['pageTitle'] = lang('Friends').' - '.SETTINGS_SITE_TITLE;
            $this->load->view('template', $data);
	}
	
	// ------------------------------------------------------------------------	
	
	function pending() {
			$data = $this->data;
			$data['page'] = 'friends/pending';
			$data['pageTitle'] = lang('Pending Friends').' - '.SETTINGS_SITE_TITLE;
            $this->load->view('template', $data);
	}

	// ------------------------------------------------------------------------	
	
	function requests() {
			$data = $this->data;
			$data['page'] = 'friends/requests';
			$data['pageTitle'] = lang('Friend Requests').' - '.SETTINGS_SITE_TITLE;
            $this->load->view('template', $data);
	}
	
	// ------------------------------------------------------------------------	
	
	function banned() {
			$data = $this->data;
			$data['page'] = 'friends/banned';
			$data['pageTitle'] = lang('Banned Friends').' - '.SETTINGS_SITE_TITLE;
            $this->load->view('template', $data);
	}
	// ------------------------------------------------------------------------	
	
	function delete() {
		$rel_id = $this->input->post('rel_id', null);
		$rel_ids = array();
		$friends = $this->friends->get($this->user->id);
		foreach($friends as $friend) $rel_ids[] = $friend->rel_id;
		if(in_array($rel_id, $rel_ids)) $this->relation->delete($rel_id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	// ------------------------------------------------------------------------	
	
	function accept() {
		$rel_id = $this->input->post('rel_id', null);
		$rel_ids = array();
		$friends = $this->friends->get($this->user->id,'pending');
		foreach($friends as $friend) {
			if($friend->owner) $rel_ids[] = $friend->rel_id;
		}
		if(in_array($rel_id, $rel_ids)) $this->relation->update($rel_id,'accepted');
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	// ------------------------------------------------------------------------	
	function ban() {
		$this->load->model('performers');
		$rel_id = $this->input->post('rel_id', null);
		$rel_ids = array();
		$friends = $this->friends->get($this->user->id,'accepted');
		foreach($friends as $friend) {
			if($friend->rel_id == $rel_id){
				$this->relation->update($rel_id, $friend->owner?'banned':'ban');
				break;
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
}