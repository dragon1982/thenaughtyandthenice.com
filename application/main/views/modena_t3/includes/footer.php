            <footer id="master-footer"  class="clearfix">
            	<div class="clearfix">
                    <ul>
                        <li><a href="<?php echo site_url(PREFORMERS_URL)?>"><?php echo lang('Performer\'s area')?></a></li>
                        <li><a href="<?php echo site_url(PREFORMERS_URL . '/register')?>" id="become_performer"><?php echo lang('$$Performers wanted$$')?></a></li>
                        <li><a href="<?php echo site_url('documents/policy')?>"><?php echo lang('Privacy policy')?></a></li>
                        <li><a href="<?php echo site_url('documents/tos')?>"><?php echo lang('Terms & conditions')?></a></li>
                        <li><a href="<?php echo site_url(STUDIOS_URL)?>"><?php echo lang('Studios')?></a></li>
                        <li><a href="<?php echo site_url(AFFILIATES_URL)?>"><?php echo lang('Affiliates')?></a></li>
                        <li><a href="<?php echo site_url('contact')?>"><?php echo lang('Contact us')?></a></li>
                    </ul>
                    <div class="copy">&copy; 2012 The Naughty And The Nice</div>
                </div>
                <div class="legal-notice"><?php echo lang('This site contains sexually explicit material. Enter this site ONLY if You are over the age of 18!')?><br>
									<a href="<?php echo site_url('documents/2257')?>"><?php echo lang('18 U.S.C 2257 Record-Keeping Requirements Compliance Statement ')?></a></div>
                <div></div>

            </footer>


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