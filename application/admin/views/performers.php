<script type="text/javascript">
$('.conthead').ready(function() {
	$(".iframe").fancybox({
		'scrolling'			: 'no',
		'transitionIn'		: 'fade',
		'transitionOut'		: 'fade',
		'type'				: 'iframe',
		'onClosed'			: function() { 
								if(typeof(parent.document.getElementById('observer').innerHTML == '1')) {
									parent.location.reload(true);
								}
							  }
	});
});

$(document).ready(function(){
	$('#reset_filters').click(function(){
		document.location.href='<?php echo site_url('performers')?>';
	});

	$('.sort').click(function(){
		var url = '<?php echo site_url('performers')?>?<?php echo $filters?>&';
		document.location.href= url + 'orderby[' + $(this).attr('id')  + ']=' + $(this).attr('order'); 
	});
});
</script>
<div class="container">
	<div class="conthead">
		<h2><?php echo lang ('Performers') ?></h2>
	</div>
	
	<div id="observer">0</div> <!-- Daca se schimba in 1 atunci inseamna ca s-au facut modificari in iframe si se da reload la pagina -->
	
	<div class="contentbox">
		<div class="bulkactions" style="margin-bottom: 10px;">
			<?php echo form_open('performers','method="get"')?>
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('Performer ID')?><br/>
					<?php echo form_input('filters[id]', $this->input->_fetch_from_array($this->input->get('filters'),'id',TRUE), 'class="inputbox" style="min-width:150px;"')?>
				</p>
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('Username')?><br/>
					<?php echo form_input('filters[username]', $this->input->_fetch_from_array($this->input->get('filters'),'username',TRUE), 'class="inputbox" style="min-width:150px;"')?>					
				</p>
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('Nickname')?><br/>
					<?php echo form_input('filters[nickname]', $this->input->_fetch_from_array($this->input->get('filters'),'nickname',TRUE), 'class="inputbox" style="min-width:150px;"')?>					
				</p>
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('E-mail')?><br/>
					<?php echo form_input('filters[email]', $this->input->_fetch_from_array($this->input->get('filters'),'email',TRUE), 'class="inputbox" style="min-width:150px;"')?>
				</p>				
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('First name')?><br/>
					<?php echo form_input('filters[first_name]', $this->input->_fetch_from_array($this->input->get('filters'),'first_name',TRUE), 'class="inputbox" style="min-width:150px;"')?>					
				</p>								
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('Last name')?><br/>
					<?php echo form_input('filters[last_name]', $this->input->_fetch_from_array($this->input->get('filters'),'last_name',TRUE), 'class="inputbox" style="min-width:150px;"')?>					
				</p>				
				<p style="float:left; margin-right:10px;">
					&nbsp;<br/>
					<input type="submit" class="btn" value="Apply Filter" style="margin-top:0px;" />
					<?php echo (strlen($filters) > 0) ? '<input type="button" id="reset_filters" class="btn" value="Reset Filters" style="margin-top:0px;" />' : null?>
				</p>
			</form>
		</div>		
		<table width="100%" border="0">
			<thead>
				<tr>
					<?php $this->load->view('table_sorting',array('name'=>lang('ID'),				'key'=>'id',				'style'=>'width:20px') )?>
					<?php $this->load->view('table_sorting',array('name'=>'',						'key'=>'country_code',		'style'=>'width:20px') )?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Username'),			'key'=>'username',			'style'=>'width:100px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('First name'),		'key'=>'first_name',		'style'=>'width:100px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Last name'),		'key'=>'last_name',			'style'=>'width:100px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Nickname'),			'key'=>'nickname',			'style'=>'width:100px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('E-mail'),			'key'=>'email',				'style'=>'width:100px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Status'),			'key'=>'status',			'style'=>'width:60px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Contract'),			'key'=>'contract_status',	'style'=>'width:60px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Photo ID'),			'key'=>'photo_id_status',	'style'=>'width:60px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Is online'),		'key'=>'is_online',			'style'=>'width:70px'))?>
					<th style="width:30px"><?php echo lang('Spy')?></th>
					<?php $this->load->view('table_sorting',array('name'=>lang('Online HD'),		'key'=>'is_online_hd',		'style'=>'width:80px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Online type'),		'key'=>'is_online_type',	'style'=>'width:85px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('In private'),		'key'=>'is_in_private',		'style'=>'width:70px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Peek'),				'key'=>'enable_peek_mode',	'style'=>'width:40px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Studio'),			'key'=>'studio_id',			'style'=>'width:40px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Earnings'),			'key'=>'Earnings',			'style'=>'width:40px'))?>
					<th style="width: 60px; text-align: center;"><?php echo lang('Actions')?></th>
				</tr>
			</thead>
			<tbody>
		<?php if( sizeof($performers) == 0 ):?>
			<tr>
				<td colspan="18"><div style="text-align:center; width:100%; " class="clear"><h3><?php echo lang('There are no entries')?></h3></div></td>
			</tr>
		<?php else:  
				$i = 1;
				foreach ($performers as $performer):?>
					<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
						<td><?php echo $performer->performers_id?></td>
						<td><img src="<?php echo assets_url('admin/images/' . (($performer->performers_country_code != '')? 'flags/'.$performer->performers_country_code : 'icons/na') . '.png') ?>" /></td>
						<td><a href="<?php echo base_url()?>performers/account/<?php echo $performer->performers_username?>"><?php echo $performer->performers_username?></a></td>
						<td><?php echo $performer->performers_first_name?></td>
						<td><?php echo $performer->performers_last_name?></td>
						<td><?php echo $performer->performers_nickname?></td>
						<td><?php echo $performer->performers_email?></td>
						<td style="text-align:center"><img src="<?php echo assets_url('admin/images/icons/' . $performer->performers_status . '.png') ?>" /></td>
						
						<?php if($contracts[$performer->performers_id]==0): ?>
							<td style="text-align:center"><a class="iframe" href="<?php echo site_url('performers/contract_status/' . $performer->performers_id) ?>"><img src="<?php echo assets_url('admin/images/icons/na.png') ?>" /></a></td>
						<?php else: ?>
							<td style="text-align:center"><a class="iframe" href="<?php echo site_url('performers/contract_status/' . $performer->performers_id) ?>"><img src="<?php echo assets_url('admin/images/icons/' . $performer->performers_contract_status . '.png') ?>" /></a></td>
						<?php endif?>
											
						<?php if($photo_ids[$performer->performers_id]==0): ?>
							<td style="text-align:center"><a class="iframe" href="<?php echo site_url('performers/photo_status/' . $performer->performers_id) ?>"><img src="<?php echo assets_url('admin/images/icons/na.png') ?>" /></a></td>
						<?php else: ?>
							<td style="text-align:center"><a class="iframe" href="<?php echo site_url('performers/photo_status/' . $performer->performers_id) ?>"><img src="<?php echo assets_url('admin/images/icons/' . $performer->performers_photo_id_status . '.png') ?>" /></a></td>
						<?php endif?>
						
						<td style="text-align:center"><img src="<?php echo assets_url('admin/images/')?><?php echo ($performer->performers_is_online) ? 'online.png' : 'offline.png'?>" alt="" /> </td>
	                    <?php if($performer->performers_is_online):?>
	                        <td style="text-align:center">
	                        	<div class="spy">
		                        	<a style="cursor: pointer;" onclick="window.open('<?php echo site_url('performers/spy/'.$performer->performers_id)?>','Spy','menubar=no,width=960,height=580,toolbar=no')">
		                        		&nbsp;&nbsp;&nbsp;&nbsp;
		                        	</a>
	                        	</div>
	                        </td>                        
	                    <?php else: ?>
	                        <td><div class="no-spy"></div></td>
	                    <?php endif ?>								
						<td style="text-align:center"><img src="<?php echo assets_url('admin/images/icons/')?><?php echo ($performer->performers_is_online_hd) ? 'approved.png' : 'rejected.png'?>" alt="" /></td>
						<td style="text-align:center">
							<?php if($performer->performers_is_online_type):
										echo	$performer->performers_is_online_type;
								else:?>
										<img src="<?php echo assets_url('admin/images/icons/na.png') ?>" />
							<?php endif?>		
						</td>
						<td style="text-align:center"><img src="<?php echo assets_url('admin/images/icons/')?><?php echo ($performer->performers_is_in_private) ? 'approved.png' : 'rejected.png'?>" alt="" /></td>
						<td style="text-align:center"><img src="<?php echo assets_url('admin/images/icons/')?><?php echo ($performer->performers_enable_peek_mode) ? 'approved.png' : 'rejected.png'?>" alt="" /></td>
						<td style="text-align:center">
							<?php if( $performer->studios_username ) :?>						
								<a href="<?php echo site_url('studios/account/'.$performer->studios_username )?>"> <?php echo $performer->studios_username?></a>
							<?php else:?>
								<img src="<?php echo assets_url('admin/images/icons/na.png') ?>" />
							<?php endif?>
						</td>
						<td><?php echo print_amount_by_currency($performer->performers_credits) ?></td>
						<td style="text-align: center;">
							<a href="<?php echo site_url()?>performers/delete/<?php echo $performer->performers_id ?>" onclick="if(confirm('<?php echo lang('Are you sure you want to delete this performer?')?>')) { return true;} else {return false;}" title=""><img src="<?php echo assets_url('admin/images/icons/icon_unapprove.png') ?>"></a>
						</td>
					</tr>
					<?php $i++?>
				<?php endforeach?>
			<?php endif?>
			</tbody>
		</table>
		<br/>
		
		<div class="extrabottom">
			<?php echo $pagination ?>
			<div class="bulkactions">
			</div>
		</div>
	</div>
</div>