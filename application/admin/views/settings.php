<script type="text/javascript">
/*
 
	$('#cents_per_credit_div').ready(function() {
   		// do stuff when div is ready
   		hide_on_load();
 	});

	//daca currency-ul e euro sau dollar , ascunde campul cents_per_credit
	function hide_on_load() {
		if ($('#settings_site_currency').val() != 'chips') {
			$('#cents_per_credit_div').hide();
		}
	}
	
	function toggle_exchange_rate() {
		if ($('#settings_site_currency').val() == 'chips' && $('#cents_per_credit_div').is(":visible") == 0) {
			$('#cents_per_credit_div').slideDown();
		} else {
			$('#cents_per_credit_div').slideUp();
		}
	}
	
*/
</script>

<div class="container">
    <div class="conthead">
	<h2><?php echo lang('Settings')?></h2>
    </div>
    <div class="contentbox">
        <div class="center_contentbox">
			
			<?if(isset($disabledForm)) {?>
			<div style="color: #AE2727; font-weight: bold; margin-top: 7px;">
				<?php echo $err_msg?><br />
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					var limit = document.forms[0].elements.length;
					for (i=0;i<limit;i++) {
						document.forms[0].elements[i].disabled = true;
					}
				});
			</script>
			<?}?>
			

			<?php echo form_open('settings', 'class="admin_settings"')?>

					<?php $seps = 0 ?>
					<?php $diabled_sep_items = array(3=>1);?>
					<?php foreach($settings as $setting):?>
			
						<?php if(preg_match('/(separator)/i', $setting->name)):?>
			
							<?php $seps++?>
							<h2><?php echo lang($setting->title)?></h2>
							
						<?php elseif($setting->name == 'settings_default_theme'):?>
							
							<div class="inputboxes">
								<label for="<?php echo $setting->name?>"><?php echo lang($setting->title)?>: </label>
								<?php echo form_dropdown($setting->name, $themes, set_value($setting->name, $setting->value), 'id="'.$setting->name.'" class="inputbox"')?>
								<span class="description"><?php echo $setting->description?></span>
							</div>
							
						<?php else:?>
							
							<div class="inputboxes">
								<label for="<?php echo $setting->name?>"><?php echo lang($setting->title)?>: </label>
							
							<?php if($setting->type == 'boolean'):?>
								
								<?php $disabled = FALSE;?>
								<?php if($setting->name == 'memcache_enable'):?>
									
									<?php if(!(is_numeric(array_search('memcache', get_loaded_extensions()))) AND !(is_numeric(array_search('memcached', get_loaded_extensions()))) ):?>
									
										<?php $disabled = TRUE?>
										<?php $setting->description = lang('Memcache is not installed!')?>
								
									<?php endif?>
								
								<?php endif?>								
								
								<label for="<?php echo $setting->name?>_yes"><?php echo form_radio($setting->name, 1, $setting->value , 'id="'.$setting->name.'_yes" class="inputbox" style="width:50px; min-width:50px; margin-top:0px;" '.(( $disabled ) ? 'disabled="disabled"' : null))?> <?php echo lang('Yes') ?></label>
								<label for="<?php echo $setting->name?>_no"><?php echo form_radio($setting->name, 0,  !$setting->value, 'id="'.$setting->name.'_no" class="inputbox" style="width:50px; min-width:50px; margin-top:0px;" '.(( $disabled ) ? 'disabled="disabled"' : null))?> <?php echo lang('No') ?></label>
								
	
							
							<?php else:?>
							<?
								if(MEMCACHE_ENABLE AND $setting->name == 'memcache_host'):
									$Memcache = new Memcache();
									$Memcache->addserver(MEMCACHE_HOST, MEMCACHE_PORT);
									if(!@$Memcache->getVersion()):
										$setting->description = '<span style="color: red;">'.lang('Can\'t connect to Memcache server!').'</span>';
									else:
										$setting->description = '<span style="color: green;">'.lang('Successfully connected to Memcache server!').'</span>';
									endif;
								endif;
							?>
							<?php echo form_input($setting->name, set_value($setting->name, $setting->value), 'id="'.$setting->name.'" class="inputbox" '.((key_exists($seps,$diabled_sep_items))?'disabled="disabled"':NULL))?>
							<?php endif;?>
								
								<span class="description"><?php echo $setting->description?></span>
							</div>
						<?php endif;?>
					<?php endforeach;?>
					
			
			
			

          
            <input class="btn" id="submit" type="submit" name="submit" value="submit" tabindex="3" value="<?php echo lang('Update settings')?>" />
            <?php echo form_close()?>
        </div>
    </div>
</div>
