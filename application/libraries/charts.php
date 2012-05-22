<?php


class charts {
	
	private $watchers_data;
	private $start_date;
	private $end_date;
	private $performer_id;
	private $studio_id;
	private $_ci;
	private $days;
	private $days_to_the_end = 5;
	private $chart_cat_names = array();
			
			
	
	
	function __construct(){
		$this->chart_cat_names = array(
						'duration'				=> lang('Total sessions duration'),
						'watchers'				=> lang('Total sessions'),
						'total_earnings'		=> lang('Total earnings'),
						'video_earnings'		=> lang('Videos earnings'),
						'gift_earnings'			=> lang('Gifts earnings'),
						'photos_earnings'		=> lang('Photos earnings'),
						'private_earnings'		=> lang('Private earnings'),
						'true_private_earnings' => lang('True private earnings'),
						'peeck_earnings'		=> lang('Peek earnings'),
						'nude_earnings'			=> lang('Nude earnings'),
						'private'				=> lang('Private viewers'),
						'true_private'			=> lang('True private viewers'),
						'peek'					=> lang('Peek viewers'),
						'nude'					=> lang('Nude viewers'),
						'free'					=> lang('Free viewers'),
						'premium_video'			=> lang('Premim videos viewers'),
						'photos'				=> lang('Paid photos viewers'),
						'gift'					=> lang('Gifts'),
						'admin_action'			=> lang('Admin actions'),
						'spy'					=> lang('Spy')		
		);
		$this->_ci =& get_instance();
		$this->_ci->load->model('chart');
	}
	
	
	public function get_chart_data($chart, $start_date, $end_date, $performer_id = FALSE, $studio_id = FALSE){
		
		if($this->start_date != $start_date || $this->end_date != $end_date || $this->performer_id != $performer_id || $this->studio_id != $studio_id || !is_array($this->watchers_data)){
			
			$end_date = $end_date + (60 * 60 * 24 * $this->days_to_the_end);// add x days to the end of chart
			
			$data = $this->_ci->chart->get_data($start_date, $end_date, $performer_id, $studio_id);
			$this->watchers_data = $data;
			$this->start_date = $start_date;
			$this->end_date = $end_date;
			$this->performer_id = $performer_id;
			$this->studio_id = $studio_id;
		}

		if($chart == 'watchers'){
			$this->chart_cat_names = array(
				'true_private'			=> lang('True private viewers'),
				'private'				=> lang('Private viewers'),
				'peek'					=> lang('Peek viewers'),
				'nude'					=> lang('Nude viewers'),
				'free'					=> lang('Free viewers'),
				'premium_video'			=> lang('Premim videos viewers'),
				'photos'				=> lang('Paid photos viewers'),
				'gift'					=> lang('Gifts'));
		}elseif($chart == 'earnings'){
			$this->chart_cat_names = array(
				'premium_video'	=> lang('Videos earnings'),
				'gift'			=> lang('Gifts earnings'),
				'photos'		=> lang('Photos earnings'),
				'private'		=> lang('Private earnings'),
				'true_private'  => lang('True private earnings'),
				'peek'			=> lang('Peek earnings'),
				'free'			=> lang('Free earnings'),
				'nude'			=> lang('Nude earnings'));
		}else{
			$this->chart_cat_names = array(
				'duration'				=>lang('Total sessions duration'),
				'watchers'				=> lang('Total sessions'),
				'total_earnings'		=> lang('Total earnings'));
		}
		$chart_data_str = '';
		
		$this->get_days_interval($start_date, $end_date);
		if(is_array($this->watchers_data) && count($this->watchers_data) > 0){
			foreach($this->watchers_data as $row){

				if($row->type != 'admin_action' && $row->type != 'spy'){
					if($chart == 'watchers' || $chart == 'earnings'){
						if($chart == 'watchers'){
							$data = $row->total_sessions;
						}else{
							if($this->performer_id > 0){
								$data = $row->performer_earnings;
							}elseif($this->studio_id > 0){
								$data = $row->studio_earnings + $row->performer_earnings;
							}else{
								$data = $row->performer_earnings + $row->studio_earnings;
							}
						}
						if($row->type != 'free'){
							if(!isset($chart_data[$row->type])){
								$chart_data[$row->type] = "[Date.UTC(".date('Y', $row->date).",  ".(date('n', $row->date)-1).",  ".date('j', $row->date)."), ".$data."],";
								//$chart_data[$row->type] = $data.",";
							}else{
								$chart_data[$row->type] .= "[Date.UTC(".date('Y', $row->date).",  ".(date('n', $row->date)-1).",  ".date('j', $row->date)."), ".$data."],";
								//$chart_data[$row->type] .= $data.",";
							}
						}elseif($chart == 'watchers'){
							if(!isset($chart_data[$row->type])){
								$chart_data[$row->type] = "[Date.UTC(".date('Y', $row->date).",  ".(date('n', $row->date)-1).",  ".date('j', $row->date)."), ".$data."],";
								//$chart_data[$row->type] = $data.",";
							}else{
								$chart_data[$row->type] .= "[Date.UTC(".date('Y', $row->date).",  ".(date('n', $row->date)-1).",  ".date('j', $row->date)."), ".$data."],";
								//$chart_data[$row->type] .= $data.",";
							}
						}
					}else{
						
						
						
						if($this->studio_id > 0){
								$totals['total_earnings'][$row->date][] = $row->studio_earnings +  $row->performer_earnings;
						}elseif($this->performer_id > 0){
								$totals['total_earnings'][$row->date][] = $row->performer_earnings;
						}else{
								$totals['total_earnings'][$row->date][] = $row->performer_earnings + $row->studio_earnings;
						}
						$totals['duration'][$row->date][] = $row->duration/100;
						$totals['watchers'][$row->date][] = $row->total_sessions;
						
						
						if(!isset($start_date) || $start_date > $row->date){
							$start_date = $row->date;
						}
						
					}
					if(isset($this->days[$row->date])){
						unset($this->days[$row->date]);
					}
				}
				
				
				
				
			}
			
			if($chart == 'totals' && isset($totals) && count($totals) > 0){
				
				foreach($totals as $cat => $days){
					foreach($days as $day => $values){
						if(!isset($chart_data[$cat])){
							$chart_data[$cat] = "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), ".(array_sum($values))."],";
							//$chart_data[$cat] = (array_sum($values)).",";
						}else{
							$chart_data[$cat] .= "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), ".(array_sum($values))."],";
							//$chart_data[$cat] .= (array_sum($values)).",";
						}
					}
				}
				
			}
			
			if(isset($chart_data) && is_array($chart_data) && sizeof($chart_data) > 0){
				foreach($chart_data as $key => $value){
					foreach($this->days as $day => $null){
						$chart_data[$key] .=  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
					}
				}
				
				
				
				foreach($chart_data as $name => $line){
					$chart_data_str .= "{
								name: '".$this->chart_cat_names[$name]."',
								pointInterval: 24 * 3600 * 1000,
								pointStart: Date.UTC(".date('Y', $start_date).",  ".(date('n', $start_date)-1).",  ".date('j', $start_date)."),
								data: [";
	
					$chart_data_str .= substr($line, 0, -1);
	
	
					$chart_data_str .= ']
						},';
					
				}
			}else{
				
				foreach($this->chart_cat_names as $key => $value){
					foreach($this->days as $day => $null){					
						if( ! isset($chart_data[$key])){
							$chart_data[$key] =  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
						}else{
							$chart_data[$key] .=  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
						}
					}
				}

				foreach($chart_data as $name => $line){
					$chart_data_str .= "{
								name: '".$this->chart_cat_names[$name]."',
								pointInterval: 24 * 3600 * 1000,
								pointStart: Date.UTC(".date('Y', $start_date).",  ".(date('n', $start_date)-1).",  ".date('j', $start_date)."),
								data: [";

					$chart_data_str .= substr($line, 0, -1);


					$chart_data_str .= ']
						},';

				}
			}
			
		
		}else{
			
			foreach($this->chart_cat_names as $key => $value){
				foreach($this->days as $day => $null){					
					if( ! isset($chart_data[$key])){
						$chart_data[$key] =  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
					}else{
						$chart_data[$key] .=  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
					}
				}
			}
			
			foreach($chart_data as $name => $line){
				$chart_data_str .= "{
							name: '".$this->chart_cat_names[$name]."',
							pointInterval: 24 * 3600 * 1000,
							pointStart: Date.UTC(".date('Y', $start_date).",  ".(date('n', $start_date)-1).",  ".date('j', $start_date)."),
							data: [";

				$chart_data_str .= substr($line, 0, -1);


				$chart_data_str .= ']
					},';
				
			}
		}
		
		
	
		
		
		return substr($chart_data_str, 0, -1);
	}
	
	
	
