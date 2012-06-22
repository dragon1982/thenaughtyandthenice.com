<?php $this->load->view('includes/head')?>
	<body>

		<div id="site-decoration">
		    <div id="site-decoration-content">

		        <header id="master-header" class="clearfix">
		        		<div class="left">
		                <a id="master-logo" href="<?php echo base_url()?>"><img src="<?php echo assets_url()?>images/logo.png" alt="The Naughty And The Nice" /></a>
		                <nav id="master-nav" class="clearfix">

												<?php
													if($page == 'performerMyAccount'){
														$this->load->view('includes/menu_performer');
													}else{
														$this->load->view('includes/menu');
													}

													if(isset($_categories) && $_categories && is_array($categories)){
														//$this->load->view('includes/_categories');
													}

													$this->load->view('includes/errors');

												?>

		                </nav>

		            </div><!--end left-->

								<?php
									if($this->user->id > 0){
										$this->load->view('includes/user_account_info');
									}else{
										$this->load->view('includes/_top_login');
									}
								?>
		        </header><!--end master-header-->

		    		<div id="wrapper" class="clearfix">
			        <div id="content">
										<?php
											if(isset($_sidebar) && $_sidebar){
												$this->load->view('includes/_sidebar');
											}elseif(isset($page)){
												$this->load->view($page);
											}
										?>

										<?php $this->load->view('includes/footer')?>

			        </div><!--end content-->

							<?php
								if($this->user->id > 0) {
									if(isset($friends)) $data['friends'] = $friends;
									else $data['friends'] = $this->users->get_friends_data($this->user->id,'user');
									$this->load->view('relations',$data);
								}
							?>
							<br /><br /><br />
							<?php if($this->user->id > 0) $this->load->view('includes/chatSidebar')?>

						</div><!--end wrapper-->


		    </div><!--end site-decoration-content-->
		</div><!--end site-decoration-->

		<!-- Included JS Files -->
		<script src="<?php echo assets_url()?>javascripts/modernizr.foundation.js"></script>
		<script src="<?php echo assets_url()?>javascripts/foundation.js"></script>
		<script src="<?php echo assets_url()?>javascripts/app.js"></script>
		<?php if($this->user->id > 0): ?>
			<script type="text/javascript" src="<?php echo assets_url()?>js/jquery-1.7.2.min.js"></script>
			<script src="<?php echo assets_url()?>js/chat.js.frontend.php"></script>
		<?php endif; ?>
	</body>
</html>