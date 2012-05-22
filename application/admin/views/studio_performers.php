
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
			
			document.location.href='<?php echo site_url('studios/payments/'.$studio->username)?>/'+ link;
			link = '';
			return false;
		});
		
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('studios/payments/'.$studio->username)?>';
		})
	});
	</script>

<div class="container">
				<div class="conthead">
					<?php $this->load->view('includes/studio_buttons')?>
				</div>

				<div id="observer">0</div> <!-- Daca se schimba in 1 atunci inseamna ca s-au facut modificari in iframe si se da reload la pagina -->
				
				<div class="contentbox">
					
					
					<?php
					if(isset($performers) AND is_array($performers) AND count($performers) > 0) {
					?>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th class="sorting<?php echo ($order_by == 'id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/performers/<?php echo $studio->username?>/<?php echo $filters?>/id/<?php echo ($order_by == 'id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('ID')?></th>
								<th class="sorting<?php echo ($order_by == 'country_code') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/performers/<?php echo $studio->username?>/<?php echo $filters?>/country_code/<?php echo ($order_by == 'country_code' && $order_type == 'asc') ? 'desc' : 'asc'?>';"></th>
								<th class="sorting<?php echo ($order_by == 'nickname') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/performers/<?php echo $studio->username?>/<?php echo $filters?>/nickname/<?php echo ($order_by == 'nickname' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Username')?></th>
								<th class="sorting<?php echo ($order_by == 'email') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/performers/<?php echo $studio->username?>/<?php echo $filters?>/email/<?php echo ($order_by == 'email' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Email')?></th>
								<th class="sorting<?php echo ($order_by == 'first_name') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/performers/<?php echo $studio->username?>/<?php echo $filters?>/first_name/<?php echo ($order_by == 'first_name' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('First name')?></th>
								<th class="sorting<?php echo ($order_by == 'last_name') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/performers/<?php echo $studio->username?>/<?php echo $filters?>/last_name/<?php echo ($order_by == 'status' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Last name')?></th>
								<th class="sorting<?php echo ($order_by == 'status') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/performers/<?php echo $studio->username?>/<?php echo $filters?>/status/<?php echo ($order_by == 'comments' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('status')?></th>
								<th class="sorting<?php echo ($order_by == 'register_date') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>studios/performers/<?php echo $studio->username?>/<?php echo $filters?>/register_date/<?php echo ($order_by == 'register_date' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Register date')?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = 1;
					foreach ($performers as $performer) {?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $performer->id?></td>
								<td><img src="<?php echo assets_url('admin/images/' . (($performer->country_code != '')? 'flags/'.$performer->country_code : 'icons/na') . '.png') ?>" /></td>
								<td><a href="<?php echo base_url()?>performers/account/<?php echo $performer->username?>"><?php echo $performer->username?></a></td>
								<td><?php echo $performer->email?></td>
								<td><?php echo $performer->first_name?></td>
								<td><?php echo $performer->last_name?></td>
								<td><?php echo $performer->status?></td>
								<td><?php echo date('d M Y H:i' ,$performer->register_date);?></td>
							</tr>
					<?php
						++$i;
					}?>
						</tbody>
					</table>
					<br />
					<?php
					} else {
						echo '<div style="text-align:center; width:100%; " class="clear"><h3>'.lang('Payment not found.').'</h3></div>';
					}
					?>
					<div class="extrabottom">
						<?php echo $pagination?>
						<div class="bulkactions">
						</div>
					</div>
				</div>

			</div>