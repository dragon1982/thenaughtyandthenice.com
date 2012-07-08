<section class="set-bott-1">
                <header class="box-header clearfix">
                    <h1 class="left box-title-1"><a href="<?php echo site_url('friends'); ?>"><span class="girls-no"><?php echo count($friends['accepted']); ?></span> <img src="<?php echo assets_url()?>images/title-friends.png" alt="Friends"></a></h1>
                    <ul class="tabs-t1 left set-tabs-pos">
                        <li><a href="<?php echo site_url('friends/pending'); ?>">Pending</a></li>
                        <li><a href="<?php echo site_url('friends/requests'); ?>">Requests</a></li>
                        <li class="selected"><a href="<?php echo site_url('friends/banned'); ?>">Banned</a></li>
                    </ul>
                </header>
                
                <ul class="list-t2 clearfix">
                	<?php foreach($friends['banned'] as $friend): ?>
	                	<li>
	                    	<article class="box-t1 clearfix">
	                        	<div class="left"><a href="<?php echo $friend->page; ?>"><img src="<?php echo $friend->large_pic; ?>" height="130"></a></div>
	                            <div class="prefix-10 set-top-10">
	                                <div class="text-size-1 set-bott-2"><a href="<?php echo $friend->page; ?>"><?php echo $friend->username; ?></a></div>
	                                <p class="model-stats">
	                                    <strong><?php echo $friend->age; ?> <?php if($friend->age):?>years<?php endif; ?></strong> - <?php echo $friend->city; ?>, <?php echo $friend->country_code; ?> <br>
	                                    Score: <strong>3.5</strong>
	                                </p>
	                                <br>
	                                <br>
									<?php echo form_open('relation/delete', array('id'=>'delete_relation_form', 'method'=>'post')); ?>
										<input type="hidden" name="rel_id" value="<?php echo $friend->rel_id; ?>" />
									</form>
	                                <a class="btn-nice-5 " href="javascript:;" onclick="$('#delete_relation_form').submit();">Unban</a>
	                            </div>
	                        </article>
	                    </li>
                    <?php endforeach; ?>
                </ul>
            </section>