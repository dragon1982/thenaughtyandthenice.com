<?php
// -------------------------------------------------------------------------

if ( ! function_exists('make_interval_time'))
{
	
	/**
	 * Creeaza un array cu intervale de data de 15 zile pana in ziua curenta
	 * @param integer $startTime
	 * @return array
	 */
	function make_interval_time($startTime = false){
	
		if( ! $startTime){
	    //no paydate was found
	    	return array();
		} else {
		//Start building the option list
	
		//check if the first date has the day lower than 16, if yes puttin in the options day 1
		if(date('d',$startTime) < 16){
			$actual = mktime(0, 0, 0, date('m',$startTime), 1, date('Y',$startTime));
		} else {//if day is bigger than 16 puttin the day 16
			$actual = mktime(0, 0, 0, date('m',$startTime), 16, date('Y',$startTime));
		}
		//Building the last day from options
		
		//check the system current day
		//if current day lower than 16, put it 1
		if(date('d',time()) < 16) {
			$target = mktime(0, 0, 0, date('m',time()), 16, date('Y',time()));
		} else {
			//bigger than 16 put it 16
			$target = mktime(0, 0, 0, (date('m',time())+1), 1, date('Y',time()));
		}
	
		//saving the values
		$current = $actual;
		$last = $actual;
	
		//until reaching the target adding 16 days to date
		while($current < $target) {
	
			//check if the current date is lower than 16
			if(date('d',$current) < 16){
			//if it is it means that we had the first day of the month, we put it now 16
				$current = mktime(0, 0, 0, date('m',$current), 16, date('Y',$current));
			} else {
			//the current day is 16, we incraese the month, and put the day to 1
				$current = mktime(0, 0, 0, date('m',$current)+1, 1, date('Y',$current));
			}
			//adding value into array
			$dateTime[date("Y-m-d", $last) .'~'. date("Y-m-d", $current)] = sprintf(lang('From %s to %s'),date('d M Y',$last),date('d M Y',$current));
			$last = $current;
			}
		}
		return $dateTime;
	}
}
