<?php
/**
 * General controller
 * @author Andrei
 *
 */
class MY_Controller extends CI_Controller{
	
	public $user;
	public $is_purified;	
	
	/**
	 * Construieste obiectul $user
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();		
		$this->user = $this->access->get_account();
		
		//filtrele pt performers
		$this->is_purified = FALSE;
		
		if(SETTINGS_DEBUG){
			$this->output->enable_profiler();
		}
		
		
		if($this->session->userdata('type') == 'studio'){
			redirect(main_url().STUDIOS_URL);
		}elseif($this->session->userdata('type') == 'performer'){
			redirect(main_url().PREFORMERS_URL);
		}
	}
}

/**
 * Users controller
 * @author Andrei
 *
 */
class MY_Users extends MY_Controller{
	
	public $active_session = NULL;

	/**
	 * Restrictioneaza accessul catre controllerul de users
	 * @return null
	 */
	function __construct(){
		parent::__construct();
		$this->access->restrict('users'); 
		
		$this->load->model('watchers');
		$watcher = $this->watchers->get_one_active_session_by_user_id($this->user->id);
		
		//ii scad chipsurile consumate
		if( $watcher ){			
			$this->user->credits -= $watcher->user_paid_chips;
			$this->active_session = $watcher; 
		}
		
		
	}
}


/**
 * Controllerul de FMS
 * @author Andrei
 *
 */
class MY_FMS extends CI_Controller{
	
	/**
	 * Constructor pentru FMS
	 * @return null
	 */
	function __construct(){
		parent::__construct();
		$hash = $this->input->post('hash');
		if( defined('FMS_SECRET_HASH') && $hash !== FMS_SECRET_HASH ) {
			//$this->write_request(APPPATH.'logs/fms/denys.txt', 'status=deny&log=bad_secret_hash', true, true);
		}
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
		
		$x = '';
	
		$pathInfo = pathinfo($file);
		$url = base_url().'fms/'. $pathInfo['filename'] .'/';
	
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
	
	


