<?php $this->load->view('includes/head')?>
<body>


<div id="site-decoration">
    <div id="site-decoration-content">

        <header id="master-header" class="clearfix">
        	<div class="left">
                <a id="master-logo" href="<?php echo base_url()?>"><img src="<?php echo assets_url()?>images/logo.png" alt="The Naughty And The Nice" /></a>
                <nav id="master-nav" class="clearfix">
                    <ul>
                        <li class="selected"><a href="javascript:;">Home</a></li>
                        <li><a href="javascript:;">Models</a></li>
                        <li><a href="javascript:;">Champagne Room</a></li>
                    </ul>
                </nav>

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

            </div><!--end left-->
            <div class="right">
							<?php
								if($this->user->id > 0){
									$this->load->view('includes/user_account_info');
								}else{
									$this->load->view('includes/_top_login');
								}
							?>
            </div><!--end right-->
        </header><!--end master-header-->

        <div class="content">

            <section>
            	<div class="">

							<?php
								if(isset($_sidebar) && $_sidebar){
									$this->load->view('includes/_sidebar');
								}elseif(isset($page)){
									$this->load->view($page);
								}
							?>

            	</div>
            </section>

        </div><!--end content-->



    </div><!--end site-decoration-content-->
</div><!--end site-decoration-->




	<?php $this->load->view('includes/footer')?>
	<!-- Included JS Files -->
	<script src="<?php echo assets_url()?>javascripts/jquery.min.js"></script>
	<script src="<?php echo assets_url()?>javascripts/modernizr.foundation.js"></script>
	<script src="<?php echo assets_url()?>javascripts/foundation.js"></script>
	<script src="<?php echo assets_url()?>javascripts/app.js"></script>

</body>
</html>