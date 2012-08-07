<?php  $filter_array = $this->input->get('filters', TRUE); //pentru repopulare + XSS CLEAN
if(isset($filter_array['price_range'])) {
	$prices = explode('-', $filter_array['price_range'][0]);
	$min_price = $prices[0];
	$max_price = $prices[1];
}

if(isset($filter_array['age_range'])) {
	$ages = explode('-', $filter_array['age_range'][0]);
	$min_age = $ages[0];
	$max_age = $ages[1];
}
?>

	<script type="text/javascript" src="<?php echo assets_url()?>js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript">
		//Pentru timeout la search-uri
		var slide_timeout;
		var nick_timeout;

		function slide_finished(){
	       clearTimeout(slide_timeout);
	       slide_timeout = setTimeout('perform_ajax_request()',500);
		}

		function type_finished(){
		   clearTimeout(nick_timeout);
		   nick_timeout = setTimeout('perform_ajax_request()',750);
		}
		
		jQuery(function($){
			$( "#slider" ).slider({
				range: true,
				min: <?php echo MIN_PRIVATE_CHIPS_PRICE ?>,
				max: <?php echo MAX_PRIVATE_CHIPS_PRICE ?>,
				values: [ <?php echo isset($min_price)?$min_price:MIN_PRIVATE_CHIPS_PRICE ?>, <?php echo isset($max_price)?$max_price:MAX_PRIVATE_CHIPS_PRICE ?> ],
				slide: function( event, ui ) {
					$("#price" ).html(ui.values[ 0 ] + " <?php echo SETTINGS_SHOWN_CURRENCY?>" + " - " + ui.values[ 1 ] + " <?php echo SETTINGS_SHOWN_CURRENCY?>");
					$('#price_range').val(ui.values[ 0 ] + '-' + ui.values[ 1 ]);
					
					$('#price_min').html(ui.values[ 0 ]);
					$('#price_max').html(ui.values[ 1 ]);
					slide_finished();
				}
			});
			
			$( "#price" ).html($( "#slider" ).slider( "values", 0 ) + " <?php echo SETTINGS_SHOWN_CURRENCY?>" +
			" - " + $( "#slider" ).slider( "values", 1 ) + " <?php echo SETTINGS_SHOWN_CURRENCY?>");
			$('#price_range').val($( "#slider" ).slider( "values", 0 ) + '-' + $( "#slider" ).slider( "values", 1 ));

			$( "#age_slider" ).slider({
				range: true,
				min: 18,
				max: 50,
				values: [ <?php echo isset($min_age)?$min_age:'18' ?>, <?php echo isset($max_age)?$max_age:'50' ?> ],
				slide: function( event, ui ) {
					$("#age" ).html( ui.values[ 0 ] + " <?php echo lang('years') ?>" + " - " + ui.values[ 1 ] + " <?php echo lang('years')?>");
					$('#age_range').val(ui.values[ 0 ] + '-' + ui.values[ 1 ]);
					
					$('#age_min').html(ui.values[ 0 ]);
					$('#age_max').html(ui.values[ 1 ]);					
					slide_finished();
				},
			});
			
			$( "#age" ).html( $( "#age_slider" ).slider( "values", 0 ) + " <?php echo lang('years') ?>" +
			" - " + $( "#age_slider" ).slider( "values", 1 ) + " <?php echo lang('years') ?>");
			$('#age_range').val($( "#age_slider" ).slider( "values", 0 ) + '-' + $( "#age_slider" ).slider( "values", 1 ));


			//AJAX SEARCH 
/* 			$(window).load(function() {
				$('#search-input-field').keyup(function() {
					if($('#search-input-field').val().length >= 3 || $('#search-input-field').val().length == 0) {
						type_finished();
					}
				});
					
			    $('#form_search').submit(function() {
			    	perform_ajax_request();
			        return false;
			    });

			    $('#form_search :input:not(input[type=text])').change(function() {
				    perform_ajax_request();
			    });
			    

			}); */

		});
		
		function toggle_advanced() {
			$('.advanced_search').css('height', $('.advanced_search').height() + 'px');
			$('.advanced_search').slideToggle(1000);
		}

		function perform_ajax_request() {
			if($('#search-input-field').val().length >= 3 || $('#search-input-field').val().length == 0) {
				$.ajax({
		        	url: "<?php echo site_url('performers/search')?>?" + $('#form_search').serialize(),
		            type: 'get',
		            dataType: "html",
		            success: function(text) {
			                	$('#performer_list').html(text);
		            }
		        });
			}
		}

		function get_ajax_page(element) {
			$.ajax({
	        	url: element.href,
	            type: 'get',
	            dataType: "html",
	            success: function(text) {
		                	$('#performer_list').html(text);
	            }
	    	});
		}

		function reset_form() {
			document.getElementById('form_search').reset();
			$( "#price" ).html(<?php echo MIN_PRIVATE_CHIPS_PRICE ?> + " <?php echo SETTINGS_SHOWN_CURRENCY?>" +
					" -  " + <?php echo MAX_PRIVATE_CHIPS_PRICE ?> + " <?php echo SETTINGS_SHOWN_CURRENCY?>");
					$('#price_range').val('<?php echo MIN_PRIVATE_CHIPS_PRICE ?>-<?php echo MAX_PRIVATE_CHIPS_PRICE ?>');
			$( "#age" ).html( "0 <?php echo lang('years') ?>" +
					" - " + "50 <?php echo lang('years') ?>");
					$('#age_range').val('18-50');
			$("#slider").slider("values",0 , $("#slider").slider("option", "min") );
			$("#slider").slider("values",1 , $("#slider").slider("option", "max") );
			$("#age_slider").slider("values",0 , $("#age_slider").slider("option", "min") );
			$("#age_slider").slider("values",1 , $("#age_slider").slider("option", "max") );
			perform_ajax_request();
		}
		
	</script>
	
