        <div id="sidebar">
        	<div id="accordion" class="sidebar-box">
            	<div id="headerOnlineFriends" class="sidebar-box-header">
                	<a class="sidebar-link-header" href="javascript:;"><img src="<?php echo assets_url()?>images/title-online-friends.png" alt="Online Friends"> <span>(<?php echo count($friends['online']); ?>)</span></a>
                </div><!--end sidebar-box-header-->

            	<div class="sidebar-box-content">
                	<ul id="chatOnlineUserList" class="chat-users-list">
                		<?php foreach($friends['online'] as $friend): ?>
	                    	<li class="item
	                    		<?php if($friend->is_in_a_group_show): ?>ico-group-show
	                    		<?php elseif($friend->is_in_a_private_show): ?>ico-private-show
	                    		<?php elseif($friend->is_true_private): ?>ico-true-private
	                    		<?php elseif($friend->is_in_champagne_room): ?>ico-champagne-room
	                    		<?php endif; ?>
	                    	">
	                        	<a href="javascript:chatWith('<?php echo $friend->id; ?>_<?php echo $friend->type; ?>');">
	                            	<img width="28" height="28" class="pic" src="<?php echo $friend->avatar_url; ?>" alt="<?php echo $friend->username; ?>">
	                                <span class="name"><?php echo $friend->username; ?></span>
	                                <span class="status"><!-- --></span>
	                            </a>
	                        </li>
                        <?php endforeach; ?>
                    </ul><!--end chat-users-list-->

                    <ul class="chat-users-status clearfix">
                    		<li>
                        	<span class="item-status ico-group-show"><!-- --></span>
                        	In a group show
                         </li>
                        <li>
                        	<span class="item-status ico-private-show"><!-- --></span>
                        	In a private show
                        </li>
                        <li>
                        	<span class="item-status ico-true-private"><!-- --></span>
                        	True private
                        </li>
                        <li>
                        	<span class="item-status ico-champagne-room"><!-- --></span>
                        	Champagne room
                        </li>
                    </ul>

                </div><!--end sidebar-box-content-->

                <div id="headerOfflineFriends" class="sidebar-box-header-last">
                	<a class="sidebar-link-header" href="javascript:;"><img src="<?php echo assets_url()?>images/title-offline-friends.png" alt="Online Friends"></a>
                </div><!--end sidebar-box-header-->

            	<div class="sidebar-box-content hide">
                	<ul id="chatOfflineUserList" class="chat-users-list">
	                	<?php foreach($friends['offline'] as $friend): ?>
	                    	<li class="item ico-group-show">
	                        	<a href="javascript:;">
	                            	<img width="28" height="28" class="pic" src="<?php echo $friend->avatar_url; ?>" alt="<?php echo $friend->username; ?>">
	                                <span class="name"><?php echo $friend->username; ?></span>
	                            </a>
	                        </li>
	                    <?php endforeach; ?>
                    </ul><!--end chat-users-list-->
                </div><!--end sidebar-box-content-->
            </div><!--end sidebar-box-->

        </div><!--end sidebar-->

	  <script type="text/javascript">
		//var $j = jQuery.noConflict();
		$(function() {
			$('#chatOnlineUserList').slimScroll({
					height: '200px',
				  width: '245px',
				  railVisible: false,
				  alwaysVisible: true,
				  railColor: '#27434e',
				  opacity: 1,
				  color: '#435962',
				  distance: '0px'
			  });

			$('#chatOfflineUserList').slimScroll({
				height: '200px',
			  width: '245px',
			  railVisible: false,
			  alwaysVisible: true,
			  railColor: '#27434e',
			  opacity: 1,
			  color: '#435962',
			  distance: '0px'
		  });
		  });

		$(function() {
			$( "#accordion" ).accordion({
				  autoHeight: false,
				});
		});
	  </script>