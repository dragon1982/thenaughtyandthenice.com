<script type="text/javascript">
$(document).ready(function(){
	$('#reset_filters').click(function(){
		document.location.href='<?php echo site_url('system_logs')?>';
	});

	$('.sort').click(function(){
		var url = '<?php echo site_url('system_logs')?>?<?php echo $filters?>&';
		document.location.href= url + 'orderby[' + $(this).attr('id')  + ']=' + $(this).attr('order'); 
	});	
});
</script>
<div class="container">
	<div class="conthead">
		<h2><?php echo lang('System logs')?></h2>
	</div>
	<div class="contentbox">
		<div class="bulkactions" style="margin-bottom: 10px;">
			<?php echo form_open('system_logs','method="get"')?>
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('Date')?><br/>
					<?php echo form_input('filters[date]', $this->input->_fetch_from_array($this->input->get('filters'),'date',TRUE), 'class="inputbox datepicker" readonly="readonly" style="min-width:150px;"')?>
				</p>
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('Actor')?><br/>
					<?php echo form_dropdown('filters[actor]',$actor, $this->input->_fetch_from_array($this->input->get('filters'),'actor',TRUE), 'class="inputbox" style="min-width:150px;margin:0px"')?>					
				</p>
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('Actor ID')?><br/>
					<?php echo form_input('filters[actor_id]', $this->input->_fetch_from_array($this->input->get('filters'),'actor_id',TRUE), 'class="inputbox" style="min-width:150px;"')?>
				</p>				
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('Action on')?><br/>
					<?php echo form_dropdown('filters[action_on]', $action_on, $this->input->_fetch_from_array($this->input->get('filters'),'action_on',TRUE), 'class="inputbox" style="min-width:150px;margin:0px"')?>					
				</p>								
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('Action on ID')?><br/>
					<?php echo form_input('filters[action_on_id]', $this->input->_fetch_from_array($this->input->get('filters'),'action_on_id',TRUE), 'class="inputbox" style="min-width:150px;"')?>					
				</p>				
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('Action')?><br/>
					<?php echo form_dropdown('filters[action]', $action, $this->input->_fetch_from_array($this->input->get('filters'),'action',TRUE), 'class="inputbox" style="min-width:150px;margin:0px"')?>					
				</p>
				<p style="float:left; margin-right:10px;">
					&nbsp;<?php echo lang('IP')?><br/>
					<?php echo form_input('filters[ip]', $this->input->_fetch_from_array($this->input->get('filters'),'ip',TRUE), 'class="inputbox" style="min-width:150px;"')?>					
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
					<?php $this->load->view('table_sorting',array('name'=>lang('Date'),				'key'=>'date',			'style'=>'width:200px') )?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Actor'),			'key'=>'actor',			'style'=>'width:100px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Actor ID'),			'key'=>'actor_id',		'style'=>'width:90px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Action on'),		'key'=>'action_on',		'style'=>'width:150px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Action on ID'),		'key'=>'action_on_id',	'style'=>'width:100px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('IP'),				'key'=>'ip',			'style'=>'width:150px'))?>
					<?php $this->load->view('table_sorting',array('name'=>lang('Action'),			'key'=>'action',		'style'=>'width:200px'))?>
					<th><?php echo lang('Action comment')?></th>					
				</tr>
			</thead>
			<tbody>
			<?php if(sizeof($system_logs) == 0 ):?>
				<tr>
					<td colspan="8" style="text-align:center"><div style="text-align:center; width:100%; " class="clear"><h3><?php echo lang('There are no entries')?></h3></div></td>				
				</tr>
			<?php else:?>
				<?php foreach ($system_logs as $log):?>
				<tr>
					<td><?php echo date('Y-m-d H:i:s',$log->date)?></td>
					<td><?php echo $log->actor?></td>
					<td><?php echo $log->actor_id?></td>
					<td><?php echo $log->action_on?></td>
					<td><?php echo $log->action_on_id?></td>
					<td>
						<?php if($log->action == 'login'):
							$country = $this->ip2location->getCountryShort(long2ip($log->ip));
							if( $country ): ?>
								<img src="<?php echo assets_url('admin/images/flags/' . strtoupper($country) . '.png') ?>" />
							<?php endif?>							 							
						<?php endif?>
					<?php echo long2ip($log->ip)?></td>
					<td><?php echo $log->action?></td>
					<td><?php echo $log->action_comment?></td>
				</tr>
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