<?php
$this->db->select('count(*) AS online_performers', FALSE);
$this->db->select('is_online', 1);
$query = $this->db->get('performers');
$online_performers = $query->row()->online_performers;
?>

	
<div class="box-header clearfix">
	<h1 class="left box-title-1">
		<a href="<?php echo site_url()?>">
			<span class="girls-no"><?php echo $online_performers?></span> <img src="<?php echo assets_url()?>images/title-models-online.png" alt="Models Online now">
		</a>
	</h1>

	<ul class="tabs-t1 left set-tabs-pos">
		<li <?php if($sort=='most_viewed'): ?>class="selected"<?php endif; ?>><a href="<?php echo site_url('?sort=most_viewed')?>">Most viewed </a></li>
		<li <?php if($sort=='newest'): ?>class="selected"<?php endif; ?>><a href="<?php echo site_url('?sort=newest')?>">Newest</a></li>
		<li <?php if($sort=='score'): ?>class="selected"<?php endif; ?>><a href="<?php echo site_url('?sort=score')?>">Cam score</a></li>
	</ul>	
	
	<?php echo form_open('', array('method' => 'get', 'id' => 'form_search', 'class' => 'search clearfix'))?>

		<div class="search-input"><input id="search-input-field" type="text" name="filters[nickname][]" value="<?php echo isset($filter_array['nickname'])?$filter_array['nickname'][0]:''?>"/></div>
		<div class="search-submit"><input type="submit" id="search_submit" value =''/></div>
		<?php if($this->user->id > 0):?>
			<div class="btn-advanced-search"><a href="javascript:;" id="adv_search"  onclick="javascript:toggle_advanced(); return false;"><!-- --></a></div>
		<?php endif;?>	
