<?php $this->load->view('includes/head')?>
	<body>
		<div id="background_img_wrap"><img src="<?php echo assets_url()?>images/bg<?php echo mt_rand(1, 3)?>.jpg" id="background-img" alt="" /></div>
		<div id="top_menu_bg"></div>
		<div id="warpper">
			<div id="header">
				<?php
					if($this->user->id > 0){
						$this->load->view('includes/user_account_info');
					}else{
						$this->load->view('includes/_top_login');
					}						
				?>

				<div class="clear"></div>

				<?php
					if($page == 'performerMyAccount'){
						$this->load->view('includes/menu_performer');
					}else{
						$this->load->view('includes/menu');
					}
					
					if(isset($_categories) && $_categories && is_array($categories)){
						$this->load->view('includes/_categories');
					}
										
					$this->load->view('includes/errors');

				?>
			</div>
			<div id="page">
			
				<?php 
					if($this->user->id > 0 && isset($friends)) {
						if($friends) $this->load->view('includes/friends'); 
					}
				?>
				
				<?php
					if(isset($_sidebar) && $_sidebar){
						$this->load->view('includes/_sidebar');
					}elseif(isset($page)){						
						$this->load->view($page);
					}
				?>


			</div>
		</div>
		<div class="clear"></div>
		<?php $this->load->view('includes/footer')?>
	</body>
</html>