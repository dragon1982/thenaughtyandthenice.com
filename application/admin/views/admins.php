<script type="text/javascript">
	$(document).ready(function(){
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('admins')?>';
		});

		$('.sort').click(function(){
			var url = '<?php echo site_url('admins')?>?';
			document.location.href= url + 'orderby[' + $(this).attr('id')  + ']=' + $(this).attr('order'); 
		});		
	});
</script>
			<div class="container">
				<div class="conthead">
					<h2><?php echo lang('Admins')?></h2>
				</div>

				<div class="contentbox">					
					<table width="100%" border="0">
						<thead>
							<tr>
								<?php $this->load->view('table_sorting',array('name'=>lang('ID'),				'key'=>'id',				'style'=>'') )?>
								<?php $this->load->view('table_sorting',array('name'=>lang('username'),			'key'=>'username',			'style'=>'') )?>
								<th style="width: 60px; text-align: center;"><?php echo lang('Actions')?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(sizeof($admins) == 0):?>
								<tr>
									<td colspan="3"><?php echo lang('There are no entries')?></td>
								</tr>
							<?php else:  
								$i = 1;
								foreach ($admins as $admin):?>
									<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
										<td><?php echo $admin->id?></td>
										<td><?php echo $admin->username?></td>
										<td style="text-align: center;">
											<a href="<?php echo base_url()?>admins/add_or_edit/<?php echo $admin->id?>"><img src="<?php echo assets_url('admin/images/icons/icon_edit.png') ?>" /></a>
											&nbsp;&nbsp;
											<a href="<?php echo base_url()?>admins/delete/<?php echo $admin->id?>" onclick="if(confirm('<?php echo lang('Are you sure you want to delete this admin account?')?>')) { return true;} else {return false;}" title=""><img src="<?php echo assets_url('admin/images/icons/icon_unapprove.png') ?>"></a>
										</td>
									</tr>
									<?php ++$i;?>
								<?php endforeach?>
							<?php endif?>
						</tbody>
					</table>
					<div class="extrabottom">
						<?php echo $pagination?>
						<div class="bulkactions">
							<input class="btn" type="button" value="<?php echo lang('Add new admin account')?>" onclick="document.location.href='<?php echo site_url('admins/add_or_edit')?>'" />
						</div>
					</div>
				</div>

			</div>


