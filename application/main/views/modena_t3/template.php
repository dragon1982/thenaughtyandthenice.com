<?php $this->load->view('includes/head')?>
	<body class="<?php echo (isset($bodyClass)) ? $bodyClass : ''?>">

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
			        			<?php if ($this->router->class == 'home_controller') $this->load->view('includes/_champagne_room_banner');

											if(isset($_categories)){
												if($_categories && is_array($categories) && ($this->router->class == 'performers_controller'))
													$this->load->view('includes/_categories');
											}

											if(isset($page)){
												$this->load->view($page);
											}
										?>

										<?php $this->load->view('includes/footer')?>

			        </div><!--end content-->

							<?php if($this->user->id > 0) $this->load->view('includes/chatSidebar'); ?>
							<?php
								if($this->user->id > 0) {
									if(isset($friends)) $data['friends'] = $friends;
									else $data['friends'] = $this->friends->get_data($this->user->id);
									$this->load->view('relations',$data);
								}
							?>
							<br /><br /><br />

						</div><!--end wrapper-->


		    </div><!--end site-decoration-content-->
		</div><!--end site-decoration-->

		<!-- Included JS Files -->
		<script src="<?php echo assets_url()?>javascripts/modernizr.foundation.js"></script>
		<script src="<?php echo assets_url()?>javascripts/foundation.js"></script>
		<script src="<?php echo assets_url()?>javascripts/app.js"></script>
		<?php if($this->user->id > 0): ?>
			<script type="text/javascript">
				var friends = new Array();
				<?php foreach($data['friends']['online'] as $key => $friend): ?>
					var friend = new Object;
					var label = "<?php echo $friend->id.'_'.$friend->type; ?>";
					friend.id = "<?php echo $friend->id; ?>";
					friend.type = "<?php echo $friend->type; ?>";
					friend.username = "<?php echo $friend->username; ?>";
					friends[label] = friend;
				<?php endforeach; ?>
			</script>

			<script type="text/javascript" src="<?php echo assets_url()?>js/jquery-1.7.2.min.js"></script>
			<script src="<?php echo assets_url()?>js/chat_main.js"></script>
		<?php endif; ?>
	</body>
</html>