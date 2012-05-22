
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
			
			document.location.href='<?php echo site_url('affiliates/payments/'.$affiliate->username)?>/'+ link;
			link = '';
			return false;
		});
		
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('affiliates/payments/'.$affiliate->username)?>';
		})
		$(".payments_info").fancybox({
				'transitionIn' : 'none',
				'transitionOut' : 'none'
		}); 
	});
	</script>

<div class="container">
				<div class="conthead">
					<?php $this->load->view('includes/affiliate_buttons')?>
				</div>

				<div id="observer">0</div> <!-- Daca se schimba in 1 atunci inseamna ca s-au facut modificari in iframe si se da reload la pagina -->
				
				<div class="contentbox">
					
					
					<?php
					if(isset($users) AND is_array($users) AND count($users) > 0) {
					?>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th class="sorting<?php echo ($order_by == 'id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/signups/<?php echo $affiliate->username?>/<?php echo $filters?>/id/<?php echo ($order_by == 'id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('ID')?></th>
								<th class="sorting<?php echo ($order_by == 'country') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/signups/<?php echo $affiliate->username?>/<?php echo $filters?>/country/<?php echo ($order_by == 'country' && $order_type == 'asc') ? 'desc' : 'asc'?>';"></th>
								<th class="sorting<?php echo ($order_by == 'username') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/signups/<?php echo $affiliate->username?>/<?php echo $filters?>/username/<?php echo ($order_by == 'username' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Username')?></th>
								<th class="sorting<?php echo ($order_by == 'email') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/signups/<?php echo $affiliate->username?>/<?php echo $filters?>/email/<?php echo ($order_by == 'email' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Email')?></th>
								<th class="sorting<?php echo ($order_by == 'credits') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>affiliates/signups/<?php echo $affiliate->username?>/<?php echo $filters?>/credits/<?php echo ($order_by == 'credits' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Balance') ?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = 1;
					foreach ($users as $user) {?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $user->users_id?></td>
								<td><img src="<?php echo assets_url('admin/images/flags/' . $user->users_detail_country_code . '.png') ?>" /></td>
								<td><a href="<?php echo site_url()?>users/account/<?php echo $user->users_username?>"><?php echo $user->users_username?></a></td>
								<td><?php echo $user->users_email?></td>
								<td><?php echo print_amount_by_currency($user->users_credits)?></td>
							</tr>
					<?php
						++$i;
					}?>
						</tbody>
					</table>
					<br />
					<?php
					} else {
						echo '<div style="text-align:center; width:100%; " class="clear"><h3>'.lang('No users found.').'</h3></div>';
					}
					?>
					<div class="extrabottom">
						<?php echo $pagination?>
						<div class="bulkactions">
						</div>
					</div>
				</div>

			</div>