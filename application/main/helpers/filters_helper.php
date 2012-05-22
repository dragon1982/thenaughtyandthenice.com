<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Functii pentru filtrarea de perfrormeri
 * 
 * @author Baidoc
 * @package main
 */


/**
 * @TUTORIAL: 
 * 		'age' -> numele filtrului
 * 		lang(age) -> cum ar trebui gasit in Pagina - diferit de la limba la limba
 * 						-> acesta are optiuni lang('age_18_22') cum se gaseste in pagina, iar valoarea lui se gaseste in URL
 */

// -------------------------------------------------------------------------
if ( ! function_exists('purify_filters'))
{
	/**
	 * Purifica filtrele, scoate din $_GET parametrii necunoscuti 
	 * @param $filters
	 * @return unknown_type
	 */
	function purify_filters($filters){

		$CI = & get_instance();
		
		//markez filtrele ca find purificate, o sa verific ulterior in model
		$CI->is_purified = TRUE;
			
		//daca nu exista filtre in $_GET , construiesc un array gol cu filtre
		if( ! is_array($filters)){
			$filters = array();
			return;
		}
		
		
		$accepted_filters = $CI->config->item('filters');
		
		
		if(sizeof($filters) > 0){
			foreach($filters as $filter => $value){
				if($filter != 'price_range' && $filter != 'age_range' && $filter != 'nickname') {
					
					//verific daca filtru e ok
					if( ! isset($accepted_filters[$filter]) ){
						unset($filters[$filter]);
						continue;
					}
					
					if( is_array($value) && sizeof($value) == 0){ // e un array gol, il sterg			
						unset($filters[$filter]);				
						continue;
											
					} elseif( ! is_array($value) ){//e valoare nu e array trebuie sa o validez
	
						if( ! array_search($value,current($accepted_filters[$filter]))){
							unset($filters[$filter]);																					
						}
											
						continue;
					}
	
					//curat eventualii parametrii "bolnavi" 
					foreach($value as $current => $option){
						//caut valoarea
						if( ! array_search($option,current($accepted_filters[$filter]))){
							unset($filters[$filter][$current]);											
							continue;					
						}										
					}	
					
					//sterg filtru deoarece e gol nu mai are nici o valoare in el
					if(sizeof($filters[$filter]) == 0){
						unset($filters[$filter]);
					}
				}
			}		
		}
		
		return $filters;			
	}	
}

// -------------------------------------------------------------------------
if ( ! function_exists('initialize_filters')){
	
	/**
	 * Seteaza filtrele si orderby default pentru cazul dorit (eg. listare performeri online, listare favoriti etc)
	 * @param $filters (pointer) array - filtrele actuale
	 * @param $order_by (pointer) - order by
	 * @param $type string tipul de filtru ce trebuie preinitializat
	 * @return unknown_type
	 */
	function initialize_filters($filters,$order_by,$type = 'listing'){
		$CI = & get_instance();
		if( $CI->user->id > 0 ){
			$filters['user_id']			= $CI->user->id;
			$order_by['favorite_id']	= 'desc';
		}
		
		switch($type){			
			case 'listing':{
				$filters['is_in_private'] 	= 0;
				$order_by['is_online']		= 'desc';
				break;
			}
			case 'online-listing':{
				$filters['is_online'] 	= 1;
				$filters['is_in_private'] 	= 0;
				$order_by['is_online']		= 'desc';
				break;
				
			}
			case 'favorites':{
				$filters['favorite_id']		= TRUE;
				break;
			}
			case 'search':{
				$order_by['favorite_id']	= TRUE;
				break;
			}
		}
		
		
		return array('filters'=>add_country_filters($filters),'order_by'=>$order_by);
	}
}

// -------------------------------------------------------------------------
if( ! function_exists('generate_active_categories') ){
	
	/**
	 * Returneaza un array cu categoriile active
	 * @return array
	 */
	function generate_active_categories(){
		
		if( ! isset($_GET['filters'])){
			return array();
		}
						
		$filters = $_GET['filters'];
		if( ! isset($filters['category'])){
			return array();
		}
		$categories = $filters['category'];
		
		if(sizeof($categories) == 0){
			return array();
		}
		
		$return = array();
		foreach($categories as $category){
			$return[$category] = 1;
		}
		
		return $return;
	}
}


if ( ! function_exists('add_country_filters')){

	/**
	 * Adauga in filtre .. filtrare pe Tara si stat daca e cazul
	 * @param $filters
	 * @return unknown_type
	 */
	function add_country_filters($filters = array()){ 
		$CI = &get_instance();
		$CI->load->library('ip2location');

		$CI->load->config('regions');
		
		$state_list = $CI->config->item('states_v2');
		$ip_country = $CI->ip2location->getCountryShort($CI->input->ip_address());
		
		//daca am identificat tara o adaug in filtre
		if($ip_country){
			$filters['country_code'] = $ip_country;
			
			//daca e din US adaug si statul
			if($ip_country == 'US'){
				$state = $CI->ip2location->getRegion($CI->input->ip_address());
				if($state){		
					$state = ucfirst(strtolower($state));
					if(isset($state_list[$state])){						
						$filters['state_code'] = $state_list[$state];	
					}	
				}
			} 
		}
		return $filters;
		 
	}
}


if( ! function_exists('purify_video_type')){
	/**
	 *
	 * Enter description here ...
	 * @param unknown_type $video_type
	 * @return NULL|mixed
	 * @author Baidoc
	 */
	function purify_video_type($video_type){
		if( ! $video_type ){
			return NULL;
		}

		$acceped = array('free','paid');
		if( ! in_array($video_type,$acceped)){
			return NULL;
		}

		return array_search($video_type, $acceped);		
	}
}