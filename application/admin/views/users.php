<script type="text/javascript">
	$(document).ready(function(){
		$('#reset_filters').click(function(){
			document.location.href='<?php echo site_url('users')?>';
		});

		$('.sort').click(function(){
			var url = '<?php echo site_url('users')?>?<?php echo $filters?>&';
			document.location.href= url + 'orderby[' + $(this).attr('id')  + ']=' + $(this).attr('order'); 
		});
		
	});
	</script>
			<div class="container">
				<div class="conthead">
					<h2><?php echo lang('Users') ?></h2>
				</div>

				<div class="contentbox">
					<div class="bulkactions" style="margin-bottom: 10px;">
						<?php echo form_open('users','method="GET"')?>
							<p style="float:left; margin-right:10px;">
								&nbsp;<?php echo lang('Username')?><br/>
								<?php echo form_input('filters[username]', $this->input->_fetch_from_array($this->input->get('filters'),'username',TRUE), 'class="inputbox" style="min-width:150px;"')?>
							</p>
							<p style="float:left; margin-right:10px;">
								&nbsp;<?php echo lang('Email')?><br/>
								<?php echo form_input('filters[email]', $this->input->_fetch_from_array($this->input->get('filters'),'email',TRUE), 'class="inputbox" style="min-width:150px;"')?>
							</p>
							<p style="float:left; margin-right:10px;">
								&nbsp;<?php echo lang('Status')?><br/>
								<?php echo form_dropdown('filters[status]', array(''=>lang('All'), 'pending'=>lang('Pending'), 'approved'=>lang('Approved'), 'rejected'=>lang('Rejected')), $this->input->_fetch_from_array($this->input->get('filters'),'status',TRUE) , 'style="min-width:155px; margin:0px;"')?>
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
								<?php $this->load->view('table_sorting',array('name'=>lang('E-mail'),			'key'=>'email',				'style'=>'width:100px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Status'),			'key'=>'status',			'style'=>'width:60px') )?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Gateway'),			'key'=>'gateway',			'style'=>'width:80px') )?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Affiliate ID'),		'key'=>'affiliate_id',		'style'=>'width:80px'))?>
								<?php $this->load->view('table_sorting',array('name'=>lang('Credits'),			'key'=>'credits',			'style'=>'width:40px'))?>
								<th style="width: 60px; text-align: center;"><?php echo lang('Actions')?></th>
							</tr>
						</thead>
						<tbody>
					<?php if(sizeof($users) == 0) : ?>
						<tr>
							<td colspan="9"><div style="text-align:center; width:100%; " class="clear"><h3><?php echo lang('There are no entries')?></h3></div></td>
						</tr>
					<?php else :
							$i = 1; 
							foreach ($users as $user) : ?>
								<tr <?php echo ($i%2 == 0) ? 'class="alt"' : null?>>
									<td><?php echo $user->users_id?></td>
									<td><img src="<?php echo assets_url('admin/images/flags/' . $user->users_detail_country_code . '.png') ?>" /></td>
									<td><a href="<?php echo site_url()?>users/account/<?php echo $user->users_username?>"><?php echo $user->users_username?></a></td>
									<td><?php echo $user->users_email?></td>
									<td><img src="<?php echo assets_url('admin/images/icons/' . $user->users_status . '.png') ?>" /></td>
									<td><?php echo ($user->users_gateway) ? $user->users_gateway : '-' ?></td>
									<td><?php echo ($user->users_detail_affiliate_id) ? $user->users_gateway : '-' ?></td>
									<td><?php echo print_amount_by_currency($user->users_credits)?></td>
									<td style="text-align: center;">
										<a href="<?php echo site_url()?>users/delete/<?php echo $user->users_id?>" onclick="if(confirm('<?php echo lang('Are you sure you want to delete this user?')?>')) { return true;} else {return false;}" title=""><img src="<?php echo assets_url('admin/images/icons/icon_unapprove.png') ?>"></a>
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

