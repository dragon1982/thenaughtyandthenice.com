
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
			
			document.location.href='<?php echo site_url('affiliates/ads/'.$affiliate->username)?>/'+ link;
			link = '';
			return false;
		});
		
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('affiliates/ads/'.$affiliate->username)?>';
		})
	});
	</script>

<div class="container">
				<div class="conthead">
					<?php $this->load->view('includes/affiliate_buttons')?>
				</div>

				<div id="observer">0</div> <!-- Daca se schimba in 1 atunci inseamna ca s-au facut modificari in iframe si se da reload la pagina -->
				
				<div class="contentbox">
					
					
					<?php
					if(isset($ad_zones) AND is_array($ad_zones) AND count($ad_zones) > 0) {
					?>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th class="sorting<?php echo ($order_by == 'id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/ads/<?php echo $affiliate->username?>/<?php echo $filters?>/id/<?php echo ($order_by == 'id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('ID')?></th>
								<th class="sorting<?php echo ($order_by == 'name') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/ads/<?php echo $affiliate->username?>/<?php echo $filters?>/name/<?php echo ($order_by == 'name' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Name')?></th>
								<th class="sorting<?php echo ($order_by == 'add_date') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/ads/<?php echo $affiliate->username?>/<?php echo $filters?>/add_date/<?php echo ($order_by == 'add_date' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Created date')?></th>
								<th class="sorting<?php echo ($order_by == 'type') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/ads/<?php echo $affiliate->username?>/<?php echo $filters?>/type/<?php echo ($order_by == 'type' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Type')?></th>
								<th class="sorting<?php echo ($order_by == 'views') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/ads/<?php echo $affiliate->username?>/<?php echo $filters?>/views/<?php echo ($order_by == 'views' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Views')?></th>
								<th class="sorting<?php echo ($order_by == 'hits') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/ads/<?php echo $affiliate->username?>/<?php echo $filters?>/hits/<?php echo ($order_by == 'hits' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Hits')?></th>
								<th class="sorting<?php echo ($order_by == 'registers') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/ads/<?php echo $affiliate->username?>/<?php echo $filters?>/registers/<?php echo ($order_by == 'registers' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Registers')?></th>
								<th class="sorting<?php echo ($order_by == 'earnings') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/ads/<?php echo $affiliate->username?>/<?php echo $filters?>/earnings/<?php echo ($order_by == 'earnings' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Earnings')?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = 1;
					foreach ($ad_zones as $ad_zone) {?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $ad_zone->id?></td>
								<td><?php echo $ad_zone->name?></td>
								<td><?php echo date('d M Y H:i' ,$ad_zone->add_date);?></td>
								<td><?php echo substr($ad_zone->type, 0, -2)?></td>
								<td><?php echo $ad_zone->views?></td>
								<td><?php echo $ad_zone->hits?></td>
								<td><?php echo $ad_zone->registers?></td>
								<td><?php echo $ad_zone->earnings?></td>
								
							</tr>
					<?php
						++$i;
					}?>
						</tbody>
					</table>
					<br />
					<?php
					} else {
						echo '<div style="text-align:center; width:100%; " class="clear"><h3>'.lang('Ads not found.').'</h3></div>';
					}
					?>
					<div class="extrabottom">
						<?php echo $pagination?>
						<div class="bulkactions">
						</div>
					</div>
				</div>

			</div>