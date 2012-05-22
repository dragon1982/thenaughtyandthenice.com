<?php
class Performers extends CI_Model{
	
	
	var $performers 			= 'performers';
	var $performers_profile 	= 'performers_profile';
	var $performers_photos 		= 'performers_photos';
	var $performers_videos 		= 'performers_videos';
	var $performers_categories 	= 'performers_categories';
	var $performers_languages	= 'performers_languages';
	var $performers_contracts	= 'performers_contracts';	
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
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza ratingu unui performer
	 * @param unknown_type $performer_id
	 * @return boolean
	 * @author Baidoc
	 */
	function get_performer_rate($performer_id){
		if($performer_id <= 0){
			return FALSE;
		}
		return $this->db->select_avg('rating')->where('performer_id', $performer_id)->get('performers_reviews')->row();
	}
	
	##################################################################################################
	############################################# ADD ################################################
	##################################################################################################

	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un performer in baza de date
	 * @param $username
	 * @param $password
	 * @param $hash
	 * @param $email
	 * @param $nickname
	 * @param $firstname
	 * @param $lastname
	 * @param $status
	 * @param $time
	 * @param $ip
	 * @param $address
	 * @param $state
	 * @param $city
	 * @param $zip
	 * @param $phone
	 * @param $country
	 * @return unknown_type
	 */
	function add($username,$password,$hash,$email,$nickname,$firstname,$lastname,$status = 'pending',$time,$ip,$address,$state,$city,$zip,$phone,$country,$studio_id = 0){
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
				'website_percentage'=>WEBSITE_PERCENTAGE,
				'register_step' => 2,
				'studio_id'		=> $studio_id
			)
		);
		
		return $this->db->insert_id();
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
	 * @author BaidocSan
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