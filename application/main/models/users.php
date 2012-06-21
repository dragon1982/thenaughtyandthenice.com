<?php
/**
 * Users model
 * @author Andrei
 *
 */
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
 */
Class Users extends CI_Model{
	
	var $users 			= 'users';
	var $users_detail 	= 'users_detail';
	var $performers_favorites = 'performers_favorites';
	#############################################################################################
	##################################### DATABASE ##############################################
	#############################################################################################
	
	#############################################################################################
	######################################### GET ###############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza userul dupa id
	 * @param $id
	 * @return object
	 */
	function get_one_by_id($id){	
		return $this->db->where('id',$id)->set_memcache_key('user_id-%s',array($id),60)->limit(1)->get($this->users)->row();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un user dupa id, si face join in tabela user_details
	 * @param $id
	 * @return object
	 */
	function get_one_by_id_and_full_details($id){
		return $this->db->where('id',$id)->join($this->users_detail,'users_detail.user_id = users.id ','inner')->limit(1)->get($this->users)->row();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un user dupa username
	 * @param $username
	 * @return unknown_type
	 */
	function get_one_by_username($username){
		return $this->db->where('username',$username)->limit(1)->get($this->users)->row();
	}
		
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza un user dupa hash
	 * @param $hash
	 * @return object
	 */
	function get_one_by_hash($hash){
		return $this->db->where('hash',$hash)->limit(1)->get($this->users)->row();
	}

	
	// -----------------------------------------------------------------------------------------
	/**
	 * Returneaza un user dupa email
	 * @param unknown_type $email
	 * @author Baidoc
	 */
	function get_one_by_email($email){
		return $this->db->where('email',$email)->limit(1)->get($this->users)->row();
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza un array de useri dupa filtre
	 * @param unknown_type $filters
	 * @param unknown_type $limit
	 * @param unknown_type $offset
	 * @author Baidoc
	 */
	function get_multiple($filters,$limit = FALSE,$offset = FALSE){
		if(isset($filters['status'])){
			$this->db->where('status',$filters['status']);
		}
		
		if(isset($filters['register_date'])){
			$this->db->join($this->users_detail, 'id=user_id','inner');
			$this->db->where('register_date',$filters['register_date']);
		}
		
		$this->db->limit($limit);
		$this->db->offset($offset);
		
		return $this->db->get($this->users)->result();
	}
	#############################################################################################
	######################################### ADD ###############################################
	#############################################################################################

	// -----------------------------------------------------------------------------------------	
	/**
	 * Adauga un user in baza de date
	 * @param $username
	 * @param $password
	 * @param $hash
	 * @param $email
	 * @param $status
	 * @param $gateway
	 * @param $credits
	 * @return unknown_type
	 */
	function add($username,$password,$hash,$email,$status = 'pending',$gateway,$credits){
		if($this->db->insert($this->users,
				array(
					'username'			=> $username,
					'password'			=> $password,
					'hash'				=> $hash,
					'email'				=> $email,
					'status'			=> $status,
					'gateway'			=> $gateway,
					'credits' 			=> $credits
				)
			)
		){
			return $this->db->insert_id();
		}
		
		return FALSE;
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga detaliile pentru un user
	 * @param $user_id
	 * @param $register_ip
	 * @param $register_date
	 * @param $country_code
	 * @param $newsletter
	 * @param $affiliate_id
	 * @param $affiliate_type
	 * @return null
	 */	
	function add_users_detail($user_id,$register_ip,$register_date,$country_code,$newsletter,$affiliate_id,$affiliate_ad_id){
		$this->db->insert($this->users_detail,
			array(
				'user_id'		=> $user_id,
				'register_ip'	=> $register_ip,
				'register_date'	=> $register_date,
				'country_code'	=> $country_code,
				'newsletter'	=> $newsletter,
				'affiliate_id'	=> $affiliate_id,
				'affiliate_ad_id'=> $affiliate_ad_id
			)			
		);
	}
	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un performer la favorite
	 * @param $user_id
	 * @param $performer_id
	 * @param $time
	 * @author VladG
	 */
	function add_favorite_performer($user_id, $performer_id, $time) {
		$data = array(
		   'performer_id'	=> $performer_id ,
		   'user_id'		=> $user_id ,
		   'add_date'		=> $time
		);
		
		$this->db->insert($this->performers_favorites, $data);
		
	}	
	
	/**
	 * Adauga credite unui user
	 * @param $user_id
	 * @param $credits
	 * @return unknown_type
	 */
	function add_credits($user_id,$credits){			
		$this->db->query('UPDATE `users` SET `credits` = `credits` + ' . $this->db->escape($credits) . ' WHERE `id` = ' . $this->db->escape($user_id) );
		$this->db->drop_memcache_key('user_id-%s',array($user_id));
	}
	
	
	#############################################################################################
	######################################### UPDATE ############################################
	#############################################################################################
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Updateaza un user
	 * @param $id
	 * @param $update
	 * @return boolean
	 */
	function update($id,$update){	
		$this->db->where('id',$id);
		$this->db->set($update);
		if($this->db->drop_memcache_key('user_id-%s',array($id))->update($this->users)){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	// -----------------------------------------------------------------------------------------
	/**
	 * Updateaza detaliile unui user
	 * @param $id
	 * @param $update
	 * @return boolean
	 */
	function update_details($id,$update){	
		$this->db->where('user_id',$id);
		$this->db->set($update);
		if($this->db->drop_memcache_key('user_id-%s',array($id))->update($this->users_detail)){
			return TRUE;
		} else {
			return FALSE;
		}
	}	
		
		
	// -----------------------------------------------------------------------------------------
	/**
	 * Salveaza o autentificare a unui user in baza de date/updateaza
	 * @param $user_id
	 * @param $ip
	 * @return unknown_type
	 */
	function log($user_id, $ip){	
		$time=time();
		$this->db->query("
			INSERT INTO `logins` (`user_id`, `ip`, `count`, `first_login`, `last_login`)
				VALUES
					('{$user_id}', '{$ip}', 1, '{$time}', '{$time}') 
				ON DUPLICATE KEY UPDATE 					
					`last_login`='{$time}', `count`=`count`+1"
		);
		
	}	
	
	#############################################################################################
	######################################### DELETE ############################################
	#############################################################################################
		
	// -----------------------------------------------------------------------------------------	
	/**
	 * Scoate un performer de la favorite
	 * @param $user_id
	 * @param $performer_id
	 * @author VladG
	 */
	function remove_favorite_performer($user_id, $performer_id) {
		$this->db->where('performer_id', $performer_id)->where('user_id', $user_id)->delete('performers_favorites');
	}	
	
	#############################################################################################
	##################################### MODELING ##############################################
	#############################################################################################
	
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Verifica daca performerul este favorit de user
	 * @param $user_id
	 * @param $performer_id
	 * @author VladG
	 * @return boolean
	 */
	function duplicate_favorite_performer($user_id, $performer_id) {			
		if( ! $this->db->where('performer_id', $performer_id)->where('user_id', $user_id)->limit(1)->get($this->performers_favorites)->row() ) {
			return FALSE;
		}
		return TRUE;
	}
		
	// -----------------------------------------------------------------------------------------	
	/**
	 * Creeaza un obiect virtual pentru validarea userului nelogat in controlleru de FMS
	 * @param $username
	 * @param $password
	 * @param $status
	 * @return unknown_type
	 */
	function create_virtual_user($username,$password,$status = 'approved'){
		$user = new stdClass();
		$user->username = $username;
		$user->password = $password;
		$user->id		= NULL;
		$user->status	= $status;
		$user->ip_address = ip2long($this->input->ip_address());
		$user->credits 	= 0;
		return $user;
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Verifica daca userul poate intra in chatul dorit
	 * @param $type
	 * @param $performer
	 * @return unknown_type
	 */
	function can_start_chat($type,$performer) {
		if( $this->user->id < 0 && $type !== 'free') return FALSE; 

		if( $type == 'nude') {
			if( $performer->nude_chips_price > $this->user->credits ) return FALSE;
		}
		
		if( $type == 'private') {
			if( $performer->private_chips_price > $this->user->credits ) return FALSE;
		}
		
		if( $type == 'peek' ){
			if( $performer->peek_chips_price > $this->user->credits ) return FALSE;
		} 
		
		return TRUE;
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
	
	// -----------------------------------------------------------------------------------------
	function get_friends_data($id, $type, $status = null){
		$results = array( 'requests'=>array(), 'pending'=>array(), 'accepted'=>array(), 'banned'=>array(), 'online'=>array(), 'offline'=>array() );
		if($this->user->id > 0) {
			$friends = $this->get_friends($id, $type, $status);
			foreach ($friends as $friend){
				if($friend->owner && $friend->status == 'pending') $results['requests'][] = $friend;
				if(!$friend->owner && $friend->status == 'pending') $results['pending'][] = $friend;
				if($friend->status == 'accepted') $results['accepted'][] = $friend;
				if($friend->status == 'ban' && !$friend->owner) $results['banned'][] = $friend;
				if($friend->status == 'banned' && $friend->owner) $results['banned'][] = $friend;
				if($friend->status == 'accepted' && $friend->is_chat_online) $results['online'][] = $friend;
				if($friend->status == 'accepted' && !$friend->is_chat_online) $results['offline'][] = $friend;
			}
		}
		return $results;
	}
	
	// -----------------------------------------------------------------------------------------
	
	function get_friends($id, $type, $status = null){
		if($status) $status = " AND relations.status = '".$status."'";
		$friends = array();
		$results = $this->db->query("
			SELECT 
				relations.id as rel_id, 
				relations.to_id as id,
				relations.to_type as `type`,
				relations.status as status,
				0 as owner
			FROM relations
			WHERE relations.from_type = '$type' AND relations.from_id = $id $status
			UNION
			SELECT 
				relations.id as rel_id, 
				relations.from_id as id,
				relations.from_type as `type`,
				relations.status as status,
				1 as owner
			FROM relations
			WHERE relations.to_type = '$type' AND relations.to_id = $id $status
			ORDER BY rel_id
		")->result();

		foreach ($results as $result){
			if($result->type == 'performer'){
				if($friend = $this->performers->get_one_by_id($result->id)){
					$friend->is_in_a_group_show = null;
					$friend->is_chat_online = $friend->is_online;
	                $friend->is_in_a_private_show = $friend->is_in_private;
	                $friend->is_true_private = null;
	                $friend->is_in_champagne_room = null;
	                if(file_exists('uploads/performers/' . $friend->id . '/small/' . $friend->avatar) && $friend->avatar){
	                	$friend->avatar_url = site_url('uploads/performers/' . $friend->id . '/small/' . $friend->avatar);
	                }else{
	                	$friend->avatar_url = assets_url().'user-pic-28x28.jpg';
	                }
				}
			}else{
				if($friend = $this->db->query("
					SELECT id,username,is_chat_online FROM {$result->type}s WHERE id = {$result->id} AND status = 'approved'
				")->row()){
					$friend->is_in_a_group_show = null;
	                $friend->is_in_a_private_show = null;
	                $friend->is_true_private = null;
	                $friend->is_in_champagne_room = null;
	                $friend->avatar_url = assets_url().'user-pic-28x28.jpg';
				}
			}
			if($friend){
				$friend->rel_id = $result->rel_id;
				$friend->type = $result->type;
				$friend->owner = $result->owner;
				$friend->status = $result->status;
				$friends[] = $friend;
			}
		}
		return $friends;
	}
	// -----------------------------------------------------------------------------------------
	
	function get_friend($id, $type, $searchId, $searchType, $status = null){
		if($status) $status = " AND relations.status = '".$status."'";
		$result = $this->db->query("
			SELECT 
				relations.id as rel_id, 
				relations.to_id as id,
				relations.to_type as `type`,
				relations.status as status,
				0 as owner
			FROM relations
			WHERE relations.from_type = '$type' AND relations.from_id = $id AND relations.to_type = '$searchType' AND relations.to_id = $searchId $status
			UNION
			SELECT 
				relations.id as rel_id, 
				relations.from_id as id,
				relations.from_type as `type`,
				relations.status as status,
				1 as owner
			FROM relations
			WHERE relations.to_type = '$type' AND relations.to_id = $id AND relations.from_type = '$searchType' AND relations.from_id = $searchId $status
			ORDER BY rel_id
		")->row();
		
		if($result){
			if($result->type == 'performer'){
				if($friend = $this->performers->get_one_by_id($result->id)){
					$friend->is_in_a_group_show = null;
					$friend->is_chat_online = $friend->is_online;
	                $friend->is_in_a_private_show = $friend->is_in_private;
	                $friend->is_true_private = null;
	                $friend->is_in_champagne_room = null;
	                if(file_exists('uploads/performers/' . $friend->id . '/small/' . $friend->avatar) && $friend->avatar){
	                	$friend->avatar_url = site_url('uploads/performers/' . $friend->id . '/small/' . $friend->avatar);
	                }else{
	                	$friend->avatar_url = assets_url().'user-pic-28x28.jpg';
	                }
				}
			}else{
				if($friend = $this->db->query("
					SELECT id,username,is_chat_online FROM {$result->type}s WHERE id = {$result->id} AND status = 'approved'
				")->row()){
					$friend->is_in_a_group_show = null;
	                $friend->is_in_a_private_show = null;
	                $friend->is_true_private = null;
	                $friend->is_in_champagne_room = null;
	                $friend->avatar_url = assets_url().'user-pic-28x28.jpg';
				}
			}
			if($friend){
				$friend->rel_id = $result->rel_id;
				$friend->type = $result->type;
				$friend->owner = $result->owner;
				$friend->status = $result->status;
				return $friend;
			}
		}
		return null;
	}
	// -----------------------------------------------------------------------------------------
	
	function is_friend($id, $type, $searchId, $searchType){
		if($friend = $this->get_friend($id, $type, $searchId, $searchType, 'accepted')) return true;
		else return false;
	}
	
	// -----------------------------------------------------------------------------------------
	
	function add_relation($from_id, $from_type, $to_id, $to_type){
		$data = array(
		   'from_id'	=> $from_id ,
		   'from_type'	=> $from_type ,
		   'to_id'		=> $to_id,
		   'to_type'	=> $to_type,
		   'status'     => 'pending'
		);
		return $this->db->insert('relations', $data);
	}
	
	// -----------------------------------------------------------------------------------------
	
	function delete_relation($rel_id){
		return $this->db->query('
			DELETE FROM relations WHERE id = '.$rel_id
		);
	}
	
	// -----------------------------------------------------------------------------------------
	
	function update_relation($rel_id, $status = 'accepted'){
		return $this->db->query('
			UPDATE relations SET status="'.$status.'" WHERE id = '.$rel_id
		);
	}
}