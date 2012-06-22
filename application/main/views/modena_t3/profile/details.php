                        	<div class="box-header-2">
                            	<h2 class="title1"><?php echo lang('Performer`s profile') ?></h2>
                          </div>

														<?php if ($photos): ?>
															<?php if(isset($photos[0])):?>
	                            <section id="latest-photos" class="latest-photos">
	                            	<div class="latest-photos-content clearfix">
																				<?php
																				shuffle($photos);
																				$n = count($photos);
																				$show_n = ($n>5) ? 5 : $n;
																				for ($i = 0; $i < $show_n-1; $i++):
																				$photo = $photos[$i];
																				?>
																			        <a class="thumb" rel="lightbox[profile_photos] title="<?php echo $photo->title?>" href="<?php echo main_url('uploads/performers/' . $performer->id .'/' . $photo->name_on_disk)?>">
				        																<img src="<?php echo main_url('uploads/performers/' . $performer->id .'/small/' . $photo->name_on_disk)?>" title="<?php echo $photo->title?>" width="114" />
																							</a>
																				<?php
																				endfor;
																				$photo = $photos[$show_n];
																				?>

																				 <a id="pictures"class="thumb last menu_item" rel="profile_photos" title="<?php echo $photo->title?>" href="javascript:;">
																				 <?php if($n>5):?>
	                                    	 	<span class="more-pics-btn">
	                                        	<span class="more-no"><?php echo $n-5?></span>
	                                          <span class="more-txt">more</span>
	                                        </span>
	                                        <?php endif;?>
				        														<img src="<?php echo main_url('uploads/performers/' . $performer->id .'/small/' . $photo->name_on_disk)?>" title="<?php echo $photo->title?>" />
																				 </a>
	                                    </a>
	                                </div><!--end latest-photos-content-->
	                            </section><!--end latest-photos-->
	                        		<?php endif?>
														<?php endif?>

                            <section class="clearfix profile-section">
                            	<h3 class="left title2">Details</h3>
                                <div class="prefix-1">
                                    <table class="table-t1" cellpadding="0" cellpadding="0">
                                        <tr>
                                            <td><strong><?php echo lang('Height') ?></strong></td>
                                            <td><?php echo $performer->height?></td>
                                            <td><strong><?php echo lang('Gender') ?></strong></td>
                                            <td><?php echo $performer->gender?></td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo lang('Age') ?></strong></td>
                                            <td><?php echo floor((time() - $performer->birthday)/31556926);?></td>
                                            <td><strong><?php echo lang('Weight') ?></strong></td>
                                            <td><?php echo $performer->weight?></td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo lang('Hair color') ?></strong></td>
                                            <td><?php echo $performer->hair_color?></td>
                                            <td><strong><?php echo lang('Eye color') ?></strong></td>
                                            <td><?php echo $performer->eye_color?></td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo lang('Ethnicity') ?></strong></td>
                                            <td><?php echo $performer->ethnicity?></td>
                                            <td><strong><?php echo lang('Language') ?></strong></td>
                                            <td>
																							<?php foreach($languages as $language): ?>
																								<img src="<?php echo assets_url()?>images/flags/<?php echo strtoupper($language)?>.png">
																							<?php endforeach;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo lang('Cup size') ?></strong></td>
                                            <td><?php echo $performer->cup_size?></td>
                                            <td><strong><?php echo lang('Body build') ?></strong></td>
                                            <td><?php echo $performer->build?></td>
                                        </tr>
                                    </table>
                                </div><!--end prefix-1-->
                            </section>

                            <section class="clearfix profile-section">
                            	<h3 class="left title2"><?php echo lang('Profile description :')?></h3>
                                <div class="prefix-1">
                                    <p class="text-normal"><?php echo $performer->description?></p>
                                </div><!--end prefix-1-->
                            </section>

                            <section class="clearfix profile-section">
                            	<h3 class="left title2"><?php echo lang('What turns me on :')?></h3>
                                <div class="prefix-1">
                                    <p class="text-normal"><?php echo $performer->what_turns_me_on?></p>
                                </div><!--end prefix-1-->
                            </section>

                            <section class="clearfix profile-section">
                            	<h3 class="left title2"><?php echo lang('What turns me off :')?></h3>
                                <div class="prefix-1">
                                    <p class="text-normal"><?php echo $performer->what_turns_me_off?></p>
                                </div><!--end prefix-1-->
                            </section>