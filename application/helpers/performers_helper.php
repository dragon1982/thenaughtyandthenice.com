<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Functii generale folosite de catre aplicatie
 * 
 * @author Baidoc
 * @package main
 */


// -------------------------------------------------------------------------

if ( ! function_exists('get_performer_languages'))
{
	/**
	 * Returneaza lista cu limbile vorbite de catre perforer
	 * @param $stack
	 * @return array
	 */
	function get_performer_languages($stack) {
		$langs = array();
		foreach($stack as $s){
			if( ! in_array($s->language_code,$langs)){
				array_push($langs,$s->language_code);
			}
		}
		return $langs;
	}
}

if ( ! function_exists('get_performer_photos')){
	/**
	 * Returneaza fotografiile uploadate de performer
	 * @param $stack
	 * @param $is_paid - filtru pe tip de poze paid/unpaid
	 * @param $key - in ce keie se afla valoarea is_paid, pe main pentru a nu fi confundate is_paid de la video si photo e photo_is_paid
	 * @return array de obiecte
	 */
	function get_performer_photos($stack,$is_paid = FALSE ,$key = 'is_paid') {
		
		$photos	= array();
		$unique_photos	= array();
		
		if(sizeof($stack) == 0){
			return $unique_photos;
		}		
		
		foreach($stack as $s){
			if( ! in_array($s->photo_id,$unique_photos) && $s->name_on_disk && $s->$key == $is_paid){
				$photo					= new stdClass();
				$photo->title			= $s->title;
				$photo->name_on_disk	= $s->name_on_disk;
				$photo->photo_id		= $s->photo_id;
				if(isset($s->main_photo)){
					$photo->main_photo = $s->main_photo;
				}
				
				array_push($photos, $photo);
				array_push($unique_photos, $s->photo_id);
			}
		}
		return $photos;
	}
}

if ( ! function_exists('get_performer_videos')){
	
	/**
	 * retruneaza videourile uploadate de performer
	 * @param $stack
	 * @return array
	 */
	function get_performer_videos($stack,$is_paid = FALSE , $key  = 'is_paid') {
		$videos = array();
		$unique_videos = array();
		
		$CI = &get_instance();
		
		if(sizeof($stack) == 0){
			return $unique_videos;
		}
				
		foreach($stack as $s) {
			if( ! in_array($s->video_id,$unique_videos) && $s->flv_file_name && $s->$key == $is_paid) {
				$video					= new stdClass();
				$video->flv_file_name	= $s->flv_file_name;
				$video->video_id		= $s->video_id;
				$video->description		= $s->description;
				$video->length			= $s->length;
				$video->fms_for_preview	= $CI->fms_list[$s->fms_id]->fms_for_preview;
				$video->is_paid			= $s->is_paid;
				$video->price			= $s->price;
				array_push($videos, $video);
				array_push($unique_videos, $s->video_id);				
			}
		}
		return $videos;
	}
}

if ( ! function_exists('get_performer_categories')){
	/**
	 * retruneaza categoriile alese de performer
	 * @param $stack
	 * @return array
	 */
	function get_performer_categories($stack) {
		$categories = array();
		$unique_categories = array();
		
		foreach($stack as $s) {
			if( ! in_array($s->performers_categories_id,$unique_categories) && $s->category_id) {
				$categoy								= new stdClass();
				$categoy->performers_categories_id		= $s->performers_categories_id;
				$categoy->category_id					= $s->category_id;
				array_push($categories, $categoy);
				array_push($unique_categories, $s->video_id);				
			}
		}
		return $categories;
	}
	
}

