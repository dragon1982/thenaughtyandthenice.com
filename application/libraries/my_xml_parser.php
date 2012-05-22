<?php
class MY_XML_Parser{
	protected $insideitem = false;
	protected $res = NULL;

	function __construct(){
		$this->res = NULL;
		$this->CI = &get_instance();			
	}
	
	function startElement($parser, $name, $attrs) {
		if ($this->insideitem) {
			$this->tag = $name;
		} else {			
			$this->tag = $name;
			$this->insideitem = TRUE;
		}
		if(is_array($attrs) && sizeof($attrs) > 0){	
			$this->res[$this->tag .'_'. key($attrs)]=$attrs[key($attrs)];
			
		}
	}

	function endElement($parser, $name) {
		if($name){
			$this->insideitem = FALSE;
		}
	}

	function characterData($parser, $data) {
			$data = trim($data);
			if($this->insideitem && (!empty($data) || $data == '0')){
				if(isset($this->res[$this->tag])){
					//TODO:alert error;	
				}else{				
					$this->res[$this->tag]=$data;
				}	
			}
	}
	
	function parse($xml){
		unset($this->res);
		$this->res = NULL;
		$xml_parser = xml_parser_create();
		xml_set_element_handler($xml_parser, array($this,"startElement"),array($this, "endElement"));
		xml_set_character_data_handler($xml_parser,array($this, "characterData"));		


		xml_parse($xml_parser, $xml) or die(sprintf("XML error: %s at line %d",
		xml_error_string(xml_get_error_code($xml_parser)),
		xml_get_current_line_number($xml_parser)));

		xml_parser_free($xml_parser);		
		
		return $this->res;
	}
		
	function __destruct(){
		$this->res = NULL;
		$this->insideitem = NULL;
	}
	
}