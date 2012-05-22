<div class="categories">
	<div class="left">
		<div>
			<h3 class="italic"><?php echo lang('ALL GIRLS')?></h3>
		</div>
		<div class="col_main">
			<?php if(isset($categories) && is_array($categories)):?>
				<?php $per_col = ceil(sizeof($categories) / 3)//cate categorii vor fi afisate pe coloana?>
				<?php foreach($categories as $row => $category):?>
					<?php if($row % $per_col == 0)://col divizibil cu nr de elemente/coloana?>											
						<?php if($row == 0)://prima coloana deschid div?>
							<div class="category col">
						<?php elseif($row + $per_col > sizeof($categories)):?>
							</div>
							<div class="category last">							
						<?php else://nu e nici prima nici ultima deci trebuie inchis divu si deschisa alta coloana?>
							</div>
							<div class="category col">
						<?php endif?>
					<?php endif?>
					<?php $active_categories = generate_active_categories();?>
					<?php if(key_exists($category->link,$active_categories)):?>						
						<span class="category_name selected"><a href="<?php echo site_url('performers')?>"><?php echo lang($category->name)?> </a></span><span class="value"><?php echo $category->performers_total?>(<?php echo $category->performers_online?>)</span>							
					<?php else:?>						
						<span class="category_name"><a href="<?php echo site_url('performers')?>?filters[category][]=<?php echo $category->link?>"><?php echo lang($category->name)?> </a></span><span class="value"><?php echo $category->performers_total?>(<?php echo $category->performers_online?>)</span>
					<?php endif?>
				<?php endforeach;?>
				</div>
			<?php endif ?>
		</div>
	</div>
</div>