<!-- PUT YOUR EMAIL SUBJECT IN HTML title TAG -->
<title>Welcome to {site_name}</title>

<center>
	<table cellpadding="0" cellspacing="0" style="width: 600px; font-family: Arial; font-size: 14px; text-align: left; color: #505050; border: solid #DDDDDD 1px; padding: 0px; margin-top: 0px;">
		<tr>
			<td style="padding: 0px; margin: 0px;">
				<img src="{site_url}assets/modena_t3/images/logo_email_600x84.png" />
			</td>
		</tr>

		<tr>
			<td style="padding: 20px 20px; line-height: 20px;">
				
				<!-- START CONTENT -->
				
				Dear <b>{first_name} {last_name}</b>,
				<br /><br />
				Your contract uploaded on <span style="font-weight: bold; color: #000000;">{site_name}</span> was <span style="font-weight: bold; color: #DB0404;"> rejected</span>!
				<br /><br />
				
				Also, you can login into your {site_name} account <a href="{login_link}"> here </a> and reapload a new contract!
				
				<br />
				
				<!-- END CONTENT -->
				 
				<br />
				Best Regards,
				<br />
				{site_name} Team
				<br />
				<a href="{site_url}" target="_blank" style="font-size: 14px; color: #505050;">{site_url}</a>
			</td>
		</tr>

		<tr>
			<td>
				<div style="text-align: center; background-color: #FAFAFA; padding: 10px 0px; border-top: dotted #DDDDDD 1px; font-size: 12px;">
					<hr style="border: none; border-top: dotted #DDDDDD 1px;" />
					<span style="color: #707070; text-align: left;">Copyright    2007-<?php echo date('Y')?> {site_name}, All rights reserved.</span>
				</div>
			</td>
		</tr>

	</table>
</center>