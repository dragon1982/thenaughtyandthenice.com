<?php
/**
 * Adauga 
 * @author Andrei
 *
 */
class View_remap{
		
	var $CI;	
	var $theme;

	/**
	 * 
	 * Verifica tema
	 * @author Baidoc
	 */
	function check_theme(){
		$this->CI = & get_instance();
		
		$theme = $this->CI->input->cookie('theme');
		$this->CI->load->helper('cookie');
		
		if($theme){
			if(is_dir(APPPATH.'views/'.$theme) || is_dir(APPEXPATH.'views/'.$theme)){
				define('SELECTED_THEME', $theme);
				return;
			}
		}		
		
		set_cookie('theme', SETTINGS_DEFAULT_THEME, time()+2592000);
		define('SELECTED_THEME', SETTINGS_DEFAULT_THEME);			
	}
	
	
	/**
	 * Verify if a country/ip is banned
	 * @author Baidoc
	 */
	function blacklisted_join(){	
		//needed data
		$this->CI = & get_instance();		
		$ip 	= $this->CI->input->ip_address();
		$this->CI->load->config('blacklists');

		//whitelisted ips
		$whitelisted_ips = $this->CI->config->item('whitelisted_ips');
		if( in_array($ip, $whitelisted_ips) ){
			return;
		}
		
		//is blacklisted ip
		$blacklisted_ips = $this->CI->config->item('blacklisted_ips');		
		if( in_array($ip, $blacklisted_ips) ){
			show_404();
		}
			
		//blacklisted country
		$blacklisted_countries = $this->CI->config->item('blacklisted_countries');
		$this->CI->load->library('ip2location');
		$country = $this->CI->ip2location->getCountryShort($ip);
		if( in_array( $country,$blacklisted_countries) ){
			show_404();
		}
		
	}
}