<?php foreach($performers as $performer):?>
	<?php $this->load->view('performer',array('performer' => $performer))?>
<?php endforeach?>
<div class="clear"></div>
<div id="performer_list_pages">
<?php echo $pagination;?>
</div>
<div class="clear"></div>
