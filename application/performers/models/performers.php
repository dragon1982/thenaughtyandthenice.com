<?php
class Performers extends CI_Model{
	
	var $performers 			= 'performers';
	var $performers_profile 	= 'performers_profile';
	var $performers_photos 		= 'performers_photos';
	var $performers_videos 		= 'performers_videos';
	var $performers_categories 	= 'performers_categories';
	var $performers_languages	= 'performers_languages';
	var $fms					= 'fms';
	
	##################################################################################################
	############################################# GET ################################################
	##################################################################################################


	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un performer dupa $id
	 * @param $id
	 * @return object
	 */	
	function get_one_by_id($id){
		return $this->db->where('id',$id)->limit(1)->get($this->performers)->row();
	}
		
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza detaliile unui performer dupa nickname
	 * @param $nickname
	 * @return array 
	 */
	function get_one_by_nickname($nickname){
		$this->db->where('nickname',$nickname)->set_memcache_key('performer-%s',array($nickname))					
					->join($this->performers_profile	, $this->performers_profile 	. '.user_id = ' . $this->performers . '.id'		,'inner')
					->join($this->performers_languages	, $this->performers_languages	. '.user_id	= ' . $this->performers . '.id'		,'inner')					
					->join($this->performers_videos		, $this->performers_videos		. '.user_id = ' . $this->performers . '.id'		,'left')
					->join($this->performers_photos		, $this->performers_photos		. '.user_id = ' . $this->performers . '.id'		,'left')
					->join($this->performers_categories	, $this->performers_categories 	. '.user_id = ' . $this->performers . '.id'		,'left')					
					->join($this->fms					, $this->fms					. '.id		= ' . $this->performers . '.fms_id'	,'left');
		
		$query = $this->db->get($this->performers);
		
		// Convenience - they aren't really related in this way
		$result = array(
			'profile'	=> $query->result(),
			'performer'	=> $query->row()
		);

		// Free results
		$query->free_result();
		return $result;
					
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un performer dupa $username
	 * @param $username
	 * @return object
	 */	
	function get_one_by_username($username){
		return $this->db->where('username',$username)->limit(1)->get($this->performers)->row();
	}
			
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un performer dupa email
	 * @param $email
	 * @return object
	 */	
	function get_one_by_email($email){
		return $this->db->where('email',$email)->limit(1)->get($this->performers)->row();
	}
		
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un performer dupa hash
	 * @param $hash
	 * @return unknown_type
	 */
	function get_one_by_hash($hash){
		return $this->db->where('hash',$hash)->limit(1)->get($this->performers)->row();
	}
	##################################################################################################
	############################################# ADD ################################################
	##################################################################################################

	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un performer in baza de date
	 * @param unknown_type $username
	 * @param unknown_type $nickname
	 * @param unknown_type $password
	 * @param unknown_type $email
	 * @param unknown_type $token
	 * @param unknown_type $firstname
	 * @param unknown_type $lastname
	 * @param unknown_type $status
	 * @param unknown_type $address
	 * @param unknown_type $state
	 * @param unknown_type $city
	 * @param unknown_type $zip
	 * @param unknown_type $phone
	 * @param unknown_type $hash
	 * @param unknown_type $payment
	 * @author VladG
	 */
	function add($username,$password,$hash,$email,$nickname,$firstname,$lastname,$status = 'pending',$time,$ip,$address,$state,$city,$zip,$phone,$country, $register_country){
		$this->db->insert(
			$this->performers,
			array(
				'username'		=> $username ,
				'password '		=> $password ,
				'email'			=> $email ,
				'hash'			=> $hash ,
				'nickname'		=> $nickname ,
				'first_name'	=> $firstname ,
				'last_name'		=> $lastname ,
				'status'		=> $status ,
				'register_date'	=> $time ,
				'register_ip'	=> $ip,
				'address'		=> $address ,
				'state'			=> $state ,
				'city'			=> $city ,
				'zip'			=> $zip ,
				'phone'			=> $phone,
				'country'		=> $country,
				'website_percentage'	=> WEBSITE_PERCENTAGE,
				'register_step' => 2,
				'country_code'	=> $register_country
			)
		);
		
		return $this->db->insert_id();
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * adauga categoriile la un performer
	 * @param $performer_id
	 * @param $category_id
	 * @author VladG
	 */
	
	function add_performers_categories($performer_id,$category_id) {
		$this->db->insert($this->performers_categories,
			array(
				'performer_id'		=> $performer_id ,
				'category_id '		=> $category_id
			)
		);
	}
	

	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga limbile pentru un performer
	 * @param $performer_id	  
	 * @param $language_code
	 * @author VladG
	 */
	function add_performers_languages($performer_id,$language_code) {
		$this->db->insert($this->performers_languages,
			array(
				'language_code'		=> $language_code ,
				'performer_id '		=> $performer_id
			)
		);
		
	}
	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga profilul pentru un performer
	 * @param $performer_id
	 * @param $gender
	 * @param $description
	 * @param $turns_me_on
	 * @param $turns_me_off
	 * @param $sexual_prefference
	 * @param $ethnicity
	 * @param $height
	 * @param $weight
	 * @param $hair_color
	 * @param $hair_lenght
	 * @param $eye_color
	 * @param $build
	 * @param $birthday
	 * @author VladG
	 */
	function add_performers_profile($performer_id,$gender,$description,$turns_me_on,$turns_me_off,$sexual_prefference,$ethnicity,$height,$weight,$hair_color,$hair_lenght,$eye_color,$build,$birthday) {
		$this->db->insert($this->performers_profile,
			array(
				'performer_id'			=> $performer_id,
				'gender'				=> $gender,
				'description'			=> $description,
				'what_turns_me_on'		=> $turns_me_on,
				'what_turns_me_off'		=> $turns_me_off,
				'sexual_prefference'	=> $sexual_prefference,
				'ethnicity'				=> $ethnicity,
				'height'				=> $height,
				'weight'				=> $weight,
				'hair_color'			=> $hair_color,
				'hair_length'			=> $hair_lenght,
				'eye_color'				=> $eye_color,
				'build'					=> $build,
				'birthday '				=> $birthday
			)
		);
	}
	
	
	
	
	##################################################################################################
	############################################ UPDATE ##############################################
	##################################################################################################
	// -----------------------------------------------------------------------------------------
	/**
	 * Updateaza proprietatile unui performer dupa performer id
	 * @param $performer_id
	 * @param $changes array CAMP => valoare
	 * @return unknown_type
	 */	
	function update($performer_id,$changes){
		
		//sterg si din memcache
		if( MEMCACHE_ENABLE ){ 
			if(isset($this->user) && isset($this->user->nickname) ) {
				$this->db->drop_memcache_key('performer-%s',array($this->user->nickname));
			} else {
				$performer = $this->get_one_by_id($performer_id);
				if( $performer ){
					$this->db->drop_memcache_key('performer-%s',array($performer->nickname));
				}
			}
		}		
		
		if($this->db->where('id',$performer_id)->set($changes)->update($this->performers)){
			return TRUE;
		}
		return FALSE;
	}
	
	##################################################################################################
	########################################## MODELARE ##############################################
	##################################################################################################	
	// -----------------------------------------------------------------------------------------
	/**
	 * Verifica daca performerul nu poate intra online
	 * @param $performer
	 * @return unknown_type
	 */
	function cannot_go_online($performer){
		if($performer->status !== 'approved'){
			return lang('your account is not approved');
		}
		if( ! $performer->private_chips_price){
			return sprintf(lang('invalid private chips price. Click %s to set it'),sprintf('<a href="' . site_url('/settings/pricing') . '">%s</a>',lang('here')));
		}
		if( ! $performer->nude_chips_price){
			return sprintf(land('invalid private chips price. Click %s to set it'),sprintf('<a href="' . site_url('/settings/pricing') . '">%s</a>',lang('here')));
		}
		if($performer->contract_status !== 'approved') {
			return lang('contract not approved');
		}

		if($performer->photo_id_status !== 'approved') {
			return lang('photo ID not approved');
		}
				
		return FALSE;
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Verifica daca userul e aprobat automat sau e in pending default
	 * @return unknown_type
	 */
	function require_verification(){	
		if( ! EMAIL_ACTIVATION ){
			return FALSE;
		}
		return TRUE;
	}	
}
