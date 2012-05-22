<script type="text/javascript">
jQuery.validator.setDefaults({
	validClass:"success",
	errorElement: "span",
	errorPlacement: function(error, element) {
		error.appendTo($(element).next('span').next('span'));
	}
});
jQuery(function($){

	$.validator.addMethod("checkcat", function(value,element) {		
		if ($("input:checkbox:checked").length  > 0){			
            return true;
		}
        else
        {       
            return false;
        }
	}, "<?php echo lang('Please select a category!')?>");
	
	$(".register_performer").validate({
		success: function(label) {
	    	label.addClass("valid")
	   },
		rules: {
			cat: {
				checkcat: true
			}
		}, 
		messages: {
			cat: 					"<?php echo lang('Please select at least one category') ?>"
		},
		debug: false
	});
});
</script>	
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
		<div class="content">
			<div class="title">
				<?php $signup_step_3_title = lang('Signup step 3 - Select Category') ?>
				<span class="eutemia"><?php echo substr($signup_step_3_title,0,1)?></span><span class="helvetica"><?php echo substr($signup_step_3_title,1)?></span>
			</div>
			<?php echo form_open('register', 'class="register_performer"') ?>
			<div class="gray italic register_performer">
				<div>
					<label><span class="gray italic bold"><?php echo lang('Categories') ?>:</span></label>
					<?php if(sizeof($cat['main_categories']) > 0): ?>
						<ul style="list-style-type: none; display:inline-block; margin-top: 0px; ">
						<?php foreach($cat['main_categories'] as $main_category): ?>
							<li>
								<label>
								<?php echo form_checkbox('category[]', $main_category->id,set_checkbox('category',$main_category->id))?>
								<span class="gray italic bold"><?php echo $main_category->name ?></span>
								</label>
							</li>
							<?php if(sizeof($cat['sub_categories']) > 0 && isset($cat['sub_categories'][$main_category->id]) && sizeof($cat['sub_categories'][$main_category->id]) > 0):?>
								<li>
									<ul style="list-style-type: none; ">
										<?php foreach($cat['sub_categories'][$main_category->id] as $sub_category): ?>
											<li>
												<label>
												<?php echo  form_checkbox('category[]', $sub_category->id,set_checkbox('category',$sub_category->id))?>
												<span class="gray italic bold"><?php echo $sub_category->name ?></span>
												</label>
											</li>
										<?php endforeach?>
									</ul>
								</li>

							<?php endif ?>
						<?php endforeach ?>
						</ul>
					
					<?php endif ?>
					<?php echo form_hidden('cat',1) ?>
					<span class="error message" htmlfor="cat" style="vertical-align: top;" generated="true"><?php echo form_error('category')?></span>
				</div>
				<div style="margin-top:8px; text-align: left; padding-left:372px;">
					<button class="red"  type="submit" style="width:207px;"><?php echo lang('Continue') ?> </button><br/>
				</div>
				<div class="clear"></div>
			</div>
			<?php echo form_close()?>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>	