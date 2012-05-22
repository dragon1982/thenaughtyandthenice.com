<script type="text/javascript">
	$(document).ready(function(){
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('categories')?>';
		});

		$('.sort').click(function(){
			var url = '<?php echo site_url('categories')?>?<?php echo $filters?>&';
			document.location.href= url + 'orderby[' + $(this).attr('id')  + ']=' + $(this).attr('order'); 
		});		
	});
</script>
			<div class="container">
				<div class="conthead">
					<h2><?php echo lang('Categories')?></h2>
				</div>

				<div class="contentbox">
					<table width="100%" border="0">
						<thead>
							<tr>
								<?php $this->load->view('table_sorting',array('name'=>lang('ID'),				'key'=>'id',				'style'=>'') )?>
								<?php $this->load->view('table_sorting',array('name'=>lang('name'),				'key'=>'name',				'style'=>'') )?>
								<?php $this->load->view('table_sorting',array('name'=>lang('link'),				'key'=>'link',				'style'=>'') )?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Parent ID'),		'key'=>'parent_id',			'style'=>'') )?>							
								<th style="width: 60px; text-align: center;"><?php echo lang('Actions')?></th>
							</tr>
						</thead>
						<tbody>
					<?php if( sizeof($categories) == 0):?>
						<tr>
							<td colspan="5"><div style="text-align:center; width:100%; " class="clear"><h3><?php echo lang('There are no entries')?></h3></div></td>
						</tr>					
					<?php else : 					
						$i = 1;
						foreach ($categories as $category) :?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $category->id?></td>
								<td><?php echo $category->name?></td>
								<td><?php echo $category->link?></td>
								<td><?php echo ($category->parent_id > 0) ? $categories[$category->parent_id]->name : null?></td>
								<td style="text-align: center;">
									<a href="<?php echo site_url('categories')?>/add_or_edit/<?php echo $category->id?>"><img src="<?php echo assets_url('admin/images/icons/icon_edit.png') ?>" /></a>&nbsp;&nbsp;
									<a href="<?php echo site_url('categories')?>/delete/<?php echo $category->id?>" onclick="if(confirm('<?php echo lang('Are you sure you want to delete this category?')?>')) { return true;} else {return false;}" title=""><img src="<?php echo assets_url('admin/images/icons/icon_unapprove.png') ?>"></a>
								</td>
							</tr>
							<?php ++$i?>
						<?php endforeach?>
					<?php endif?>
						</tbody>
					</table>
					<br />					
					<div class="extrabottom">
						<div class="bulkactions">
							<input class="btn" type="button" value="<?php echo lang('Add new category')?>" onclick="document.location.href='<?php echo site_url('categories/add_or_edit')?>'" />
						</div>
					</div>
				</div>

			</div>


