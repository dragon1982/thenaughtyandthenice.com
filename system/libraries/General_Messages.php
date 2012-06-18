<?php
Class General_Messages extends CI_Model{
	var $messages 	= 'messages';
	
// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un mesaj in baza de date
	 * @param unknown_type $subject
	 * @param unknown_type $body
	 * @param unknown_type $read_by_recipient
	 * @param unknown_type $trashed_by_recipient
	 * @param unknown_type $deleted_by_sender
	 * @param unknown_type $date
	 * @param unknown_type $from_type
	 * @param unknown_type $from_id
	 * @param unknown_type $to_type
	 * @param unknown_type $to_id
	 */
	function add($subject, $body, $read_by_recipient, $trashed_by_recipient, $deleted_by_recipient, $deleted_by_sender, $date ,$from_type,$from_id, $to_type, $to_id) {
		if( $this->db->insert(
			$this->messages,
			array(
				'subject'					=> $subject ,
				'body '						=> $body ,
				'readed_by_recipient'		=> $read_by_recipient ,
				'trashed_by_recipient'		=> $trashed_by_recipient ,
				'deleted_by_recipient'		=> $deleted_by_recipient ,
				'deleted_by_sender'			=> $deleted_by_sender ,
				'date'						=> $date ,
				'from_type'					=> $from_type ,
				'from_id'					=> $from_id ,
				'to_type'					=> $to_type ,
				'to_id'						=> $to_id
			)
		))
		{
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Preia toate mesajele dupa id-ul userului pe pagini, daca se da si parametrul count, intoarce numarul total de inregistrari
	 * daca se da si ultimul parametru returneza numarul de mesaje necitite
	 * @param $id
	 * @param $limit
	 * @param $offset
	 * @param $count
	 * @param unread
	 * @return unknown_type
	 */
	function get_all_received_by_user_id($user_id, $type, $limit, $offset ,$count = FALSE, $unread = FALSE ) {
		if($count){
			$this->db->select('count(distinct(id)) as total');
		} else {
			$this->db->select('messages.*');
			//$this->db->join('performers', 'performers.id = from_id', 'left');
			$this->db->limit($limit);
			$this->db->offset($offset);
		}
		
		$this->db->from($this->messages)
				 ->where('to_id' , $user_id)
				 ->where('to_type', $type)
				 ->where('deleted_by_recipient' , 0)
				 ->where('trashed_by_recipient' , 0);
		if($unread) {
			$this->db->where('readed_by_recipient', 0);
		}		 
		if($count){
			return $this->db->get()->row()->total;
		} else {
			$this->db->order_by('date', 'desc');
			$messages = $this->db->get()->result();
			$senders = array();
			foreach($messages as $message) {
				if(!isset($senders[$message->from_type.'s'])) $senders[$message->from_type.'s'][]=$message->from_id;
				else{
					if(!in_array($message->from_id, $senders[$message->from_type.'s'])) $senders[$message->from_type.'s'][]=$message->from_id;
				}
			}
			foreach ($senders as $key => $ids){
				if(!$users = $this->db->query("
					SELECT id,username
					FROM $key
					WHERE id IN (".implode($ids).")
				")->result()) continue;
				$senders[$key] = array();
				foreach($users as $user) $senders[$key][$user->id] = $user->username;
			}
			foreach($messages as $message) $message->username = $senders[$message->from_type.'s'][$message->from_id];
			return $messages;
		}	
	}
	
	/**
	 * Extrage un mesaj din baza de date dupa id
	 * @param $message_id
	 * @return unknown_type
	 */
	function get_one_by_message_id($message_id, $sent = FALSE) {
		$this->db->select('messages.*');				
		$this->db->limit(1)
				 ->where('messages.id', $message_id);
		$message = $this->db->get($this->messages)->row();
		if($sent) {
			$sql = 'SELECT username FROM '.$message->to_type.'s WHERE id='.$message->to_id;
			$type = $message->to_type;
		} else {
			$sql = 'SELECT username FROM '.$message->from_type.'s WHERE id='.$message->from_id;
			$type = $message->from_type;
		}
		if($sender = $this->db->query($sql)->row()){
			if(property_exists($sender,'username')) {
				$message->type = $type;
				$message->username = $sender->username;
			}	
		}
		return $message;
	}
	
	/**
	 * Preia toate mesajele trimise dupa id-ul userului pe pagini, daca se da si parametrul count, intoarce numarul total de inregistrari
	 * @param $id
	 * @param $limit
	 * @param $offset
	 * @param $count
	 * @param unread
	 * @return unknown_type
	 */
	function get_all_sent_by_user_id($user_id, $type, $limit, $offset, $count = FALSE) {
		if($count){
			$this->db->select('count(distinct(id)) as total');
		} else {
			$this->db->select('messages.*');
			//$this->db->join('performers', 'performers.id = to_id', 'left');
			$this->db->limit($limit);
			$this->db->offset($offset);
		}
		
		$this->db->from($this->messages)
				 ->where('from_type', $type)
				 ->where('from_id' , $user_id)
				 ->where('deleted_by_sender' , 0);
				 
		if($count){
			return $this->db->get()->row()->total;
		} else {
			$this->db->order_by('date', 'desc');
			$messages = $this->db->get()->result();
			$senders = array();
			foreach($messages as $message) {
				if(!isset($senders[$message->to_type.'s'])) $senders[$message->to_type.'s'][]=$message->to_id;
				else{
					if(!in_array($message->to_id, $senders[$message->to_type.'s'])) $senders[$message->to_type.'s'][]=$message->to_id;
				}
			}
			foreach ($senders as $key => $ids){
				if(!$users = $this->db->query("
					SELECT id,username
					FROM $key
					WHERE id IN (".implode($ids).")
				")->result()) continue;
				$senders[$key] = array();
				foreach($users as $user) $senders[$key][$user->id] = $user->username;
			}
			foreach($messages as $message) $message->username = $senders[$message->to_type.'s'][$message->to_id];
			return $messages;
		}	
	}
	
/**
	 * Preia toate mesajele din trash dupa id-ul userului pe pagini, daca se da si parametrul count, intoarce numarul total de inregistrari
	 * @param $id
	 * @param $limit
	 * @param $offset
	 * @param $count
	 * @param unread
	 * @return unknown_type
	 */
	function get_all_trashed_by_user_id($user_id, $type, $limit, $offset, $count = FALSE) {
		if($count){
			$this->db->select('count(distinct(id)) as total');
		} else {
			$this->db->select('messages.*');
			//$this->db->join('performers', 'performers.id = from_id', 'left');
			$this->db->limit($limit);
			$this->db->offset($offset);
		}
		
		$this->db->from($this->messages)
				 ->where('to_type', $type)
				 ->where('to_id' , $user_id)
				 ->where('deleted_by_recipient' , 0)
				 ->where('trashed_by_recipient' , 1);
				 
		if($count){
			return $this->db->get()->row()->total;
		} else {
			$this->db->order_by('date', 'desc');
			$messages = $this->db->get()->result();
			$senders = array();
			foreach($messages as $message) {
				if(!isset($senders[$message->from_type.'s'])) $senders[$message->from_type.'s'][]=$message->from_id;
				else{
					if(!in_array($message->from_id, $senders[$message->from_type.'s'])) $senders[$message->from_type.'s'][]=$message->from_id;
				}
			}
			foreach ($senders as $key => $ids){
				if(!$users = $this->db->query("
					SELECT id,username
					FROM $key
					WHERE id IN (".implode($ids).")
				")->result()) continue;
				$senders[$key] = array();
				foreach($users as $user) $senders[$key][$user->id] = $user->username;
			}
			foreach($messages as $message) $message->username = $senders[$message->from_type.'s'][$message->from_id];
			return $messages;
		}	
	}
	
	/**
	 * Update la un mesaj, la coloanele si valorile trimise in $updates
	 * @param $message_id
	 * @param $updates
	 * @return unknown_type
	 */
	function update_message($message_id, $updates) {
		$this->db->where('id', $message_id)->update($this->messages, $updates);
	}

}