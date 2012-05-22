<div class="container">
	<div class="conthead">
		<?php $this->load->view('includes/templates_buttons') ?>
	</div>

	<div class="contentbox">
		<?php //$this->load->view('includes/_emails_templates_submenu')?>
		
		<?php
					
					if(isset($templates) AND is_array($templates) AND count($templates) > 0) {
					?>
					<table width="100%" border="0">
					
					
					<?php
					$i = 1;
					foreach ($templates as $module => $templates_module) { ?>
							<thead>
								<tr>
									<th ><?php echo ucfirst(lang($module)) ?></th>
									<th style="width: 60px; text-align: center;"><?php echo lang('Actions')?></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($templates_module as $file_name => $file_path){?>
								<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
									<td><?php echo $file_name?></td>
									<td style="text-align: center;">
										<a href="<?php echo site_url('emails_templates/edit/'.$module.'/'.$file_name)?>"  title=""><img src="<?php echo assets_url('admin/images/icons/icon_edit.png') ?>"></a>
									</td>
								</tr>
							<?
							++$i;
							}?>
							</tbody>
					<?php }?>
					</table>
					<br/>
					<?php
					} else {
						echo '<div style="text-align:center; width:100%; " class="clear"><h3>'. lang('Templates not found.') . '</h3></div>';
					}
					?>
	</div>
</div>