<script type="text/javascript">
	$(document).ready(function(){
	
		$(".logs").fancybox({
			'transitionIn' : 'none',
			'transitionOut' : 'none' 
		}); 
		
		$('#date').change(function(){
			document.location.href = '<?php echo site_url()?>performers/chat_logs/<?php echo $performer->username?>/'+$(this).val();
		})
		
	})
</script>

<div class="container">
				<div class="conthead">
					<?php $this->load->view('includes/edit_buttons')?>
				</div>

				
				<div class="contentbox">
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('Date')?><br/>
					<?=form_input('date', ($date != 'all') ? $date : FALSE, 'class="inputbox datepicker" id="date" style="min-width:150px;"')?>
				</p>
				

					
					<?php
					if(isset($chat_logs) AND is_array($chat_logs) AND count($chat_logs) > 0) {
					?>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th><?php echo lang('ID')?></th>
								<th><?php echo lang('Add date')?></th>
								<th><?php echo lang('Log')?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = 1;
					foreach ($chat_logs as $chat_log) {?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $chat_log->id?></td>
								<td><?php echo date('d M Y H:i' ,$chat_log->add_date);?></td>
								<td>
									<a class="logs" href="#log_<?php echo $i?>" ><?php echo current( explode("\n",$chat_log->log, 2))?></a>
									<div class="complete_log" id="log_<?php echo $i?>" >
										<?php echo nl2br($chat_log->log)?>
									</div>
								</td>
							</tr>
					<?php
						++$i;
					}?>
						</tbody>
					</table>
					<br />
					<?php
					} else {
						echo '<div style="text-align:center; width:100%; " class="clear"><h3>'.lang('Chat log not found.').'</h3></div>';
					}
					?>
					<div class="extrabottom">
						<?php echo $pagination?>
						<div class="bulkactions">
						</div>
					</div>
				</div>

			</div>