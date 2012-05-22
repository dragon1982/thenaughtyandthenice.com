<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Em {

	
	//config vars
	private $CI = '';
	private $messages = '';
	private $message_types = array('error', 'success', 'warning', 'info');
	
	function __construct() {
		$this->CI =& get_instance();
	}
	
	
	/**
	 * Set messages
	 * 
	 * @author CagunA
	 * @since 14 July 2011
	 *
	 * @param string $type
	 * @param string $message 
	 */
	public function set($type, $message) {
		$this->messages = $this->CI->session->flashdata('errors_and_messages');
		$this->messages[] = array('type' => $type, 'msg' => $message);
		
		$this->CI =& get_instance();
		$this->CI->session->set_flashdata('errors_and_messages', $this->messages);
	}
	
	
	/**
	 * Return messages
	 * 
	 * @author CagunA
	 * @since 14 July 2011
	 * 
	 * @return array   All types of errors, each type is array 
	 */
	public function get(){
		
		$messages = $this->CI->session->flashdata('errors_and_messages');
		$this->CI->session->set_flashdata('errors_and_messages');
		
		if(is_array($messages) && count($messages) > 0){
			foreach($messages as $message){
				if(in_array($message['type'], $this->message_types)){
					$return_messages[$message['type']][] = $message['msg'];
				}
			}

			return $return_messages;
		}else{
			return FALSE;
		}
		
	} 
}