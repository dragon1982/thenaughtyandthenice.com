<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
 * @property Performers $performers
 * @property Watchers $watchers
 * @property System_logs $system_logs
 */

class Install_controller extends CI_Controller{

	var $translations,$available_languages=array(),$generated_translations;
	
	var $supported_languages = array(
		array('code'=>'de','title'=>'deutsch'),
		array('code'=>'en','title'=>'english'),
		array('code'=>'es','title'=>'espanol'),
		array('code'=>'fr','title'=>'francais'),
		array('code'=>'it','title'=>'italiano'),		
		array('code'=>'ro','title'=>'romana')
		
	);

	
	function __construct(){
		parent::__construct();
		
		if( ! file_exists('started_install' . EXT) || APP_INSTALLED ){
			die('Fatal error.');			
		} else {
						
			require_once 'started_install' . EXT;
			//trebuie inceput installu
			if( ! isset( $data['salt']) ){

				//nu pot sa scriu in fisierele dorite
				if( ! check_chmod('started_install' . EXT) || ! check_chmod(APPPATH.'config/config.php') ){
					$data['list']	=	array(					
							array	(
								'name'		=>	'CHMOD 0777 <b>' . getcwd() . '/application/main/config/config.php</b>',
								'type'		=>	'fil',
								'request'	=>	'writable',
								'current'	=>	(check_chmod('application/main/config/config.php')) ? 'writable' : @substr(sprintf('%o', fileperms('application/main/config/config.php')), -4),
								'why'		=>	null,
							),
							array	(
								'name'		=>	'CHMOD 0777 <b>' . getcwd() . '/started_install.php</b>',
								'type'		=>	'fil',
								'request'	=>	'writable',
								'current'	=>	(check_chmod('started_install.php')) ? 'writable' : @substr(sprintf('%o', fileperms('started_install.php')), -4),
								'why'		=>	null,
							)
					);
						
					$view = $this->load->view('install/cannot_start_setup',$data,TRUE);
					die($view);	
				} else {

					//generez variabilele pt config
					$data['encrypt_key'] 	= substr(md5(uniqid()),0,9);
					$data['session_name']	= preg_replace("/^([a-z])+$/i",'',substr(md5(uniqid()),0,10));
					$data['salt']			= sha1(uniqid('',mt_rand()));
					$data['secret_temp_path']= sha1(uniqid('',mt_rand()));
					$data['url']			=  str_replace('install','','http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
					
					
					//rescriu start_installul
					$text = "<?php\r\n";
					$text .= $this->load->view('install/first',$data,TRUE);						
					write_file('started_install.php', $text);
					
						
					//rescriu application/main/config/config
					$config_main	= "<?php\r\n ". $this->load->view('install/config',$data,TRUE);					
					write_file(APPPATH.'config/config.php',$config_main);
						
					header('Location: http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);						
				}				
			}
		}
	}
	
	/**
	 * Redirectare catre stepul dorit
	 * @author Baidoc
	 */
	function index(){
		//step loading
		if( ! $this->session->userdata('step') ){
			$this->step1();
		
		} else {
			$step = 'step' . $this->session->userdata('step');
		
			$this->$step();
				
		}		
	}

	/**
	 * Check for permisions / needed libraries
	 * @return unknown_type
	 */

	function step1(){
		require 'started_install.php';
		
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('<span class="error">','</span>');
		$this->form_validation->set_rules('go_forward','continue','trim|required');
		
		if($this->form_validation->run() === FALSE) {
			$extensions		=	get_loaded_extensions();	
			$data['list']	=	array(
			
							array	(
										'name'		=>	'PHP Version',
										'type'		=>	'phpVersion',
										'request'	=>	'5.2+',
										'current'	=>	phpversion(),
										'why'		=>	null,
									),
	
							array	(
										'name'		=>	'PHP Directive: Register Globals (<a href="http://www.php.net/manual/en/ini.core.php#ini.register-globals" target="_blank">register_globals</a>)',
										'type'		=>	'ini',
										'request'	=>	'off',
										'current'	=>	(ini_get('register_globals') == 1) ? 'on' : 'off',
										'why'		=>	"This feature has been DEPRECATED as of PHP 5.3.0.<br />Relying on this feature is highly discouraged.",
									),
	
							array	(
										'name'		=>	'PHP Directive: Short Open Tags (<a href="http://www.php.net/ini.core#ini.short-open-tag" target="_blank">short_open_tag</a>)',
										'type'		=>	'ini',
										'request'	=>	'on',
										'current'	=>	(ini_get('short_open_tag') == 1) ? 'on' : 'off',
										'why'		=>	null,
									),
	
							array(
										'name'			=> 'PHP Directive: Safe mode',
										'type'			=> 'ini',
									 	'request'		=> 'off',
									 	'current'		=> (ini_get('safe_mode')?'on':'off'),
									 	'why'			=> 'This feature has been DEPRECATED as of PHP 5.3.0.<br />Relying on this feature is highly discouraged.'
							),					
							array	(
										'name'		=>	'PHP Directive: Allow Url Fopen (<a href="http://www.php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen" target="_blank">allow_url_fopen</a>)',
										'type'		=>	'ini',
										'request'	=>	'on',
										'current'	=>	(ini_get('allow_url_fopen') == 1) ? 'on' : 'off',
										'why'		=>	null,
									),
	
	
							array	(
										'name'		=>	'PHP Directive:  (<a href="http://www.php.net/manual/en/ini.core.php#ini.post-max-size" target="_blank">post_max_size</a> & <a href="http://www.php.net/manual/en/ini.core.php#ini.upload-max-filesize" target="_blank">upload_max_filesize</a>)',
										'type'		=>	'maxUploadSize',
										'request'	=>	'32',
										'current'	=>	abs(intval(min(ini_get('post_max_size'), ini_get('upload_max_filesize')))),
										'why'		=>	null,
									),
	
							array	(
										'name'		=>	'PHP Directive:  (<a href="http://www.php.net/manual/en/ini.core.php#ini.max_execution_time" target="_blank">max_execution_time</a>)',
										'type'		=>	'maxExecutionTime',
										'request'	=>	'60',
										'current'	=>	abs(intval(ini_get('max_execution_time'))),
										'why'		=>	null,
									),
	
							array	(
										'name'		=>	'PHP Extension: GD (<a href="http://php.net/manual/en/book.image.php" target="_blank">GD Library</a>)',
										'type'		=>	'ext',  
										'request'	=>	'true',
										'current'	=>	(is_numeric(array_search('gd', $extensions))) ? 'true' : 'false',
										'why'		=>	null,
									),
	
							array	(
										'name'		=>	'PHP Extension: PDO (<a href="http://www.php.net/manual/en/book.pdo.php" target="_blank">PDO Library</a>)',
										'type'		=>	'ext',
										'request'	=>	'true',
										'current'	=>	(is_numeric(array_search('PDO', $extensions))) ? 'true' : 'false',
										'why'		=>	null,
									),
							array	(
										'name'		=>	'PHP Extension: CURL (<a href="http://php.net/manual/en/book.curl.php" target="_blank">CURL Library</a>)',
										'type'		=>	'ext',
										'request'	=>	'true',
										'current'	=>	(is_numeric(array_search('curl', $extensions))) ? 'true' : 'false',
										'why'		=>	null,
							),
							array	(
										'name'		=>	'PHP Extension: PDO MySQL (<a href="http://www.php.net/manual/en/ref.pdo-mysql.php" target="_blank">PDO MySQL Library</a>)',
										'type'		=>	'ext',
										'request'	=>	'true',
										'current'	=>	(is_numeric(array_search('pdo_mysql', $extensions))) ? 'true' : 'false',
										'why'		=>	null,
									),
							array	(
										'name'		=>	'mkdir -m 0777  <b>' . getcwd() . '/'.$secret_temp_path.'</b>',
										'type'		=>	'directory',
										'request'	=>	'writable',
										'current'	=>	(check_chmod($secret_temp_path)) ? 'writable' : @substr(sprintf('%o', fileperms($secret_temp_path)), -4),
										'why'		=>	null,
							),									
							array	(
										'name'		=>	'CHMOD 0777  <b>' . getcwd() . '/'.$secret_temp_path.'</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod($secret_temp_path)) ? 'writable' : @substr(sprintf('%o', fileperms($secret_temp_path)), -4),
										'why'		=>	null,
							),									
							array	(
										'name'		=>	'CHMOD 0777  <b>' . getcwd() . '/settings.php</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('settings.php')) ? 'writable' : @substr(sprintf('%o', fileperms('settings.php')), -4),
										'why'		=>	null,
							),									

							array	(
										'name'		=>	'CHMOD -R 0777  <b>' . getcwd() . '/application/language</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/language')) ? 'writable' : @substr(sprintf('%o', fileperms('application/language')), -4),
										'why'		=>	null,
							),							
							array	(
										'name'		=>	'CHMOD -R 0777  <b>' . getcwd() . '/uploads</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('uploads')) ? 'writable' : @substr(sprintf('%o', fileperms('uploads')), -4),
										'why'		=>	null,
							),							
							array	(
										'name'		=>	'CHMOD -R 0777  <b>' . getcwd() . '/application/main/config</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/main/config')) ? 'writable' : @substr(sprintf('%o', fileperms('application/main/config')), -4),
										'why'		=>	null,
							),
							array	(
										'name'		=>	'CHMOD 0777  <b>' . getcwd() . '/application/main/logs</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/main/logs')) ? 'writable' : @substr(sprintf('%o', fileperms('application/main/logs')), -4),
										'why'		=>	null,
							),				
							array	(
										'name'		=>	'CHMOD 0777  <b>' . getcwd() . '/application/main/logs/fms</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/main/logs/fms')) ? 'writable' : @substr(sprintf('%o', fileperms('application/main/logs/fms')), -4),
										'why'		=>	null,
							),
							array	(
										'name'		=>	'CHMOD 0777  <b>' . getcwd() . '/application/main/logs/fms/more</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/main/logs/fms/more')) ? 'writable' : @substr(sprintf('%o', fileperms('application/main/logs/fms/more')), -4),
										'why'		=>	null,
							),				
							array	(
										'name'		=>	'CHMOD -R 0777  <b>' . getcwd() . '/application/performers/config</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/performers/config')) ? 'writable' : @substr(sprintf('%o', fileperms('application/performers/config')), -4),
										'why'		=>	null,
							),		
							array	(
										'name'		=>	'CHMOD 0777  <b>' . getcwd() . '/application/performers/logs</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/performers/logs')) ? 'writable' : @substr(sprintf('%o', fileperms('application/performers/logs')), -4),
										'why'		=>	null,
							),
							array	(
										'name'		=>	'CHMOD 0777  <b>' . getcwd() . '/application/performers/logs/fms</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/performers/logs/fms')) ? 'writable' : @substr(sprintf('%o', fileperms('application/performers/logs/fms')), -4),
										'why'		=>	null,
							),							
							array	(
										'name'		=>	'CHMOD -R 0777  <b>' . getcwd() . '/application/studios/config/</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/studios/config')) ? 'writable' : @substr(sprintf('%o', fileperms('application/studios/config')), -4),
										'why'		=>	null,
							),				
							array	(
										'name'		=>	'CHMOD 0777  <b>' . getcwd() . '/application/studios/logs</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/studios/logs')) ? 'writable' : @substr(sprintf('%o', fileperms('application/studios/logs')), -4),
										'why'		=>	null,
							),																		
							array	(
										'name'		=>	'CHMOD -R 0777  <b>' . getcwd() . '/application/admin/config</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/admin/config')) ? 'writable' : @substr(sprintf('%o', fileperms('application/admin/config')), -4),
										'why'		=>	null,
							),
							array	(
										'name'		=>	'CHMOD 0777  <b>' . getcwd() . '/application/admin/logs</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/admin/logs')) ? 'writable' : @substr(sprintf('%o', fileperms('application/admin/logs')), -4),
										'why'		=>	null,
							),
							array	(
										'name'		=>	'CHMOD -R 0777  <b>' . getcwd() . '/application/affiliates/config</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/affiliates/config')) ? 'writable' : @substr(sprintf('%o', fileperms('application/affiliates/config')), -4),
										'why'		=>	null,
							),			
							array	(
										'name'		=>	'CHMOD 0777  <b>' . getcwd() . '/application/affiliates/logs</b>',
										'type'		=>	'fil',
										'request'	=>	'writable',
										'current'	=>	(check_chmod('application/affiliates/logs')) ? 'writable' : @substr(sprintf('%o', fileperms('application/admin/logs')), -4),
										'why'		=>	null,
							),
										
					);
										
			$this->load->view('install/step1',$data);
		} else {
			$url = (substr($_SERVER['REQUEST_URI'],-1) == '/')?substr($_SERVER['REQUEST_URI'],0,-1):$_SERVER['REQUEST_URI'];
			if(strlen($_SERVER['REQUEST_URI']) > 0){
				
				$settings = '<?php
					define(\'APP_INSTALLED\',FALSE);				
					define(\'WEB_URL\',       \''. str_replace('install','',$url).'\');
					define(\'PREFORMERS_URL\',\'performer\');
					define(\'STUDIOS_URL\',   \'studio\');
					define(\'AFFILIATES_URL\',\'affiliate\');
					define(\'ADMINS_URL\',    \'admin\');
					define(\'MY_TEMP_PATH\', \''. $secret_temp_path .'\');				
				';
				
			}
			write_file($secret_temp_path.'/.htaccess', 'deny from all');
			write_file('settings.php', $settings);
			$this->session->set_userdata('step',2);
			redirect(current_url());
		}
			
	}
	
	
	/**
	 * 
	 * @return unknown_type
	 */
	function step2(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<span class="error">','</span>');
		
		$this->form_validation->set_rules('agree','agree','trim|required');
		if( $this->form_validation->run() === FALSE ){			
			$this->load->view('install/step2');	
		} else {
			$this->session->set_userdata('step',3);
			redirect(current_url());			
		}
		
	}
	
	
	/**
	 * Application paths
	 * Database/PDO settings
	 * @return unknown_type
	 */
	function step3(){			
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="error">','</span>');
		
		//DATABASE SETTINGS		
		$this->form_validation->set_rules('database_host',		'database host',		'trim|required');
		$this->form_validation->set_rules('database_username',	'database username',	'trim|required');
		$this->form_validation->set_rules('database_name',		'database name',		'trim|required|callback_check_database');		

		
		//MEMCACHE SETTINGS
		/*
		$this->form_validation->set_rules('enable_memcache',	'memcache',			'trim');
		if($this->input->post('enable_memcache')){
			$this->form_validation->set_rules('memcache_host',	'memcache host',	'trim|required');
			$this->form_validation->set_rules('memcache_port',	'memcache port',	'trim|required|callback_check_memcache');
		}
		*/
		if( $this->form_validation->run() === FALSE){
			$this->load->view('install/step3');
		} else {		
			//urls
			$main_url 				= str_replace('install','',current_url());
			
			$data['debug']	= 'TRUE';
			
			$constant = '<?php' . PHP_EOL;
			
			require 'started_install' . EXT;
			
			$database_conf	= $constant	. $this->load->view('install/database',$data,TRUE);			
			
			//main APP
			$data['url'] = $main_url;			
			$config_main	= $constant . $this->load->view('install/config',$data,TRUE);			
			write_file(APPPATH.'config/config.php',$config_main);
			write_file(APPPATH.'config/database.php',$database_conf);
			
			
			$data['url'] = $main_url.'performer/';
			$config_main	= $constant . $this->load->view('install/config',$data,TRUE);
			write_file(APPPATH.'../performers/config/config.php',$config_main);
			write_file(APPPATH.'../performers/config/database.php',$database_conf);
						
			$data['url'] 	= $main_url.'studio/';
			$config_main	= $constant . $this->load->view('install/config',$data,TRUE);
			write_file(APPPATH.'../studios/config/config.php',$config_main);
			write_file(APPPATH.'../studios/config/database.php',$database_conf);

			
			$data['url'] = $main_url.'affiliate/';
			$config_main	= $constant . $this->load->view('install/config',$data,TRUE);			
			write_file(APPPATH.'../affiliates/config/config.php',$config_main);
			write_file(APPPATH.'../affiliates/config/database.php',$database_conf);			
			
			$data['url'] 		= $main_url.'admin/';
			$config_main	= $constant . $this->load->view('install/config',$data,TRUE);
			write_file(APPPATH.'../admin/config/config.php',$config_main);
			write_file(APPPATH.'../admin/config/database.php',$database_conf);

			$this->session->set_userdata('step',4);
			redirect(current_url());										
		}
	}
	
	//Admin step 4
	function step4(){		
		//instalez dbu
		$this->load->database();
		
		$this->load->library('migrations');
		if ( ! $this->migrations->install())
		{
			show_error($this->migrations->error);
			exit;
		}
		
		
		if( is_dir('extended') ){
			
			$this->load->helper('file');
			$data = read_file('import/database.sql');
			$queries = explode(';',$data);
				
			//start transaction
			$this->db->trans_start();
				
			//opresc foreign key checku
			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
						
			foreach($queries as $query){
				if(strlen(trim($query)) == 0) continue;
				$this->db->query($query);
			}
				
			//il repornesc
			$this->db->query("SET FOREIGN_KEY_CHECKS = 1");
				
			if($this->db->trans_status() === FALSE ){
				$this->db->trans_rollback();
				die('Database import error');
			}
				
			$this->db->trans_commit();
			
			$this->load->helper('directories');
			if ($handle = opendir('import')) {
				while (false !== ($dir = readdir($handle))) {
					if ($dir != "." && $dir != ".." && is_dir('import/'.$dir)) {
						copy_directory('import/'.$dir,'uploads/performers/'.$dir);
					}
				}
				closedir($handle);
			}
			
			$performers = $this->db->get('performers')->result();
			if(sizeof($performers) > 0){
				foreach( $performers as $performer ){
					$this->db->set(array('password'=>hash('sha256',$this->config->item('salt'). $performer->hash . 'sample')))->where('id',$performer->id)->update('performers');
				}
			}
		}		
						
		$this->session->set_userdata('step',5);
		redirect(current_url());			
	}
	
	//Admin settings
	function step5(){
		$data['currency'] = array(
			0	=> 'chips',
			1	=> 'euro',
			2	=> 'dollar'
		);
		
		$data['currency_types'] = array(
			'0'	=> 'real currency',
			'1'	=> 	'chips'
		);
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="error">','</span>');
		
		//website name
		$this->form_validation->set_rules('site_title',			'site title',			'trim|required|max_length[100]');
		$this->form_validation->set_rules('site_description',	'site description',		'trim|required|max_length[100]');
		$this->form_validation->set_rules('website_license',	'website license',		'trim|max_length[255]');
						
		
		$this->form_validation->set_rules('admin_user',		'admin username',	'trim|required');
		$this->form_validation->set_rules('admin_pass',		'admin password',	'trim|required');
		
		$this->form_validation->set_rules('support_name',	'Support name',		'trim|required');
		$this->form_validation->set_rules('support_email',	'Support email',	'trim|required');
		$this->form_validation->set_rules('currency_type',  'currency type', 	'trim|required');
		
		$this->form_validation->set_rules('free_chat_limit_notlogged',			'Free chat limit not logged',			'trim|required');
		$this->form_validation->set_rules('free_chat_limit_logged_no_credits',	'Free chat limit logged no credits',	'trim|required');
		$this->form_validation->set_rules('free_chat_limit_logged_with_credits','Free chat limit logged with credits',	'trim|required');
		$this->form_validation->set_rules('minimum_paid_chat_time',				'Minimum paid chat time',				'trim|required');
		
		if( $this->input->post() ){
			
			//validez tipul de currency
			$tip_currency = $this->input->post('currency_type');
			if( $tip_currency == '0' ){//real
				$this->form_validation->set_rules('real_currency', 'Currency',	'trim|required');
				
				//daca e other trebuie sa isi mai seteze in plus si celelalte suboptiuni name si symbol
				$other = $this->input->post('real_currency');				
				if( $other == 'other' ){
					
					$this->form_validation->set_rules('real_currency_other_name', 'Currency name','trim|required');
					$this->form_validation->set_rules('real_currency_other_symbol', 'Currency symbol','trim|required');
				}
			} else {//virtual (chips)

				$this->form_validation->set_rules('real_currency_chips', 'Currency',	'trim|required');
				
				//daca e other trebuie sa isi mai seteze in plus si celelalte suboptiuni name si symbol
				$other = $this->input->post('real_currency_chips');
				if( $other == 'other' ){
						
					$this->form_validation->set_rules('real_currency_chips_other_name', 'Currency name','trim|required');
					$this->form_validation->set_rules('real_currency_chips_other_symbol', 'Currency symbol','trim|required');
				}
								
				$this->form_validation->set_rules('chips_currency',		'Virtual currency',	'trim|required');
				$this->form_validation->set_rules('chips_per_currency',	'Price per chip',	'trim|required');
			}
		}
		$this->form_validation->set_rules('cents_per_credit',	'cents_per_credit',	'trim');
						
		if( $this->form_validation->run() === FALSE ){
			$this->load->view('install/step5',$data);
		} else {
			
			$this->load->database();
			require 'started_install.php';
			
        	$hash     = generate_hash('admins');
        	$salt     = $data['salt'];
        	$password = hash('sha256', $salt . $hash . $this->input->post('admin_pass'));
        	
	        $this->db->insert(
	        	'admins',
	        		array(
        					'username'=>$this->input->post('admin_user'),
                            'password'=>$password,
                            'hash'=>$hash
	        		)
			);
        					
				
	        $currencys = array(
	        				'dollars'	=> array('symbol'=>'$','name'=>'USD'),
	        				'euros'		=> array('symbol'=>'&euro;','name'=>'EUR'),
	        			);
	        
			$this->db->where('name','settings_site_title')->update('settings',
				array(
					'value'=>$this->input->post('site_title')
				)
			);

			
			$this->db->where('name','settings_site_description')->update('settings',
				array(
					'value'=>$this->input->post('site_description')
				)
			);			        	

			$this->db->where('name','settings_currency_type')->update('settings',
				array(
					'value'=>$this->input->post('currency_type')
				)
			);

			$type = $this->input->post('currency_type');
			
			if( $type == 0){
				
				##################REAL MONEY ################
				$real_currency = $this->input->post('real_currency');
			
				$symbol = '';
				$name 	= '';
				
				if($real_currency == 'other'){
					$symbol = $this->input->post('real_currency_other_symbol');
					$name	= $this->input->post('real_currency_other_name');
				} else {
					$symbol = $currencys[$real_currency]['symbol'];
					$name 	= $currencys[$real_currency]['name'];
				}
				

				$this->db->where('name','settings_real_currency_name')->update('settings',
					array(
						'value'=>$name
					)
				);
					
				$this->db->where('name','settings_real_currency_symbol')->update('settings',
					array(
						'value'=>$symbol
					)
				);

				
				$this->db->where('name','settings_cents_per_credit')->update('settings',
					array(
						'value'=>1
					)
				);
								
				$this->db->where('name','settings_shown_currency')->update('settings',
					array(
						'value'=>$name
					)
				);				
			} else {
				##################VIRTUAL MONEY ################
				$real_currency = $this->input->post('real_currency_chips');
					
				$symbol = '';
				$name 	= '';
				
				if($real_currency == 'other'){
					$symbol = $this->input->post('real_currency_chips_other_symbol');
					$name	= $this->input->post('real_currency_chips_other_name');
				} else {
					$symbol = $currencys[$real_currency]['symbol'];
					$name 	= $currencys[$real_currency]['name'];
				}
				
				
				$this->db->where('name','settings_real_currency_name')->update('settings',
					array(
						'value'=>$name
					)
				);
					
				$this->db->where('name','settings_real_currency_symbol')->update('settings',
					array(
						'value'=>$symbol
					)
				);				

				//cum apare in lang
				$this->db->where('name','settings_shown_currency')->update('settings',
					array(
						'value'=>$this->input->post('chips_currency')
					)
				);				

				//cum se numesc chipsurile
				$this->db->where('name','settings_virtual_currency_name')->update('settings',
					array(
						'value'=>$this->input->post('chips_currency')
					)
				);
								
				$this->db->where('name','settings_cents_per_credit')->update('settings',
					array(
						'value'=>$this->input->post('chips_per_currency')
					)
				);				
			}
			
			$this->db->where('name','support_name')->update('settings',
				array(
					'value'=>$this->input->post('support_name')
				)
			);
			
			$this->db->where('name','support_email')->update('settings',
				array(
					'value'=>$this->input->post('support_email')
				)
			);
			
			$this->db->where('name','free_chat_limit_notlogged')->update('settings',
				array(
					'value'=>$this->input->post('free_chat_limit_notlogged')
				)
			);

			$this->db->where('name','free_chat_limit_logged_no_credits')->update('settings',
				array(
					'value'=>$this->input->post('free_chat_limit_logged_no_credits')
				)
			);
			
			$this->db->where('name','free_chat_limit_logged_with_credits')->update('settings',
				array(
					'value'=>$this->input->post('free_chat_limit_logged_with_credits')
				)
			);	

			$this->db->where('name','minimum_paid_chat_time')->update('settings',
				array(
					'value'=>$this->input->post('minimum_paid_chat_time')
				)
			);			
			
			$this->db->where('name','website_license')->update('settings',
				array(
					'value'=>$this->input->post('website_license')
				)
			);
			
			$settings = '<?php';
			$settings .= PHP_EOL;
						
			$set = $this->db->get('settings')->result();
			foreach($set as $s){
				if(is_numeric($s->value)) {
					$line = "define('" . strtoupper($s->name) . "', 	" . $s->value . ");";
				} else {
					$line = "define('" . strtoupper($s->name) . "', 	'" . $s->value . "');";
				}
				$settings .= $line;
				$settings .= PHP_EOL;				
			}
			
			write_file('./application/admin/config/settings.php', $settings, 'w');
			write_file('./application/affiliates/config/settings.php', $settings, 'w');
			write_file('./application/performers/config/settings.php', $settings, 'w');
			write_file('./application/studios/config/settings.php', $settings, 'w');
			write_file('./application/main/config/settings.php', $settings, 'w');
			
			
			$this->load->helper('lang_support');
			
			//populez baza de date cu limbile acceptate
			$this->populate_supported_languages();
			
			//detectez limbile vorbite
			$languages = language_init();
			
			//generez arrayul de translationuri
			$this->load->helper('directory');
			$directories 	= directory_map('application/');
			$translations 	= get_lang_array($directories);
			
			$currency_type = $this->input->post('currency_type');			
			if( ! $currency_type ){//e cu currency real
				$replacement = $name;
			} else {
				$replacement = $this->input->post('chips_currency');
			}
			
			//scriu translationurile
			populate_langs($languages, $translations,$replacement);

			
			$this->session->set_userdata('step',6);				
			redirect(current_url());			
		}		
	}
	
	/**
	 * Step 6 .. cron setup
	 * @author Baidoc
	 */
	function step6(){		
		$this->load->view('install/step6');
		$data = read_file('settings.php');
		$data = str_replace('FALSE','TRUE',$data);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.modenacam.com/install_reporter');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'website='.$this->config->item('base_url') . '&key=' . WEBSITE_LICENSE.'&salt='.$this->config->item('salt'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($ch);
		curl_close($ch);
		
		
		write_file('./settings.php', $data, 'w');
		$this->session->unset_userdata('step');				
	}
	
	/**
	 * Verifica daca datele de database sunt corecte
	 * @return unknown_type
	 */
	function check_database(){
		if ( ! $con =  @mysql_connect($this->input->post('database_host'), $this->input->post('database_username'), $this->input->post('database_password')) ){
			$this->form_validation->set_message(__FUNCTION__,'Invalid database logins');
			return FALSE;
		}    			
		
		if( ! mysql_select_db($this->input->post('database_name'),$con)){
			@mysql_close($con);
			$this->form_validation->set_message(__FUNCTION__,'Invalid database name');
			return FALSE;			
		}
		
		@mysql_close($con);
		
		return TRUE;
	}
	

	/**
	 * Populeaza langurile suportate
	 * @return unknown_type
	 */
    private function populate_supported_languages(){
    	if(sizeof($this->supported_languages) == 0){
    		return;
    	}	
    	
    	foreach($this->supported_languages as $supported_language){
    		$this->db->insert('supported_languages',$supported_language);
    	}
    }
	/**
	 * Verifica daca datele de memcache sunt corecte
	 * @return unknown_type
	 */
	function check_memcache(){
		return TRUE;
	}
}