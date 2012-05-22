<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Functii generale folosite de catre aplicatie
 * 
 * @author Baidoc
 * @package main
 */

// -------------------------------------------------------------------------
if ( ! function_exists('bits_size')) {
	
	/**
	 * Returns the size
	 * @param $bytes
	 * @return unknown_type
	 */
	function bits_size($bits) 
	{
		$bytes = $bits / 8;
		$size = $bytes / 1024;
		if($size < 1024)
		{
			$size = number_format($size, 2);
			$size .= ' KB';
		} 
		else 
		{
			if($size / 1024 < 1024) 
			{
				$size = number_format($size / 1024, 2);
				$size .= ' MB';
			} 
			else if ($size / 1024 / 1024 < 1024)  
			{
				$size = number_format($size / 1024 / 1024, 2);
				$size .= ' GB';
			} 
		}
		return $size;
	} 
}
// -------------------------------------------------------------------------

if ( ! function_exists('generate_hash'))
{
	/**
	 * Genereaza un hash random pentru user
	 * @param $type -> tabela in care sa verifice daca hashul e unic
	 * @return unknown_type
	 */ 
	function generate_hash($type = 'users'){
		$CI = &get_instance();
		$CI->load->model($type);
	
		do{
			$hash = sha1(uniqid(mt_rand(),TRUE));
			$exists = $CI->$type->get_one_by_hash($hash);
		}
		while($exists);
	
		return $hash;
	}		
}

// -------------------------------------------------------------------------
if( ! function_exists('check_chmod')){
	
	/**
	 * Verifica daca un director/fisier are sau nu 0777
	 * @param unknown_type $file
	 * @return boolean
	 * @author Baidoc
	 */
	function check_chmod($file){
		if(@substr(sprintf('%o', fileperms($file)), -4) !== '0777'){
			return FALSE;
		}
		
		return TRUE;
	}
}

// -------------------------------------------------------------------------
if ( ! function_exists('generate_token'))
{
	/**
	 * Genereaza un hash random pentru user
	 * @param $type -> tabela in care sa verifice daca hashul e unic
	 * @return unknown_type
	 */ 
	function generate_token($type = 'affiliates'){
		$CI = &get_instance();
		$CI->load->model($type);
	
		do{
			$token = substr(sha1(uniqid(mt_rand(),TRUE)), 0, 5);
			$exists = $CI->$type->get_one_by_token($token);
		}
		while($exists);
	
		return $token;
	}		
}

// -------------------------------------------------------------------------
if ( ! function_exists('assets_url'))
{
	function assets_url($theme = FALSE)
	{
		$CI =& get_instance();
		
		//if theme is not set in controller
		if($theme === FALSE){
			//set from cookie
			$theme = get_cookie('theme').'/';
		}
		
		
		//if theme not set from controller and cookie , set from settings
		if($theme === FALSE || $theme == '/'){
			
			//if is defined theme in settings use it , else leave empty and no use theme
			if(defined('SETTINGS_DEFAULT_THEME')){
				$theme = SETTINGS_DEFAULT_THEME.'/';
			}else{
				$theme = '';
			}
		}

		return  str_replace(IGNORE_URI.'/','',$CI->config->slash_item('base_url')).'assets/'.$theme;
	}
}


// -------------------------------------------------------------------------
if ( ! function_exists('main_url'))
{	
	/**
	 * Returneaza calea catre urul de baza a aplicatiei main
	 * @param $url
	 * @return string
	 */
	function main_url($url = '')
	{
		$CI =& get_instance();
		
		$current_url = $CI->config->item('base_url');
				
		$main_url = str_replace(WEB_URL.IGNORE_URI,(substr(WEB_URL,0,1) === '/')?substr(WEB_URL,0,-1):WEB_URL,$current_url);
		
 		return $main_url . $url; 			
 	}
}

