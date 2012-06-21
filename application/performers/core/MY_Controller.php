<?php
/**
 * General controller
 * @author Andrei
 *
 */
class MY_Controller extends CI_Controller{
	
	public $user;
	/**
	 * Construieste obiectul $user
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->user = $this->access->get_account('performer');
		
		if(SETTINGS_DEBUG){
			$this->output->enable_profiler();
		}
	}
}

/**
 * Controllerul pentru register performer
 * @author Andrei
 *
 */
class MY_Registration extends CI_Controller{
	
	public $register_user;
	public $step;
		
	public $user;
	
	/**
	 * Constructorul
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		
		$this->user = $this->access->get_account('performer');
		
		//nu las performerii inregistrati sa isi faca alt cont
		$this->access->restrict('logged_out');

		$register = $this->session->userdata('register');
		
		//nu are in sessiune nimic
		if( ! $register ){
			$this->step = 'step1';			
		} else {
			
			$this->load->model('performers');
			
			$performer = $this->performers->get_one_by_id($register['performer_id']);
			
			//performerul a fost sters/rejectat -> trimitem performeru la step1 back
			if( ! $performer || $performer->status == 'rejected'){
				$this->session->unset_userdata('register');
				redirect('register');
			}
			
			$this->register_user = $performer;
			
			$this->step = 'step'.$register['step'];
		}
	}
}

/**
 * Users controller
 * @author Andrei
 *
 */
class MY_Performer extends MY_Controller{
	

	/**
	 * Restrictioneaza accessul catre controllerul de users
	 * @return null
	 */
	function __construct(){
		parent::__construct();
		$this->access->restrict('performers');
		$this->load->model('messages');
		$this->load->model('users');
		$this->user->unread_messages = $this->messages->get_all_received_by_user_id($this->user->id, $this->user->type, FALSE, FALSE, TRUE, TRUE);
	}
}


/**
 * Affiliate controller
 * @author	AgLiAn
 *
 */
class MY_Affiliate extends MY_Controller{
	

	/**
	 * Restrictioneaza accessul catre controllerul de affiliates
	 */
	function __construct(){
		parent::__construct();
		$this->access->restrict('affiliates');
	}
}

class MY_FMS_Free extends CI_Controller{
	
	function __construct(){
		parent::__construct();
	}
	
	/**
	* Logheaza in fisier requesturile facute catre Controlleru de FMS
	* @param $file
	* @param $content
	* @param $reWrite
	* @param $exit
	* @return unknown_type
	*/
	function write_request($file, $content = false, $reWrite = true, $exit = false ){
			
		$pathInfo = pathinfo($file);
		$url = base_url().'fms/'. $pathInfo['filename'] .'/';
	
		$x = NULL;
	
		if($content == false) {
			$x = 'DATE: '. date('Y-m-d H:i:s') ."\n";
			$x .= 'IP: '. $_SERVER['REMOTE_ADDR'] ."\n\n";
	
			$x .= "SESSION:\n";
			if(isset($_SESSION) AND is_array($_SESSION)) {
				foreach($_SESSION as $requestKey => $requestValue) {
					if(!is_object($requestValue)){
						$x .= "\t".$requestKey .' => '. $requestValue ."\n";
					}
				}
			}
	
			$x .= "POST:\n";
			if(isset($_POST) AND is_array($_POST)){
				foreach($_POST as $requestKey => $requestValue) {
					$x .= "\t".$requestKey .' => '. $requestValue ."\n";
				}
			}
	
			$x .= "GET:\n";
			if(isset($_GET) AND is_array($_GET)){
				foreach($_GET as $requestKey => $requestValue) {
					$x .= "\t".$requestKey .' => '. $requestValue ."\n";
				}
			}
	
			$i = 1;
			foreach ($_POST as $key => $value) {
	
				if($i == 1) {
					$sep = '?';
				} else {
					$sep = '&';
				}
	
				$url .= $sep.$key .'='.$value;
	
				++$i;
			}
	
			foreach ($_GET as $key => $value) {
	
				if($i == 1) {
					$sep = '?';
				} else {
					$sep = '&';
				}
	
				$url .= $sep.$key .'='.$value;
	
				++$i;
			}
	
			$x .= "\n\n{$url}";
		}
	
		if($reWrite == true) {
			fwrite(fopen($file, 'w+'), $x);
		} else {
			fwrite(fopen($file, 'a'), "\n\n\nRETURN:\n\n".$content);
		}
	
		if(true){
			if(is_dir(APPPATH.'logs/fms/more/') AND is_writable(APPPATH.'logs/fms/more/')) {
				if(isset($_REQUEST['uniqId'])) {
	
					$_REQUEST['uniqId'] = str_replace('/', '', $_REQUEST['uniqId']);
	
					$file = APPPATH.'logs/fms/more/'. $_REQUEST['uniqId'] .'.txt';
	
					if($reWrite == true) {
						$y  = "\n\n###############################################################################################################\n###############################################################################################################\n\n";
						$y .= "\t". $pathInfo['filename'] . "\n\n";
						$x = $y . $x;
						@fwrite(@fopen($file, 'a'), $x);
					} else {
						@fwrite(@fopen($file, 'a'), "\n\n\nRETURN:\n\n". $content);
					}
				}
			}
		}
	
		if($exit === true) {
			exit($content);die;
		}
	}
		
}

/**
 * Controllerul de FMS
 * @author Andrei
 *
 */
class MY_FMS extends MY_FMS_Free{
	
	function __construct(){
		parent::__construct();
		$hash = $this->input->post('hash');
		if( defined('FMS_SECRET_HASH') && $hash !== FMS_SECRET_HASH ) {
			$this->write_request(APPPATH.'logs/fms/denys.txt', 'status=deny&log=bad_secret_hash', true, true);
		}
	}
}

