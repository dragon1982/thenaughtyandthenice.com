<script type="text/javascript">
	$(document).ready(function(){
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('champagne_rooms')?>';
		});

		$('.sort').click(function(){
			var url = '<?php echo site_url('champagne_rooms')?>?<?php echo $filters?>&';
			document.location.href= url + 'orderby[' + $(this).attr('id')  + ']=' + $(this).attr('order'); 
		});
		
	});
	</script>
			<div class="container">
				<div class="conthead">
					<h2><?php echo lang('Champagne rooms') ?></h2>
				</div>

				<div class="contentbox">
					<div class="bulkactions" style="margin-bottom: 10px;">
						<?php echo form_open('champagne_rooms','method="GET"')?>
							<p style="float:left; margin-right:10px;">
								&nbsp;<?php echo lang('Title')?><br/>
								<?php echo form_input('filters[title]', $this->input->_fetch_from_array($this->input->get('filters'),'title',TRUE), 'class="inputbox" style="min-width:150px;"')?>
							</p>
                                                        <!--
							<p style="float:left; margin-right:10px;">
								&nbsp;<?php echo lang('Status')?><br/>
								<?php echo form_dropdown('filters[status]', array(''=>lang('All'), '0'=>lang('Inactive'), '1'=>lang('Active')), $this->input->_fetch_from_array($this->input->get('filters'),'status',TRUE) , 'style="min-width:155px; margin:0px;"')?>
							</p>
                                                        -->
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
								<?php $this->load->view('table_sorting',array('name'=>lang('ID'),			'key'=>'id',				'style'=>'width:20px') )?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Performer'),		'key'=>'performer',			'style'=>'width:100px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Title'),			'key'=>'title',				'style'=>'width:100px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Private'),			'key'=>'is_private',			'style'=>'width:20px') )?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Type'),			'key'=>'type',                          'style'=>'width:40px') )?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Ticket price'),		'key'=>'ticket_price',                  'style'=>'width:40px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Min ticket number'),	'key'=>'min_tickets',			'style'=>'width:40px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Max ticket number'),	'key'=>'max_tickets',			'style'=>'width:40px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Join in session'),          'key'=>'join_in_session',		'style'=>'width:20px'))?>
                                                                <?php $this->load->view('table_sorting',array('name'=>lang('Start time'),               'key'=>'start_time',                    'style'=>'width:50px'))?>
                                                                <?php $this->load->view('table_sorting',array('name'=>lang('Duration'),                 'key'=>'duration',                      'style'=>'width:30px'))?>
                                                                <?php $this->load->view('table_sorting',array('name'=>lang('Status'),                   'key'=>'status',                        'style'=>'width:40px'))?>
								<th style="width: 60px; text-align: center;"><?php echo lang('Actions')?></th>
							</tr>
						</thead>
						<tbody>
					<?php if(sizeof($champagne_rooms) == 0) : ?>
						<tr>
							<td colspan="13"><div style="text-align:center; width:100%; " class="clear"><h3><?php echo lang('There are no entries')?></h3></div></td>
						</tr>
					<?php else :
							$i = 1; 
							foreach ($champagne_rooms as $champagne_room) : ?>
								<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
									<td><?php echo $champagne_room->champagne_rooms_id?></td>
									<td><?php echo $champagne_room->performers_username?></td>
                                                                        <td><?php echo $champagne_room->champagne_rooms_title?></td>
                                                                        <td><img src="<?php echo assets_url('admin/images/icons/' . ($champagne_room->champagne_rooms_is_private?'approved':'rejected') . '.png') ?>" /></td>
                                                                        <td><?php echo $types[$champagne_room->champagne_rooms_type] ?></td>
                                                                        <td><?php echo $champagne_room->champagne_rooms_ticket_price?></td>
                                                                        <td><?php echo $champagne_room->champagne_rooms_min_tickets?></td>
                                                                        <td><?php echo $champagne_room->champagne_rooms_max_tickets?></td>
                                                                        <td><img src="<?php echo assets_url('admin/images/icons/' . ($champagne_room->champagne_rooms_join_in_session?'approved':'rejected') . '.png') ?>" /></td>
                                                                        <td><?php echo $champagne_room->champagne_rooms_start_time?></td>
                                                                        <td><?php echo _format_seconds($champagne_room->champagne_rooms_duration); ?></td>
                                                                        <td><img src="<?php echo assets_url('admin/images/icons/' . ($champagne_room->champagne_rooms_status?'approved':'rejected') . '.png') ?>" /></td>
									<td style="text-align: center;">
										<a href="<?php echo site_url()?>champagne_rooms/delete/<?php echo $champagne_room->champagne_rooms_id?>" onclick="if(confirm('<?php echo lang('Are you sure you want to delete this champagne room?')?>')) { return true;} else {return false;}" title=""><img src="<?php echo assets_url('admin/images/icons/icon_unapprove.png') ?>"></a>
                                                                                <a href="<?php echo site_url()?>champagne_rooms/add_or_edit/<?php echo $champagne_room->champagne_rooms_id?>" title=""><img src="<?php echo assets_url('admin/images/icons/icon_edit.png') ?>"></a>
                                                                        </td>
								</tr>
								<?php ++$i;?>
							<?php endforeach?>
					<?php endif?>
						</tbody>
					</table>
					<br />
					<div class="extrabottom">
						<?php echo $pagination?>
						<div class="bulkactions">
						</div>
					</div>
				</div>

			</div>

