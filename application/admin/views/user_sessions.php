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
			
			document.location.href='<?php echo site_url('users/sessions/'.$user->username)?>/'+ link;
			link = '';
			return false;
		});
		
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('users/sessions/'.$user->username)?>';
		})
	});
	</script>

<div class="container">
				<div class="conthead">
					<?php $this->load->view('includes/user_buttons')?>
				</div>

				<div id="observer">0</div> <!-- Daca se schimba in 1 atunci inseamna ca s-au facut modificari in iframe si se da reload la pagina -->
				
				<div class="contentbox">
					
					<?php
					
					if(isset($sessions) AND is_array($sessions) AND count($sessions) > 0) {
					?>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th class="sorting<?php echo ($order_by == 'id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/id/<?php echo ($order_by == 'id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('ID')?></th>
								<th class="sorting<?php echo ($order_by == 'type') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/type/<?php echo ($order_by == 'type' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Chat type')?></th>
								<th class="sorting<?php echo ($order_by == 'start_date') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/start_date/<?php echo ($order_by == 'start_date' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Start date')?></th>
								<th class="sorting<?php echo ($order_by == 'end_date') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/end_date/<?php echo ($order_by == 'end_date' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('End date')?></th>
								<th class="sorting<?php echo ($order_by == 'duration') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/duration/<?php echo ($order_by == 'duration' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Length')?></th>
								<th class="sorting<?php echo ($order_by == 'ip') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/ip/<?php echo ($order_by == 'ip' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Ip')?></th>
								<th class="sorting<?php echo ($order_by == 'fee_per_minute') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/fee_per_minute/<?php echo ($order_by == 'fee_per_minute' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Price/minute')?></th>
								<th class="sorting<?php echo ($order_by == 'user_paid_chips') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/user_paid_chips/<?php echo ($order_by == 'user_paid_chips' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Total paid')?></th>
								<th class="sorting<?php echo ($order_by == 'site_chips') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/site_chips/<?php echo ($order_by == 'site_chips' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Site earning')?></th>
								<th class="sorting<?php echo ($order_by == 'studio_chips') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/studio_chips/<?php echo ($order_by == 'studio_chips' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Studio earning')?></th>
								<th class="sorting<?php echo ($order_by == 'performer_chips') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/performer_chips/<?php echo ($order_by == 'performer_chips' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Performer earning')?></th>
								<th class="sorting<?php echo ($order_by == 'performer_id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/performer_id/<?php echo ($order_by == 'performer_id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Performer id') ?></th>
								<th class="sorting<?php echo ($order_by == 'studio_id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/studio_id/<?php echo ($order_by == 'studio_id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Studio id') ?></th>
								<th class="sorting<?php echo ($order_by == 'performer_video_id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/sessions/<?php echo $user->username?>/performer_video_id/<?php echo ($order_by == 'performer_video_id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Video id') ?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = 1;
					foreach ($sessions as $session) {?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $session->id?></td>
								<td><?php echo lang($session->type)?></td>
								<td><?php echo date('d M Y H:i' ,$session->start_date);?></td>
								<td><?php echo date('d M Y H:i' ,$session->end_date);?></td>
								<td><?php echo sec2hms($session->duration);?></td>
								<td><?php echo long2ip($session->ip);?></td>
								<td><?php echo print_amount_by_currency($session->fee_per_minute);?></td>
								<td><?php echo print_amount_by_currency($session->user_paid_chips);?></td>
								<td><?php echo print_amount_by_currency($session->site_chips);?></td>
								<td><?php echo print_amount_by_currency($session->studio_chips);?></td>
								<td><?php echo print_amount_by_currency($session->performer_chips);?></td>
								<td><?php echo $session->performer_id;?></td>
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