<?php $this->load->view('includes/head')?>
	<body>
		<div id="background_img_wrap"><img src="<?php echo assets_url()?>images/bg<?php echo mt_rand(1, 3)?>.jpg" id="background-img" alt="" /></div>
		<?php echo ($this->user->id > 0 && $this->user->type == 'affiliate')? '<div id="top_menu_bg"></div>' : null?>
		<div id="warpper">
			<div id="header">
				<?php
				/*
					if($page == 'performerMyAccount' || isset($_performer_menu) && $_performer_menu){
						$this->load->view('includes/performer_account_info');
					}elseif($page == 'userMyAccount'){
						$this->load->view('includes/user_account_info');
					}else{
						$this->load->view('includes/_top_login');
					}
					*/
				
					$this->load->view('includes/_top_login');
				?>

				<div class="clear"></div>

				<?php
					if($this->user->id > 0 ){
						$this->load->view('includes/menu');
					}
					
					
					$this->load->view('includes/errors');
				?>
			</div>
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
	</body>
</html>