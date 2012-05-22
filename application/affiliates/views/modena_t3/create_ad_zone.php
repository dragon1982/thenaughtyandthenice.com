	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo assets_url()?>addons/colorpicker/css/colorpicker.css" />
	<script type="text/javascript" src="<?php echo assets_url()?>addons/colorpicker/js/colorpicker.js"></script>
    <script type="text/javascript" src="<?php echo assets_url()?>addons/colorpicker/js/eye.js"></script>

    <script type="text/javascript" src="<?php echo assets_url()?>addons/colorpicker/js/utils.js"></script>
    <script type="text/javascript" src="<?php echo assets_url()?>addons/colorpicker/js/layout.js?ver=1.0.2"></script>	
<?if(isset($ad_zone)){
	$ad_hash = $ad_zone->hash;	
}?>
<div class="black_box_bg_middle"><div class="black_box_bg_top">
<div class="black_box" style="height: 100%;">
		<script type="text/javascript">
			$(document).ready(function(){
				
				$('#promo_tools_type').change(function(){
					change_ifaffpt();
				});
				
				$('#category').change(function(){
					change_ifaffpt();
				});
				
				$('#performer_status').change(function(){
					change_ifaffpt();
				});
				
				
				setTimeout(change_ifaffpt, 300);
				
				
				function change_ifaffpt(){
					var selected_type = $('#promo_tools_type').val();
					var category_id = $('#category').val();;
					var performer_status = $('#performer_status').val();
					var dimensions = selected_type.split('x');
					var width = dimensions[0];
					var height = dimensions[1].split('/');
					var text_color = $('#text_color').val();
					var bg_color = $('#bg_color').val();
					var border_color = $('#border_color').val();
					text_color = text_color.split('#');
					$('#ifaffpt').attr({
						'src':'<?php echo main_url()?>/ads/promo/<?php echo $this->user->token ?>/'+category_id+'/'+dimensions[0]+'/'+dimensions[1]+'/'+text_color[1]+'/'+performer_status+'/<?php echo $ad_hash?>/1',
						'width':width,
						'height':height[0]
					})
					
				}
				
				var colorpicker_action_element = '';
				
				$('.colorSelector').click(function(){
					colorpicker_action_element = $(this).attr('id'); 
				});
				
				
				$('.colorSelector').ColorPicker({
					color: '#0000ff',
					onShow: function (colpkr) {
						$(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						$(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						$('#'+colorpicker_action_element).attr('value', '#' + hex);
						
						if(colorpicker_action_element == 'border_color'){
							$('#ifaffpt').css('border', 'solid 1px #' + hex);
						}else if(colorpicker_action_element == 'bg_color'){
							$('#ifaffpt').css('background', '#' + hex);
						}else if(colorpicker_action_element == 'text_color'){
							$('#ifaffpt').contents().find('a').css("color", '#' + hex);
						}
					}
				});			
			});
		</script>
		<div class="content">
			<?php 
			if(isset($page_title) && $page_title != ''):
				$first_char = substr($page_title, 0, 1);
				$rest_of_text = substr($page_title, 1);
			?>
				<div class="title">
					<span class="eutemia "><?php echo strtoupper($first_char) ?></span><span class="helvetica "><?php echo $rest_of_text ?></span>
				</div>
			
			<?php endif ?>				
			<div id="affiliate_promo">	
			<?php echo form_open('')?>
			<div class="gray italic register_performer" style="margin: 0px auto;width:500px;">
				
				
				<?php echo   form_hidden('ad_hash', $ad_hash)?>
				
				<!--  AD NAME -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Ad name')?>:</span></label>
					<?php echo 	form_input('name',  set_value('name', (isset($ad_zone))? $ad_zone->name : null), 'id="name"')?>
				</div>
				<!--  AD TYPE -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Ad size')?>:</span></label>
					<?php echo 	form_dropdown('ad_type', $promo_types,  set_value('ad_type', (isset($ad_zone))? $ad_zone->type : null), 'id="promo_tools_type"')?>
				</div>
				
				<!--  CATEGORY -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Category')?>:</span></label>
					<?php
					if(isset($ad_zone)){
						$category_link = $ad_zone->category_link;
					}else{
						$category_link = '';
					}
					if(is_array($categories['main_categories']) && count($categories['main_categories']) > 0){
						echo '<select name="category" id="category">';
						echo '<option value="0">'.lang('All').'</option>';
						foreach($categories['main_categories'] as $main_category){
							echo '<option value="'.$main_category->link.'"   '.($category_link == $main_category->link)? 'selected="selected"' : null .'>'.$main_category->name.'</option>';
							if(is_array($categories['sub_categories']) && is_array($categories['sub_categories'][$main_category->id]) && count($categories['sub_categories'][$main_category->id]) > 0){
								foreach($categories['sub_categories'][$main_category->id] as $sub_category){
									echo '<option value="'.$sub_category->link.'"  '.($category_link == $sub_category->link)? 'selected="selected"' : null .'>&nbsp;&nbsp;&nbsp;'.lang($sub_category->name).'</option>';
								}
							}
						}
						
						echo '</select>';
					}		
					
					?>
				</div>
				
				<!--  PERFORMERS STATUS -->
				<?
					if(isset($ad_zone)){
						$performers_status = $ad_zone->performers_status;
					}else{
						$performers_status  = '';
					}
				?>
				<div>
					<label><span class="gray italic bold"><?php echo lang('Performer status')?>:</span></label>
					<select name="performers_status" id="performer_status">
						<option value="all" <?=($performers_status == 'all')? 'selected="selected"' : null ?>><?php echo lang('All')?></option>
						<option value="true" <?=($performers_status == 'true')? 'selected="selected"' : null ?>><?php echo lang('Online')?></option>
						<option value="false" <?=($performers_status == 'false')? 'selected="selected"' : null ?>><?php echo lang('Offline')?></option>
					</select>
				</div>
				
				<!--  LINK LOCATION -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Link location')?>:</span></label>
					<?=  form_dropdown('link_location', $link_location, set_value('link_location', (isset($ad_zone))? $ad_zone->link_location : null), 'id="link_location"')?>
				</div>
				
				<!--  BORDER COLOR -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Border color')?>:</span></label>
					<?php echo form_input('border_color',set_value('border_color', (isset($ad_zone))? $ad_zone->border_color : '#999999'), 'readonly="readonly" id="border_color" class="colorSelector"')?>
				</div>
				
				<!--  BACKGROUND COLOR -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Background color')?>:</span></label>
					<?php echo form_input('bg_color',set_value('bg_color', (isset($ad_zone))? $ad_zone->bg_color : '#000000'), 'readonly="readonly" id="bg_color" class="colorSelector"')?>
				</div>
				
				<!--  TEXT COLOR -->
				<div>
					<label><span class="gray italic bold"><?php echo lang('Text color')?>:</span></label>
					<?php echo form_input('text_color',set_value('text_color', (isset($ad_zone))? $ad_zone->text_color : '#ffffff'), 'readonly="readonly" id="text_color" class="colorSelector"')?>
				</div>
				
				<br/>
				<!--  SUBMIT BUTTON -->
				<div style="margin-top:8px; margin-left:223px;">
					<button class="red"  type="submit" style="width:206px;"> <?php echo lang('Get code')?> </button><br/>
				</div>
			</div>
			<?php echo form_close()?>
			</div>	
			<div class="clear"></div>
			
			<!--  AD IFRAME -->
			<div style="width:auto; margin:0px auto; text-align: center;">
				<iframe id="ifaffpt" src="" style="border:solid 1px #999999; overflow:hidden"></iframe>
			</div>
			<div class="clear"></div>
			
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>	