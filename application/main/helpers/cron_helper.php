<?php
// -------------------------------------------------------------------------
if( ! function_exists('get_first_day_of_interval')){
	
	/**
	 * Returneaza prima zii din interval 1 sau 16 
	 * @param unknown_type $time
	 * @author Baidoc
	 */
	function get_first_day_of_interval($time){
		if(date('j',$time) > 15){
			return mktime(0,0,0,date('m',$time),16,date('Y',$time));
		}
		
		return mktime(0,0,0,date('m',$time),1,date('Y',$time));
	}
}

// -------------------------------------------------------------------------
if( ! function_exists('get_last_day_of_interval')){

	/**
	 * Returneaza ultima zi din interval 16 sau X
	 * @param unknown_type $time
	 * @author Baidoc
	 */
	function get_last_day_of_interval($time){
		if(date('j',$time) < 16){
			return mktime(0,0,0,date('m',$time),1,date('Y',$time));
		}
		return mktime(0,0,0,date('m',$time),16,date('Y',$time));
	}
}