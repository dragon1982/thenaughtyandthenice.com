<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_update_controller extends MY_Controller{

	var $chat;

	// -----------------------------------------------------------------------------------------

	function __construct(){
		parent::__construct();

		 $this->load->model('performers');
	}


	// -----------------------------------------------------------------------------------------

	function index(){
		redirect();
	}

	function update_stats(){
		$this->output->set_header("HTTP/1.1 200 OK");
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");

		//$query = $this->db->select('title, content, date')->where('id',30)->get('mytable');
		/*
		 `status_message` VARCHAR(255) NULL DEFAULT NULL,
		 `is_in_pause` TINYINT(1) UNSIGNED NULL DEFAULT NULL,
		 `pause_time` INT(10) UNSIGNED NULL DEFAULT NULL,
		 `pause_timestamp` INT UNSIGNED NULL DEFAULT NULL,
		 `pause_message` VARCHAR(255) NULL DEFAULT NULL,
		 */

		$performer = $this->performers->get_one_by_nickname($_GET['nickname']);
		$timeArray = array('00','00','00');
//var_dump($performer['profile'][0]->is_online);
		$is_in_break = false;
		if (isset($performer['profile'][0]->is_in_pause)) {
			if($performer['profile'][0]->is_in_pause == 1){
			$is_in_break = true;
			}
		}
		//if (isset($performer['profile'][0]->is_in_pause)) {
		$clockMsg = 'Model is online';
			if(($performer['profile'][0]->is_online == 0) || $is_in_break){
				$timeLeft = $performer['profile'][0]->pause_timestamp+($performer['profile'][0]->pause_time) - time();
				$clockMsg = isset($performer['profile'][0]->pause_message) ? $performer['profile'][0]->pause_message : 'default_message';
				$is_in_break = true;
				if($timeLeft > 0){
				$timeLefthms = sec2hms($timeLeft);
				$timeArray = explode(":", $timeLefthms);
				$is_in_break = true;
				}else{
					$is_in_break = false;
					$clockMsg = 'Model is offline';
				}
			}
		//}
//echo "<pre>"; print_r($performer['profile'][0]->status_message); echo "</pre>";
		$data['json'] = array(
				'roomStatus'=> isset($performer['profile'][0]->status_message) ? $performer['profile'][0]->status_message : 'default_status',
				'clockMsg'=> $clockMsg,
				'clockMin'=> $timeArray[1],
				'clockSec'=> $timeArray[2],
				'nickname'=> $_GET['nickname'],
				'is_in_break' => $is_in_break,
				'is_online' => $performer['profile'][0]->is_online,
				);
		$this->load->view('json',$data);
	}

}