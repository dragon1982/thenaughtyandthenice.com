<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Functii pentru filtrarea de perfrormeri
 * 
 * @author Baidoc
 * @package main
 */


// -------------------------------------------------------------------------
if ( ! function_exists('purify_filters'))
{
	/**
	 * Purifica filtrele, scoate din $_GET parametrii necunoscuti 
	 * @param $filters
	 * @return unknown_type
	 */
	function purify_filters($filters,$page = 'performers'){

		$CI = & get_instance();
		
		//markez filtrele ca find purificate, o sa verific ulterior in model
		$CI->is_purified = TRUE;
			
		//daca nu exista filtre in $_GET , construiesc un array gol cu filtre
		if( ! is_array($filters)){
			$filters = array();
			return;
		}
		$CI->load->config('filters');
				
		$accepted_filters = $CI->config->item('filters');
		$accepted_filters = $accepted_filters[$page];

		if(sizeof($filters) > 0){		
			foreach($filters as $filter => $value){
				
				//verific daca filtru e ok
				if( ! key_exists(strtolower($filter),$accepted_filters) ){					
					unset($filters[$filter]);
					continue;
				}
				
				if( is_array($value) && sizeof($value) == 0){ // e un array gol, il sterg			
					unset($filters[$filter]);				
					continue;
										
				} elseif( ! is_array($value) ){//e valoare nu e array trebuie sa o validez
					if( empty($value) ){
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
		return $filters;			
	}	
}

// -------------------------------------------------------------------------
if( ! function_exists('purify_orders') ){

	/**
	 * Purifica orderu
	 * @param $orders
	 * @param $page
	 * @return unknown_type
	 */
	function purify_orders($orders,$page = 'performers'){
		$orders = purify_filters($orders,$page);
		
		if( sizeof( $orders) == 0 ){
			return array();
		}
		
		foreach( $orders as $key => $order ){
			if( ! in_array($order,array('asc','desc') ) ){
				unset($orders[$key]);
			}
		}
		
		return $orders;
	}
}

// -------------------------------------------------------------------------
if( ! function_exists('implode_order') ){

	/**
	 * Creaza dintrun array string pentru a fi tirmis la model
	 * @param $order
	 * @return string
	 */
	function implode_order($order){
		if( sizeof($order) == 0 ){
			return '';
		}
		
		$current = current($order);
		
		return key($order) . ' ' . $current;
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