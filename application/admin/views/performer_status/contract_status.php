<script type="text/javascript">
function change() {
	parent.document.getElementById('observer').innerHTML = '1';
}
</script>

	<div id="content_status">
		<div class="content-box-header">
			<div class="status_name"><h3><?php echo $performer->nickname ?>'s <?php echo lang('contracts') ?></h3></div>
			<div class="content-box-content">
				<table class="pagination" width="100%" rel="100">
					<thead class="status_head">
						<tr>
							<th><?php echo lang('ID') ?></th>
							<th><?php echo lang('Date') ?></th>
							<th><?php echo lang('Performer') ?></th>
							<th><?php echo lang('Status') ?></th>
							<th><?php echo lang('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php $i=0; //pentru a alterna culorile tabelului?>
						<?php if( ! empty($contracts)):?>
						<?php foreach ($contracts as $contract): ?>
						<?php $i++;?>
						<tr class="row_<?php echo ($i%2==0)?'2':'1' ?>">
							<td><?php echo $contract->id ?></td>
							<td><?php echo date('Y-m-d h:s', $contract->date)?></td>
							<td><?php echo $performer->nickname ?></td>
							<td>
								<img src="<?php echo assets_url('admin/images/icons/'. $contract->status .'.png') ?>" alt="<?php echo $contract->status ?>" title=<?php echo sprintf(lang('Status is %s'), $contract->status )?>"/>
							</td>
							<td>
								<a href="<?php echo main_url('uploads/performers/'. $performer->id .'/others/'. $contract->name_on_disk) ?>"  target="_blank">
									<img src="<?php echo assets_url('admin/images/icons/download.png') ?>" alt="download" title="<?php echo lang('Download Contract') ?>"/>
								</a>
								
								<?php if ($contract->status == 'approved'): ?>
								<a href="<?php echo site_url('performers/update_status/contracts/rejected/' . $contract->id . '/' . $performer->id) ?>">
									<img src="<?php echo assets_url('admin/images/icons/rejected.png') ?>" onclick="javascript:change();" alt="rejected" title="<?php echo lang('Reject Contract') ?>"/>
								</a>
								<?php elseif ($contract->status == 'pending'): ?>
								<a href="<?php echo site_url('performers/update_status/contracts/approved/' . $contract->id . '/' . $performer->id) ?>">
									<img src="<?php echo assets_url('admin/images/icons/approved.png') ?>" onclick="javascript:change();" alt="approved" title="<?php echo lang('Approve Contract') ?>"/>
								</a>
								<a href="<?php echo site_url('performers/update_status/contracts/rejected/' . $contract->id . '/' . $performer->id) ?>">
									<img src="<?php echo assets_url('admin/images/icons/rejected.png') ?>" onclick="javascript:change();" alt="rejected" title="<?php echo lang('Reject Contract') ?>"/>
								</a>
								<?php else: ?>
								<a href="<?php echo site_url('performers/update_status/contracts/approved/' . $contract->id . '/' . $performer->id) ?>">
									<img src="<?php echo assets_url('admin/images/icons/approved.png') ?>" onclick="javascript:change();" alt="approved" title="<?php echo lang('Approve Contract') ?>"/>
								</a>
								<?php endif ?>
							</td>
						</tr>
						<?php endforeach ?>
						<?php else: ?>
							<tr class="row_1"><td style="text-align:center;" colspan="5"><?php echo lang('Performer has no uploaded contracts') ?></td></tr>
						<?php endif; ?>					
					</tbody>
				</table>
				<div class="status_pagination"><?php echo $pagination; ?></div>
			</div>
		</div>
	</div>

