
            <section>
				<?php
				$champagneRoomFeatured = $champagne_room_featured->row_array();
				$now = time();
				//echo date('d-m-Y, H:i:s', $champagneRoomFeatured['start_time']);
				$timeLeft = $champagneRoomFeatured['start_time']-$now;
				if($timeLeft<0){
					$tlHour = '00';
					$tlMin = '00';
					$tlSec = '00';
				}else{
					$tlHour = date('H', $timeLeft);
					$tlMin = date('i', $timeLeft);
					$tlSec = date('s', $timeLeft);
				}
				$startTime = date('H:i', $champagneRoomFeatured['start_time']);
				?>
            	<header>
                    <div class="box-t4">
                        <div class="box-t4-content2 clearfix">
                            <div class="clock clearfix left">
                                <div class="left-part">
                                    <div class="time-decoration"><!-- --></div>
                                    <div class="time-no"><?php echo $tlHour?></div>
                                    <div class="time-desc">Hours</div>
                                </div>							
                                <div class="left-part">
                                    <div class="time-decoration"><!-- --></div>
                                    <div class="time-no"><?php echo $tlMin?></div>
                                    <div class="time-desc">Minutes</div>
                                </div>
                                <div class="right-part">
                                    <div class="time-decoration"><!-- --></div>
                                    <div class="time-no"><?php echo $tlSec?></div>
                                    <div class="time-desc">Seconds</div>
                                </div>
                            </div><!-- end clock -->

                            <div class="title-national-show"><img src="<?php echo assets_url()?>images/title-champagne-room-national-show.png" alt="Champagne room National Show starts at"><span><?php echo $startTime?></span></div>
                            <a href="javascript:;" class="btn-nice-1">Buy tickets!</a>
                        </div><!--end box-t4-conten2t-->
                    </div>
                </header>

                <ul class="list-t3 clearfix">
					<?php
					foreach($champagne_rooms_featured->result_array() as $champagneRoom):
					$type = (isset($champagneRoom['type'])) ? $champagneRoom['type'] : 'girl';
					?>
                	<li class="clearfix">
                    	<article class="box-t1 clearfix">
                        	<div class="featuring-label">Featuring</div>
                        	<div class="box-decoration"><!-- --></div>
                        	<div class=" thumb-size-2">
								<a href="<?php echo site_url('champagne_room/view/'.$champagneRoom['id'])?>">
									<img src="<?php echo  ( ! (file_exists('uploads/performers/' . $champagneRoom['performer_id'] . '/small/' . $champagneRoom['avatar']) && $champagneRoom['avatar']))? assets_url().'images/poza_tarfa.png':site_url('uploads/performers/' . $champagneRoom['performer_id'] . '/small/' . $champagneRoom['avatar'])?>" alt="" width="246">
								</a>
							</div>
                            <div class="model-desc">
                                <div class="model-name"><a href="javascript:;"><?php echo $champagneRoom['nickname']?></a></div>
                                <p class="model-stats">
                                    <strong><?php echo floor((time() - $champagneRoom['birthday'])/31556926)?> years</strong> - <?php echo $champagneRoom['city']?>, <?php echo $champagneRoom['state']?>  <br>
                                    Show Type: <strong><?php echo $type?></strong> 
                                </p>
                            </div>
                        </article>
                    </li>
					<?php endforeach;?>
                </ul>

            </section>



            <section class="set-bott-1">
                <header class="box-header clearfix">
                    <div class="box-title-1"><a href="javascript:;"><img src="<?php echo assets_url()?>images/title-champagne-room-shows.png" alt="Champagne room"></a></div>
                </header>

                <ul class="list-t2 clearfix">
					<?php
					foreach($champagne_rooms->result_array() as $champagneRoom):
					$type = (isset($champagneRoom['type'])) ? $champagneRoom['type'] : 'girl';
					?>				
                	<li>
                    	<article class="box-t1 clearfix">
                        	<div class="left">
								<a href="javascript:;">
									<img src="<?php echo  ( ! (file_exists('uploads/performers/' . $champagneRoom['performer_id'] . '/small/' . $champagneRoom['avatar']) && $champagneRoom['avatar']))? assets_url().'images/poza_tarfa.png':site_url('uploads/performers/' . $champagneRoom['id'] . '/small/' . $champagneRoom['avatar'])?>" alt="" width="178">
								</a>														
							</div>
                            <div class="prefix-10 set-top-10">
                                <div class="text-size-1 set-bott-2"><a href="javascript:;"><?php echo $champagneRoom['nickname']?></a></div>
                                <p class="model-stats">
                                    <strong><?php echo floor((time() - $champagneRoom['birthday'])/31556926)?> years</strong> - <?php echo $champagneRoom['city']?>, <?php echo $champagneRoom['state']?> <br>
                                    Show Type: <strong><?php echo $type?></strong> 
                                </p>
                                <div class="buy-tickets clearfix">
                                	<div class="text-normal text-color-1 left"><span class="text-size-1"><strong>3:30</span> remaining</strong></div>
                                    <a class="btn-nice-5 right" href="javascript:;">Buy tickets</a>
                                </div>
                            </div>
                        </article>
                    </li>
					<?php endforeach;?>
                </ul>



            </section>

