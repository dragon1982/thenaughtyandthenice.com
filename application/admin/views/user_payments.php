
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
			
			document.location.href='<?php echo site_url('users/payments/'.$user->username)?>/'+ link;
			link = '';
			return false;
		});
		
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('users/payments/'.$user->username)?>';
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
					
					if(isset($payments) AND is_array($payments) AND count($payments) > 0) {
					?>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th class="sorting<?php echo ($order_by == 'id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/payments/<?php echo $user->username?>/id/<?php echo ($order_by == 'id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('ID')?></th>
								<th class="sorting<?php echo ($order_by == 'amount_paid') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/payments/<?php echo $user->username?>/amount_paid/<?php echo ($order_by == 'amount_paid' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Amount paid')?></th>
								<th class="sorting<?php echo ($order_by == 'amount_received') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/payments/<?php echo $user->username?>/amount_received/<?php echo ($order_by == 'amount_received' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Amount received')?></th>
								<th class="sorting<?php echo ($order_by == 'date') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/payments/<?php echo $user->username?>/date/<?php echo ($order_by == 'date' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Date')?></th>
								<th class="sorting<?php echo ($order_by == 'type') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/payments/<?php echo $user->username?>/type/<?php echo ($order_by == 'type' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Type')?></th>
								<th class="sorting<?php echo ($order_by == 'invoice_id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/payments/<?php echo $user->username?>/invoice_id/<?php echo ($order_by == 'invoice_id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Invoice id')?></th>
								<th class="sorting<?php echo ($order_by == 'refunded') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/payments/<?php echo $user->username?>/refunded/<?php echo ($order_by == 'refunded' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Refunded')?></th>
								<th class="sorting<?php echo ($order_by == 'status') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/payments/<?php echo $user->username?>/status/<?php echo ($order_by == 'status' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('Status')?></th>
								<th class="sorting<?php echo ($order_by == 'user_id') ? '_'.$order_type : '' ?>" onclick="document.location.href='<?php echo site_url()?>users/payments/<?php echo $user->username?>/user_id/<?php echo ($order_by == 'user_id' && $order_type == 'asc') ? 'desc' : 'asc'?>';"><?php echo lang('User id')?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = 1;
					foreach ($payments as $payment) {?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $payment->id?></td>
								<td><?php echo $payment->amount_paid.' '.$payment->currency_paid?></td>
								<td><?php echo $payment->amount_received.' '.$payment->currency_received?></td>
								<td><?php echo date('d M Y H:i' ,$payment->date);?></td>
								<td><?php echo $payment->type;?></td>
								<td><?php echo $payment->invoice_id;?></td>
								<td><?php echo $payment->refunded;?></td>
								<td><?php echo $payment->status;?></td>
								<td><?php echo $payment->user_id;?></td>
							</tr>
					<?php
						++$i;
					}?>
						</tbody>
					</table>
					<br />
					<?php
					} else {
						echo '<div style="text-align:center; width:100%; " class="clear"><h3>'.lang('No payments found.').'</h3></div>';
					}
					?>
					<div class="extrabottom">
						<?php echo $pagination?>
						<div class="bulkactions">
						</div>
					</div>
				</div>

			</div>