<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/table.css" media="screen" />
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">	
	<div class="content">
		<div class="title">
			<?php $account_summary_title = lang('Photo IDs - Summary') ?>
			<span class="eutemia "><?php echo substr($account_summary_title,0,1)?></span><span class="helvetica "><?php echo substr($account_summary_title,1)?></span>
		</div>
		
		<a href="<?php echo site_url('performer/photo_id/add')?>" style="float:right"><?php echo form_button('add', lang('Add Photo ID'),'class="red"')?></a>			
		<div style="clear:both"></div>
		<br />
        <table class="data display datatable">
        	<thead>
            <tr>
                <th width="20%"><?php echo lang('Add date') ?></th>
                <th width="25%"><?php echo lang('Status') ?></th>
                <th width="7%"><?php echo lang('View') ?></th>
                <th width="5%"><?php echo lang('Actions')?></th>
            </tr>
            </thead>
            <?php if(sizeof($photo_ids) == 0):?>
	            <tr>
	            	<td colspan="4" style="text-align:center"><?php echo lang('You have no photo IDs added')?></td>
	            </tr>
            <?php else:?>
            	<?php $i = 0 ?>	            	            
	            <?php foreach ($photo_ids as $photo_id): ?>
					<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">
	                	<td><?php echo date('Y-m-d',$photo_id->date)?></td>		                	
	                	<?php 
	                	if($photo_id->status == 'approved'):
							$class = 'approved';									                				
	                	elseif($photo_id->status == 'pending'):
	                		$class = 'pending';
						else:
	                		$class = 'rejected';
	                	endif;
	                	?>
	                	<td><div class="<?php echo $class?>"></div></td>
		                <td>
		                	<a href="<?php echo main_url('uploads/performers/' . $photo_id->performer_id . '/others/' . $photo_id->name_on_disk)?>" target="_blank"><img src="<?php echo assets_url()?>images/find_on.png" /></a>			                
		                </td>
		                <td>
		                	<a href="<?php echo site_url('performer/photo_id/delete/' . $photo_id->id)?>" onclick="return confirm('<?php echo lang('Are you sure you want to delete this item')?>')"><img src="<?php echo assets_url()?>images/icons/trash.gif" /></a>
		               </td>
		            </tr>
		            <?php $i++ ?>			         
	            <?php endforeach ?>
       		<?php endif?>
        </table>
		<div class="clear"></div>
	</div>
</div>
</div></div><div class="black_box_bg_bottom"></div>