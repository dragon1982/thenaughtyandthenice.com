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
					id,
					username,
					is_online as is_chat_online,
					is_in_private as is_in_a_private_show,
					avatar
				FROM {$result->type}s 
				WHERE id = {$result->id}
			")->row()){
				$friend->is_in_a_group_show = null;
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
		}
		return $friend;
	}
	
	// -----------------------------------------------------------------------------------------
	
	function is_friend($id, $type, $search_id, $search_type){
		if($friend = $this->get_one($id, $type, $search_id, $search_type, 'accepted')) return true;
		else return false;
	}

}