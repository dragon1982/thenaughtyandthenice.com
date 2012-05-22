<div id="footer" class="bold italic">
	<br/>
	<a href="<?php echo site_url(PREFORMERS_URL)?>"><?php echo lang('Performer\'s area')?></a>
	
	&nbsp;&nbsp;|&nbsp;&nbsp;
	
	<a href="<?php echo site_url(PREFORMERS_URL . '/register')?>" id="become_performer"><?php echo lang('$$Performers wanted$$')?></a>
	
	&nbsp;&nbsp;|&nbsp;&nbsp;
	
	<a href="<?php echo site_url('documents/policy')?>"><?php echo lang('Privacy policy')?></a>
	
	&nbsp;&nbsp;|&nbsp;&nbsp;
	
	<a href="<?php echo site_url('documents/tos')?>"><?php echo lang('Terms & conditions')?></a>
	
	&nbsp;&nbsp;|&nbsp;&nbsp;
		
	<a href="<?php echo site_url(STUDIOS_URL)?>"><?php echo lang('Studios')?></a>
	
	&nbsp;&nbsp;|&nbsp;&nbsp;
	
	<a href="<?php echo site_url(AFFILIATES_URL)?>"><?php echo lang('Affiliates')?></a>
	
	&nbsp;&nbsp;|&nbsp;&nbsp;
	
	<a href="<?php echo site_url('contact')?>"><?php echo lang('Contact us')?></a>
	
	<div id="langs">
		<span><?php echo lang('Choose your language:')?></span>	
		<?php 
			$langs_av = $this->config->item('lang_avail');
			foreach($langs_av as $row => $language):
		?>
			<a href="<?php echo site_url('language/'.$row)?>" title="<?php echo sprintf(lang('Change language to %s'),$language)?>"><img src="<?php echo assets_url()?>images/flags/<?php echo strtoupper($row)?>.png" alt="<?php echo $language?>" /></a>&nbsp;
		<?php endforeach?>
	</div>
	<?php echo sprintf(lang('ModenaCam - All rights reserved &copy; 2007 - %s'),date('Y'))?>	
	<br/>
	<?php echo lang('This site contains sexually explicit material. Enter this site ONLY if You are over the age of 18!')?><br/>
	<a href="<?php echo site_url('documents/2257')?>"><?php echo lang('18 U.S.C 2257 Record-Keeping Requirements Compliance Statement ')?></a>
</div>
<?php if($this->agent->is_browser('Internet Explorer')):?>
<script type="text/javascript">
	jQuery(function($){
		$('button').click(function(){
			if($(this).parent().is("a")){
				document.location.href = $(this).parent().attr('href'); 
			}
		});
	});
</script>
<?php endif?>

<?php
if(is_file(BASEPATH.'../assets/txt/analytics.txt')){
	echo file_get_contents(BASEPATH.'../assets/txt/analytics.txt');
}
?>