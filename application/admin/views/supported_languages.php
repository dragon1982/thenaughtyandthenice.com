			<div class="container">
				<div class="conthead">
					<h2><?php echo lang('Supported languages') ?></h2>
				</div>				
				<div class="contentbox">			
					<table width="100%" border="0">
						<thead>
							<tr>
								<th><?php echo lang('ID')?></th>
								<th></th>
								<th><?php echo lang('Code')?></th>
								<th><?php echo lang('Title')?></th>
								<th style="width: 60px; text-align: center;"><?php echo lang('Actions')?></th>
							</tr>
						</thead>
						<tbody>
					<?php if( sizeof($languages) == 0) :?>
						<tr>
							<td colspan="5"><div style="text-align:center; width:100%; " class="clear"><h3><?php echo lang('There are no entries')?></h3></div></td>
						</td>
					<?php else:
						$i = 1;
						foreach ($languages as $language) :?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $language->id?></td>
								<td><img src="<?php echo assets_url('admin/images/flags/' . strtoupper($language->code) . '.png') ?>" /></td>
								<td><?php echo $language->code?></td>
								<td><?php echo $language->title?></td>
								<td style="text-align: center;">
									<a href="<?php echo site_url()?>supported_languages/delete/<?php echo $language->id?>" onclick="if(confirm('<?php echo lang('Are you sure you want to delete this language?')?>')) { return true;} else {return false;}" title=""><img src="<?php echo assets_url('admin/images/icons/icon_unapprove.png') ?>"></a>
								</td>
							</tr>
							<?php $i++?>
						<?php endforeach?>
					<?php endif?>
						</tbody>
					</table>
					<br />
					<div class="extrabottom">
						<div class="bulkactions">
							<input class="btn" type="button" value="<?php echo lang('Add new supported language')?>" onclick="document.location.href='<?php echo site_url('supported_languages/add')?>'" />
						</div>
					</div>
				</div>

			</div>


