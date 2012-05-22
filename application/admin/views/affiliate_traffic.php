
<script type="text/javascript">
$(document).ready(function(){
	var link = '';
	var i = 0;
	$('#filters').submit(function(){
		$('#filters').find('p').each(function(){


			$(this).find('input').each(function(){
				if($(this).attr('name').toLowerCase() != $(this).val().toLowerCase() && $(this).attr('type') != 'submit' && $(this).val() != ''){
					if(i > 0){
						link += '/';
					}
					link += $(this).val();
					i++;
				}
			});


			
		});

		if(!link){
			link = '0';
		}
		
		document.location.href='<?php echo site_url('affiliates/traffic/'.$affiliate->username)?>/'+ link;
		link = '';
		return false;
	});
	
});
</script>

<div class="container">
				<div class="conthead">
					<?php $this->load->view('includes/affiliate_buttons')?>
				</div>

				
				<div class="contentbox">
					<div class="bulkactions" style="margin-bottom: 10px;">
			<form action="" id="filters" name="filters">
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('Start date')?><br/>
					<?=form_input('start_date', (isset($start_date)) ? date('Y-m-d',$start_date) : FALSE, 'class="inputbox datepicker" readonly="readonly" style="min-width:150px;"')?>
				</p>
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('End date')?><br/>
					<?=form_input('end_date', (isset($end_date)) ? date('Y-m-d', $end_date) : FALSE, 'class="inputbox datepicker" readonly="readonly" style="min-width:150px;"')?>
				</p>
				
				<p style="float:left; margin-right:10px;">
					&nbsp;<br/>
					<input type="submit" class="btn" value="Apply Filter" style="margin-top:0px;" />
				</p>
			</form>

		</div>
					
					<?php
					if(isset($ad_zones) AND is_array($ad_zones) AND count($ad_zones) > 0) {
					?>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th><?php echo lang('Name')?></th>
								<th><?php echo lang('Views')?></th>
								<th><?php echo lang('Hits')?></th>
								<th><?php echo lang('Registers')?></th>
								<th><?php echo lang('Transactions') ?></th>
								<th><?php echo lang('Earnings') ?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = 1;
					foreach ($ad_zones as $ad_zone) {?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $ad_zone->name?></td>
								<td><?php echo (isset($ad_zone->view)) ? $ad_zone->view : '0'?></td>
								<td><?php echo (isset($ad_zone->hit)) ? $ad_zone->hit : '0'?></td>
								<td><a href="<?php echo site_url('affiliates/signups/'.$affiliate->username)?>"><?php echo (isset($ad_zone->register)) ? $ad_zone->register : '0'?></a></td>
								<td><?php echo (isset($ad_zone->transaction)) ? $ad_zone->transaction : '0'?></td>
								<td><?php echo print_amount_by_currency($ad_zone->earnings)?></td>

							</tr>
					<?php
						++$i;
					}?>
						</tbody>
					</table>
					<br />
					<?php
					} else {
						echo '<div style="text-align:center; width:100%; " class="clear"><h3>'.lang('No traffic found.').'</h3></div>';
					}
					?>
					<div class="extrabottom">
						<div class="bulkactions">
						</div>
					</div>
				</div>

			</div>