	<nav class="categories set-bott-1">

		<img alt="Categories" src="<?php echo assets_url()?>images/title-categories.png">
			<div class="categories-content clearfix">
      	<ul>
				<?php if(isset($categories) && is_array($categories)):?>
					<?php $per_col = ceil(sizeof($categories) / 3)//cate categorii vor fi afisate pe coloana?>
					<?php foreach($categories as $row => $category):?>
						<?php $active_categories = generate_active_categories();?>
						<li>
							<?php if(key_exists($category->link,$active_categories)):?>
					  	<a class="clearfix" href="<?php echo site_url('performers')?>">
							<?php else:?>
							<a class="clearfix" href="<?php echo site_url('performers')?>?filters[category][]=<?php echo $category->link?>">
							<?php endif?>
					  		<span class="left"><?php echo lang($category->name)?></span>
					  		<span class="right"><?php echo $category->performers_total?> (<?php echo $category->performers_online?>)</span>
					  	</a>
					  </li>
						<?php endforeach;?>
				<?php endif ?>
      	</ul>


    	</div><!--end categories-content-->
  	<div class="categories-decoration"><!-- --></div>
  </nav><!-- categories -->