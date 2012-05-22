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
			
			document.location.href='<?php echo site_url('fms')?>/'+ link;
			link = '';
			return false;
		});
		
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('fms')?>';
		})
	});
	</script>
			<div class="container">
				<div class="conthead">
					<h2><?php echo lang('Fmss')?></h2>
				</div>
				<div class="contentbox">					
				<?php if(sizeof($fmss) > 0) :?>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th><?php echo lang('ID')?></th>
								<th><?php echo lang('Name')?></th>
								<th><?php echo lang('Max hosted performers')?></th>
								<th><?php echo lang('Current hosted performers')?></th>
								<th><?php echo lang('Status')?></th>
								<th><?php echo lang('FMS')?></th>
								<th style="width: 60px; text-align: center;"><?php echo lang('Actions')?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = 1;
					foreach ($fmss as $fms) {?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $fms->fms_id?></td>
								<td><?php echo $fms->name?></td>
								<td><?php echo $fms->max_hosted_performers?></td>
								<td><?php echo $fms->current_hosted_performers?></td>
								<td><?php echo $fms->status?></td>
								<td><?php echo $fms->fms?></td>
								<td style="text-align: center;">
									<a href="<?php echo site_url('fms/edit/' . $fms->fms_id)?>"><img src="<?php echo assets_url('admin/images/icons/icon_edit.png') ?>" /></a>&nbsp;&nbsp;
									<a href="<?php echo site_url('fms/delete/' . $fms->fms_id)?>" onclick="return confirm('<?php echo lang('Are you sure you want to delete this fms? By deleting the FMS you will delete all videos from IT')?>')" title=""><img src="<?php echo assets_url('admin/images/icons/icon_unapprove.png') ?>"></a>
								</td>
							</tr>
					<?php
						++$i;
					}?>
						</tbody>
					</table>
					<br />
					<?php
					else:
						echo '<div style="text-align:center; width:100%; " class="clear"><h3>'.lang('There are no fmss').'</h3></div>';
					endif;
					?>
					<div class="extrabottom">
						<div class="bulkactions">
							<input class="btn" type="button" value="<?php echo lang('Add new FMS')?>" onclick="document.location.href='<?php echo site_url('fms/add')?>'" />
						</div>
					</div>
				</div>
			</div>