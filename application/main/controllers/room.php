<?php
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
 * @property System_logs $system_logs
 * @property Watchers	$watchers
 */
class Room_controller extends MY_Controller{
	
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('performers');
		$this->load->model('watchers');

	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Intrare in chat
	 * @param $nickname
	 * @param $type
	 * @return unknown_type
	 */
	function index($nickname = FALSE, $type = 'free'){
			
		if( ! $nickname ){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=> lang('invalid performer')));
			redirect();
		}
		
		if( ! $this->performers->valid_performer($nickname)){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=> lang('invalid performer')));
			redirect();			
		}
	
		if( ! $this->watchers->valid_chat_type($type) ){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=> lang('invalid room type')));
			redirect();			
		}
		
		//access to other types of chats is restricted to logged users
		if( $type !== 'free'){		
			$this->access->restrict('users');
					
		}	
		
		$performer = $this->performers->get_one_by_nickname($nickname);
		if( ! $performer || ! $performer['performer']){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=> lang('performer does not exist')));
			redirect();						
		}
		
		$performer = $performer['performer'];
		
		$this->load->model('users');
		if( ! $this->users->can_start_chat($type,$performer) ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>sprintf(lang('Your account balance is too low to access %s show.'), $type)));
			redirect('add-credits');						
		}
				
		if( ! $performer->is_online ){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=> lang('performer is currently offline')));
			redirect();									
		}
		
		if( ! $this->performers->allowed_chat_type($performer,$type) ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('performer is currently in another room type')));
			redirect();												
		} 
		
		$this->load->model('banned_countries');
				
		//userul se afla intro regiune blacklistata de catre performer
		if($this->banned_countries->is_performer_blacklisted_region($performer->id)){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=>lang('invalid performer')));
			redirect();
		}		
				
		if( $this->user->id > 0) { //userul e logat il caut dupa user_id
			
			if( $this->watchers->get_one_active_session_by_user_id($this->user->id) ){
				$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=> lang('you are allowed to have only one session at once')));
				redirect();															
			}
			
		} else { //userul nu e logat il caut dupa ip
			
			if( $this->watchers->get_one_active_session_by_ip($this->input->ip_address())){
				$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=> lang('you are allowed to have only one session at once')));
				redirect();															
			}						
		}

		//verific daca userul e banat
		if( $this->watchers->check_user_for_ban_by_performer_id($this->user->id,$performer->id,$this->input->ip_address()) ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>sprintf(lang('you are banned by %s'),$performer->nickname)));
			redirect();
		}
		
		$this->load->model('fms');
		$this->fms_list = create_array_by_property($this->fms->get_multiple(),'fms_id');
		
		if( ! isset($this->fms_list[$performer->fms_id]) ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Performer cannot go online!')));
			redirect();			
		}
		
		$fms = $this->fms_list[$performer->fms_id];
		
		$this->system_log->add(
            			'user', 
            			$this->user->id,
            			'user', 
            			$this->user->id, 
            			'start_chat', 
            			sprintf('User has entered chat with %s chips , performer %s .', isset($this->user->credits)?$this->user->credits:0,$performer->credits), 
            			time(), 
            			ip2long($this->input->ip_address())
		);
		
		$this->load->model('categories');

		//pentru submeniu de profil
		$this->load->model('performers_videos');
		$data['videos_nr'] = $this->performers_videos->get_multiple_by_performer_id($performer->id,FALSE,FALSE,TRUE);
		$this->load->model('performers_photos');
		$data['photos_nr'] = $this->performers_photos->get_multiple_by_performer_id($performer->id,FALSE,FALSE,TRUE);
		
		$this->load->config('others');
		$general_types = $this->config->item('session_types');
		
		$data['categories'] 			= $this->categories->get_all_categories();		
		$data['_categories']			= true;
		$data['_sidebar']				= false;
		$data['_signup_header']			= true;
		$data['page'] 					= 'chat/website_models';
		$data['description']			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords']				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle']				= $performer->nickname.'\'s '.lang('Room').' - '.SETTINGS_SITE_TITLE;
		$this->is_purified = TRUE;		
		$data['performers']				= $this->performers->get_multiple_performers(array(),13,0,array());
		
		$params['uniqId']				= $this->watchers->generate_one_unique_id();		
		if($this->user->id > 0){
			$params['pasword']		= $this->user->password;
			$params['userId']		= 'v' . $this->user->id;
			$params['userName']		= $this->user->username;
			$params['chips']		= $this->user->credits;
			$params['tipFileLink'] 	= site_url('tip');
			$params['peekLink']		= site_url('room/' . $performer->nickname . '/peek');
			$params['nudeLink']		= site_url('room/' . $performer->nickname . '/nude');
			$params['redirectLink']	= ($type == 'public')?site_url():site_url($performer->nickname . '/review?id=' . $params['uniqId']);
		} else {
			$params['userName']		= 'Anonymus' . mt_rand(1000,9999);
			$params['userId']		= 'v';			
			$params['chips']		= 0;
			$params['redirectLink']	= site_url();				
		}
		
		
		$params['performerId']			= $performer->id;
		$params['sessionType']			= $general_types[$type];
		$params['performersFeePerMinutePrivate']	= $performer->private_chips_price;
		$params['performersFeePerMinuteTruePrivate']= $performer->true_private_chips_price;
		$params['performersFeePerMinutePeek']		= $performer->peek_chips_price;
		$params['performersFeePerMinuteNude']		= $performer->nude_chips_price;
		$params['minChipsForPrivate']				= $performer->private_chips_price;;		
		$params['performerNick']		= $performer->nickname;		
		$params['performerNickColor']	= '0x129400';
		$params['noChat']				= 'false';
		$params['nickColor']			= '0x129400';
		$params['showSwitch']			= 'true';
		$params['sitePath']				= site_url();
		$params['rtmp']					= $fms->fms;

		$data['params']		= $params;
		$data['width']		= ($type == 'peek')?824:940;
		$data['height']		= ($type == 'peek')?682:750;
		$data['height_resize'] = ($type == 'peek')?480:540;
		$data['swf']		= ($type == 'peek')?'peek.swf':'viewer.swf';
		$data['allow_fullscreen']	 = TRUE;
		
		$this->output->set_header("HTTP/1.1 200 OK");
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
		 
		$this->load->view('template',$data);
	}
	
	/**
	 * Confirmation method
	 * @return unknown_type
	 */
	/*
	private function confirm($nickname = FALSE,$type = FALSE){

		
		if( ! $this->input->is_ajax_request() ){
			//requestul se face prin ajax, daca nu e prin ajax inseamna ca atacatorul a incercat el manual sa duca utilizatorul pe pagina
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid request type!')));
			redirect();
		}
		
		$this->im_in_modal = TRUE;
		
		$nickname = $this->uri->segment(2);
		if( ! $nickname ){		
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid performer')));
			redirect();			
		}
		
		$performer = $this->performers->get_one_by_nickname($nickname);
		if( ! $performer ){		
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('Invalid performer')));
			redirect();			
		}
		
		$performer = $performer['performer'];
		
		if( ! $this->watchers->valid_chat_type($type) ){
			$this->session->set_flashdata('msg', array('success'=>FALSE,'message'=> lang('invalid room type')));
			redirect();			
		}

		if( ! $this->users->can_start_chat($type,$performer) ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>sprintf(lang('Your account balance is too low to access %s show.'), $type)));			
			redirect('add-credits');						
		}

		if( ! $this->performers->allowed_chat_type($performer,$type) ){
			$this->session->set_flashdata('msg',array('success'=>FALSE,'message'=>lang('performer is currently in another room type')));
			redirect();												
		} 
		$data['type'] 		= $type;
		$data['performer']	= $performer;
		$this->load->view('confirmations/join_chat',$data);
	}
	*/
}