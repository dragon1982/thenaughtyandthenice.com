<script type="text/javascript">
	var chart;	
	function get_data(){
		$.ajax({
			url: 'live-server-data.php',
			success: function(point) {
				var series = chart.series[0],
					shift = series.data.length > 20; // shift if the series is longer than 20

				// add the point
				chart.series[0].addPoint(point, true, shift);

				// call it again after one second
				setTimeout(requestData, 1000);    
			},
			cache: false
		});
	}
	
	function show_chart(id, button){
	
		$('#barbtns .selected').removeClass('selected');
		$(button).addClass('selected');
		
	
		$('#statistics .displayed').hide();
		$('#chart_'+id).addClass('displayed');
		$('#chart_'+id).show();
	}
</script>

<div class="container">
    <div class="conthead">
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
		<?php $this->load->view('includes/statistics_buttons');?>
    </div>
    <div class="contentbox">
        <div class="center_contentbox" style="width:auto; max-width: 1500px;">

			<div id="statistics">

		<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/highcharts.src.js"></script>
		<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/modules/exporting.js"></script>
		<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/themes/gray.js"></script>
		<!-- Additional files for the Highslide popup effect -->
		<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/highslide-full.min.js"></script>
		<script type="text/javascript" src="<?php echo assets_url()?>js/highcharts/highslide.config.js" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/highslide.css" />
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
						text: "<?php echo lang('Statistics')?>"
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
						itemWidth: 180,
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
		
		
			<div id="chart_totals" class="displayed" style="width:100%; max-width: 1500px;">
				
			</div>
	<?php else:?>
			<div id="chart_totals" style="width:100%; max-width: 1500px; text-align: center; display:none;">
			<?php echo lang('Not available')?>		
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
						text: "<?php echo lang('Earnings statistics')?>"
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
						itemWidth: 180,
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
		
		
			<div id="chart_earnings"  style="display:none;width:100%; max-width: 1500px;" >
				
			</div>
		<?php else:?>
			<div id="chart_earnings" style="width:100%; max-width: 1500px; text-align: center; display:none;">
			<?php echo lang('Not available')?>		
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
						text: "<?php echo lang('Watchers statistics')?>"
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
						itemWidth: 180,
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
		
		
		
			<div id="chart_watchers" style="display:none;width:100%; max-width: 1500px;">
				
			</div>
		<?php else:?>
			<div id="chart_watchers" style="width:100%; max-width: 1500px; text-align: center; display:none;">
			<?php echo lang('Not available')?>		
			</div>
		<?php endif?>
		<?php if($chart_registers != ''):?>		
		
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				
				 chart = new Highcharts.Chart({
				
			
					chart: {
						renderTo: 'chart_registers',
						marginBottom:50,
						height:450,
						zoomType: 'x'
					},
					
					title: {
						text: "<?php echo lang('Signups statistics')?>"
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
							text: 'accounts'
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
						itemWidth: 180,
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
								 
									 tooltip += '<span><b style="color:'+this.points[i].series.color+'">'+ this.points[i].series.name +'</b>: '+this.points[i].y +'  </span> <br/>';
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
												this.y ,
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
					
					series: [<?php echo $chart_registers ?>]
				});
				
				
				
			});
				
		</script>
		
		
			<div id="chart_registers"  style="display:none;width:100%; max-width: 1500px;" >
				
			</div>
		<?php else:?>
			<div id="chart_registers" style="width:100%; max-width: 1500px; text-align: center; display:none;">
			<?php echo lang('Not available')?>		
			</div>
		<?php endif?>
		
		<?php if($chart_affiliates != ''):?>		
		
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				
				 chart = new Highcharts.Chart({
				
			
					chart: {
						renderTo: 'chart_affiliates',
						marginBottom:50,
						height:450,
						zoomType: 'x'
					},
					
					title: {
						text: "<?php echo lang('Affiliates ads traffic statistics')?>"
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
						itemWidth: 180,
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
								 
									 tooltip += '<span><b style="color:'+this.points[i].series.color+'">'+ this.points[i].series.name +'</b>: '+this.points[i].y +'  </span> <br/>';
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
												this.y ,
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
					
					series: [<?php echo $chart_affiliates ?>]
				});
				
				
				
			});
				
		</script>
		
		
			<div id="chart_affiliates"  style="display:none;width:100%; max-width: 1500px;" >
				
			</div>
		<?php else:?>
			<div id="chart_affiliates" style="width:100%; max-width: 1500px; text-align: center; display:none;">
			<?php echo lang('Not available')?>		
			</div>
		<?php endif?>
		<?php if($chart_payments != ''):?>		
		
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				
				 chart = new Highcharts.Chart({
				
			
					chart: {
						renderTo: 'chart_payments',
						marginBottom:50,
						height:450,
						zoomType: 'x'
					},
					
					title: {
						text: "<?php echo lang('Payments statistics')?>"
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
						itemWidth: 180,
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
								 if(this.points[i].series.name == 'Amount'){
										unit = '<?=SETTINGS_SHOWN_CURRENCY?>';
									}else{
										unit = '';
									}
								 
									 tooltip += '<span><b style="color:'+this.points[i].series.color+'">'+ this.points[i].series.name +'</b>: '+this.points[i].y +' '+ unit +' </span> <br/>';
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
												this.y ,
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
					
					series: [<?php echo $chart_payments ?>]
				});
				
				
				
			});
				
		</script>
		
		
			<div id="chart_payments"  style="display:none;width:100%; max-width: 1500px;" >
				
			</div>
		<?php else:?>
			<div id="chart_payments" style="width:100%; max-width: 1500px; text-align: center; display:none;">
				<?php echo lang('Not available')?>		
			</div>
		<?php endif?>
		<?php if($chart_transactions != ''):?>		
		
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				
				 chart = new Highcharts.Chart({
				
			
					chart: {
						renderTo: 'chart_transactions',
						marginBottom:50,
						height:450,
						zoomType: 'x'
					},
					
					title: {
						text: "<?php echo lang('Transactions statistics')?>"
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
					   maxZoom: 28 * 24 * 3600 * 1000, // fourteen days
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
						itemWidth: 180,
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
									 tooltip += '<span><b style="color:'+this.points[i].series.color+'">'+ this.points[i].series.name +'</b>: '+this.points[i].y +' </span> <br/>';
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
												this.y ,
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
					
					series: [<?php echo $chart_transactions ?>]
				});
				
				
				
			});
				
		</script>
		
		
			<div id="chart_transactions"  style="display:none;width:100%; max-width: 1500px;" >
				
			</div>
		<?php else:?>
			<div id="chart_transactions" style="width:100%; max-width: 1500px; text-align: center; display:none;">
			<?php echo lang('Not available')?>		
			</div>
		<?php endif?>
		</div>
        </div>
    </div>
</div>
