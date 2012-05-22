<html>
	<head>
		
		<?
		$ad_type = $width.'x'.$height;
		?>
		<style type="text/css">
			body{
				overflow: hidden;
			}
			
			#afpad{
				
				/*border:1px solid <?php // $border_color?>;*/
				height: <?php echo $height-3?>px;
				margin: 0px;
				width: <?php echo $width-3?>px;
				overflow: hidden;
			}
			
			#afpad a{
				color:<?php echo $text_color?>;
				text-decoration: none;
			}
			
			.bold{
				font-weight: bold;
			}
			
			.type_728x90, .type_468x60, .type_125x125{
				padding:0px 5px;
			}
			
			.type_234x60, .type_120x600, .type_160x600, .type_180x150, .type_120x240, .type_200x200, .type_250x250, .type_300x250, .type_336x280{
				padding:0px 3px;
			}
			
			.type_728x90 .item{
				float:left;
				margin:6px;
			}
			
			.type_468x60 .item, .type_234x60 .item{
				float:left;
				margin:5px 6px;
			}
			.type_125x125 .item{
				float:left;
				margin:16px 6px;
			}
			.type_120x600 .item, .type_160x600 .item, .type_180x150 .item, .type_120x240 .item{
				float:left;
				margin:12px 6px;
			}
			.type_200x200 .item, .type_250x250 .item, .type_300x250 .item, .type_336x280 .item{
				float:left;
				margin:7px 3px;
			}
			
			.type_728x90  .item a img{height:60px;}
			.type_468x60  .item a img{height:50px;}
			.type_125x125 .item a img{height:80px;}
			.type_234x60  .item a img{height:50px;}
			.type_120x600 .item a img{width:100px;}
			.type_160x600 .item a img{width:140px;}
			.type_180x150 .item a img{width:163px;}
			.type_120x240 .item a img{width:100px;}
			.type_200x200 .item a img{width:90px;}
			.type_250x250 .item a img{width:115px;}
			.type_300x250 .item a img{width:286px;}
			.type_336x280 .item a img{width:324px;}
			
		</style>
	</head>
	<body style="margin:0px; padding:0px;">
		
		<div id="afpad" class="type_<?=$ad_type?>">
			<?
		
			
			if(is_array($performers) && count($performers) > 0){
				foreach($performers as $performer){
					
					$item_link = site_url('ads/'.$performer->nickname.'/'.$link_location.'/'.$hash);
				?>
			
			<div class="item">
				<?if($ad_type =='336x280' || $ad_type == '300x250' ){?>
				<div>
					<a href="javascript:void(0);" onclick="parent.location.href='<?php echo $item_link?>';"><img src="<?php echo  ( ! (file_exists('uploads/performers/' . $performer->id . '/medium/' . $performer->avatar) && $performer->avatar))? assets_url().'images/poza_tarfa.png':site_url('uploads/performers/' . $performer->id . '/medium/' . $performer->avatar)?>"/></a>
				</div>
				<?}else{?>
				<div>
					<a href="javascript:void(0);" onclick="parent.location.href='<?php echo $item_link?>';"><img src="<?php echo  ( ! (file_exists('uploads/performers/' . $performer->id . '/small/' . $performer->avatar) && $performer->avatar))? assets_url().'images/poza_tarfa.png':site_url('uploads/performers/' . $performer->id . '/small/' . $performer->avatar)?>"/></a>
				</div>
				<?}?>
<!--				<div>
					<a href="javascript:void(0);" onclick="parent.location.href='<?php echo $item_link?>';"><img src="<?php echo assets_url()?>images/poza_tarfa.png"/></a>
				</div>-->
				<?if($ad_type != '180x150' && $ad_type != '468x60' && $ad_type != '234x60'){?>
				<div style="text-align:center;">
					<a href="javascript:void(0);" onclick="parent.location.href='<?php echo $item_link?>';"><span class="bold"><?php echo $performer->nickname?></span></a>
				</div>
				<?}?>
			</div>
			<?} 
			
			}?>
		</div>
		
	</body>
</html>