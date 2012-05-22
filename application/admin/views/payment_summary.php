	
<script type="text/javascript">
	$(document).ready(function(){
		var link = '';
		var i = 0;
		$('#filters').submit(function(){
			$('#filters').find('p').each(function(){


				$(this).find('input').each(function(){
					if($(this).attr('name').toLowerCase() != $(this).val().toLowerCase() && $(this).attr('type') != 'submit' && $(this).val() != ''){
						if(i > 0){
							link += '&';
						}
						link += $(this).attr('name') + ':' +$(this).val();
						i++;
					}
				});

				$(this).find('select').each(function(){
					if($(this).attr('name').toLowerCase() != $(this).val().toLowerCase()){
						if(i > 0){
							link += '&';
						}
						link += $(this).attr('name') + ':' +$(this).val();
						i++;
					}
				});

				
			});

			if(!link){
				link = '0';
			}
			
			document.location.href='<?php echo site_url('to_pay')?>/'+ link;
			link = '';
			return false;
		});
		
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('to_pay')?>';
		})
		
		
		
		$('.payment_status').change(function(){
			var payment_id = $(this).attr('paymentId');
			var payment_status = $(this).val();
			var parrent = $(this).parent();
			var elem = $(this);
			elem.attr('disabled', 'disabled');
			var old_status = elem.attr('status');
			
			
			parrent.find('span.loader').show();
			
			 $.ajax({
				url: '<?php echo site_url('to_pay/update_status')?>',
				type: 'post',
				data: {
					id: payment_id,
					status: payment_status,
					ci_csrf_token: '<?php echo $this->security->_csrf_hash?>'                
				},
				success: function(data) {
					
					
					if(data == 'succes'){
						parrent.find('.loader').hide();
						parrent.find('.ok').show();
						setTimeout(function(){
							parrent.find('.ok').hide();
							elem.removeAttr('disabled');
						}, 3000);
					}
					
					if(data == 'error'){
						parrent.find('.loader').hide();
						parrent.find('.error_ajax').show();
						setTimeout(function(){
							parrent.find('.error_ajax').hide();
							elem.removeAttr('disabled');
							elem.val(old_status);
						}, 3000);
					}
					
				}
			});
			
		});
	});
	</script>

			<div class="container">
				<div class="conthead">
					<h2><?php echo lang('Payment Summary')?></h2>
				</div>

				<div class="contentbox">
					<div style="text-align:center; width:100%;  margin-top:30px;" class="clear"><h3><?php echo lang('Payment')?></h3></div>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th style="width: 12%; white-space: nowrap;"><?php echo lang('Performer ID')?></th>
								<th style="width: 15%; white-space: nowrap;"><?php echo lang('Username')?></th>
								<th style="width: 15%; white-space: nowrap;"><?php echo lang('Nickname')?></th>
								<th style="width: 16%; white-space: nowrap;"><?php echo lang('Payment Date')?></th>
								<th style="width: 22%; white-space: nowrap;"><?php echo lang('Interval')?></th>
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Amount')?></th>
							</tr>
						</thead>
						<tbody style="text-align: center;">
							<tr class="even">
								<td><?php echo $performer->id?></td>
								<td><?php echo $performer->username?></td>
								<td><?php echo $performer->nickname?></td>
								<td><?php echo date('Y-m-d', $payment->paid_date) ?></td>
								<td><?php echo date('Y-m-d', $payment->from_date)?> - <?php echo date('Y-m-d', $payment->to_date)?></td>
								<td>
									<?php if( ! SETTINGS_CURRENCY_TYPE):?>
										<?php echo print_amount_by_currency($payment->amount_chips,TRUE)?>
									<?php else:?>
										<?php echo print_amount_by_currency($payment->amount_chips,TRUE)?> (<?php echo sprintf(lang('%s chips'),$payment->amount_chips)?>)
									<?php endif?>						
								</td>
							</tr>
						</tbody>
					</table>
					
					
					<div style="text-align:center; width:100%;  margin-top:30px;" class="clear"><h3><?php echo lang('Income Summary')?></h3></div>
					
					
					
					<table width="100%" border="0">
						<thead>
							<tr>				
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Chat type') ?></th>
								<th style="width: 40%; white-space: nowrap;"><?php echo lang('Performer Amount') ?></th>
								<?if($performer->studio_id > 0){?>
								<th style="width: 40%; white-space: nowrap;"><?php echo lang('Studio Amount') ?></th>
								<?}?>
							</tr>
						</thead>
						<tbody style="text-align: center;">
							<?php $i = 0?>								
							<?php foreach($summary as $line):?>
								<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">
									<td><?php echo lang($line->type)?></td>
									<td>
										<?php if( ! SETTINGS_CURRENCY_TYPE):?>
											<?php echo print_amount_by_currency($line->performer_chips,TRUE)?>
										<?php else:?>
											<?php echo print_amount_by_currency($line->performer_chips,TRUE)?> (<?php echo sprintf(lang('%s chips'),$line->performer_chips)?>)
										<?php endif?>								
									</td>
									<?if($performer->studio_id > 0){?>
									<td>
										<?php if( ! SETTINGS_CURRENCY_TYPE):?>
											<?php echo print_amount_by_currency($line->studio_chips,TRUE)?>
										<?php else:?>
											<?php echo print_amount_by_currency($line->studio_chips,TRUE)?> (<?php echo sprintf(lang('%s chips'),$line->studio_chips)?>)
										<?php endif?>								
									</td>							
									<?}?>
								</tr>
								<?php $i++?>
							<?php endforeach?>
						</tbody>
					</table>
					
					<div style="text-align:center; width:100%; margin-top:30px;" class="clear"><h3><?php echo lang('Sessions')?></h3></div>
			
					<table width="100%" border="0">
						<thead>
							<tr>
								<th style="width: 15%; white-space: nowrap;"><?php echo lang('Start date') ?></th>
								<th style="width: 15%; white-space: nowrap;"><?php echo lang('End date') ?></th>
								<th style="width: 12%; white-space: nowrap;"><?php echo lang('User') ?></th>
								<th style="width: 8%; white-space: nowrap;"><?php echo lang('Type') ?></th>
								<th style="width: 10%; white-space: nowrap;"><?php echo lang('Length') ?></th>
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Performer Earnings') ?></th>
								<?if($performer->studio_id > 0){?>
								<th style="width: 20%; white-space: nowrap;"><?php echo lang('Studio Earnings') ?></th>
								<?}?>
							</tr>
						</thead>
						<tbody style="text-align: center;">
							<?php $i = 0?>
							<?php foreach($watchers as $watcher ):?>
								<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">						
									<td><?php echo date('Y-m-d H:i:s',$watcher->start_date)?></td>
									<td><?php echo date('Y-m-d H:i:s',$watcher->end_date)?></td>
									<td><?php echo $watcher->username ?></td>
									<td><?php echo lang($watcher->type)?></td>
									<td><?php echo ($watcher->duration)?sec2hms($watcher->duration):'N/A'?></td>
									<td>
										<?php if( ! SETTINGS_CURRENCY_TYPE):?>
											<?php echo print_amount_by_currency($watcher->performer_chips,TRUE)?>
										<?php else:?>
											<?php echo print_amount_by_currency($watcher->performer_chips,TRUE)?> (<?php echo sprintf(lang('%s chips'),$watcher->performer_chips)?>)
										<?php endif?>
									</td>	
									<?if($performer->studio_id > 0){?>
									<td>
										<?php if( ! SETTINGS_CURRENCY_TYPE):?>
											<?php echo print_amount_by_currency($watcher->studio_chips,TRUE)?>
										<?php else:?>
											<?php echo print_amount_by_currency($watcher->studio_chips,TRUE)?> (<?php echo sprintf(lang('%s chips'),$watcher->studio_chips)?>)
										<?php endif?>
									</td>
									<?}?>
								</tr>
								<?php $i++?>
							<?php endforeach;?>
						</tbody>
					</table>
						
					
					<div class="extrabottom">
						<div class="bulkactions">
						</div>
					</div>
				</div>

			</div>


