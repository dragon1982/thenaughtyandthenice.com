<script type="text/javascript">
jQuery(function($){ 
	$('.modal').fancybox({
		'overlayShow': true,
		'scrolling': 'no',
		'type': 'ajax',
		'titleShow'			: false,		
		'overlayColor'		: '#000',
		'overlayOpacity'	: 0.7,
		'showCloseButton'	: true
	});
});
</script>
<link rel="stylesheet" type="text/css" href="<?php echo assets_url()?>css/table.css" media="screen" />	
<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content">
		<div class="title">
			<?php $performer_title = lang('Performers') ?>
			<span class="eutemia"><?php echo substr($performer_title,0,1)?></span><span class="helvetica"><?php echo substr($performer_title,1)?></span>
		</div>
        <a href="<?php echo site_url('performers/register')?>" style="float:right"><?php echo form_button('register', lang('Add performer'),'class="red"')?></a>
		
        <div id="filters">
            <?php echo form_open()?>
            <?php echo form_dropdown('status', $status, set_value('status'), 'class="rounded" style="width:120px;"')?>
            <?php echo form_dropdown('contract_status', $contract_status, set_value('contract_status'), 'class="rounded" style="width:120px;"')?>
            <?php echo form_dropdown('photo_id_status', $photo_id_status, set_value('photo_id_status'), 'class="rounded" style="width:120px;"')?>
            <?php echo form_submit('submit', lang('Apply Filters'),'class="red"')?>
            <?php echo form_close()?>
        </div>
        <table id="performers" class="data display datatable">
        	<thead>
            <tr>
                <th width="15%"><?php echo lang('Nickname') ?></th>
                <th width="17%"><?php echo lang('Full name') ?></th>
                <th width="7%"><?php echo lang('Status') ?></th>
                <th width="8%"><?php echo lang('Contract') ?></th>
                <th width="10%"><?php echo lang('Photo ID') ?></th>
                <th width="5%"><?php echo lang('Online') ?></th>
                <th width="5%"><?php echo lang('Spy') ?></th>
                <th width="15%"><?php echo lang('Balance') ?></th>
                <th width="13%"><?php echo lang('Login as performer') ?></th>
                <th width="5%" class="edit"></th>
            </tr>
            </thead>
            <?php if(sizeof($studio_performers) == 0 ):?>
            	<tr>
            		<td colspan="11" style="text-align:center"><?php echo lang('There are no performers.')?></td>
            	</tr>
            <?php else :?>
            	<?php $i = 0;?>                        
	            <?php foreach ($studio_performers as $performer): ?>
					<tr class="<?php echo ($i % 2==0)?'even':'odd'?>">
	                    <td><?php echo $performer->nickname ?></td>
	                    <td><?php echo $performer->first_name . ' ' . $performer->last_name ?></td>
	                    <td><div class="<?php echo $performer->status ?>"></div></td>
	                    <td>
	                    	<?php if($performer->contract_status == 'approved'):?>
	                    		<div class="<?php echo $performer->contract_status?>"></div>
	                    	<?php else: ?>
	                    		<a href="<?php echo site_url('performer/add-contract/'.$performer->id)?>" class="modal"><div class="<?php echo $performer->contract_status?>"></div></a>
	                    	<?php endif?>
	                    </td>
	                    <td>
	                    	<?php if($performer->photo_id_status == 'approved'):?>
	                    		<div class="<?php echo $performer->photo_id_status?>"></div>
	                    	<?php else:?>
	                    		<a href="<?php echo site_url('performer/add-photo-id/'.$performer->id)?>" class="modal"><div class="<?php echo $performer->photo_id_status?>"></div></a>
	                    	<?php endif?>
	                    </td>
	                    <?php if ($performer->is_online): ?>
	                        <td><div class="online"></div></td>
	                    <?php else:?>
	                        <td><div class="offline"></div></td>
	                    <?php endif?>
	                    <?php if($performer->is_online):?>
	                        <td>
	                        	<div class="spy">
		                        	<a style="cursor: pointer;" onclick="window.open('<?php echo site_url('performers/spy/'.$performer->id)?>','Spy','menubar=no,width=960,height=580,toolbar=no')">
		                        		&nbsp;&nbsp;&nbsp;&nbsp;
		                        	</a>
	                        	</div>
	                        </td>                        
	                    <?php else: ?>
	                        <td><div class="no-spy"></div></td>
	                    <?php endif ?>
	                    <td><a href="<?php echo site_url('performers/earnings/'.$performer->id)?>"><?php echo print_amount_by_currency($performer->credits) ?></a></td>
	                    <td><a href="<?php echo site_url('performers/edit/' . $performer->id)?>" target="_blank"><img src="<?php echo assets_url()?>images/icons/right_arrow.png" alt="" /></a></td>
	                    <td><a href="<?php echo site_url('performers/account/' . $performer->id)?>"><img src="<?php echo assets_url()?>/images/pencil.png" /></a></td>
	                </tr>
	                <?php $i++?>
	            <?php endforeach ?>
	     	<?php endif?>
        </table>
    <div class="clear"></div>
    </div>
</div>
</div></div><div class="black_box_bg_bottom"></div>