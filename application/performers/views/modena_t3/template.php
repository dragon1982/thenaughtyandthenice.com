<?php $this->load->view('includes/head')?>
<body>
	<div id="background_img_wrap"><img src="<?php echo assets_url()?>images/bg<?php echo mt_rand(1, 3)?>.jpg" id="background-img" alt="" /></div>
	<?php if($page == 'performerMyAccount' || isset($_performer_menu) && $_performer_menu):?>	
		<div id="top_menu_bg"></div>
	<?php endif?>			
	<div id="warpper">
		<div id="header">
			<?php
				if($this->user->id > 0){
					$this->load->view('includes/performer_account_info');					
				}else{
					$this->load->view('includes/_top_login');
				}
	
			?>
			<div class="clear"></div>
			<?php
				if($page == 'performerMyAccount' || isset($_performer_menu) && $_performer_menu){
					$this->load->view('includes/menu_performer');
				}
				
				$this->load->view('includes/errors');
			?>
		</div>
		<?php 
			if($this->user->id > 0) {
				if(isset($friends)) $data['friends'] = $friends;
				else $data['friends'] = $this->users->get_friends_data($this->user->id,'performer');
				$this->load->view('relations',$data); 
			}
		?>
		<div id="page">
			<?php
				if(isset($_sidebar) && $_sidebar){
					$this->load->view('includes/_sidebar');
				}elseif(isset($page) && !(isset($_payments_sidebar) && $_payments_sidebar)){						
					$this->load->view($page);
				}
				
				if(isset($_payments_sidebar) && $_payments_sidebar) {
					$this->load->view('includes/_my_payments_sidebar');
				}
				
			?>
		</div>
	</div>
	<div class="clear"></div>
	<?php $this->load->view('includes/footer')?>
	<?php if($this->user->id > 0): ?>
		<script src="<?php echo assets_url()?>js/chat.js.php?app=performer"></script>
	<?php endif; ?>
</body>
</html>