	public function get_registers_chart_data($start_date, $end_date){
		
		$end_date = $end_date + (60 * 60 * 24 * $this->days_to_the_end);// add x days to the end of chart
		
		$data['affiliates'] = $this->_ci->chart->get_registers_data($start_date, $end_date, 'affiliates');
		$data['studios'] = $this->_ci->chart->get_registers_data($start_date, $end_date, 'studios');
		$data['performers'] = $this->_ci->chart->get_registers_data($start_date, $end_date, 'performers');
		$data['users'] = $this->_ci->chart->get_registers_data($start_date, $end_date, 'users_detail');
		$chart_data_str = '';
		$chart_data = '';
		
		$this->chart_cat_names = array(
				'affiliates'			=> lang('Affiliates'),
				'studios'				=> lang('Studios'),
				'performers'			=> lang('Performers'),
				'users'					=> lang('Users'));
		$this->get_days_interval($start_date, $end_date);
		foreach($data as $cat => $days){
			if(is_array($days) && count($days) > 0){
				foreach($days as $value){
					if(!isset($chart_data[$cat])){
						$chart_data[$cat] = "[Date.UTC(".date('Y', $value->date).",  ".(date('n', $value->date)-1).",  ".date('j', $value->date)."), ".$value->total."],";
						//$chart_data[$cat] = (array_sum($values)).",";
					}else{
						$chart_data[$cat] .= "[Date.UTC(".date('Y', $value->date).",  ".(date('n', $value->date)-1).",  ".date('j', $value->date)."), ".$value->total."],";
						//$chart_data[$cat] .= (array_sum($values)).",";
					}
					if(isset($this->days[$value->date])){
						unset($this->days[$value->date]);
					}
				}
			}
			
		}
		if(is_array($chart_data) && count($chart_data) > 0){
		
		foreach($chart_data as $key => $value){
			foreach($this->days as $day => $null){
				$chart_data[$key] .=  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
			}
		}
			
		foreach($chart_data as $name => $line){
				$chart_data_str .= "{
							name: '".lang(ucfirst($name))."',
							pointInterval: 24 * 3600 * 1000,
							pointStart: Date.UTC(".date('Y', $start_date).",  ".(date('n', $start_date)-1).",  ".date('j', $start_date)."),
							data: [";

				$chart_data_str .= substr($line, 0, -1);


				$chart_data_str .= ']
					},';
				
			}
		}else{
			foreach($this->chart_cat_names as $key => $value){
				foreach($this->days as $day => $null){
					if(!isset($chart_data[$key])){
						$chart_data[$key] =  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
					}else{
						$chart_data[$key] .=  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
					}
				}
			}
			
			foreach($chart_data as $name => $line){
				$chart_data_str .= "{
							name: '".$this->chart_cat_names[$name]."',
							pointInterval: 24 * 3600 * 1000,
							pointStart: Date.UTC(".date('Y', $start_date).",  ".(date('n', $start_date)-1).",  ".date('j', $start_date)."),
							data: [";

				$chart_data_str .= substr($line, 0, -1);


				$chart_data_str .= ']
					},';
				
			}
		}
		
		return substr($chart_data_str, 0, -1);
	}
	
