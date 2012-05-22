<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="<?php echo $width?>" height="<?php echo $height?>" id="movie_name" align="middle">
    <param name="movie" value="<?php echo main_url('assets/swf/' . $swf)?>" />
    <?php if (sizeof($params) > 0) :?>
    	<param name="flashvars" value="<?php echo implode_string($params) ?>" />
    <?php endif?>
    <?php if(isset($allow_fullscreen)):?>
   		<param name="allowfullscreen" value="true">  
    <?php endif?>
     <?php if ($this->agent->is_browser('Safari')):?>
			 <param name="WMode" value="window">
		<?php else:?>
			<param name="WMode" value="Transparent">
		<?php endif?>
    <!--[if !IE]>-->
    <object type="application/x-shockwave-flash" data="<?php echo main_url('assets/swf/' . $swf )?>" width="<?php echo $width?>" height="<?php echo $height?>"  wmode="transparent">
        <param name="movie" value="<?php echo main_url('assets/swf/' . $swf)?>" />
	    <?php if (sizeof($params) > 0) :?>
	    	<param name="flashvars" value="<?php echo implode_string($params) ?>" />
	    <?php endif?>
	    <?php if(isset($allow_fullscreen)):?>
	   		<param name="allowfullscreen" value="true">    
	    <?php endif?>	  
	     <?php if ($this->agent->is_browser('Safari')):?>
			 <param name="WMode" value="window">
		<?php else:?>
			<param name="WMode" value="Transparent">
		<?php endif?>          
    <!--<![endif]-->
        <a href="http://www.adobe.com/go/getflash">
            <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player"/>
        </a>
    <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
</object>
