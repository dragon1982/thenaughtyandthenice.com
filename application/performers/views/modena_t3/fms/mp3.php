<?php echo '<?xml version="1.0"?>'?>
<mp3 label="Songs">
<?php if(sizeof($songs) > 0):?>
	<?php foreach($songs as $song):?>
		<song label="<?php echo $song->title?>" path="<?php echo main_url('uploads/stuff/'.$song->src)?>"></song>	
	<?php endforeach?>
<?php endif?>
</mp3>