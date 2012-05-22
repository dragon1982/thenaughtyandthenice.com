<script type="text/javascript">
	$(document).ready(function(){
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('affiliates')?>';
		});

		$('.sort').click(function(){
			var url = '<?php echo site_url('affiliates')?>?<?php echo $filters?>&';
			document.location.href= url + 'orderby[' + $(this).attr('id')  + ']=' + $(this).attr('order'); 
		});
	});
	</script>
			<div class="container">
				<div class="conthead">
					<h2><?php echo lang ('Affiliates') ?></h2>
				</div>

				<div class="contentbox">
					<div class="bulkactions" style="margin-bottom: 10px;">
						<?php echo form_open('affiliates','method="GET"')?>
							<p style="float:left; margin-right:10px;">
								&nbsp;<?php echo lang('Affiliate ID')?><br/>
								<?php echo form_input('filters[id]', $this->input->_fetch_from_array($this->input->get('filters'),'id',TRUE), 'class="inputbox" style="min-width:150px;"')?>
							</p>
							<p style="float:left; margin-right:10px;">
								&nbsp;<?php echo lang('Username')?><br/>
								<?php echo form_input('filters[username]', $this->input->_fetch_from_array($this->input->get('filters'),'username',TRUE), 'class="inputbox" style="min-width:150px;"')?>					
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
								<?php $this->load->view('table_sorting',array('name'=>lang('Credits'),			'key'=>'credits',			'style'=>'width:40px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('First name'),		'key'=>'first_name',		'style'=>'width:100px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Last name'),		'key'=>'last_name',			'style'=>'width:100px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('E-mail'),			'key'=>'email',				'style'=>'width:100px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Register Date'),	'key'=>'register_date',		'style'=>'width:60px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Register IP'),		'key'=>'register_ip',		'style'=>'width:60px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Status'),			'key'=>'status',			'style'=>'width:60px'))?>
								<th style="width: 60px; text-align: center;"><?php echo lang('Actions')?></th>
							</tr>
						</thead>
						<tbody>
					<?php if( sizeof($affiliates) == 0) : ?>
						<tr>
							<td colspan="11"><div style="text-align:center; width:100%; " class="clear"><h3><?php echo lang('There are no entries')?></h3></div></td>
						</tr>
					<?php else :
						$i = 1;
						foreach ($affiliates as $affiliate):?>
							<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
								<td><?php echo $affiliate->id?></td>
								<td><img src="<?php echo assets_url('admin/images/flags/' . $affiliate->country_code . '.png') ?>" /></td>
								<td><a href="<?php echo site_url('affiliates/')?>/account/<?php echo $affiliate->username?>"><?php echo $affiliate->username?></a></td>
								<td><?php echo $affiliate->credits?></td>
								<td><?php echo $affiliate->first_name?></td>
								<td><?php echo $affiliate->last_name?></td>
								<td><?php echo $affiliate->email?></td>
								<td><?php echo date('d M Y H:i', $affiliate->register_date)?></td>
								<td><?php echo long2ip($affiliate->register_ip)?></td>
								<td><img src="<?php echo assets_url('admin/images/icons/' . $affiliate->status . '.png') ?>" /></td>
								<td style="text-align: center;">
									<a href="<?php echo site_url('affiliates')?>/delete/<?php echo $affiliate->id?>" onclick="if(confirm('<?php echo lang('Are you sure you want to delete this Affiliate?')?>')) { return true;} else {return false;}" title=""><img src="<?php echo assets_url('admin/images/icons/icon_unapprove.png') ?>"></a>
								</td>
							</tr>
							<?php $i++?>
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