	public function get_affiliates_chart_data($start_date, $end_date, $affiliate_id = FALSE){
		
		$end_date = $end_date + (60 * 60 * 24 * $this->days_to_the_end);// add x days to the end of chart
		
		$this->chart_cat_names = array(
				'register'			=> lang('Signups'),
				'hit'				=> lang('Hits'),
				'view'				=> lang('Views'),
				'transaction'		=> lang('Transactions'),
				'Earning'		    => lang('Earnings'));
		
		$data = $this->_ci->chart->get_affiliates_traffic_data($start_date, $end_date, $affiliate_id);
		//die(print_r($data));
		
		$chart_data_str = '';
		$this->get_days_interval($start_date, $end_date);
		if(is_array($data) && count($data) > 0){
			foreach($data as  $actions){
				if(!isset($chart_data[$actions->action])){
					$chart_data[$actions->action] = "[Date.UTC(".date('Y', $actions->date).",  ".(date('n', $actions->date)-1).",  ".date('j', $actions->date)."), ".$actions->total."],";
					//$chart_data[$cat] = (array_sum($values)).",";
				}else{
					$chart_data[$actions->action] .= "[Date.UTC(".date('Y', $actions->date).",  ".(date('n', $actions->date)-1).",  ".date('j', $actions->date)."), ".$actions->total."],";
					//$chart_data[$cat] .= (array_sum($values)).",";
				}
				if(isset($this->days[$actions->date])){
					unset($this->days[$actions->date]);
				}
				if(isset($earnings[$actions->date])){
					$earnings[$actions->date] = $earnings[$actions->date] + $actions->earnings;
				}else{
					$earnings[$actions->date] = $actions->earnings;
				}
			}

			foreach($earnings as $date => $value){
				if(!isset($chart_data['Earning'])){
					$chart_data['Earning'] = "[Date.UTC(".date('Y', $date).",  ".(date('n', $date)-1).",  ".date('j', $date)."), ".$value."],";
					//$chart_data[$cat] = (array_sum($values)).",";
				}else{
					$chart_data['Earning'] .= "[Date.UTC(".date('Y', $date).",  ".(date('n', $date)-1).",  ".date('j', $date)."), ".$value."],";
					//$chart_data[$cat] .= (array_sum($values)).",";
				}

			}

			foreach($chart_data as $key => $value){
				foreach($this->days as $day => $null){
					$chart_data[$key] .=  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
				}
			}
			
			foreach($chart_data as $name => $line){
					$chart_data_str .= "{
								name: '".ucfirst($this->chart_cat_names[$name])."',
								pointInterval: 24 * 3600 * 1000,
								pointStart: Date.UTC(".date('Y', $start_date).",  ".(date('n', $start_date)-1).",  ".date('j', $start_date)."),
								data: [";

					$chart_data_str .= substr($line, 0, -1);


					$chart_data_str .= ']
						},';

				}
		}else{
			foreach($this->chart_cat_names as $key => $value){
				foreach($this->days as $day => $null){
					if(!isset($chart_data[$key])){
						$chart_data[$key] =  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
					}else{
						$chart_data[$key] .=  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
					}
					
				}
			}
			
			foreach($chart_data as $name => $line){
				$chart_data_str .= "{
							name: '".$this->chart_cat_names[$name]."',
							pointInterval: 24 * 3600 * 1000,
							pointStart: Date.UTC(".date('Y', $start_date).",  ".(date('n', $start_date)-1).",  ".date('j', $start_date)."),
							data: [";

				$chart_data_str .= substr($line, 0, -1);


				$chart_data_str .= ']
					},';
				
			}
		}
		
		return substr($chart_data_str, 0, -1);
	}
	
	
	
