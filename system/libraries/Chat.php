<?php

class Chat extends CI_Model{

	private $table = 'messages';
	private $id;
	private $type;
	
	function __construct($id, $type){
		$this->id = $id;
		$this->type = $type;
		if(!isset($_SESSION)) session_start();
	}
	
	function __destruct() {
		if (!isset($_SESSION['chatHistory'])) {
			$_SESSION['chatHistory'] = array();
		}
		
		if (!isset($_SESSION['openChatBoxes'])) {
			$_SESSION['openChatBoxes'] = array();
		}
	}
	
	function heartbeat() {
		
		$results = $this->db->where('to_id',$this->id)->where('to_type',$this->type)->where('readed_by_recipient',0)->order_by('id')->get($this->table)->result_array();
		$items = '';

		$chatBoxes = array();

		foreach($results as $chat) {
			$result = $this->db->where('id',$chat['from_id'])->get($chat['from_type'].'s')->row();
			$label = $chat['from_id'].'_'.$chat['from_type'];

			if (!isset($_SESSION['openChatBoxes'][$label]) && isset($_SESSION['chatHistory'][$label])) {
				$items = $_SESSION['chatHistory'][$label];
			}

			$chat['body'] = $this->sanitize($chat['body']);

			$items .= <<<EOD
						   {
				"s": "0",
				"f": "{$label}",
				"m": "{$chat['body']}"
		   },
EOD;

		if (!isset($_SESSION['chatHistory'][$label])) {
			$_SESSION['chatHistory'][$label] = '';
		}

		$_SESSION['chatHistory'][$label] .= <<<EOD
							   {
				"s": "0",
				"f": "{$label}",
				"m": "{$chat['body']}"
		   },
EOD;

			unset($_SESSION['tsChatBoxes'][$label]);
			$_SESSION['openChatBoxes'][$label] = date('Y-m-d H:i:s',$chat['date']);
		}

		if (!empty($_SESSION['openChatBoxes'])) {
		foreach ($_SESSION['openChatBoxes'] as $chatbox => $time) {
			if (!isset($_SESSION['tsChatBoxes'][$chatbox])) {
				$now = time()-strtotime($time);
				$time = date('g:iA M dS', strtotime($time));

				$message = "Sent at $time";
				if ($now > 180) {
					$items .= <<<EOD
	{
	"s": "2",
	"f": "$chatbox",
	"m": "{$message}"
	},
EOD;

		if (!isset($_SESSION['chatHistory'][$chatbox])) {
			$_SESSION['chatHistory'][$chatbox] = '';
		}

		$_SESSION['chatHistory'][$chatbox] .= <<<EOD
			{
	"s": "2",
	"f": "$chatbox",
	"m": "{$message}"
	},
EOD;
				$_SESSION['tsChatBoxes'][$chatbox] = 1;
			}
			}
		}
	}
	
		$this->db->where('to_id',$this->id)->where('to_type',$this->type)->where('readed_by_recipient',0)->update($this->table, array('readed_by_recipient'=>1)); 
		
		if ($items != '') {
			$items = substr($items, 0, -1);
		}
	header('Content-type: application/json');
	?>
	{
			"items": [
				<?php echo $items;?>
	        ]
	}

	<?php
				exit(0);
	}

	function boxSession($chatbox) {

		$items = '';

		if (isset($_SESSION['chatHistory'][$chatbox])) {
			$items = $_SESSION['chatHistory'][$chatbox];
		}

		return $items;
	}

	function startSession() {
		$items = '';
		if (!empty($_SESSION['openChatBoxes'])) {
			foreach ($_SESSION['openChatBoxes'] as $chatbox => $void) {
				$items .= $this->boxSession($chatbox);
			}
		}


		if ($items != '') {
			$items = substr($items, 0, -1);
		}

	header('Content-type: application/json');
	?>
	{
			"username": "<?php echo $this->id.'_'.$this->type; ?>",
			"items": [
				<?php echo $items;?>
	        ]
	}

	<?php


		exit(0);
	}

	function send($to_id, $to_type, $message = null, $subject = 'Chat message') {
		$label = $to_id.'_'.$to_type;
		$from = $this->id.'_'.$this->type;
		$_SESSION['openChatBoxes'][$label] = date('Y-m-d H:i:s', time());

		$messagesan = $this->sanitize($message);

		if (!isset($_SESSION['chatHistory'][$label])) {
			$_SESSION['chatHistory'][$label] = '';
		}

		$_SESSION['chatHistory'][$label] .= <<<EOD
						   {
				"s": "1",
				"f": "{$label}",
				"m": "{$messagesan}"
		   },
EOD;


		unset($_SESSION['tsChatBoxes'][$label]);

		$data = array(
		   'from_id'	=> $this->id,
		   'from_type'	=> $this->type,
		   'to_id'		=> $to_id,
		   'to_type'	=> $to_type,
		   'subject'    => $subject,
		   'body'       => $message,
		   'date'		=> time()
		);

		$this->db->insert($this->table, $data);

		echo "1";
		exit(0);
	}

	function close() {
		$chatbox = $this->id.'_'.$this->type;
		unset($_SESSION['openChatBoxes'][chatbox]);

		echo "1";
		exit(0);
	}

	function sanitize($text) {
		$text = htmlspecialchars($text, ENT_QUOTES);
		$text = str_replace("\n\r","\n",$text);
		$text = str_replace("\r\n","\n",$text);
		$text = str_replace("\n","<br>",$text);
		return $text;
	}
	
	  public function __call($method, $args) {
	    $attribute = strtolower(substr($method, 3));
	    if(strstr($method,'get') == $method) return $this->$attribute;
	    else return null;
	  }

}