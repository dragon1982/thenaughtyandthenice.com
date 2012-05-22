<?php
// ---------------------------------------------------------------------------------
if( ! function_exists('language_init') ){
	
	/**
	 * Returneaza limbile functionale din system
	 * @return array
	 * @author Baidoc
	 */
	function language_init(){
		$CI = & get_instance();
		$langs = $CI->config->item('lang_avail');
	
		if(sizeof($langs) == 0) return;
	
		//create the language directories
		foreach($langs as $row => $lang){
	
			//put in an array
			$available_languages[] = $lang;
	
			if( is_dir('application/language/'.$lang)){
				continue;
			}
			mkdir('application/language/'.$lang,777);
	
		}
	
		return $available_languages;
	}
}

// ---------------------------------------------------------------------------------
if( ! function_exists('get_lang_array')){
	
	/**
	 * Returneaza arrayul cu tranzlatiile 
	 * @param unknown_type $input
	 * @return multitype:
	 * @author Baidoc
	 */
	function get_lang_array($input){
		global $trans;
		recurse_output($input);
		$translations = $trans;
		$translations = array_merge($translations,get_admin_settings());
		return array_merge($translations,get_table_enums());				
	}
}

// ---------------------------------------------------------------------------------
if( ! function_exists('recurse_output') ){
	/**
	 * Searches within directories for language texts
	 * @param $input
	 * @param $level
	 * @param $current
	 * @return unknown_type
	 */
	function recurse_output($input, $level = 0,$current = '/') {
		global $trans;
		
		foreach($input as $key => $value) {
			if(is_array($value)){	
				recurse_output($value, $level + 1,$current.$key.'/');
			}
			else
			{
				if( filesize('application/' . $current.$value) > 126056809 ){
					continue;
				}
				$content = file_get_contents('application/' . $current.$value);
				if(preg_match_all("/lang\(\'(.*?)\'\)/",$content,$matches)){
					foreach($matches[1] as $key){
						if( sizeof(lang($key)) > 0){
							$trans[$key] = 1;
						} else {
							$trans[$key] = 0;
						}
					}
				}
			}
		}		
	}
}


// ---------------------------------------------------------------------------------
if( ! function_exists('generate_translations_string') ){

	/**
	* Generates the language translation string
	* @return unknown_type
	*/
	function generate_translations_string($translation_array = array(),$replacements = FALSE){

		$translations = "<?php" . PHP_EOL;
		
		if( sizeof($translation_array) == 0) {
			return;
		}
			
		$writed_translations = array();
		foreach($translation_array as $key => $value){
			$key = check_string($key);
									
			if( isset($writed_translations[strtolower($key)]) ){
				continue;
			}

			$writed_translations[strtolower($key)] = 1;
			
			if( $value == 1){								
				$trans = preg_replace("/(?<!\\\)\'/",'\\\'',lang($key));
				
				$translations .= '$lang[\''. strtolower($key) .'\'] = \'' . replace_lang_date($trans,$replacements) . '\';'. PHP_EOL;
				
			} else {				
				$translations .= '$lang[\''. strtolower($key) .'\'] = \'' . replace_lang_date($key,$replacements) . '\';'. PHP_EOL;
			}
				
		}
		
		return $translations;
	}
}

// ---------------------------------------------------------------------------------
if( ! function_exists('replace_lang_data')){
	/**
	 * Inlocuieste in lang cuvintele keie gen chips/credits
	 * @param unknown_type $lang
	 * @param unknown_type $replace
	 * @return unknown
	 * @author Baidoc
	 */
	function replace_lang_date($lang,$replace){
		
		if( ! $replace ){
			return $lang;
		}
		
		$lang = preg_replace("/(?<![a-zA-Z])(chips)(?!a-zA-Z)/i",$replace,$lang);
		$lang = preg_replace("/(?<![a-zA-Z])(credits)(?!a-zA-Z)/i",$replace,$lang);
		
		return $lang;
		
	}
}

// ---------------------------------------------------------------------------------
if( ! function_exists('check_string') ){
	
	/**
	 * Protejeaza langu de evenimente nedorite
	 * @param unknown_type $string
	 * @return string
	 * @author Baidoc
	 */
	function check_string($string = ''){
		return $string;
		if( ! @eval($string)){
			$string = addslashes(stripslashes($string));
		}
		
		if( $string != @eval($string) ){
			$string = addslashes(stripslashes($string));
		}
				
		return $string;
	}	
}

// ---------------------------------------------------------------------------------
if( ! function_exists('populate_langs') ){
	/**
	*
	* @param $langs
	* @param $translations
	* @return unknown_type
	*/
	function populate_langs($langs,$translations,$replacements = FALSE ){
		if( sizeof ( $langs ) == 0 )  return;
	
		$CI = & get_instance();
		
		foreach($langs as $lang){
			$CI->load->language('general',$lang);
			$my_transalations = generate_translations_string($translations,$replacements);
			write_translations($lang,$my_transalations);
		}
	}
}

// ---------------------------------------------------------------------------------
if( ! function_exists('write_translations') ){
	/**
	* Write the translation string for a specific language
	* @param $lang
	* @param $translations
	* @return unknown_type
	*/
	function write_translations($lang,$translations){
		$CI = & get_instance();
		
		$CI->load->helper('file');

		write_file('application/language/'.$lang.'/general_lang.php',$translations);
			
	}
}

// ---------------------------------------------------------------------------------
if( ! function_exists('get_table_enums') ){
	
	/**
	* Ia si introduce in lang toate enumurile din tabelele date in array-ul tables din interiorul functiei
	* @return unknown_type
	*/
	function get_table_enums() {
		
		$CI = & get_instance();
		
		$tables = array('performers' , 'performers_profile','watchers');
	
		foreach($tables as $table) {
	
			$columns = $CI->db->query('SHOW COLUMNS FROM ' . $table)->result();
	
			foreach($columns as $column) {
				if(substr($column->Type,0,4) == 'enum')
	
				preg_match_all("{'([^'']*)'}si",$column->Type, $enum_array);
	
				if( ! empty($enum_array)) {
					foreach($enum_array[1] as $enum) {
						if( sizeof(lang($enum)) > 0){
							$translations[$enum] = 1;
						} else {
							$translations[$enum] = 0;
						}
					}
				}
			}
		}
		return $translations;
	}
}

// ---------------------------------------------------------------------------------
if( ! function_exists('get_admin_settings') ){
	
	/**
	 * Genereaza langu pt admin
	 * @author Baidoc
	 */
	function get_admin_settings(){
		
		$CI = &get_instance();
		
		$settings = $CI->db->get('settings')->result();
		
		$translations = array(); 
		
		foreach( $settings as $setting ){

			if( sizeof(lang($setting->title)) > 0){
				$translations[$setting->title] = 1;
			} else {
				$translations[$setting->title] = 0;
			}
			
		}
		
		return $translations;
	}
}