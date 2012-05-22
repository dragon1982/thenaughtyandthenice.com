<?php
class Banned_countries extends CI_Model{
	
	var $banned_contries	= 'banned_countries';
	var $banned_states		= 'banned_states';

	
	##################################################################################################
	############################################# GET ################################################
	##################################################################################################	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Verifica daca ipul curent este in regiune blacklistata de catre performer
	 * @param $performer_id
	 * @return bool
	 */
	function is_performer_blacklisted_region($performer_id){
				
		$ip_regions  = $this->get_regions($this->input->ip_address());		
		$banned_regions = $this->get_blacklisted_regions_by_performer_id($performer_id);

		if( ! $this->is_banned_region_by_ip($ip_regions,$banned_regions)) {
			return FALSE;
		}
		return TRUE;
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	* returneaza regiunile blacklistate pentru un performer id
	* @param unknown_type $performer_id
	* @author Baidoc
	*/
	function get_blacklisted_regions_by_performer_id($performer_id){
		return $this->db->select('banned_countries.country_code,state_code')
						->join($this->banned_states. ' as states','states.performer_id = performers.id','left')
						->join($this->banned_contries,'banned_countries.performer_id = performers.id','left')
						->set_memcache_key('ban_country-performer-%s',array($performer_id),120)
						->where('performers.id', $performer_id)		
						->get('performers')
						->result();
	}

	
	
	##################################################################################################
	########################################### HELPERS ##############################################
	##################################################################################################
		
	// -----------------------------------------------------------------------------------------	
	/**
	 * Verifica daca regiunea de care apartine ipul se afla in lista de tari banate
	 * @param unknown_type $ip_regions
	 * @param unknown_type $banned_regions
	 * @author Baidoc
	 */
	function is_banned_region_by_ip($ip_regions,$banned_regions){	
		if(sizeof($banned_regions) == 0){
			return FALSE;
		}

		
		foreach( $banned_regions as $banned_region ){
			if( $banned_region->country_code == $ip_regions['country'] && $ip_regions['country'] ){
				return TRUE;
			}
			
			$this->load->config('regions');
			$state_list = $this->config->item('states');

			if( $ip_regions['state'] && isset($state_list[$banned_region->state_code]) && strtolower($state_list[$banned_region->state_code]) ==  strtolower($ip_regions['state']) ){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza tara/statul pentru un ip
	 * @param $ip
	 * @return array
	 */
	function get_regions($ip){
		$this->load->library('ip2location');
		$country 	= $this->ip2location->getCountryShort($ip);
		$state		= FALSE;
		if($country === 'US'){
			$state = $this->ip2location->getRegion($ip);
		}
		return array('country'=>$country,'state'=>$state);
	}
}