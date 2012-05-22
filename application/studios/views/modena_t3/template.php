<?php $this->load->view('includes/head')?>
	<body>
		<div id="background_img_wrap"><img src="<?php echo assets_url()?>images/bg<?php echo mt_rand(1, 3)?>.jpg" id="background-img" alt="" /></div>
		<?php if(isset($this->performer->id)):?>
			<div id="top_menu_bg"></div>
		<?php endif?>
		<div id="warpper">
			<div id="header">
				<?php
					if($this->user->id > 0){
						$this->load->view('includes/studio_account_info');
					}else{
						$this->load->view('includes/_top_login');
					}						
				?>

				<div class="clear"></div>				
				<?php
					if(isset($this->performer->id)){
						$this->load->view('includes/menu');
					}
					$this->load->view('includes/errors');
				?>				
				</div>
			<div id="page">
				<?php
					if(isset($_sidebar) && $_sidebar){
						$this->load->view('includes/_sidebar');
					}
					elseif(isset($page) && !(isset($_settings_sidebar) && $_settings_sidebar) && !(isset($_payments_sidebar) && $_payments_sidebar)) {						
						$this->load->view($page);
					}
					
					if(isset($_payments_sidebar) && $_payments_sidebar) {
						$this->load->view('performers/includes/_my_payments_sidebar');
					}
					
					if(isset($_settings_sidebar) && $_settings_sidebar) {
						$this->load->view('includes/_my_settings_sidebar');
					}					
				?>
			</div>
		</div>
		<div class="clear"></div>
		<?php $this->load->view('includes/footer')?>
	</body>
</html>