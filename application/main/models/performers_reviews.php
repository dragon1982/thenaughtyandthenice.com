<?php
class Performers_reviews extends CI_Model{
	
	var $reviews = 'performers_reviews';
	/*
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
	}
	
			
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza un review dupa idul unic din chat
	 * @param $unique_id
	 * @return object
	 */
	function get_one_by_unique_id($unique_id){
		return $this->db->where('unique_id',$unique_id)->limit(1)->get($this->reviews)->row();
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Returneaza reviewuri pentru un performer
	 * @param $performer_id
	 * @return array/int
	 */
	function get_multiple_by_performer_id($performer_id,$limit = 10,$offset = 0,$count = FALSE){
		
		
		$this->db->where('performer_id',$performer_id);
		
		
		if( $count ){
			return $this->db->select('count(id) as number')->get($this->reviews)->row()->number;
		}
		
		$this->db->select('performers_reviews.*, users.username as user');
		$this->db->join('users', 'performers_reviews.user_id = users.id');
		
		$this->db->limit($limit);
		$this->db->offset($offset);
		
		return $this->db->get($this->reviews)->result();
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Adauga un review la un performer
	 * @param unknown_type $user_id
	 * @param unknown_type $performer_id
	 * @param unknown_type $unique_id
	 * @param unknown_type $message
	 * @param unknown_type $rating
	 */
	function add($user_id,$performer_id,$unique_id,$message,$rating){
		$data = array(
			'user_id'		=> $user_id,
			'performer_id'	=> $performer_id,
			'add_date'		=> time(),
			'unique_id'		=> $unique_id,
			'message'		=> $message,
			'rating'		=> $rating
		);
		
		$this->db->insert($this->reviews,$data);
	}
	
	
}