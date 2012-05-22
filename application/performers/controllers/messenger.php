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
 * @property Messages $messages
 */
Class Messenger_controller extends MY_Performer{
		
	// -----------------------------------------------------------------------------------------	
	/**
	 * Constructor
	 * @return unknown_type
	 */
	function __construct(){
		parent::__construct();
		$this->folders = array('inbox','sent','trash');
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * 
	 * @return unknown_type
	 */
	function index(){
		$this->inbox();			
	}
	
	
	// -----------------------------------------------------------------------------------------	
	/**
	 * Listare mesaje din inbox
	 * @return unknown_type
	 */
	function inbox(){
		$this->load->model('messages');
		$this->load->helper('text');
		

		$data['messages'] 		= $this->messages->get_all_received_by_user_id($this->user->id, $this->user->type, FALSE, FALSE, FALSE);
		$data['unread_number'] 	= $this->messages->get_all_received_by_user_id($this->user->id, $this->user->type, FALSE, FALSE, TRUE, TRUE);
			
		
		$data['folder'] = 'inbox';
		
		$data['_performer_menu']		= TRUE;
		$data['page'] 					= 'messenger/messenger_inbox';
		$data['description'] 			= SETTINGS_SITE_DESCRIPTION;
		$data['keywords'] 				= SETTINGS_SITE_KEYWORDS;
		$data['pageTitle'] 				= lang('Messenger').' - '.SETTINGS_SITE_TITLE;
			
		$this->load->view('template', $data);		
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Listare de mailuri dintrun folder
	 * @author Baidoc
	 */
	function mail_list(){
		//nu e apelat prin ajax
		if( ! $this->input->is_ajax_request() ){			
			redirect();	
		}
		
		$folder = $this->input->post('folder');
		
		//folderul nu e valid
		if( ! in_array($folder,$this->folders) ){
			$folder = 'inbox';
		}
		
		$this->load->model('messages');
		$this->load->helper('text');
		
		if($folder == 'inbox'){
		
			$data['messages'] 	= $this->messages->get_all_received_by_user_id($this->user->id, $this->user->type, FALSE, FALSE, FALSE);
			
		}elseif($folder == 'sent'){
			
			$data['messages'] 	= $this->messages->get_all_sent_by_user_id($this->user->id, $this->user->type, FALSE, FALSE, FALSE);
			
		}elseif($folder == 'trash'){
			
			$data['messages'] 	= $this->messages->get_all_trashed_by_user_id($this->user->id, $this->user->type, FALSE, FALSE, FALSE);
			
		}
		
		$data['folder'] = $folder;
		
		if(is_array($data['messages']) && count($data['messages']) > 0){
			$json_response['list'] = $this->load->view('messenger/messenger_list', $data, TRUE);		
			$json_response['success'] = TRUE;
			die(json_encode($json_response));
		}else{
			$json_response['error'] = '<span class="no_messages">'. lang('No messages in this folder') .'.</span>';		
			$json_response['success'] = false;
			die(json_encode($json_response));
		}
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Afiseaza un email
	 * @author Baidoc
	 */	
	function mail(){
		//nu e apelat prin ajax
		if( ! $this->input->is_ajax_request() ){			
			redirect();	
		}
		
		$this->load->model('messages');
		$this->load->helper('text');

		$folder = $this->input->post('folder');
		$this->sent = ($folder === 'sent')?TRUE:FALSE;
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('folder',		lang('folder'),		'trim|required|valid_message_folder');
		$this->form_validation->set_rules('id',			lang('message id'),	'trim|required|valid_message_id');
		
		if( $this->form_validation->run() === FALSE ){
				
			$json_response['error'] = '<span class="no_messages">'. validation_errors('<div>','</div>') .'.</span>';
			$json_response['success'] = FALSE;
			die(json_encode($json_response));
				
		} else {
				
			$data['message'] = $this->message;
			
			if ($this->user->id == $data['message']->to_id && $this->user->type == $data['message']->to_type) {
				
				//daca e mesaj trimis de catre performer, sau primit de catre performer
				$data['received'] = TRUE;
				
				//citim mesajul daca e necitit
				if($data['message']->readed_by_recipient == 0) {
					$updates = array('readed_by_recipient' => 1);
					$this->messages->update_message($data['message']->id, $updates);
				}
				//determinam numarul de mesaje necitite dupa ce se face update-ul pentru cititrea unui mesaj
				$json_response['unread_number'] = $this->messages->get_all_received_by_user_id($this->user->id, $this->user->type, FALSE, FALSE, TRUE, TRUE);
				//incarcam view-ul pentru citirea mesajului
				
				$json_response['mail'] = $this->load->view('messenger/messenger_mail', $data, TRUE);
				$json_response['success'] = TRUE;
				die(json_encode($json_response));
									
			} elseif ($this->user->id == $data['message']->from_id && $this->user->type == $data['message']->from_type) {
											
				$json_response['unread_number'] = $this->messages->get_all_received_by_user_id($this->user->id, $this->user->type, FALSE, FALSE, TRUE, TRUE);
				$data['received'] = FALSE;
				
				$json_response['mail'] = $this->load->view('messenger/messenger_mail', $data, TRUE);
				$json_response['success'] = TRUE;
				die(json_encode($json_response));
				
				
			} else {
				$json_response['error'] = '<span class="no_messages">'. lang('Error please try again!') .'.</span>';
				$json_response['success'] = FALSE;
				die(json_encode($json_response));
			}
		}
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	 * Functie ce trimite mail
	 * @author Baidoc
	 */
	 function send_mail(){
		//nu e apelat prin ajax
		if( ! $this->input->is_ajax_request() ){			
			redirect();	
		}
		
		$this->load->model('messages');
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('subject',	lang('subject'),	'trim|required|strip_tags|purify|max_length[255]');
		$this->form_validation->set_rules('message',	lang('message'),	'trim|required|strip_tags|purify');
		$this->form_validation->set_rules('message_id',	lang('message_id'),	'trim|required|valid_message_id');
		
		if( $this->form_validation->run() === FALSE ){
			
			$json_response['success'] = FALSE;
			$json_response['error'] = '<span class="no_messages">'. validation_errors('<div>','</div>') .'.</span>';
			die(json_encode($json_response));
						
		} else {
			
			$old_message 	= $this->message;
			
			if( $this->messages->add(
							$this->input->post('subject'),
							$this->input->post('message'),
							0,
							0,
							0,
							0,
							time(),
							'performer',
							$this->user->id,
							$old_message->from_type,
							$old_message->from_id
				)) 
			{
				$json_response['success'] = TRUE;
				$json_response['error'] = lang('Message sent!');
				die(json_encode($json_response));
			} else {
				$json_response['success'] = FALSE;
				$json_response['error'] = lang('Error sending message!');
				die(json_encode($json_response));
			}	
		}				
	}
	
	// -----------------------------------------------------------------------------------------	
	/**
	* Sterge un mesaj
	* @author Baidoc
	*/	
	function move_to_trash(){
		
		//nu e apelat prin ajax
		if( ! $this->input->is_ajax_request() ){			
			redirect();	
		}
		
		$folder = $this->input->post('folder');
		$this->sent = ($folder == 'sent')?TRUE:FALSE;
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('folder',		lang('folder'),		'trim|required|valid_message_folder');
		$this->form_validation->set_rules('message_id',	lang('message id'),	'trim|required|valid_message_id');
		
		if( $this->form_validation->run() === FALSE ){
			
			$json_response['success'] = FALSE;
			$json_response['error'] = '<span class="no_messages">'. validation_errors(NULL,NULL) .'</span>';
			die(json_encode($json_response));
						
		} else {
			
			$message = $this->message;
				
			if (
				($this->user->id == $message->to_id && $this->user->type == $message->to_type) //from inbox or trash
					|| 
				($this->user->id == $message->from_id && $this->user->type == $message->from_type)
			){ //from sent
				if($folder == 'inbox'){
					$updates = array('trashed_by_recipient' => 1);
					$json_response['error'] = lang('Message was moved to trash!');
				}elseif($folder == 'sent'){
					$updates = array('deleted_by_sender' => 1);
					$json_response['error'] = lang('Message was deleted!');
				}else{
					$updates = array('deleted_by_recipient' => 1);
					$json_response['error'] = lang('Message was deleted!');
				}
			
				$this->messages->update_message($message->id, $updates);
		
				$json_response['success'] = TRUE;
				die(json_encode($json_response));
			}
		}		
	}
}