<?php
/* Adaugare/stergere regiuni banate / ipuri */
class Blacklist_controller extends MY_Admin{
	
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * Banned zones
	 * @author Baidoc
	 */
	function index(){
		$this->load->config('blacklists');
		$this->load->config('regions');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('whitelisted_ips',		lang('Whitelisted IPS'),		'trim');
		$this->form_validation->set_rules('blacklisted_ips',		lang('Blacklisted IPS'),		'trim');
		$this->form_validation->set_rules('blacklisted_countries',	lang('Blacklisted Countries'),	'');
		
		if( $this->form_validation->run() === FALSE ) {
			$data['countries'] = $this->config->item('countries');
			
			$data['whitelisted_ips'] = implode("\r\n", $this->config->item('whitelisted_ips'));
			$data['blacklisted_ips'] = implode("\r\n", $this->config->item('blacklisted_ips'));
			$data['selected_countries'] =  $this->config->item('blacklisted_countries');
			
			
			$data['page'] = 'blacklists';
			
			$data['breadcrumb'][lang('blacklist')]	= 'current';
			$data['page_head_title']				= lang('Blacklist'); 
			
			$this->load->view('template', $data);
		} else {
			$this->load->helper('utils');
			$whitelist = explode("\n", $this->input->post('whitelisted_ips'));
			$blacklist = explode("\n", $this->input->post('blacklisted_ips'));
			$countries = $this->input->post('blacklisted_countries');
							
			$wh_list = array();
			if(sizeof($whitelist) > 0){
				foreach($whitelist as $ip){
					if( $this->input->valid_ip($ip) ){
						array_push($wh_list, $ip);
					}
				}
			}
			
			$bl_list = array();
			if(sizeof($whitelist) > 0){
				foreach($blacklist as $ip){
					if( $this->input->valid_ip($ip) ){
						array_push($bl_list, $ip);
					}
				}
			}
			
			$data['blacklisted_ip_data'] 	= implode_to_array($bl_list);
			$data['whitelisted_ip_data']	= implode_to_array($wh_list);
			$data['blacklisted_countries_data']	= implode_to_array($countries);

			$content = '<?php' . PHP_EOL;
			$content .= $this->load->view('pre_completed/blacklist',$data,TRUE);

			# Rescrie fisierele de settings
			write_file('./application/admin/config/blacklists.php', $content, 'w');
			write_file('./application/affiliates/config/blacklists.php', $content, 'w');
			write_file('./application/performers/config/blacklists.php', $content, 'w');
			write_file('./application/studios/config/blacklists.php', $content, 'w');
			write_file('./application/main/config/blacklists.php', $content, 'w');
						
			$this->session->set_flashdata('msg', array('type' => 'success', 'message' => lang('Details saved')));
			redirect('blacklist');				
		}
	}
}