<table>
	<?php if(isset($friends['request'])): ?>
		<tr>
			<td colspan="3" align="center" bgcolor="#bbbbbb">
				<?php if($friends['request']->status == 'new'): ?>
					<?php echo form_open('user/add_relation', array('id'=>'add_relation_form', 'method'=>'post')); ?>
						<input type="hidden" name="id" value="<?php echo $friends['request']->id; ?>" />
						<input type="hidden" name="type" value="<?php echo $friends['request']->type; ?>" />
						<input type="submit" value="Send friend request" />
					</form>
				<?php elseif($friends['request']->status == 'pending'): ?>
					Friend request sent
				<?php elseif($friends['request']->status == 'ban'): ?>
					The user is banned
				<?php elseif($friends['request']->status == 'banned'): ?>
					You were banned by this user
				<?php endif; ?>
			</td>
		</tr>
	<?php endif; ?>
	<tr><td colspan="3" align="center" bgcolor="#bbbbbb"><b>Friends</b></td></tr>
	<?php foreach($friends['accepted'] as $friend): ?>
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
	<?php foreach($friends['pending'] as $friend): ?>
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
	<tr><td colspan="3" align="center" bgcolor="#bbbbbb"><b>Friend requests</b></td></tr>
	<?php foreach($friends['requests'] as $friend): ?>
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
	<?php foreach($friends['banned'] as $friend): ?>
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