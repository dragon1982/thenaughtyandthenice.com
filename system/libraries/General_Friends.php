<?php

class General_Friends extends CI_Model{

	function get_data($id, $type, $status = null){
		$results = array( 'requests'=>array(), 'pending'=>array(), 'accepted'=>array(), 'banned'=>array(), 'online'=>array(), 'offline'=>array() );
		$friends = $this->get($id, $type, $status);
		foreach ($friends as $friend){
			if($friend->owner && $friend->status == 'pending') $results['requests'][] = $friend;
			if(!$friend->owner && $friend->status == 'pending') $results['pending'][] = $friend;
			if($friend->status == 'accepted') $results['accepted'][] = $friend;
			if($friend->status == 'ban' && !$friend->owner) $results['banned'][] = $friend;
			if($friend->status == 'banned' && $friend->owner) $results['banned'][] = $friend;
			if($friend->status == 'accepted' && $friend->is_chat_online) $results['online'][] = $friend;
			if($friend->status == 'accepted' && !$friend->is_chat_online) $results['offline'][] = $friend;
		}
		return $results;
	}
	
	// -----------------------------------------------------------------------------------------
	
	function get($id, $type, $status = null) {
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
			$friends[] = $this->friend($result);
		}
		return $friends;
	}
	
	// -----------------------------------------------------------------------------------------
	
	function get_one($id, $type, $search_id, $search_type, $status = null) {
		if($status) $status = " AND relations.status = '".$status."'";
		$result = $this->db->query("
			SELECT 
				relations.id as rel_id, 
				relations.to_id as id,
				relations.to_type as `type`,
				relations.status as status,
				0 as owner
			FROM relations
			WHERE relations.from_type = '$type' AND relations.from_id = $id AND relations.to_type = '$search_type' AND relations.to_id = $search_id $status
			UNION
			SELECT 
				relations.id as rel_id, 
				relations.from_id as id,
				relations.from_type as `type`,
				relations.status as status,
				1 as owner
			FROM relations
			WHERE relations.to_type = '$type' AND relations.to_id = $id AND relations.from_type = '$search_type' AND relations.from_id = $search_id $status
			ORDER BY rel_id
		")->row();
		
		if($result) return $this->friend($result);
		
		return null;
	}
	
	// -----------------------------------------------------------------------------------------
	
	function friend($result){
		if($result->type == 'performer'){
			if($friend = $this->db->query("
				SELECT 
					t1.id,
					t1.username,
					t1.is_online as is_chat_online,
					t1.is_in_private as is_in_a_private_show,
					t1.avatar,
					t1.country_code,
					t1.city,
					t2.birthday
				FROM performers as t1
				INNER JOIN performers_profile as t2 ON t1.id = t2.performer_id
				WHERE t1.id = {$result->id}
			")->row()){
				$friend->is_in_a_group_show = null;
				$friend->is_true_private = null;
                $friend->is_in_champagne_room = null;
                $friend->age = $this->get_age($friend->birthday);
                $friend->page = '/'.$friend->username;
                if(file_exists('uploads/performers/' . $friend->id . '/small/' . $friend->avatar) && $friend->avatar){
                	$friend->small_pic = site_url('uploads/performers/' . $friend->id . '/small/' . $friend->avatar);
                	$friend->large_pic = $friend->small_pic ;
                }else{
	                $friend->small_pic = assets_url().'user-pic-28x28.jpg';
	                $friend->large_pic = assets_url().'pic-178.png';
                }
			}
		}else if($result->type == 'user'){
			if($friend = $this->db->query("
				SELECT 
					t1.id,
					t1.username,
					t1.is_chat_online,
					t2.country_code 
				FROM users as t1 
				INNER JOIN users_detail as t2 ON t1.id = t2.user_id
				WHERE t1.id = {$result->id} AND t1.status = 'approved'
			")->row()){
				$friend->is_in_a_group_show = null;
                $friend->is_in_a_private_show = null;
                $friend->is_true_private = null;
                $friend->is_in_champagne_room = null;
                $friend->city = null;
                $friend->age = null;
                $friend->small_pic = assets_url().'user-pic-28x28.jpg';
                $friend->large_pic = assets_url().'pic-178.png';
                $friend->page = 'javascript:;';
			}
		}
		if($friend){
			$friend->rel_id = $result->rel_id;
			$friend->type = $result->type;
			$friend->owner = $result->owner;
			$friend->status = $result->status;
		}
		return $friend;
	}
	
	private function get_age($iTimestamp) 
	{
	    $iAge = date('Y') - date('Y', $iTimestamp);
	    
	    if(date('n') < date('n', $iTimestamp)) 
	    {
	        return --$iAge;
	    } 
	    elseif(date('n') == date('n', $iTimestamp)) 
	    {
	        if(date('j') < date('j', $iTimestamp)) 
	        {
	            return $iAge - 1;
	        } 
	        else 
	        {
	            return $iAge;
	        }
	    } 
	    else 
	    {
	        return $iAge;
	    }
	}  
	
	// -----------------------------------------------------------------------------------------
	
	function is_friend($id, $type, $search_id, $search_type){
		if($friend = $this->get_one($id, $type, $search_id, $search_type, 'accepted')) return true;
		else return false;
	}

}