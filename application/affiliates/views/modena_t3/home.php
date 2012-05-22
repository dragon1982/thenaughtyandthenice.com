<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<?php
		if (isset($page_title) && $page_title != ''):
			$first_char = substr($page_title, 0, 1);
			$rest_of_text = substr($page_title, 1);
			?>
			<div class="title">
				<span class="eutemia "><?php echo strtoupper($first_char) ?></span><span class="helvetica "><?php echo $rest_of_text ?></span>
			</div>

		<?php endif ?>	

		<div style="margin-left:30px;" class="f13 red italic">
			<p>	
				<?php $credits_red = '<span class="red">' . print_amount_by_currency($earning, TRUE) . '</span>' ?>
				<?php echo lang('Your account has').' '.$credits_red ?> <br/>
				<?php echo lang('Please send all users to this URL') ?>: <a href="<?php echo main_url('ads/0/1/' . $this->user->hash) ?>"><?php echo main_url('ads/0/1/' . $this->user->hash) ?></a><br/>
				<?php if($this->user->release < convert_chips_to_value($earning)):?>
					<div style="margin:5px;"><span><?php echo lang('You have been marked for payment.')?></span></div>
				<?php else: ?>
					<?php $need_more  = '<span class="red">' . print_amount_by_currency(convert_value_to_chips(abs($this->user->release - convert_chips_to_value($earning))), TRUE) . '</span>' ?>
					<div style="margin:5px;"><?php echo sprintf(lang('You need %s more and we\'ll send you the payment!'), $need_more)?></div>
				<?php endif; ?>
				
				<?php echo sprintf(lang('Your commission is %s from each transaction referred users do.'), SETTINGS_TRANSACTION_PERCENTAGE.'%') ?>
				<br/><br/>
			</p>
		</div>
		<div class="clear"></div>
			
			<script type="text/javascript" src="<?php echo assets_url() ?>js/jquery.strtotime.min.js"></script>
			<script type="text/javascript" src="<?php echo assets_url() ?>js/jquery.ui.datepicker.js"></script>
			<script type="text/javascript">
				$(function() {


					$( ".datepickerStart" ).datepicker({ maxDate: '<?php echo date('d-m-Y') ?>',  dateFormat: 'dd-mm-yy'});
					$( ".datepickerEnd" ).datepicker({ maxDate: '<?php echo date('d-m-Y') ?>',  dateFormat: 'dd-mm-yy'});


				});

				function show_chart(id){

					$('#statistics .displayed').hide();
					$('#chart_'+id).addClass('displayed');
					$('#chart_'+id).show();
				}	
			</script>
			<div style="float:right;margin-bottom: 10px;">
				<?php echo form_open(current_url()) ?>
				<label style="display:inline-block; "><?php echo lang('Start date') ?><br/><?php echo form_input("start_date", $start_date, 'class="datepickerStart" readonly="readonly"') ?></label>
				<label style="display:inline-block;"><?php echo lang('End date') ?><br/><?php echo form_input("end_date", $end_date, ' class="datepickerEnd"  readonly="readonly"') ?></label>
				<label style="display: inline-block; vertical-align: bottom; padding-bottom: 4px;"><input type="image" src="<?php echo assets_url() ?>images/icons/right_arrow.png"/></label>
				<?php echo form_close() ?>
			</div>

			<div class="clear"></div>
			<?php if ($chart_affiliates != ''): ?>	
			<script type="text/javascript" src="<?php echo assets_url() ?>js/highcharts/highcharts.src.js"></script>
			<script type="text/javascript" src="<?php echo assets_url() ?>js/highcharts/modules/exporting.js"></script>
			<script type="text/javascript" src="<?php echo assets_url() ?>js/highcharts/themes/gray.js"></script>
			<!-- Additional files for the Highslide popup effect -->
			<script type="text/javascript" src="<?php echo assets_url() ?>js/highcharts/highslide-full.min.js"></script>
			<script type="text/javascript" src="<?php echo assets_url() ?>js/highcharts/highslide.config.js" charset="utf-8"></script>
			<link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>css/highslide.css" />

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
							text: "<?php echo lang('Ads traffic statistics')?>"
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


			<div id="chart_affiliates"  style="width:100%; max-width: 960px;" >

			</div>
		<?php else:?>
			<div id="chart_affiliates" style="width:965px; text-align: center;">
			<?php echo lang('Not available')?>		
			</div>
		<?php endif ?>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>	

