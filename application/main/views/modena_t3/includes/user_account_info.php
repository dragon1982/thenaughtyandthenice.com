<?php $bold_credits = print_amount_by_currency($this->user->credits)?>
<div class="my-account">

    <ul class="clearfix">
        <li><a class="ico-account" href="<?php echo site_url('settings')?>"><strong><span><?php echo $this->user->username?></span></strong> (<?php echo lang('Settings')?>)</a></li>
        <li><a href="<?php echo site_url('friends')?>"><?php echo lang('Friends')?></a></li>
        <li><a href="<?php echo site_url('statement')?>"><?php echo lang('Statements')?></a></li>
        <li><a href="<?php echo site_url('payments')?>"><?php echo lang('Payments')?></a></li>
        <li><a href="<?php echo site_url('logout')?>"><em><?php echo lang('Logout')?></em></a></li>
    </ul>

    <div class="chips-status">
    	<span id="user_chips"><?php echo $bold_credits?></span> credits left in your account &nbsp;|&nbsp; <a href="<?php echo site_url('add-credits')?>"><strong>Buy more coins!</strong></a>
    </div>

</div><!--end my-account-->