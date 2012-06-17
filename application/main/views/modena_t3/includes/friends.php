<!-- 
<div class="black_box_bg_middle">
	<div class="black_box_bg_top">
		<div class="black_box">
			<div class="content">
				<div class="title">
					<span class="eutemia ">F</span><span class="helvetica ">riends List</span>	
				</div>
				<div class="clear"></div>
				
			</div>
		</div>
	</div>
</div>
-->
<table>
	<tr><td colspan="3" align="center" bgcolor="#bbbbbb"><b>Friends</b></td></tr>
	<?php foreach($accepted_friends as $friend): ?>
	<tr>
		<td><?php echo $friend->username; ?></td>
		<td>
			<?php echo form_open('user/delete_relation', array('id'=>'delete_relation_form', 'method'=>'post')); ?>
				<input type="hidden" name="rel_id" value="<?php echo $friend->rel_id; ?>" />
				<input type="submit" value="Remove friend" />
			</form>
		</td>
		<td>
			<?php echo form_open('user/ban_relation', array('id'=>'ban_relation_form', 'method'=>'post')); ?>
				<input type="hidden" name="rel_id" value="<?php echo $friend->rel_id; ?>" />
				<input type="submit" value="Ban friend" />
			</form>
		</td>
	</tr>
	<?php endforeach; ?>
	<tr><td colspan="3" align="center" bgcolor="#bbbbbb"><b>Pending friends</b></td></tr>
	<?php foreach($pending_friends as $friend): ?>
	<tr>
		<td><?php echo $friend->username; ?></td>
		<td colspan="2">
			<?php echo form_open('user/delete_relation', array('id'=>'delete_relation_form', 'method'=>'post')); ?>
				<input type="hidden" name="rel_id" value="<?php echo $friend->rel_id; ?>" />
				<input type="submit" value="Cancel request" />
			</form>
		</td>
	</tr>
	<?php endforeach; ?>
	<tr><td colspan="3" align="center" bgcolor="#bbbbbb"><b>Friend request</b></td></tr>
	<?php foreach($friend_requests as $friend): ?>
	<tr>
		<td><?php echo $friend->username; ?></td>
		<td>
			<?php echo form_open('user/accept_relation', array('id'=>'accept_relation_form', 'method'=>'post')); ?>
				<input type="hidden" name="rel_id" value="<?php echo $friend->rel_id; ?>" />
				<input type="submit" value="Accept friend" />
			</form>
		</td>
		<td>
			<?php echo form_open('user/delete_relation', array('id'=>'delete_relation_form', 'method'=>'post')); ?>
				<input type="hidden" name="rel_id" value="<?php echo $friend->rel_id; ?>" />
				<input type="submit" value="Refuse" />
			</form>
		</td>
	</tr>
	<?php endforeach; ?>
	<tr><td colspan="3" align="center" bgcolor="#bbbbbb"><b>Banned friends</b></td></tr>
	<?php foreach($banned_friends as $friend): ?>
	<tr>
		<td><?php echo $friend->username; ?></td>
		<td colspan="2">
			<?php echo form_open('user/delete_relation', array('id'=>'delete_relation_form', 'method'=>'post')); ?>
				<input type="hidden" name="rel_id" value="<?php echo $friend->rel_id; ?>" />
				<input type="submit" value="Unban" />
			</form>
		</td>
	</tr>
	<?php endforeach; ?>
</table>