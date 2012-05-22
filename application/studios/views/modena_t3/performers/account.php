<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/table.css" media="screen" /> 
<script type="text/javascript">
	$(document).ready(function(){
		$('.time_interval').change(function(){
			$('#time_interva_form').submit();
		});
		
		$(".logs").fancybox({
			'transitionIn' : 'none',
			'transitionOut' : 'none' 
		}); 
	})
</script>
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $title = lang('Performer\'s Personal Details Page') ?>
			<span class="eutemia"><?php echo substr($title,0,1)?></span><span class="helvetica"><?php echo substr($title,1)?></span>
		</div>
		<div id="">
			<div class="left" style="text-align: center;">
				<div class="title">
					<?php $title = lang('Personal details')?>
					<span class="eutemia"><?php echo substr($title,0,1)?></span><span class="helvetica"><?php echo substr($title,1)?></span>
				</div>
					<?php echo form_open('')?>
					<div class="gray italic register_performer" style="padding-top:0px;">
						<div>
							<label><span class="gray italic bold"><?php echo lang('Password') ?>:</span></label>
							<?php echo form_input('password',set_value('password'))?>
							<span class="error message" htmlfor="password" generated="true"><?php echo form_error('password')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('First name') ?>:</span></label>
							<?php echo form_input('firstname',$performer->first_name)?>
							<span class="error message" htmlfor="firstname" generated="true"><?php echo form_error('firstname')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('Last name') ?>:</span></label>
							<?php echo form_input('lastname',$performer->last_name)?>
							<span class="error message" htmlfor="lastname" generated="true"><?php echo form_error('lastname')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('Phone') ?>:</span></label>
							<?php echo form_input('phone',$performer->phone)?>
							<span class="error message" htmlfor="phone" generated="true"><?php echo form_error('phone')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('Address') ?>:</span></label>
							<?php echo form_input('address', $performer->address)?>
							<span class="error message" htmlfor="address" generated="true"><?php echo form_error('address')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('City') ?>:</span></label>
							<?php echo form_input('city', $performer->city)?>
							<span class="error message" htmlfor="city" generated="true"><?php echo form_error('city')?></span>
						</div>
						<div>
							<label><span class="gray italic bold"><?php echo lang('Zip') ?>:</span></label>
							<?php echo form_input('zip',$performer->zip)?>
							<span class="error message" htmlfor="zip" generated="true"><?php echo form_error('zip')?></span>
						</div>
						
						<div>
							<label><span class="gray italic bold"><?php echo lang('Country') ?>:</span></label>
							<?php echo form_dropdown('country',$countries,  $performer->country, 'id="country" class="rounded"')?>
							<span class="error message" htmlfor="country" generated="true"><?php form_error('country')?></span>
						</div>
						<script type="text/javascript">
							$(function(){
								if($('#country').val() == 'US'){
									$('#state').show();
								}			
								
								$('#country').change(function(){
										if($('#country').val() == 'US'){
											$('#state').slideDown();
											$('input[name=state]').val('');
										} else {
											$('#state').slideUp();
											$('input[name=state]').val('state');						
										}
								});
							});
						</script>	
						<div id="state" style="display:none">
							<label><span class="gray italic bold"><?php echo lang('State') ?>:</span></label>
							<?php echo form_input('state',set_value('state', $performer->state))?>
							<span class="error message" htmlfor="state" generated="true"><?php echo form_error('state')?></span>
						</div>
						<div>
							<label style="vertical-align:top; float: left;"><span class="grey italic bold"><?php echo lang('Languages') ?>:</span></label>
							<span style="display: inline-block; width:212px; ">
							<?php foreach($languages as $language):?>
								<label><span style="display: block; padding-top: 3px; text-align: left;"><?php echo form_checkbox('languages[]', $language->code, set_checkbox('languages', $language->code, (in_array($language->code,$performers_languages)?TRUE:FALSE)))?><span class="gray italic bold"><?php echo ucfirst($language->title)?></span></label>
							<?php endforeach?>
							</span>
						</div>
						<div>
							<label></label>
							<?php echo form_submit('submit', lang('Save'), 'class="red" style=width:206px;')?>
						</div>
					<?php echo form_close()?>
					</div>
				
				<div class="red_h_sep"></div>
				<div class="white_h_sep"></div>
				<br/>
				
				<?php echo form_open('', 'id="time_interva_form"')?>

				<div class="title">
					<?php $title = lang('Payments')?>
					<span class="eutemia "><?php echo substr($title,0,1)?></span><span class="helvetica "><?php echo substr($title,1)?></span>
				</div>
				<div style="width:960px; margin:0px auto;">
					<div style="float:right; margin-bottom: 10px;">
						<?php echo form_dropdown('payments_interval', $interval_time, set_value('payments_interval', $payments_interval), 'class="time_interval rounded"')?>
					</div>
					<div class="clear"></div>
					<table class="data display datatable" align="center">
						<thead>
							<tr>
								<th style="width: 25%; white-space: nowrap;"><?php echo lang('Paid Date') ?></th>
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Paid interval') ?></th>
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Amount') ?></th>
							</tr>
						</thead>
						<tbody style="text-align: center;">
							<?php if(sizeof($payments) == 0):?>
								<tr>
									<td colspan="3" style="text-align:center"><?php echo lang('You have no payments') ?></td>
								</tr>
							<?php else:?>
								<?php $i = 0?>
								<?php foreach($payments as $payment ):?>
									<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">
										<td><?php echo date('Y-m-d', $payment->paid_date) ?></td>
										<td><?php echo date('Y-m-d', $payment->from_date)?> - <?php echo date('Y-m-d', $payment->to_date)?></td>
										<td><?php echo print_amount_by_currency($payment->amount_chips,TRUE)?></td>
									</tr>
									<?php $i++ ?>
								<?php endforeach;?>
							<?php endif;?>
						</tbody>
					</table>
				</div>
				
				<div class="red_h_sep"></div>
				<div class="white_h_sep"></div>
				<br/>
				
				<div class="title">
					<?php $title = lang('Sessions')?>
					<span class="eutemia "><?php echo substr($title,0,1)?></span><span class="helvetica "><?php echo substr($title,1)?></span>
				</div>
				<div style="width:960px; margin:0px auto;">
					<div style="float:right; margin-bottom: 10px;">
						<?php echo form_dropdown('sessions_interval', $interval_time, set_value('sessions_interval', $sessions_interval), 'class="time_interval rounded"')?>
					</div>
					<div class="clear"></div>
					<table class="data display datatable" align="center">
						<thead>
							<tr>
								<th style="width: 25%; white-space: nowrap;"><?php echo lang('Type') ?></th>
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Date') ?></th>
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Lenth') ?></th>
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Performer earnings') ?></th>
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Your earnings') ?></th>
							</tr>
						</thead>
						<tbody style="text-align: center;">
							<?php if(sizeof($sessions) == 0):?>
								<tr>
									<td colspan="5" style="text-align:center"><?php echo lang('You have no sessions') ?></td>
								</tr>
							<?php else:?>
								<?php $i = 0?>
								<?php foreach($sessions as $session ):?>
									<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">
										<td><?php echo lang($session->type)?></td>
										<td><?php echo date('d M Y H:i', $session->start_date)?></td>
										<td><?php echo sec2hms($session->duration)?></td>
										<td><?php echo print_amount_by_currency($session->performer_chips)?></td>
										<td><?php echo print_amount_by_currency($session->studio_chips)?></td>
									</tr>
									<?php $i++ ?>
								<?php endforeach;?>
							<?php endif;?>
						
						</tbody>
					</table>
				</div>
				
				
				<div class="red_h_sep"></div>
				<div class="white_h_sep"></div>
				<br/>
				
				<div class="title">
					<?php $title = lang('Chat logs')?>
					<span class="eutemia "><?php echo substr($title,0,1)?></span><span class="helvetica "><?php echo substr($title,1)?></span>
				</div>
				<div style="width:960px; margin:0px auto;">
					<div style="float:right; margin-bottom: 10px;">
						<?php echo form_dropdown('chat_logs_interval', $interval_time, set_value('chat_logs_interval', $chat_logs_interval), 'class="time_interval rounded"')?>
					</div>
					<div class="clear"></div>
					<table class="data display datatable" align="center">
						<thead>
							<tr>
								<th style="; white-space: nowrap;"><?php echo lang('Logs') ?></th>
							</tr>
						</thead>
						<tbody style="text-align: center;">
							<?php if(sizeof($chat_logs) == 0):?>
								<tr>
									<td colspan="3" style="text-align:center">
										<?php echo lang('You have no chat logs') ?>
									</td>
								</tr>
							<?php else:?>
								<?php $i = 0?>
								<?php foreach($chat_logs as $chat_log ):?>
									<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">
										<td style="text-align:left;">
											<a class="logs" href="#log_<?php echo $i?>" ><?php echo current( explode("\n",$chat_log->log, 2))?></a>
											<div class="complete_log" id="log_<?php echo $i?>" style="padding:20px; background: #000000;">
												<div class="title">
													<?php $title = lang('Chat logs')?>
													<span class="eutemia "><?php echo substr($title,0,1)?></span><span class="helvetica "><?php echo substr($title,1)?></span>
												</div>
												<?php echo nl2br($chat_log->log)?>
											</div>
										</td>
									</tr>
									<?php $i++ ?>
								<?php endforeach;?>
							<?php endif;?>
						
						</tbody>
					</table>
				</div>
				
				<div class="red_h_sep"></div>
				<div class="white_h_sep"></div>
				<br/>
				
				<div class="title">
					<?php $title = lang('Total sessions time')?>
					<span class="eutemia "><?php echo substr($title,0,1)?></span><span class="helvetica "><?php echo substr($title,1)?></span>
				</div>
				<div style="width:960px; margin:0px auto;">
					<div style="float:right; margin-bottom: 10px;">
						<?php echo form_dropdown('total_sessions_time_interval', $interval_time, set_value('total_sessions_time_interval', $total_sessions_time_interval), 'class="time_interval rounded"')?>
					</div>
					<div class="clear"></div>
					<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/highcharts.src.js"></script>
					<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/modules/exporting.js"></script>
					<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/themes/gray.js"></script>
					<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/highslide-full.min.js"></script>
					<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/highslide.config.js" charset="utf-8"></script>
					<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/highslide.css" />
					
			<script type="text/javascript">
			
		
			function show_chart(id){

				$('#statistics .displayed').hide();
				$('#chart_'+id).addClass('displayed');
				$('#chart_'+id).show();
			}	
		</script>
		
		
		<div id="statistics_buttons" >
			<button class="red" type="button" onclick="show_chart('totals');"><?php echo lang('Totals')?></button>
			<button class="red" type="button" onclick="show_chart('watchers');"><?php echo lang('Viewers')?></button>
			<button class="red" type="button" onclick="show_chart('earnings');"><?php echo lang('Earnings')?></button>
		</div>
		<div class="clear"></div>
		<div id="statistics">

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
						text: "<?php echo $this->user->username.lang('\'s statistics')?>"
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
						text: "<?php echo $this->user->username.lang('\'s earnings statistics')?>"
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
						text: "<?php echo $this->user->username.lang('\'s watchers statistics')?>"
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
	
		<div id="chart_watchers" style="display:none;width:965px;">
			
		</div>
	
		<?php endif?>
		</div>
			<?php echo form_close()?>
		</div>
				

				
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>