	public function get_payments_chart_data($start_date, $end_date, $performer_id = FALSE, $studio_id = FALSE, $affiliate_id = FALSE){
		
		$end_date = $end_date + (60 * 60 * 24 * $this->days_to_the_end);// add x days to the end of chart
		
		$data = $this->_ci->chart->get_payments_data($start_date, $end_date, $performer_id, $studio_id, $affiliate_id);
		$this->get_days_interval($start_date, $end_date);
		$chart_data_str = '';
		//die(print_r($data));
		$this->chart_cat_names = array(
				'payments'			=> lang('Payments'),
				'amount'			=> lang('Amount')
			);
		
		if(is_array($data) && count($data) > 0){
			foreach($data as  $day){
				if(!isset($chart_data['payments'])){
					$chart_data['payments'] = "[Date.UTC(".date('Y', $day->date).",  ".(date('n', $day->date)-1).",  ".date('j', $day->date)."), ".$day->total."],";
					//$chart_data[$cat] = (array_sum($values)).",";
				}else{
					$chart_data['payments'] .= "[Date.UTC(".date('Y', $day->date).",  ".(date('n', $day->date)-1).",  ".date('j', $day->date)."), ".$day->total."],";
					//$chart_data[$cat] .= (array_sum($values)).",";
				}

				if(!isset($chart_data['amount'])){
					$chart_data['amount'] = "[Date.UTC(".date('Y', $day->date).",  ".(date('n', $day->date)-1).",  ".date('j', $day->date)."), ".convert_chips_to_value($day->amount_chips)."],";
					//$chart_data[$cat] = (array_sum($values)).",";
				}else{
					$chart_data['amount'] .= "[Date.UTC(".date('Y', $day->date).",  ".(date('n', $day->date)-1).",  ".date('j', $day->date)."), ".convert_chips_to_value($day->amount_chips)."],";
					//$chart_data[$cat] .= (array_sum($values)).",";
				}
				if(isset($this->days[$day->date])){
					unset($this->days[$day->date]);
				}

			}
			
			foreach($chart_data as $key => $value){
				foreach($this->days as $day => $null){
					$chart_data[$key] .=  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
				}
			}
			
			foreach($chart_data as $name => $line){
					$chart_data_str .= "{
								name: '".lang(ucfirst($name))."',
								pointInterval: 24 * 3600 * 1000,
								pointStart: Date.UTC(".date('Y', $start_date).",  ".(date('n', $start_date)-1).",  ".date('j', $start_date)."),
								data: [";

					$chart_data_str .= substr($line, 0, -1);


					$chart_data_str .= ']
						},';

				}
		}else{
			foreach($this->chart_cat_names as $key => $value){
				foreach($this->days as $day => $null){
					if(!isset($chart_data[$key])){
						$chart_data[$key] =  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
					}else{
						$chart_data[$key] .=  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
					}
				}
			}
			
			foreach($chart_data as $name => $line){
				$chart_data_str .= "{
							name: '".$this->chart_cat_names[$name]."',
							pointInterval: 24 * 3600 * 1000,
							pointStart: Date.UTC(".date('Y', $start_date).",  ".(date('n', $start_date)-1).",  ".date('j', $start_date)."),
							data: [";

				$chart_data_str .= substr($line, 0, -1);


				$chart_data_str .= ']
					},';
				
			}
		}
		
		return substr($chart_data_str, 0, -1);
	}
	
