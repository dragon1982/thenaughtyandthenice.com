<?php
        function dinamic_base_url() {
                $url = explode('index.php',$_SERVER['PHP_SELF']);
                return $url[0];
        }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>	
	<head>
		<title>ModenaCam Install - Step 4/5</title>
		<link rel="stylesheet" href="<?php echo dinamic_base_url();?>assets/install/install.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo dinamic_base_url();?>assets/install/widefat/widefat-gray-ultra-light.css" type="text/css" media="screen" />

		<!--[if IE 7]>
		<link href="<?php echo dinamic_base_url();?>assets/install/installie7.css" rel="stylesheet" type="text/css" />
		<![endif]-->
		<!--[if IE 8]>
		<link href="<?php echo dinamic_base_url();?>assets/install/installie8.css" rel="stylesheet" type="text/css" />
		<![endif]-->
	</head>
	<body>
		<script type="text/javascript" src="<?php echo dinamic_base_url();?>assets/install/js/wz_tooltip.js" charset="utf-8"></script>
		<script type="text/javascript" src="<?php echo dinamic_base_url();?>assets/install/js/jquery-1.4.2.min.js" charset="utf-8"></script>
		
		<div class="warper">
			<div class="titleSteps">ModenaCam Setup <span>4/5</span></div>
			<div class="pageTopBg">&nbsp;</div>
			<div class="pageBg">
				<h1>Settings</h1>
				<?php echo validation_errors()?>
				<?php echo form_open()?>
					<table cellpadding="0" cellspacing="10" style="margin: auto;">
						<tr>
							<td class="fieldName">Admin user</td>
							<td><?php echo form_input('admin_user',set_value('admin_user'),'class="field"')?>
							<td class="fieldDesc"></td>
						</tr>

						<tr>
							<td class="fieldName">Admin pass</td>
							<td><?php echo form_input('admin_pass',set_value('admin_pass'),'class="field"')?>
							<td class="fieldDesc"></td>
						</tr>

						<tr><td colspan=3">&nbsp;</td></tr>
						<tr>
							<td class="fieldName">Website title</td>
							<td><?php echo form_input('site_title',set_value('site_title'),'class="field"')?>
							<td class="fieldDesc"></td>
						</tr>

						<tr>
							<td class="fieldName">Website description</td>
							<td><?php echo form_input('site_description',set_value('site_description'),'class="field"')?>
							<td class="fieldDesc"></td>
						</tr>

						<tr>
							<td class="fieldName">Website license</td>
							<td><?php echo form_input('website_license',set_value('website_license','trial'),'class="field"')?>
							<td class="fieldDesc"></td>
						</tr>
						
						<tr><td colspan=3">&nbsp;</td></tr>
						
						<tr>
							<td class="fieldName">Support name</td>
							<td><?php echo form_input('support_name',set_value('support_name'),'class="field"')?>
							<td class="fieldDesc"></td>
						</tr>
					
						<tr>
							<td class="fieldName">Global email</td>
							<td><?php echo form_input('support_email',set_value('support_email'),'class="field"')?>														
							<td class="fieldDesc"></td>
						</tr>

						<tr>
							<td class="fieldName">Free chat limit not logged</td>
							<td><?php echo form_input('free_chat_limit_notlogged',set_value('free_chat_limit_notlogged',60),'class="field"')?>														
							<td class="fieldDesc">secconds</td>
						</tr>
						
						<tr>
							<td class="fieldName">Free chat limit logged no credits</td>
							<td><?php echo form_input('free_chat_limit_logged_no_credits',set_value('free_chat_limit_logged_no_credits',120),'class="field"')?>														
							<td class="fieldDesc">secconds</td>
						</tr>
						
						<tr>
							<td class="fieldName">Free chat limit logged with credits</td>
							<td><?php echo form_input('free_chat_limit_logged_with_credits',set_value('free_chat_limit_logged_with_credits',9999),'class="field"')?>														
							<td class="fieldDesc">secconds</td>
						</tr>
						
						<tr>
							<td class="fieldName">Minimum paid chat time</td>
							<td><?php echo form_input('minimum_paid_chat_time',set_value('minimum_paid_chat_time',60),'class="field"')?>														
							<td class="fieldDesc">secconds</td>
						</tr>																										
						<script type="text/javascript">
							jQuery(function($){
								$('#currency_type').change(function(){
									if( $(this).val() > 0 ){
										$('.currency').hide();
										$('.chips').show(); 
									} else {
										$('.currency').hide();
										$('#real').show();
									}
								});

								$('.curtype').change(function(){
									if( $(this).val() == 'other' ){
										$(".real_currency_other").show();
									} else {
										$(".real_currency_other").hide();
									} 
								});

								$('.curtype2').change(function(){
									if( $(this).val() == 'other' ){
										$(".real_currency_other2").show();
									} else {
										$(".real_currency_other2").hide();
									} 
								});
								
								if( $('#currency_type').val() > 0 ){
									$('.currency').hide();
									$('.chips').show(); 
								} else {
									$('.currency').hide();
									$('#real').show();
								}

								if( $('.curtype:checked').val() == 'other' ){
									$(".real_currency_other").show();
								} else {
									$(".real_currency_other").hide();
								} 

								if( $('.curtype2:checked').val() == 'other' ){
									$(".real_currency_other2").show();
								} else {
									$(".real_currency_other2").hide();
								} 
							});
						</script>
						<tr>
							<td class="fieldName">Currency type</td>
							<td><?php echo form_dropdown('currency_type',$currency_types,set_value('currency_type'),'class="field" id="currency_type"')?>
							<td class="fieldDesc">This value cannot be changed later!</td>																					
						</tr>		
						<tr class="currency" id="real" style="display:none">
							<td class="fieldName">Currency</td>
							<td>
								<?php echo form_radio('real_currency','dollars',set_radio('real_currency','dollars',TRUE),'class="rc curtype"')?><label class="fieldName">Dollars</label><br />
								<?php echo form_radio('real_currency','euros',set_radio('real_currency','euros',FALSE),'class="rc curtype"')?><label class="fieldName">Euros</label><br />
								<?php echo form_radio('real_currency','other',set_radio('real_currency','other',FALSE),'class="rc curtype"')?><label class="fieldName">Other</label>
								<table class="real_currency_other" style="display:inline">
									<tr>
										<td class="fieldName">Name</td>
										<td>
											<?php echo form_input('real_currency_other_name',set_value('real_currency_other_name','USD'),'class="rc field" style="width:100px;"')?>							
										</td>
									</tr>
									<tr>
										<td class="fieldName">Symbol</td>
										<td>
											<?php echo form_input('real_currency_other_symbol',set_value('real_currency_other_symbol','$'),'class="rc field" style="width:30px;"')?>							
										</td>
									</tr>
								</table>
							</td>													
							<td class="fieldDesc">This value cannot be changed later!</td>
						</tr>
						<tr class="currency chips" style="display:none">
							<td class="fieldName">Virtual currency</td>
							<td><?php echo form_input('chips_currency',set_value('chips_currency','chips'),'class="field"')?>														
							<td class="fieldDesc"></td>
						</tr>						
						<tr class="currency chips" style="display:none">
							<td class="fieldName">Chips per currency unit</td>
							<td><?php echo form_input('chips_per_currency',set_value('chips_per_currency'),'class="field"')?>														
							<td class="fieldDesc">This value cannot be changed later!</td>
						</tr>	
						<tr class="currency chips" style="display:none">
							<td class="fieldName">Payment currency</td>
							<td>
								<?php echo form_radio('real_currency_chips','dollars',set_radio('real_currency_chips','dollars',TRUE),'class="rc curtype2"')?><label class="fieldName">Dollars</label><br />
								<?php echo form_radio('real_currency_chips','euros',set_radio('real_currency_chips','euros',FALSE),'class="rc curtype2"')?><label class="fieldName">Euros</label><br />
								<?php echo form_radio('real_currency_chips','other',set_radio('real_currency_chips','other',FALSE),'class="rc curtype2"')?><label class="fieldName">Other</label>
								<table class="real_currency_other2" style="display:inline">
									<tr>
										<td class="fieldName">Name</td>
										<td>
											<?php echo form_input('real_currency_chips_other_name',set_value('real_currency_chips_other_name','USD'),'class="rc field" style="width:100px;"')?>							
										</td>
									</tr>
									<tr>
										<td class="fieldName">Symbol</td>
										<td>
											<?php echo form_input('real_currency_chips_other_symbol',set_value('real_currency_chips_other_symbol','$'),'class="rc field" style="width:30px;"')?>							
										</td>
									</tr>
								</table>
							</td>													
							<td class="fieldDesc">This value cannot be changed later!</td>
						</tr>																	
					</table> 
					<div class="btnDiv"><input type="submit" value="Continue"  class="blackBtn" /></div>
				<?php echo form_close()?>									
			</div>
			<div class="pageBottomBg">&nbsp;</div>
		</div>
	</body>
</html>