// -------------------------------------------------------------------------
if ( ! function_exists('sec2hms'))
{
	
	/**
	 * Transforma secundele in h:m:s
	 * @param $sec
	 * @param $padHours
	 * @return string
	 */
	function sec2hms ($sec, $padHours = false) {	
		// start with a blank string
		$hms = "";
		    
		// do the hours first: there are 3600 seconds in an hour, so if we divide
		// the total number of seconds by 3600 and throw away the remainder, we're
		// left with the number of hours in those seconds
		$hours = intval(intval($sec) / 3600); 
		
		//add hours to $hms (with a leading 0 if asked for)
		$hms .= ($padHours) 
		        ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
		        : $hours. ":";
		    
		// dividing the total seconds by 60 will give us the number of minutes
		// in total, but we're interested in *minutes past the hour* and to get
		// this, we have to divide by 60 again and then use the remainder
		$minutes = intval(($sec / 60) % 60); 
		
		// add minutes to $hms (with a leading 0 if needed)
		$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";
		
		// seconds past the minute are found by dividing the total number of seconds
		// by 60 and using the remainder
		$seconds = intval($sec % 60); 
		
		// add seconds to $hms (with a leading 0 if needed)
		$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
		
		// done!
		return $hms;
	}
}


// -------------------------------------------------------------------------
if ( ! function_exists('prepare_dropdown'))
{
	/**
	 * Pregateste un array pentru a fii afisat ca dropdown 
	 * @param $array - un array cu valori .. care le va face unice
	 * @param $empty_item - daca vrem sa adaugam o valoare default noua in array.. ex( Choose gender)
     * @param $use_key - daca sa foloseasca ca keie , keia primita din array sau valoarea
	 * @return $array
	 */
	function prepare_dropdown($array, $empty_item = FALSE, $use_key = FALSE, $convert_to_lang = FALSE) {
				
		$new_array = array();
		
		if($empty_item){
			$new_array['']	= $empty_item;	
		}
		foreach ($array as $key => $value) {
	   		$new_array[($use_key)?$key:$value] = ($convert_to_lang)?lang($value):$value;
		}
		return $new_array;
	}
}


// -------------------------------------------------------------------------
if ( ! function_exists('prepare_dropdown_objects'))
{
	/**
	 * Pregateste un array pentru a fii afisat ca dropdown
	 * @param $array - un array cu valori .. care le va face unice
	 * @param $empty_item - daca vrem sa adaugam o valoare default noua in array.. ex( Choose gender)
	 * @param $use_key - daca sa foloseasca ca keie , keia primita din array sau valoarea
	 * @return $array
	 */
	function prepare_dropdown_objects($array, $empty_item = FALSE, $use_key = FALSE, $convert_to_lang = FALSE) {

		$new_array = array();

		if($empty_item){
			$new_array['']	= $empty_item;
		}
		foreach ($array as $key => $value) {

			$new_array[$value->id] = ($convert_to_lang)?lang($value->$use_key):$value->$use_key;
		}
		return $new_array;
	}
}

// -------------------------------------------------------------------------
if ( ! function_exists('prepare_objects'))
{

	/**
	 * Creeaza obiect pe baza de keie
	 * @param unknown_type $array
	 * @param unknown_type $key
	 * @author Baidoc
	 */
	function prepare_objects($array,$key = 'id'){
		
		if(sizeof($array) == 0){
			return array();
		}
		
		$result = array();
		
		foreach( $array as $item ){
			$result[$item->$key]	 = $item;
		}
		
		return $result;		
	}
}
// -------------------------------------------------------------------------
if ( ! function_exists('prepare_search_dropdown'))
{
	/**
	 * Pregateste un array pentru a fii afisat ca dropdown 
	 * @param $array - un array cu valori .. care le va face unice
	 * @param $empty_item - daca vrem sa adaugam o valoare default noua in array.. ex( Choose gender)
     * @param $use_key - daca sa foloseasca ca keie , keia primita din array sau valoarea
	 * @return $array
	 */
	function prepare_search_dropdown($array, $empty_item = FALSE, $use_key = FALSE) {
				
		$new_array = array();
		
		if($empty_item){
			$new_array['']	= $empty_item;	
		}
		foreach ($array as $key => $value) {
	   		$new_array[($use_key)?$key:$value] = $key;
		}
		return $new_array;
	}
}


