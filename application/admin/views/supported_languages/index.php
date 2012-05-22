
			<div class="container">
				<div class="conthead">
					<h2><?php echo lang('Supported languages')?></h2>
				</div>

				<div class="contentbox">
					
				<?php if(sizeof($supported_languages) > 0) :?>
					<table width="100%" border="0">
						<thead>
							<tr>
								<th><?php echo lang('ID')?></th>
								<th><?php echo lang('code')?></th>
								<th><?php echo lang('title')?></th>
								<th style="width: 60px; text-align: center;"><?php echo lang('Actions')?></th>
							</tr>
						</thead>
						<tbody>
					<?php
					$i = 1;
					foreach ($supported_languages as $supported_language) {?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $supported_language->id?></td>
								<td><?php echo $supported_language->code?></td>
								<td><?php echo $supported_language->title?></td>
								<td style="text-align: center;">
									<a href="<?php echo site_url('languages/edit/' . $supported_language->id)?>"><img src="<?php echo assets_url('admin/images/icons/icon_edit.png') ?>" /></a>&nbsp;&nbsp;
									<a href="<?php echo site_url('languages/delete/' . $supported_language->id)?>" onclick="return confirm('<?php echo lang('Are you sure you want to delete the language?')?>')" title=""><img src="<?php echo assets_url('admin/images/icons/icon_unapprove.png') ?>"></a>
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
						echo '<div style="text-align:center; width:100%; " class="clear"><h3>'.lang('There are no languages').'</h3></div>';
					endif;
					?>
					<div class="extrabottom">
						<div class="bulkactions">
							<input class="btn" type="button" value="<?php echo lang('Add new language')?>" onclick="document.location.href='<?php echo site_url('languages/add')?>'" />
						</div>
					</div>
				</div>
			</div>