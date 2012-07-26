<ul>
	<li <?php if ($this->router->class == 'home_controller'):?>class="selected"<?php endif;?>><a href="<?php echo base_url()?>">Home</a></li>
	<li <?php if ($this->router->class == 'performers_controller'):?>class="selected"<?php endif;?>><a href="<?php echo site_url('performers')?>"><?php echo lang('models')?></a></li>
	<li <?php if ($this->router->class == 'champagne_room_controller'):?>class="selected"<?php endif;?>><a href="<?php echo site_url('champagne-room')?>">Champagne Room</a></li>
</ul>

