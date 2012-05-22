<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/table.css" media="screen" />  
  <div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content" style="margin-left:50px;">
		<div class="red_h_sep"></div>
		<div class="title">
			<?php $payments_title = lang('Payment') ?>
			<span class="eutemia "><?php echo substr($payments_title,0,1)?></span><span class="helvetica "><?php echo substr($payments_title,1)?></span>
		</div>			
		<div style="float: left; width: 900px;">
			<table class="data display datatable">
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
		</div>
		<div class="title">
			<?php $payments_title = lang('Income Summary') ?>
			<span class="eutemia "><?php echo substr($payments_title,0,1)?></span><span class="helvetica "><?php echo substr($payments_title,1)?></span>
		</div>	
		<div style="float: left; width: 900px;">
			<table class="data display datatable">
				<thead>
					<tr>				
						<th style="width: 20%; white-space: nowrap;"><?php echo lang('Chat type') ?></th>
						<th style="width: 40%; white-space: nowrap;"><?php echo lang('Performer Amount') ?></th>
						<th style="width: 40%; white-space: nowrap;"><?php echo lang('Studio Amount') ?></th>
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
							<td>
								<?php if( ! SETTINGS_CURRENCY_TYPE):?>
									<?php echo print_amount_by_currency($line->studio_chips,TRUE)?>
								<?php else:?>
									<?php echo print_amount_by_currency($line->studio_chips,TRUE)?> (<?php echo sprintf(lang('%s chips'),$line->studio_chips)?>)
								<?php endif?>								
							</td>							
						</tr>
						<?php $i++?>
					<?php endforeach?>
				</tbody>
			</table>
		</div>
		<div class="title">
			<?php $payments_title = lang('Sessions') ?>
			<span class="eutemia "><?php echo substr($payments_title,0,1)?></span><span class="helvetica "><?php echo substr($payments_title,1)?></span>
		</div>	
		<div style="float: left; width: 900px;">
			<table class="data display datatable">
				<thead>
					<tr>
						<th style="width: 15%; white-space: nowrap;"><?php echo lang('Start date') ?></th>
						<th style="width: 15%; white-space: nowrap;"><?php echo lang('End date') ?></th>
						<th style="width: 12%; white-space: nowrap;"><?php echo lang('User') ?></th>
						<th style="width: 8%; white-space: nowrap;"><?php echo lang('Type') ?></th>
						<th style="width: 10%; white-space: nowrap;"><?php echo lang('Length') ?></th>
						<th style="width: 20%; white-space: nowrap;"><?php echo lang('Performer Earnings') ?></th>
						<th style="width: 20%; white-space: nowrap;"><?php echo lang('Studio Earnings') ?></th>
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
							<td>
								<?php if( ! SETTINGS_CURRENCY_TYPE):?>
									<?php echo print_amount_by_currency($watcher->studio_chips,TRUE)?>
								<?php else:?>
									<?php echo print_amount_by_currency($watcher->studio_chips,TRUE)?> (<?php echo sprintf(lang('%s chips'),$watcher->studio_chips)?>)
								<?php endif?>
							</td>
						</tr>
						<?php $i++?>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>			
		<div class="clear"></div>
		<div class="red_h_sep"></div>
		<div class="white_h_sep"></div>		
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>