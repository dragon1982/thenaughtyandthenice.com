			<?php $category_id = (isset($category) && is_object($category)) ? $category->id : 0 ?> 
			<div class="container">
				<div class="conthead">
					<h2><?php echo ($category_id > 0)? lang('Edit') : lang('Add')?> <?php echo lang('category')?></h2>
				</div>

				<div class="contentbox">
					
					<?php echo form_open('categories/add_or_edit/'.$category_id)?>
						<div class="inputboxes">
							<label for="name"><?php echo lang('Name')?>: </label>
							<?php echo form_input('name', set_value('name', (isset($category) && is_object($category))? $category->name : null), 'id="name" class="inputbox" tabindex="1" type="text"')?>
						</div>
						<div class="inputboxes">
							<label for="parent_id"><?php echo lang('Parent')?>: </label>
							<?php echo form_dropdown('parent_id', $categories, (isset($category) && is_object($category))? $category->parent_id : false, 'id="parent_id" class="inputbox" tabindex="1" type="text" style="width:323px;"')?>
						</div>
						
						<input class="btn" type="submit" tabindex="3" value="<?php echo ($category_id > 0)? lang('Update') : lang('Add')?> <?php echo lang('category')?>" />
					<?php echo form_close()?>
				</div>
			</div>
