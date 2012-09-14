                	<ul id="usersListing" class="list-t1">
										<?php foreach($users as $user):?>
                    	<li>
                        	<article class="box-t1">
                                <div class="thumb-size-1-container">
                                    <header>
                                    	<h1>
                                        	<a class="title-topic-1" href="<?php echo site_url($user->nickname)?>">
                                            	<?php echo $user->performer_status?>
                                            </a>
                                        </h1>
                                    </header>
                                    <a class="model-status" href="javascript:;"><!-- --></a>
                    								<?php if($user->performer_status != null):?>
                                    	<a class="bg-topic-1" href="<?php echo site_url($user->nickname)?>"><!-- --></a>
                                    <?php endif;?>
                                    <a class="thumb-size-1" href="<?php echo site_url($user->nickname)?>">
                                    	<img src="<?php echo  ( ! (file_exists('uploads/performers/' . $user->id . '/small/' . $user->avatar) && $user->avatar))? assets_url().'images/poza_tarfa.png':site_url('uploads/performers/' . $user->id . '/small/' . $user->avatar)?>" alt="" width="246">
                                    </a>
                                </div><!-- thumb-size-1-container -->
                                <div class="model-desc">
                                	<div class="model-name"><a href="<?php echo site_url($user->nickname)?>"><?php echo $user->nickname?></a></div>
                                    <p class="model-stats">
                                        <strong><?php echo floor((time() - $user->birthday)/31556926);?> years</strong> - <?php echo $user->city?>, <?php echo $user->state?> <br>
                                        Score: <strong><?php echo ($user->score)?$user->score:'N/A';  ?></strong>
                                    </p>
                                </div>
                                <div class="clearfix">
                                    <a href="<?php echo site_url($user->nickname)?>" class="btn-view-profile">Profile</a>
                                    <a href="<?php echo site_url($user->nickname)?>" class="btn-view-webcam">Webcam</a>
                                </div>
                            </article>
                        </li>
											<?php endforeach?>
                    </ul><!--end list-t1-->

	  <script type="text/javascript">
	  //var $j = jQuery.noConflict();
		$(function() {
			$('#usersListing').slimScroll({
					height: '<?php echo $pageViewHeight ?>px',
				  width: '<?php echo ($this->user->id > 0)? '941px' : '1101px'?>',
				  railVisible: true,
				  alwaysVisible: true,
				  railColor: '#27434e',
				  opacity: 1,
				  color: '#69a4bb',
				  size: '10px'
			  });
		  });
	  </script>