if ( ! function_exists('prepare_search_options'))
{
	/**
	 * 
	 * @return unknown_type
	 */
	function prepare_search_options() {
		
		$CI =& get_instance();
		$CI->load->config('filters');
		$filters = $CI->config->item('filters');
		foreach($filters as $key => $value) {
			$data[$key] = prepare_search_dropdown($value[lang($key)], lang(str_replace('_', ' ', ucfirst($key))));
		}
		return $data;
	}
}


// -------------------------------------------------------------------------
if ( ! function_exists('prepare_payment_dropdown'))
{
	/**
	 * Returneaza un array pentru dropdown-ul cu metodele de plata valabile
	 * @return $array
	 */
	function prepare_payment_dropdown()
	{
		$CI = & get_instance();
		$CI->load->model('payment_methods');
		
		$methods = $CI->payment_methods->get_all_approved();
		
		if(empty($methods)) return array('' => lang('No payment methods available'));
		
		$available_methods = array('' => lang('Choose payment method'));
		foreach($methods as $method) {
			$available_methods[$method->id] = $method->name;
		}
		
		return $available_methods;
	}
}

// -------------------------------------------------------------------------
if( ! function_exists('prepare_payment_list')){	
	/**
	 *
	 * @param unknown_type $data
	 * @author Baidoc
	 */
	function prepare_payment_list($data){
		$result = array();
		$result[NULL]	= lang('all');
		if(sizeof($data) > 0){
			foreach($data as $key => $row){				
				$result[$key] = sprintf(lang('From %s to %s'),date('d M Y',$row->from_date),date('d M Y',$row->to_date));
			}
		}
		return $result;
	}	
}

// -------------------------------------------------------------------------
if ( ! function_exists('extract_value_by_property'))
{
	/**
	 * Creaza un array cu valori unice ale $property dintrun array de obiecte 
	 * @param $haystack - Array de obiecte
	 * @param $property - obiectul ce vrem sa fie returnat
	 * @return array
	 */
	function extract_values_by_property($haystack,$property)
	{
		if( ! is_array($haystack) || sizeof($haystack) == 0){
			return array();
		}	
		
		$return = array();
		foreach($haystack as $row){
			//daca nu exista proprietatea in obiectul curent
			if( ! isset($row->$property) ) continue;
			
			array_push($return,$row->$property);
		}
		
		return array_unique($return);
	}
}

// -------------------------------------------------------------------------
if( ! function_exists('get_fine_name_without_ext') ){
	/**
	 * Returns a file name
	 * @param unknown_type $filename
	 * @return unknown|string
	 * @author Baidoc
	 */
	function get_fine_name_without_ext($filename){
		$pos = strripos($filename, '.');
		if($pos === false){
			return $filename;
		}else{
			return substr($filename, 0, $pos);
		}
	}
}

// -------------------------------------------------------------------------
if ( ! function_exists('create_array_by_property'))
{
	/**
	 * Creaza un array de obiecte care are ca si cheie category_id-ul array-ului de obiecte primit ca si parametru
	 * @param $object_array - Array de obiecte
         * @param $property - proprietatea dupa care cream noul array
	 * @return array
	 */
	function create_array_by_property($object_array, $property )
	{
		
		$return = array();
		foreach($object_array as $object){
			//daca nu exista proprietatea in obiectul curent
			if( ! isset($object->$property) ) continue;
			$return[$object->$property] = $object;
			
		}
		
		return $return;
	}
}

if ( ! function_exists('implode_string')){
	// -----------------------------------------------------------------------------------------	
	/**
	 * Genereaza dintrun array un url-string
	 * @param $params
	 * @return string
	 */
	function implode_string( $params ){
		$result = '';
		$i = 0;
		foreach( $params as $key=>$value ){
			if( $i == 0 ){
				$result = $key . '=' . $value;
			} else {
				$result .= '&' . $key . '=' . $value;
			}
			$i++;
		}
		return $result;
	}
}