	public function get_credits_chart_data($start_date, $end_date, $performer_id = FALSE, $studio_id = FALSE, $affiliate_id = FALSE){
		
		$end_date = $end_date + (60 * 60 * 24 * $this->days_to_the_end);// add x days to the end of chart
		
		$this->get_days_interval($start_date, $end_date);
		
		$data = $this->_ci->chart->get_credits_data($start_date, $end_date);
		
		
		
		$chart_data_str = '';
		
		if(is_array($data) && count($data) > 0){
			foreach($data as  $day => $values){
				foreach($values as $cat => $value){

					if(!isset($chart_data[$cat])){
						$chart_data[$cat] = "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), ".$value."],";
						//$chart_data[$cat] = (array_sum($values)).",";
					}else{
						$chart_data[$cat] .= "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), ".$value."],";
						//$chart_data[$cat] .= (array_sum($values)).",";
					}
					if(isset($this->days[$day])){
						unset($this->days[$day]);
					}
				}
			}
			
			foreach($chart_data as $key => $value){
				foreach($this->days as $day => $null){
					$chart_data[$key] .=  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
				}
			}
			foreach($chart_data as $name => $line){
					$chart_data_str .= "{
								name: '".lang(ucfirst($name))."',
								pointInterval: 24 * 3600 * 1000,
								pointStart: Date.UTC(".date('Y', $start_date).",  ".(date('n', $start_date)-1).",  ".date('j', $start_date)."),
								data: [";

					$chart_data_str .= substr($line, 0, -1);


					$chart_data_str .= ']
						},';

				}
		}else{
			foreach($this->chart_cat_names as $key => $value){
				foreach($this->days as $day => $null){
					if(!isset($chart_data[$key])){
						$chart_data[$key] =  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
					}else{
						$chart_data[$key] .=  "[Date.UTC(".date('Y', $day).",  ".(date('n', $day)-1).",  ".date('j', $day)."), 0],";
					}
				}
			}
			
			foreach($chart_data as $name => $line){
				$chart_data_str .= "{
							name: '".$this->chart_cat_names[$name]."',
							pointInterval: 24 * 3600 * 1000,
							pointStart: Date.UTC(".date('Y', $start_date).",  ".(date('n', $start_date)-1).",  ".date('j', $start_date)."),
							data: [";

				$chart_data_str .= substr($line, 0, -1);


				$chart_data_str .= ']
					},';
				
			}
		}
		
		return substr($chart_data_str, 0, -1);
	}
	
	/**
	 * returneaza un array cu lunile cuprinse intre start date si end date
	 * 
	 * @param integer $start_date
	 * @param integer $end_date
	 * @return array 
	 */
	private function get_days_interval($start_date, $end_date){
			
		
		$this->days = array();
		while($start_date < $end_date){
			$days[$start_date] = '';
			$start_date  = strtotime('+1 day', $start_date);
			
		}
		
		$this->days =  $days;
	}
	
	
	
}