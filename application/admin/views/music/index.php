<div class="container">
	<div class="conthead">
		<h2><?php echo lang('Songs')?></h2>
	</div>
	<div class="contentbox">
		<table width="100%" border="0">
			<thead>
				<tr>
					<th><?php echo lang('ID')?></th>
					<th><?php echo lang('Title')?></th>
					<th><?php echo lang('src')?></th>
					<th style="width: 60px; text-align: center;"><?php echo lang('Actions')?></th>
				</tr>
			</thead>
			<tbody>
			<?php if(sizeof($songs) ==0 ):?>
				<tr>
					<td colspan="4" style="text-align:center">There are no songs</td>				
				</tr>
			<?php else:?>
				<?php foreach ($songs as $song):?>
				<tr>
					<td><?php echo $song->id?></td>
					<td><?php echo $song->title?></td>
					<td><?php echo $song->src?></td>
					<td>
						<a href="<?php echo site_url('music')?>/edit/<?php echo $song->id?>"><img src="<?php echo assets_url('admin/images/icons/icon_edit.png') ?>" /></a>&nbsp;&nbsp;
						<a href="<?php echo site_url('music')?>/delete/<?php echo $song->id?>" onclick="if(confirm('<?php echo lang('Are you sure you want to delete this song?')?>')) { return true;} else {return false;}" title=""><img src="<?php echo assets_url('admin/images/icons/icon_unapprove.png') ?>"></a>					
					</td>
				</tr>
				<?php endforeach?>
			<?php endif?>
			</tbody>
		</table>
		<div class="extrabottom">
			<div class="bulkactions">
				<input class="btn" type="button" value="<?php echo lang('Add new song')?>" onclick="document.location.href='<?php echo site_url('music/add')?>'" />
			</div>
		</div>
	</div>
</div>
