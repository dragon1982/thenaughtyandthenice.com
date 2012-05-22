<?php echo '<?xml version="1.0"?>'?>
<list>
	<?php if(sizeof($userlist) > 0):?>
		<?php foreach($userlist as $user):?>
			<viewer
				username="<?php echo $user->username?>"
				userid="v<?php echo $user->user_id?>"
				chipsum="<?php echo $user->credits - $user->user_paid_chips?>"
				color="#654399"
			>
			</viewer>
		<?php endforeach?>
	<?php endif?>	
</list>