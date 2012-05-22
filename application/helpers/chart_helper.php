<?php

if ( ! function_exists('performer_generate_watchers_chart_data')){
		/**
	 * genereaza date pentru grafic, pentru ultimele 30/31 zile
	 * @param array $watchers
	 * @param mixed $dates_to_show
	 * @return array
	 * 
	 * Avaiable dates
	 * <br/>
	 * $dates_to_show = false //default to show all data<br/>
	 * 
	 *  OR 
	 * 
	 * $dates_to_show = array(<br/>
				'duration',<br/>
				'watchers',<br/>
				'total_earnings',<br/>
				'video_earnings',<br/>
				'gift_earnings',<br/>
				'photos_earnings',<br/>
				'private_earnings',<br/>
				'true_private_earnings',<br/>
				'peeck_earnings',<br/>
				'nude_earnings',<br/>
				'private',<br/>
				'true_private',<br/>
				'peek',<br/>
				'nude',<br/>
				'free',<br/>
				'premium_video',<br/>
				'photos',<br/>
				'gift',<br/>
				'admin_action',<br/>
				'spy'<br/>
	 * );
	 * 
	 */
	function performer_generate_watchers_chart_data($watchers, $dates_to_show = false){
		$return = array();
		$chart_data = '';
		$chart = array();
		if(is_array($watchers) && count($watchers) > 0){
			foreach($watchers as $watcher){
				$start_date = strtotime(date('Y-m-d 00:00:00', $watcher->start_date));
				$end_date = strtotime('+ 1 day', $start_date);
				//set duration
				if(!isset($chart['duration'][$start_date])){
					$chart['duration'][$start_date] = $watcher->duration;
				}else{
					$chart['duration'][$start_date] = $chart['duration'][$start_date] + $watcher->duration;
				}
				
				//set watchers
				if(!isset($chart['watchers'][$start_date])){
					$chart['watchers'][$start_date] = 1;
				}else{
					$chart['watchers'][$start_date]++;
				}
				
				//set sessions type
				if($watcher->type != 'spy' && $watcher->type != 'admin_action'){
					if(!isset($chart[$watcher->type][$start_date])){
						$chart[$watcher->type][$start_date] = 1;
					}else{
						$chart[$watcher->type][$start_date]++;
					}
				}
				
				//set earnings
				if(!isset($chart['total_earnings'][$start_date])){
					$chart['total_earnings'][$start_date] = $watcher->performer_chips;
				}else{
					$chart['total_earnings'][$start_date] = $chart['total_earnings'][$start_date] + $watcher->performer_chips;
				}
				
				
				if($watcher->type == 'premium_video'){
					//set video earnings
					if(!isset($chart['video_earnings'][$start_date])){
						$chart['video_earnings'][$start_date] =  $watcher->performer_chips;
					}else{
						$chart['video_earnings'][$start_date] = $chart['video_earnings'][$start_date] + $watcher->performer_chips;
					}
				}elseif($watcher->type == 'gift'){
					//set gift earnings
					if(!isset($chart['gift_earnings'][$start_date])){
						$chart['gift_earnings'][$start_date] =  $watcher->performer_chips;
					}else{
						$chart['gift_earnings'][$start_date] = $chart['gift_earnings'][$start_date] + $watcher->performer_chips;
					}
				}elseif($watcher->type == 'photos'){
					//set gift earnings
					if(!isset($chart['photos_earnings'][$start_date])){
						$chart['photos_earnings'][$start_date] =  $watcher->performer_chips;
					}else{
						$chart['photos_earnings'][$start_date] = $chart['photos_earnings'][$start_date] + $watcher->performer_chips;
					}
				}elseif($watcher->type == 'private'){
					//set gift earnings
					if(!isset($chart['private_earnings'][$start_date])){
						$chart['private_earnings'][$start_date] =  $watcher->performer_chips;
					}else{
						$chart['private_earnings'][$start_date] = $chart['private_earnings'][$start_date] + $watcher->performer_chips;
					}
				}elseif($watcher->type == 'true_private'){
					//set gift earnings
					if(!isset($chart['true_private_earnings'][$start_date])){
						$chart['true_private_earnings'][$start_date] =  $watcher->performer_chips;
					}else{
						$chart['true_private_earnings'][$start_date] = $chart['true_private_earnings'][$start_date] + $watcher->performer_chips;
					}
				}elseif($watcher->type == 'peek'){
					//set gift earnings
					if(!isset($chart['peeck_earnings'][$start_date])){
						$chart['peeck_earnings'][$start_date] =  $watcher->performer_chips;
					}else{
						$chart['peeck_earnings'][$start_date] = $chart['peeck_earnings'][$start_date] + $watcher->performer_chips;
					}
				}elseif($watcher->type == 'nude'){
					//set gift earnings
					if(!isset($chart['nude_earnings'][$start_date])){
						$chart['nude_earnings'][$start_date] =  $watcher->performer_chips;
					}else{
						$chart['nude_earnings'][$start_date] = $chart['nude_earnings'][$start_date] + $watcher->performer_chips;
					}
				}
			
			}
		}
		
		if(is_array($chart) && count($chart) > 0){
			$chart_cat_names = array(
				'duration'				=>'Total sessions duration',
				'watchers'				=> 'Total sessions',
				'total_earnings'		=> 'Total earnings',
				'video_earnings'		=> 'Videos earnings',
				'gift_earnings'			=> 'Gifts earnings',
				'photos_earnings'		=> 'Photos earnings',
				'private_earnings'		=> 'Private earnings',
				'true_private_earnings' => 'True private earnings',
				'peeck_earnings'		=> 'Peek earnings',
				'nude_earnings'			=> 'Nude earnings',
				'private'				=> 'Private watchers',
				'true_private'			=> 'True private watchers',
				'peek'					=> 'Peek watchers',
				'nude'					=> 'Nude watchers',
				'free'					=> 'Free watchers',
				'premium_video'			=> 'Premim videos watchers',
				'photos'				=> 'Paid photos watchers',
				'gift'					=> 'Gifts',
				'admin_action'			=> 'Admin actions',
				'spy'					=> 'Spy');
			
			
			$y = 0;
			
			foreach($chart['duration'] as $time => $value){
				$categories[] ='\''.date('d M',$time).'\'';
			}
			$return['categories'] = implode(',', $categories);
			
			if(is_array($dates_to_show)){
				$total_cats = count($dates_to_show);
			}else{
				$total_cats = count($chart);
			}
			foreach($chart as $cat => $days){
				if((is_array($dates_to_show) && in_array($cat, $dates_to_show)) || !$dates_to_show){
					$chart_data .= '{
							name: \''.lang($chart_cat_names[$cat]).'\',
							 data: [';

					if($cat == 'duration'){
						foreach($days as $key => $value){
							$days[$key] = $value/10;
						}
					}
					$chart_data .= implode(',', $days);
	//				
	//				foreach ($days as $time => $value){
	//				
	//					$chart_data .= '[Date.UTC('.date('Y', $time).',  '.date('n', $time).',  '.date('j', $time).'), '.$value.' ]';
	//					
	//					if($x < $total_days){
	//						$chart_data .= ',';
	//					}
	//				}

					$chart_data .= ']}';
					if($y < $total_cats){
						$chart_data .= ',';
					}
				}
			}
		}
		$return['chart_data'] = $chart_data;
		return $return;
	}
}
