<?php
/**
 * 
 * @author Andrei
 *
 */
abstract class Videos{

	public $user;
	public $video;
	public $CI;
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Returneaza o instanta 
	 * @param $user
	 * @param $video
	 * @return unknown_type
	 */
	static function get_instance($user,$video){
		switch($video->is_paid){
			case 0:{
				require_once APPPATH . 'models/video/free.php';
				return new Free($user,$video);				
			}
			case 1:{
				require_once APPPATH . 'models/video/paid.php';
				return new Paid($user,$video);							
			}
		}
	} 
	
	// -----------------------------------------------------------------------------------------		
	/**
	 * Inchide sessiunea free a unui user
	 * @param $watcher
	 * @return unknown_type
	 */
	function free_view($watcher){
		$this->CI->load->model('watchers');
		$data['show_is_over'] 	= 1;
		$data['end_date']		= time();
		$data['duration']		= time() - $this->watcher->start_date;
		
		//update the data
		$this->CI->watchers->update($this->watcher->id,$data);		
	}
	
	
}