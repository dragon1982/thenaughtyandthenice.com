<div class="black_box_bg_middle"><div class="black_box_bg_top"><div class="black_box">
	<div class="content" style="width:470px;float:left; text-align:center;">
		<div class="title">
			<?php $performer_broadcast_title = lang('Go online now!') ?>
			<span class="eutemia"><?php echo substr($performer_broadcast_title,0,1)?></span><span class="helvetica"><?php echo substr($performer_broadcast_title,1) ?></span>
		</div>
		<?php 
			$height = '560';
		if($this->agent->is_browser('Safari')){
			$height = '500';
		}
		?>
		<?php echo form_button('Go online',lang('Go online!'),'class="red" onclick="window.open(\''. site_url('live') . '\',\'\',\'menubar=no,width=940,height='.$height.',toolbar=no\')"')?>
		
		<div style="text-align:left; margin:10px;">
			<span class="bold"><?php echo lang('Web based encoder advantages')?></span>:
			<div style="margin-left:10px;">
				&raquo;&nbsp;<?php echo lang('Does not require 3rd party apps or plug-ins')?><br/>
				&raquo;&nbsp;<?php echo lang('Automated bandwidth selection based on speed test')?><br/>
				&raquo;&nbsp;<?php echo lang('Pre-set Low, Medium and High quality settings')?><br/>
				&raquo;&nbsp;<?php echo lang('Low resource usage ')?><br/>
			</div>
		</div>
		<div class="clear"></div>		
	</div>
	<div class="content" style="width:470px;float:left; text-align:center;">
		<div class="title">
			<?php $performer_broadcast_title = lang('Go online using FMLE / WireCast') ?>
			<span class="eutemia"><?php echo substr($performer_broadcast_title,0,1)?></span><span class="helvetica"><?php echo substr($performer_broadcast_title,1) ?></span>
		</div>
		<?php echo form_button('Go online',lang('Go online!'),'class="red" onclick="window.open(\''. site_url('live?fmle=1') . '\',\'\',\'menubar=no,width=940,height=560,toolbar=no\')"')?>						
		<div style="text-align:left; margin:10px;">
			<span class="bold"><?php echo lang('FMLE encoder advantages')?></span>:
			<div style="margin-left:10px;">
				&raquo;&nbsp;<?php echo lang('H.264/MP3 video/audio encoding technology')?><br/>
				&raquo;&nbsp;<?php echo lang('Customizable individual quality settings')?><br/>
				&raquo;&nbsp;<?php echo lang('The result is HD video and audio')?><br/>
				&raquo;&nbsp;<?php echo lang('Less bandwidth usage')?><br/>
			</div>
			
			<br/>
			
			<span class="bold"><?php echo lang('1. What are they?')?></span><br/>
			<?php echo lang('These are 3rd party applications that have to be installed on your Windows or MAC computer. They are video and audio encoders that compress the video from your camera and stream it to ModenaCam’s server with a higher quality than the web based application.')?><br/><br/>
			<span class="bold"><?php echo lang('2. Who is using it?')?></span><br/>
			<?php echo lang('All professionals from the entertainment industry are using it.')?><br/><br/>
			<span class="bold"><?php echo lang('3. How much does it cost?')?></span><br/>
			<?php echo lang('Adobe\'s FMLE is freeware software, but WireCast is a commercial application.')?><br/><br/>
			<span class="bold"><?php echo lang('4. Flash Media Live Encoder contains spyware or adware since it\'s free?')?></span><br/>
			<?php echo lang('No, the application is clean and safe. It is built by Adobe. Official home page.')?><br/><br/>
			<span class="bold"><?php echo lang('5. Do I need to run both? Which one should I choose?')?></span><br/>
			<?php echo lang('They\'re both complete and powerful solutions, you can choose whichever you want. You don\'t need to use them both, basically they\'re doing the same thing.')?><br/><br/>

			<span class="bold"><?php echo lang('Start now!')?></span><br/><br/>

			<span class="bold"><?php echo lang('Step1: Installation of Adobe Live Encoder or WireCast')?></span><br/>
			<?php echo lang('Download the Adobe application here . Install it and run it. MAC users, please visit Adobe\'s site for the latest installation kit. WireCast users, please consult the official site in order to get license.')?><br/><br/>
			
			<span class="bold"><?php echo lang('Step 2: Configuration')?></span><br/>
			<?php echo sprintf(lang('Download the XML configuration file <a href="%s">here</a>, run Flash Media Live Encoder, go to file > Open profile and select the recently downloaded configuration file. Select the video and audio device you\'re going to use and press the Start button. You can adjust the video settings to adapt the stream to your hardware and Internet connection.'),site_url('fmle?url=' . $fms->fms .'&stream=cam1&fms_id='. $fms->fms_id))?><br/><br/>
		</div>
		<div class="clear"></div>		
	</div>
	<div class="clear"></div>	
</div>
</div></div><div class="black_box_bg_bottom"></div>