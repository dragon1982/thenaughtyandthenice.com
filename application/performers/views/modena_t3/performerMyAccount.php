<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $my_account_page_title = lang('My Account Page')?>
			<span class="eutemia"><?php echo substr($my_account_page_title,0,1)?></span><span class="helvetica"><?php echo substr($my_account_page_title,1)?></span>
		</div>
		<div class="gray italic" style="padding: 10px; text-align: justify; ">		

			<?php $credits_red = '<span class="red">' . print_amount_by_currency($this->user->credits) . '</span>' ?>

			<div style="margin:5px;">
				<?php echo sprintf(lang('Your account has %s'), $credits_red)?>
				<?php if( SETTINGS_CURRENCY_TYPE )://daca nu e in bani reali afisez suma si in real money?>
					<?php $equivalent = '<span class="red">' . print_amount_by_currency($this->user->credits,TRUE) . '</span>'?>
					<?php echo sprintf(lang('the equivalent of %s.'), $equivalent)?>
				<?php endif?>
			</div>
			<?php if( ! $this->user->studio_id ):?>			
				<?php if($this->user->release <= convert_chips_to_value($this->user->credits)):?>
					<div style="margin:5px;"><span><?php echo lang('You have been marked for payment.')?></span></div>
				<?php else: ?>
					<?php $need_more  = '<span class="red">' . print_amount_by_currency(convert_value_to_chips(abs($this->user->release - convert_chips_to_value($this->user->credits)))) . '</span>' ?>
					<div style="margin:5px;"><?php echo sprintf(lang('You need %s more and we\'ll send you the payment!'), $need_more)?></div>
				<?php endif; ?>
			<?php endif?>								
			<?php $video_access = '<span class="red">' .$video_access . '</span>'; ?>
			<div style="margin:5px;"><?php echo sprintf(lang('You have been accesed on videochat %s times.'), $video_access) ?></div>
			<?php $unread_messages = '<a href="'.site_url('messenger').'"><span class="red">' . $this->user->unread_messages . '</span></a>' ?> 
			<div style="margin:5px;"><?php echo sprintf(lang('You have %s unread message(s).'), $unread_messages) ?></div>
			<?php if($this->user->contract_status !== 'approved'):?>
				<br />
				<div style="margin:5px">
					<a class="red" href="<?php echo site_url('contracts')?>"><?php echo sprintf(lang('Your contract is %s'),$this->user->contract_status)?></a>
				</div>
			<?php endif?>
			<?php if($this->user->photo_id_status !== 'approved'):?>
				<div style="margin:5px">
					<a class="red" href="<?php echo site_url('photo_id')?>"><?php echo sprintf(lang('Your photo ID is %s'),$this->user->photo_id_status)?></a>
				</div>
			<?php endif?>	

			<?php if($this->user->contract_status == 'approved' && $this->user->photo_id_status == 'approved'):?>
				<div style="margin:5px">
					<?php echo lang('Your account is active!')?>
				</div>			
			<?php endif?>
			<div style="margin:20px 5px;"><a href="<?php echo main_url('guides/guide.pdf')?>" target="_blank"><img src="<?php echo assets_url()?>images/icons/guide.jpg" align="left"/><?php echo lang('View performer\'s manual') ?></a></div>

			
		</div>
		<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.strtotime.min.js"></script>
			<script type="text/javascript" src="<?php echo assets_url()?>js/jquery.ui.datepicker.js"></script>
			<script type="text/javascript">
			$(function() {						
					$( ".datepickerStart" ).datepicker({ maxDate: '<?php echo date('d-m-Y')?>',  dateFormat: 'dd-mm-yy'});
					$( ".datepickerEnd" ).datepicker({ maxDate: '<?php echo date('d-m-Y')?>',  dateFormat: 'dd-mm-yy'});
				});
		
			function show_chart(id){

				$('#statistics .displayed').hide();
				$('#chart_'+id).addClass('displayed');
				$('#chart_'+id).show();
			}	
		</script>
		<div style="float:right;margin-bottom: 10px;">
			<?php echo form_open(current_url())?>
			<label style="display:inline-block; "><?php echo lang('Start date')?><br/><?php echo form_input("start_date",  $start_date, 'class="datepickerStart" readonly="readonly"')?></label>
			<label style="display:inline-block;"><?php echo lang('End date')?><br/><?php echo form_input("end_date", $end_date, ' class="datepickerEnd"  readonly="readonly"')?></label>
			<label style="display: inline-block; vertical-align: bottom; padding-bottom: 4px;"><input type="image" src="<?php echo assets_url()?>images/icons/right_arrow.png"/></label>
			<?php echo form_close()?>
		</div>
		<div id="statistics_buttons" >
			<button class="red" onclick="show_chart('totals');"><?php echo lang('Totals')?></button>
			<button class="red" onclick="show_chart('watchers');"><?php echo lang('Viewers')?></button>
			<button class="red" onclick="show_chart('earnings');"><?php echo lang('Earnings')?></button>
		</div>
		<div class="clear"></div>
		<div id="statistics">

		<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/highcharts.src.js"></script>
		<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/modules/exporting.js"></script>
		<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/themes/gray.js"></script>
	<?php if($chart_totals != ''):?>	
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				
				 chart = new Highcharts.Chart({
				
			
					chart: {
						renderTo: 'chart_totals',
						marginBottom:50,
						height:450,
						zoomType: 'x'
						
					},
					
					title: {
						text: "<?php echo sprintf(lang('%s\'s statistics'),$this->user->username)?>"												
					},
					
					subtitle: {
						text: null
					},
					
					xAxis: {
					  type: 'datetime',
					 dateTimeLabelFormats: { // don't display the dummy year
						month: '%e. %b',
						year: '%b'
					 },
					  maxZoom: 28 * 24 * 3600000, // fourteen days
						tickWidth: 10,
						gridLineWidth: 1,
						alternateGridColor: '#151515',
						gridLineColor: '#373737',
						labels: {
							align: 'left',
							x: 3,
							y: 15,
							rotation:45
						}
					},
					
					yAxis: [{ // left y axis
						title: {
							text: null
						},
						labels: {
							align: 'right',
							x:0,
							y:6,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}],
					
					legend: {
						align: 'right',
						verticalAlign: 'top',
						y: 20,
						x: 5,
						floating: false,
						width: 180,
						style:{
							display: 'block'
						},
						//margin:100,
						borderWidth: 0
					},
					
					
					tooltip: {
						shared:true,
						 formatter: function() {
							 var tooltip = '';
							  tooltip += '<b>'+Highcharts.dateFormat('%e %b. %Y', this.x)+'<b><br/>';
							 for(var i in this.points){
								 if(this.points[i].series.name == 'Total earnings'){
										y = this.y;
										unit = 'chips';
									}else if(this.points[i].series.name == 'Total sessions'){
										y = this.y;
										unit = 'sessions';
									}else{
										y = time(this.y * 100000);
										unit = '';
									}
									
								 if(this.points[i].series.name == 'Total sessions duration'){
									 tooltip += '<span><b style="color:'+this.points[i].series.color+'">'+ this.points[i].series.name +'</b>: '+ time(this.points[i].y * 100000) +' '+ unit+ ' </span><br/>';
								 }else{
									 tooltip += '<span><b style="color:'+this.points[i].series.color+'">'+ this.points[i].series.name +'</b>: '+this.points[i].y +' '+ unit+ '</span><br/>';
								 }
							}
								 
							 
							return tooltip;
						 }
					  },
					plotOptions: {
						series: {
							cursor: 'pointer',
							point: {
								events: {
									click: function() {
										if(this.series.name == 'Total earnings'){
											y = this.y;
											unit = 'chips';
										}else if(this.series.name == 'Total sessions'){
											y = this.y;
											unit = 'sessions';
										}else{
											y = time(this.y * 10000);
											unit = '';
										}
										hs.htmlExpand(null, {
											pageOrigin: {
												x: this.pageX, 
												y: this.pageY
											},
											headingText: this.series.name,
											maincontentText: Highcharts.dateFormat('%e %b. %Y', this.x) +':<br/> '+ 
												y +' '+unit,
											width: 200
										});
									}
								}
							},
							marker: {
							   enabled: false,
							   states: {
								  hover: {
									 enabled: true,
									 radius: 5
								  }
							   }
							}
						}
					},
					
					series: [<?php echo $chart_totals ?>]
				});
				
				
				
			});
				
		</script>
		
		
			<div id="chart_totals" class="displayed" style="width:965px;">
				
			</div>
		
	<?php endif?>	
	<?php if($chart_earnings != ''):?>		
		
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				
				 chart = new Highcharts.Chart({
				
			
					chart: {
						renderTo: 'chart_earnings',
						marginBottom:50,
						height:450,
						zoomType: 'x'
					},
					
					title: {
						text: "<?php echo sprintf(lang('%s\'s earnings statistics'),$this->user->username)?>"	
					},
					
					subtitle: {
						text: null
					},
					
					xAxis: {
					  type: 'datetime',
					 dateTimeLabelFormats: { // don't display the dummy year
						month: '%e. %b',
						year: '%b'
					 },
					   maxZoom: 28 * 24 * 3600000, // fourteen days
						tickWidth: 10,
						gridLineWidth: 1,
						alternateGridColor: '#151515',
						gridLineColor: '#373737',
						labels: {
							align: 'left',
							x: 3,
							y: 15,
							rotation:45
						}
					},
					
					yAxis: [{ // left y axis
						title: {
							text: 'chips'
						},
						labels: {
							align: 'right',
							x:0,
							y:6,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}],
					
					legend: {
						align: 'right',
						verticalAlign: 'top',
						y: 20,
						x: 5,
						floating: false,
						width: 180,
						style:{
							display: 'block'
						},
						//margin:100,
						borderWidth: 0
					},
					
					
					tooltip: {
						shared:true,
						 formatter: function() {
							 var tooltip = '';
							 tooltip += '<b>'+Highcharts.dateFormat('%e %b. %Y', this.x)+'<b><br/>';
							 for(var i in this.points){
								
								 if(this.points[i].series.name == 'Total sessions duration'){
									 tooltip += '<span><b style="color:'+this.points[i].series.color+'">'+ this.points[i].series.name +'</b>: '+ time(this.points[i].y * 10000) +' chips </span><br/>';
								 }else{
									 tooltip += '<span><b style="color:'+this.points[i].series.color+'">'+ this.points[i].series.name +'</b>: '+this.points[i].y +' chips </span> <br/>';
								 }
							}
								 
							 
							return tooltip;
						 }
					  },
					plotOptions: {
						series: {
							cursor: 'pointer',
							point: {
								events: {
									click: function() {
										hs.htmlExpand(null, {
											pageOrigin: {
												x: this.pageX, 
												y: this.pageY
											},
											headingText: this.series.name,
											maincontentText: Highcharts.dateFormat('%e %b. %Y', this.x) +':<br/> '+ 
												this.y +' chips',
											width: 200
										});
									}
								}
							},
							marker: {
							   enabled: false,
							   states: {
								  hover: {
									 enabled: true,
									 radius: 5
								  }
							   }
							}
						}
					},
					
					series: [<?php echo $chart_earnings ?>]
				});
				
				
				
			});
				
		</script>
		
		
			<div id="chart_earnings"  style="display:none;width:965px;" >
				
			</div>
		
		<?php endif?>
		<?php if($chart_watchers != ''):?>	
		
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				
				 chart = new Highcharts.Chart({
				
			
					chart: {
						renderTo: 'chart_watchers',
						marginBottom:50,
						height:450,
						zoomType: 'x'
					},
					
					title: {
						text: "<?php echo sprintf(lang('%s\'s watchers statistics'),$this->user->username)?>"
					},
					
					subtitle: {
						text: null
					},
					
					xAxis: {
					  type: 'datetime',
					 dateTimeLabelFormats: { // don't display the dummy year
						month: '%e. %b',
						year: '%b'
					 },
					   maxZoom: 28 * 24 * 3600000, // fourteen days
						tickWidth: 10,
						gridLineWidth: 1,
						alternateGridColor: '#151515',
						gridLineColor: '#373737',
						labels: {
							align: 'left',
							x: 3,
							y: 15,
							rotation:45
						}
					},
					
					yAxis: [{ // left y axis
						title: {
							text: 'watchers'
						},
						labels: {
							align: 'right',
							x:0,
							y:6,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}],
					
					legend: {
						align: 'right',
						verticalAlign: 'top',
						y: 20,
						x: 5,
						floating: false,
						width: 180,
						style:{
							display: 'block'
						},
						//margin:100,
						borderWidth: 0
					},
					
					
					
					tooltip: {
						shared:true,
						 formatter: function() {
							 var tooltip = '';
							 tooltip += '<b>'+Highcharts.dateFormat('%e %b. %Y', this.x)+'<b><br/>';
							 for(var i in this.points){
								if(this.points[i].series.name == 'Gifts'){
									unit = 'gifts';
								}else{
									unit = 'watchers';
								}
								 if(this.points[i].series.name == 'Total sessions duration'){
									 tooltip += '<span><b style="color:'+this.points[i].series.color+'">'+ this.points[i].series.name +'</b>: '+ time(this.points[i].y * 10000) +' '+ unit +' </span><br/>';
								 }else{
									 tooltip += '<span><b style="color:'+this.points[i].series.color+'">'+ this.points[i].series.name +'</b>: '+this.points[i].y +' '+ unit +'</span> <br/>';
								 }
							}
								 
							 
							return tooltip;
						 }
					  },
					plotOptions: {
						series: {
							cursor: 'pointer',
							point: {
								events: {
									click: function() {
										if(this.series.name == 'Gifts'){
											unit = 'gifts';
										}else{
											unit = 'watchers';
										}
										hs.htmlExpand(null, {
											pageOrigin: {
												x: this.pageX, 
												y: this.pageY
											},
											headingText: this.series.name,
											maincontentText: Highcharts.dateFormat('%e %b. %Y', this.x)+' :<br/> '+ 
												this.y +' '+unit,
											width: 200
										});
									}
								}
							},
							marker: {
							   enabled: false,
							   states: {
								  hover: {
									 enabled: true,
									 radius: 5
								  }
							   }
							}
						}
					},
					
					series: [<?php echo $chart_watchers ?>]
				});
				
				
				
			});
				
		</script>
		
		<!-- Additional files for the Highslide popup effect -->
		<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/highslide-full.min.js"></script>
		<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/highslide.config.js" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/highslide.css" />
		
			<div id="chart_watchers" style="display:none;width:965px;">
				
			</div>
		
		<?php endif?>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>