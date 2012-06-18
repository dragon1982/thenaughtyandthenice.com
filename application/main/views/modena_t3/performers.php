<?php if ($this->router->class == 'home_controller'):?>
<section class="set-bott-1">
    <header class="box-header clearfix">
        <div class="box-title-1"><a href="javascript:;"><img src="<?php echo assets_url()?>images/title-champagne-room.png" alt="Champagne room"></a></div>
    </header>
    <img src="<?php echo assets_url()?>promo-champagneroom-homepage.png">
</section>
<?php endif;?>


<section class="set-bott-1">
    <div class="box-header clearfix">
        <h1 class="left box-title-1">
        	<a href="javascript:;"><img src="<?php echo assets_url()?>images/title-models-online.png" alt="Models Online now"></a></h1>
        <ul class="tabs-t1 left set-tabs-pos">
            <li class="selected"><a href="javascript:;"> Most viewed  </a></li>
            <li><a href="javascript:;">Newest</a></li>
            <li><a href="javascript:;">Cam score</a></li>
        </ul>
        <form action="" class="search clearfix">
            <div class="search-input"><input value="Keywords" type="text"></div>
            <div class="search-submit"><input type="submit" value=""></div>
        </form>
    </div><!--end box-header-->

    <div class="models-list clearfix">
    	<?php
    	$users = $performers;
    	$this->load->view('usersListing',array('users'=>$users, 'pageViewHeight'=>$pageViewHeight));
    	?>
    </div><!--end models-list-->
</section>