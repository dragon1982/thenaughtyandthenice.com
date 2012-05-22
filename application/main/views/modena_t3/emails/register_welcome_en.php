<!-- PUT YOUR EMAIL SUBJECT IN HTML title TAG -->
<title>Welcome to ModenaCam</title>

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
				
				Dear <b>{username}</b>,
				<br /><br />
				Welcome to <span style="font-weight: bold; color: #000000;">{site_name}</span>, and thank you for choosing us.
				<br /><br />
				Here are the details on your {site_name} account:
				<br /><br />
				<table cellpadding="0" cellspacing="0" style="font-family: Arial; font-size: 14px; text-align: left; color: #505050; line-height: 20px">
					<tr>
						<td style="width: 75px;">Username:</td>
						<td style="font-weight: bold;">{username}</td>
					</tr>
					
					<tr>
						<td>Password:</td>
						<td style="font-weight: bold;">{password}</td>
					</tr>
				</table>
				
				<br />
				
				Also, you can login into your {site_name} account with your email and password.
				
				<br />
				
				<!-- END CONTENT -->
				 
				<br />
				Best Regards,
				<br />
				ModenaCam Team
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