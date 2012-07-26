<section class="set-bott-1">



	<?php $this->load->view('includes/_search')?>
			


<div class="models-list clearfix">
<?php
     $users = $performers;
     $this->load->view('usersListing',array('users'=>$users, 'pageViewHeight'=>$pageViewHeight));
     ?>
</div><!--end models-list-->
</section>