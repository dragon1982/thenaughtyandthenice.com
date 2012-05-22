<script type="text/javascript">
	$(document).ready(function(){		
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('performers/sessions/'.$performer->username)?>';
		})
	});
	</script>

<div class="container">
				<div class="conthead">
					<?php $this->load->view('includes/edit_buttons')?>
				</div>

				<div id="observer">0</div> <!-- Daca se schimba in 1 atunci inseamna ca s-au facut modificari in iframe si se da reload la pagina -->
				
				<div class="contentbox">
					<div class="bulkactions" style="margin-bottom: 10px;">
						<form action="" id="filters" name="filters" method="GET">
							<p style="float:left; margin-right:10px;">
								&nbsp;<?php echo lang('Period')?><br/>
								<?php echo form_dropdown('period', $payments,(isset($filters['filter_id']) ? $filters['filter_id'] : FALSE ), 'class="inputbox" style="min-width:150px;"')?>
							</p>
							<p style="float:left; margin-right:10px;">
								&nbsp;<?php echo lang('Chat type')?><br/>
								<?php echo form_dropdown('type', $this->types,(isset($filters['type']) ? $filters['type'] : FALSE ), 'class="inputbox" style="min-width:150px;"')?>					
							</p>
							<p style="float:left; margin-right:10px;">
								&nbsp;<br/>
								<input type="submit" class="btn" value="Apply Filter" style="margin-top:0px;" />
								<?php echo (is_array($filters_array) && count($filters_array) > 0) ? '<input type="button" id="reset_filters" class="btn" value="Reset Filters" style="margin-top:0px;" />' : null?>
							</p>
						</form>
					</div>					
					<?php
					
					if(isset($sessions) AND is_array($sessions) AND count($sessions) > 0) {
					?>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th class="sorting<?php echo ($order_by == 'id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/id/<?php echo ($order_by == 'id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('ID')?></th>
								<th class="sorting<?php echo ($order_by == 'type') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/type/<?php echo ($order_by == 'type' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Chat type')?></th>
								<th class="sorting<?php echo ($order_by == 'start_date') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/start_date/<?php echo ($order_by == 'start_date' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Start date')?></th>
								<th class="sorting<?php echo ($order_by == 'end_date') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/end_date/<?php echo ($order_by == 'end_date' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('End date')?></th>
								<th class="sorting<?php echo ($order_by == 'duration') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/duration/<?php echo ($order_by == 'duration' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Length')?></th>
								<th class="sorting<?php echo ($order_by == 'ip') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/ip/<?php echo ($order_by == 'ip' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Ip')?></th>
								<th class="sorting<?php echo ($order_by == 'fee_per_minute') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/fee_per_minute/<?php echo ($order_by == 'fee_per_minute' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Price/minute')?></th>
								<th class="sorting<?php echo ($order_by == 'user_paid_chips') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/user_paid_chips/<?php echo ($order_by == 'user_paid_chips' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Total paid')?></th>
								<th class="sorting<?php echo ($order_by == 'site_chips') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/site_chips/<?php echo ($order_by == 'site_chips' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Site earning')?></th>
								<th class="sorting<?php echo ($order_by == 'studio_chips') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/studio_chips/<?php echo ($order_by == 'studio_chips' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Studio earning')?></th>
								<th class="sorting<?php echo ($order_by == 'performer_chips') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/performer_chips/<?php echo ($order_by == 'performer_chips' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Performer earning')?></th>
								<th class="sorting<?php echo ($order_by == 'user_id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/user_id/<?php echo ($order_by == 'user_id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('User id') ?></th>
								<th class="sorting<?php echo ($order_by == 'studio_id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/studio_id/<?php echo ($order_by == 'studio_id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Studio id') ?></th>
								<th class="sorting<?php echo ($order_by == 'performer_video_id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>performers/sessions/<?php echo $performer->username?>/performer_video_id/<?php echo ($order_by == 'performer_video_id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Video id') ?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = 1;
					foreach ($sessions as $session) {?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $session->id?></td>
								<td><?php echo $session->type?></td>
								<td><?php echo date('d M Y H:i' ,$session->start_date);?></td>
								<td><?php echo date('d M Y H:i' ,$session->end_date);?></td>
								<td><?php echo sec2hms($session->duration);?></td>
								<td><?php echo long2ip($session->ip);?></td>
								<td><?php echo print_amount_by_currency($session->fee_per_minute);?></td>
								<td><?php echo print_amount_by_currency($session->user_paid_chips);?></td>
								<td><?php echo print_amount_by_currency($session->site_chips);?></td>
								<td><?php echo print_amount_by_currency($session->studio_chips);?></td>
								<td><?php echo print_amount_by_currency($session->performer_chips);?></td>
								<td><?php echo $session->user_id;?></td>
								<td><?php echo $session->studio_id;?></td>
								<td><?php echo $session->performer_video_id;?></td>
							</tr>
					<?php
						++$i;
					}?>
						</tbody>
					</table>
					<br />
					<?php
					} else {
						echo '<div style="text-align:center; width:100%; " class="clear"><h3>'.lang('Sessions not found.').'</h3></div>';
					}
					?>
					<div class="extrabottom">
						<?php echo $pagination?>
						<div class="bulkactions">
						</div>
					</div>
				</div>

			</div>