</div><!--end box-header-->	

	<?php if($this->user->id > 0):?>                

					   
		<div class="advanced_search" style=" display: block;">
				<div class="box-header clearfix">
					<div class="advanced_search_container clearfix">	
					
						<div class="advanced-search-head">
						 <img src="<?php echo assets_url()?>images/title-advanced-search.png" alt="Advanced search">
						</div>
					
						<div class="sliders">
							<div class="search-dragger-item">
								 <div class="clearfix search-dragger-label">
									<div class=""><?php echo lang('Price') ?></div>  
								</div>
								<div class="search-dragger">
									<div class="clearfix">
										<div id="price_min" class="left no-label"><?php echo isset($min_price)?$min_price:MIN_PRIVATE_CHIPS_PRICE ?></div>
										<div id="price_max" class="right no-label"><?php echo isset($max_price)?$max_price:MAX_PRIVATE_CHIPS_PRICE ?> </div>
									</div>
									<div id="slider"></div>
								</div><!--end dragger-->
							</div><!--end search-dragger-item-->			
							
							<div class="search-dragger-item">
								 <div class="clearfix search-dragger-label">
									<div class=""><?php echo lang('Age') ?></div>  
								</div>
								<div class="search-dragger">
									<div class="clearfix">
										<div id="age_min" class="left no-label"><?php echo isset($min_age)?$min_age:'18' ?></div>
										<div id="age_max" class="right no-label"><?php echo isset($max_age)?$max_age:'50' ?></div>
									</div>
									<div id="age_slider"></div>
								</div><!--end dragger-->
							</div><!--end search-dragger-item-->		
						</div>	
						
						<input type="hidden" value="" id="price_range" name="filters[price_range][]"/>
						<input type="hidden" value="" id="age_range" name="filters[age_range][]"/>
						<?php echo form_dropdown('filters[category][]', 			$category,				set_value('filters[category][]',			isset($filter_array['category']) ?			$filter_array['category'][0]			:''))?>
						<?php echo form_dropdown('filters[gender][]', 				$gender,				set_value('filters[gender][]',				isset($filter_array['gender'])	 ?			$filter_array['gender'][0]				:''))?>
						<?php echo form_dropdown('filters[sexual_prefference][]',	$sexual_prefference,	set_value('filters[sexual_prefference][]',	isset($filter_array['sexual_prefference']) ?$filter_array['sexual_prefference'][0]	:''))?>
						<?php echo form_dropdown('filters[ethnicity][]', 			$ethnicity,				set_value('filters[ethnicity][]',			isset($filter_array['ethnicity']) ?			$filter_array['ethnicity'][0]			:''))?>
						<?php echo form_dropdown('filters[language][]', 			$language,				set_value('filters[language][]',			isset($filter_array['language']) ?			$filter_array['language'][0]			:''))?>
						<?php echo form_dropdown('filters[height][]', 				$height,				set_value('filters[height][]',				isset($filter_array['height']) ?			$filter_array['height'][0]				:''))?>
						<?php echo form_dropdown('filters[weight][]', 				$weight,				set_value('filters[weight][]',				isset($filter_array['weight']) ?			$filter_array['weight'][0]				:''))?>
						<?php echo form_dropdown('filters[build][]', 				$build,					set_value('filters[build][]',				isset($filter_array['build']) ?				$filter_array['build'][0]				:''))?>
						<?php echo form_dropdown('filters[eye_color][]', 			$eye_color,				set_value('filters[eye_color][]',			isset($filter_array['eye_color']) ?			$filter_array['eye_color'][0]			:''))?>
						<?php echo form_dropdown('filters[hair_color][]', 			$hair_color,			set_value('filters[hair_color][]',			isset($filter_array['hair_color']) ?		$filter_array['hair_color'][0]			:''))?>
						<?php echo form_dropdown('filters[hair_length][]', 			$hair_length,			set_value('filters[hair_length][]',			isset($filter_array['hair_length']) ?		$filter_array['hair_length'][0]			:''))?>
						<div class="adv_search_pos">
							<input type="submit" value="<?php echo lang('Search') ?>" class="btn-nice-1" id="search_submit"/>
							<button class="btn-nice-2" onclick="javascript:reset_form(); return false;"><?php echo lang('Reset') ?></button><span class="submit_r"></span>
						</div>
					
					</div>
				</div>
				
		</div>
	<?php endif;?>
	<?php echo form_close()?>