// -------------------------------------------------------------------------
if( ! function_exists('sum_union_counts')){
	
	/**
	 * Face suma unor counturi din DB
	 * @param unknown_type $results
	 * @param unknown_type $key
	 * @return number
	 * @author Baidoc
	 */
	function sum_union_counts($results,$key = 'number'){
		$totals = 0;
		if( sizeof($results) == 0){
			return $totals;
		}
		foreach($results as $result){
			$totals += $result->$key;
		}		
		return $totals;
	}
}

// -------------------------------------------------------------------------
if( ! function_exists('watch_video') ){
	
	/**
	 * Returneaza ce metoda javascript trebuie apelata la click pe video
	 * @param unknown_type $user
	 * @param unknown_type $video
	 * @author Baidoc
	 * @return string
	 */
	function watch_video($user,$video){
		
		if( ! $video->is_paid ){
			return 'previewOpenVideoInModal';
		}
		
		if( $user->id == -1 ){
			return 'register';			
		}
		
		if( $video->has_paid ){
			return 'previewOpenVideoInModal';
		}
		
		return 'pay_video';				
	}
}

// -------------------------------------------------------------------------
if( ! function_exists('mark_paid_videos') ){

	/**
	 * Markeaza videou ca paid
	 * @param unknown_type $video_list
	 * @param unknown_type $brought_videos
	 * @author Baidoc
	 */
	function mark_paid_videos(& $video_list, $brought_videos ){
		
		$brought_list = array();
		if(sizeof($brought_videos) > 0){
			
			//construiesc lista
			foreach($brought_videos as $video){
				$brought_list[$video->performer_video_id] = 1;
			}
		}
		
		foreach ($video_list as $key=>$value){
			if( isset( $brought_list[$value->video_id] ) ){
				$video_list[$key]->has_paid = 1;
			} else {
				$video_list[$key]->has_paid = 0;
			}
		}
	}
}
// -------------------------------------------------------------------------

if ( ! function_exists('get_promo_ads_types'))
{
	
	/**
	 * Creeaza un array cu toate tipurile de reclame disponibile pentru affiliate
	 * Cheia reprezinta dimensiuna bannerului si numarul de performeri afisati
	 * @return array
	 */
	function get_promo_ads_types(){
		$promo_ads = array(
			'728x90/8'	=> 'Leaderboard (728 x 90)',
			'468x60/7'	=> 'Banner (468 x 60)',
			'125x125/1'	=> 'Button (125x125)',
			'234x60/3'	=> 'Half Banner (234x60) ',
			'120x600/5'	=> 'Skyscraper (120x600)',
			'160x600/4'	=> 'Wide Skyscraper (160x600)',
			'180x150/1'	=> 'Small Rectangle (180x150)',
			'120x240/2'	=> 'Vertical Banner (120 x 240)',
			'200x200/4'	=> 'Small Square (200 x 200)',
			'250x250/4'	=> 'Square (250 x 250)',
			'300x250/1'	=> 'Medium Rectangle (300 x 250)',
			'336x280/1'	=> 'Large Rectangle (336 x 280)'
		);
		
		return $promo_ads;
	
	}
}

// -------------------------------------------------------------------------
if ( ! function_exists('get_promo_link_otions'))
{
	
	/**
	 * Locatia lincului din reclamele afiiliatilor
	 * 0 - Profile
	 * 1 - Home page
	 * 2 - Free chat cu o tarfa care e in free.
	 * 
	 * @return array
	 */
	function get_promo_link_otions(){
		$promo_links = array('Profile', 'Home page', 'Free chat');
		
		return $promo_links;
	
	}
}

// -------------------------------------------------------------------------
if( ! function_exists('write_log') ){
	
	/**
	 * Scrie in log
	 * @param unknown_type $path
	 * @param unknown_type $log
	 * @author Baidoc
	 */
	function write_log($path,$log){
		$file = @fopen(APPPATH. 'logs/'. $path, 'a');
		
		if( ! $file ){
			return FALSE;
		}
		
		fwrite($file,$log.PHP_EOL);
		
		fclose($file);
		
		exit;		
	}
}

