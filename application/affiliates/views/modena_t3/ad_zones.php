<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/table.css" media="screen" />  
<div class="black_box_bg_middle"><div class="black_box_bg_top">
	<div class="black_box" style="height: 100%;">
		<div class="content">
			<?php if(isset($page_title) && $page_title != ''):
				$first_char = substr($page_title, 0, 1);
				$rest_of_text = substr($page_title, 1);
				?>
				<div class="title">
					<span class="eutemia "><?php echo strtoupper($first_char)?></span><span class="helvetica "><?php echo $rest_of_text?></span>
				</div>			
			<?php endif?>
			<div>
				
				<div style="margin-bottom:8px; text-align: right;">
					<button class="red"  onclick="document.location.href='<?php echo site_url('promo/create_ad_zone')?>'" style="width:200px;"> <?php echo lang('Create new ad zone')?> </button><br/>
				</div>
				<table cellspacing="0" cellpadding="0" style="width:100%;" class="data display datatable">
					<thead>
						<tr>
							<th style="white-space: nowrap; text-align: left;"><?php echo lang('Name')?></th>
							<th style="width: 150px; white-space: nowrap; text-align: left;"><?php echo lang('Create date')?></th>
							<th style="width: 100px; white-space: nowrap; text-align: left;"><?php echo lang('Type')?></th>
							<th style="width: 100px; white-space: nowrap; text-align: left;"><?php echo lang('Earnings')?></th>
							<th style="width: 150px; white-space: nowrap; "><?php echo lang('Action')?></th>
						</tr>
					</thead>
					<tbody>
				<?php if(sizeof($ad_zones) == 0):?>
					<tr>
						<td colspan="5"><?php echo lang('There are no ads.')?></td>
					</tr>
				<?php else: 
					foreach($ad_zones as $ad_zone):?>
						<tr>
							<td><?php echo $ad_zone->name?></td>
							<td><?php echo date('d M Y H:i', $ad_zone->add_date)?></td>
							<td><?php echo substr($ad_zone->type, 0, -2)?></td>
							<td><?php echo print_amount_by_currency($ad_zone->earnings, TRUE)?></td>
							<td>
								<a href="<?php echo site_url('promo/get_code/' . $ad_zone->hash)?>"><?php echo lang('get code')?></a>
								&nbsp;&nbsp;|&nbsp;&nbsp;
								<a href="<?php echo site_url('promo/edit_ad_zone/' . $ad_zone->id)?>"><?php echo lang('edit')?></a>
								&nbsp;&nbsp;|&nbsp;&nbsp;
								<a href="<?php echo site_url('promo/delete/' . $ad_zone->id)?>"><?php echo lang('delete')?></a>
							</td>
						</tr>
						<?php
					endforeach;
				endif?>
					</tbody>
				</table>
			
				<div style="margin-top:8px; text-align: right;">
					<button class="red"  onclick="document.location.href='<?php echo site_url('promo/create_ad_zone')?>'" style="width:200px;"> <?php echo lang('Create new ad zone')?> </button><br/>
				</div>
			</div>	
			<div class="clear"></div>
		</div>
	</div>
</div></div><div class="black_box_bg_bottom"></div>		