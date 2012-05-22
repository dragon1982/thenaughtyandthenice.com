<?php
        function dinamic_base_url() {
                $url = explode('index.php',$_SERVER['PHP_SELF']);
                return $url[0];
        }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>	
	<head>
		<title>ModenaCam Install - Step 2/5</title>
		<link rel="stylesheet" href="<?php echo dinamic_base_url();?>assets/install/install.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo dinamic_base_url();?>assets/install/widefat/widefat-gray-ultra-light.css" type="text/css" media="screen" />

		<!--[if IE 7]>
		<link href="<?php echo dinamic_base_url();?>assets/install/installie7.css" rel="stylesheet" type="text/css" />
		<![endif]-->
		<!--[if IE 8]>
		<link href="<?php echo dinamic_base_url();?>assets/install/installie8.css" rel="stylesheet" type="text/css" />
		<![endif]-->
	</head>
	<body>
		<script type="text/javascript" src="<?php echo dinamic_base_url();?>assets/install/js/wz_tooltip.js" charset="utf-8"></script>
		<div class="warper">
			<div class="titleSteps">ModeaCam Setup <span>2/5</span></div>
			<div class="pageTopBg">&nbsp;</div>
			<div class="pageBg">

				<h1>Terms of service & License Agreement</h1>

				<textarea class="field" style="width: 97%; height: 140px; font-size: 12px;" readonly="readonly">			
ModenaCam Service Terms of Service
------------------------------------
By using and/or purchasing ModenaCam services/package you read, understand and agree the following terms:

1. Hours of Operation
Our hours of operation are Monday-Friday 9AM-6PM GMT+1 excepting legal holidays. Telephone assistance is only available during business hours. While we answer support tickets during off hours certain types of requests such as billing, customer service, and advanced support are examples of issues that may require advanced services only available during business hours.

2. ModenaCam Hosted Emergency Support
We staff our system 24/7/365 but only answer general technical support questions during normal business hours. If you are a ModenaCam Hosted customer and your site is offline after hours at any time you can submit an emergency support request which will instantly page our after-hours techs. We also offer a 24 hour emergency telephone assistance if your site is offline to notify our staff if your site is offline. Use of this emergency line if your site is online or for non-hosting issues may incur a fee.

3. Telephone Assistance
Not all ModenaCam software or services include phone support. Please be sure to check your purchase description to see if phone support is included.

4. Ticket Responses and Support
We guarantee one ticket reply within one business day.
You can always view your existing tickets to see the progress of your request or what department your ticket has been assigned to. After a ticket has existed for 48 hours, you may use the management escalation feature to tag your ticket for management review if the issue is not being resolved properly. Billing, customer service, and special requests will only be answered during normal business hours.

ModenaCam cannot support modifications to the software. If a modification you have installed is causing issue, our only solution will be to revert back to unmodified files.

In some circumstances server-level issues will impact our software's ability to execute properly. ModenaCam cannot make adjustments to your server hosting environment to bring it within the normal environment most hosting providers use.

Our staff will often need access to your community admin area or server file system to diagnose a support issue. If you cannot or will not provide such access: support will be limited or unavailable.

5. Disclaimers and Limitation of Liability
You understand and agree that this Site is provided "AS-IS" and that we assume no responsibility for your ability to (or any costs or fees associated with your ability to) obtain access to ModenaCam. Nor do we assume any liability for the failure to store or maintain any user communications or personal settings.

NO ADVICE OR INFORMATION, WHETHER ORAL OR WRITTEN, OBTAINED BY YOU FROM ModenaCam OR THROUGH OR FROM ITS SERVICES SHALL CREATE ANY WARRANTY NOT EXPRESSLY STATED IN THESE TERMS AND CONDITIONS.

IN NO EVENT SHALL ModenaCam OR ITS OWNER BE LIABLE TO YOU OR ANY THIRD PARTY FOR ANY INDIRECT, CONSEQUENTIAL, EXEMPLARY, INCIDENTAL, SPECIAL OR PUNITIVE DAMAGES, INCLUDING LOST PROFIT DAMAGES ARISING FROM YOUR USE OF ModenaCam OR ITS SERVICES EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.

Some jurisdictions do not allow the disclaimer, exclusion or limitation of incidental or consequential damages, so the foregoing disclaimer, exclusion and limitation may not apply to you, and you may have other legal rights that vary according to jurisdiction. In no event will damages provided by law (if any) apply unless they are required to apply by statute, notwithstanding their exclusion by contract.

The section titles and other headings in these Terms are for convenience only and have no legal or contractual effect. Our failure to exercise or enforce any right or provision of these Terms will not operate as a waiver of such right or provision. If any provision of these Terms is unlawful, void or unenforceable, that provision is deemed severable and does not affect the validity and enforceability of any remaining provisions.

6. Content on ModenaCam
The material on this Site is protected by U.S. and international copyright, trademark, and other applicable laws. You may not modify, copy, reproduce, republish, upload, post, transmit, publicly display, prepare derivative works based on, or distribute in any way any material from ModenaCam without a license or other written permission obtained in advance, including but not limited to text, audio, video, code and software. During your visit to this Site, however, you may download material displayed for non-commercial, personal use only (provided that you also retain all copyright and other proprietary notices contained on the materials). We neither warrant nor represent that your use of materials displayed on this Site will not infringe rights of third parties not owned by us or affiliated with ModenaCam.

ModenaCam provides you and other users with an opportunity to submit, post, display, transmit and/or exchange information, ideas, opinions, photographs, images, video, creative works or other information, messages, transmissions or material to us, the Forum or others ("Post" or "Postings"). Postings do not reflect our views; and we have no obligation to monitor, edit, or review any Postings on the Forum. We assume no responsibility or liability arising from the content of any such Postings nor for any error, defamation, libel, slander, omission, falsehood, obscenity, pornography, profanity, danger, or inaccuracy contained in any information within such Postings on this Site or the Forum. You are strictly prohibited from posting or transmitting any unlawful, threatening, libelous, defamatory, obscene, scandalous, inflammatory, pornographic, or profane material that could constitute or encourage conduct that would be considered a criminal offense, give rise to civil liability, or otherwise violate any law.

Without limiting the foregoing, the following behaviors are strictly prohibited:

* Strong, vulgar, obscene or otherwise harmful language
* Racially, ethnically or otherwise, objectionable language
* Harassing, intimidating, stalking or threatening other community members
* Libelous, defamatory or otherwise tortuous language
* Online vandalism
* Impersonation of another person or persons
* Posting, distributing, transmitting or promoting illegal content
* Invasion of another's privacy
* Actions that are hurtful or harmful to minors
* Posting, providing, transmitting or otherwise making available any materials or information infringing on the rights of a third party
* Posting, providing, transmitting or otherwise making available any junk mail or spam
* Posting, uploading, emailing or otherwise transmitting any material that contains any malicious computer code, or reverse engineering or hacking any materials on this Site.

We will cooperate with any law enforcement authorities or court order requesting or directing ModenaCam to disclose the identity of anyone posting any such information or materials.

7. ModenaCam Liability
In no event shall ModenaCam (or it's employees) be held liable for any direct, indirect, consequential, special and exemplary damages, or any damages whatsoever, stemming from the use or performance of any information, products and services provided through this web site, even if this web site has been advised of the possibility of such damages. Although ModenaCam does its best to maintain the information, products and services it offers on the Website, it cannot be held responsible for any mistakes, faults, lost profits or other consequential damages arising from the use of ModenaCam products.

8. Download Period and Upgrades
With your purchase of your product you receive 1 year of free download and upgrade service. When downloading your product for the first time, be sure to save the download in a safe place. If you need a download and your 1 year of free download service has expired you'll need to purchase the download/upgrade service. If your download period has expired, we cannot send you a download of your original purchase.

9. License types
Owned License
The owned license involves a single, outright purchase. This entitles you to the following:

* One installation of the software, under one domain name.
* Access to the majority of the server-side product source code (with the exception of license related code), allowing you to customize and extend the software.
* Lifetime technical support.
* Lifetime of access to upgrades (future releases of the software).
* The license to use the software is yours forever, with no renewal obligation.

Leased license
Our licenses can be leased monthly or yearly (the latter at a discount). A leased license entitles you to the following:
* One installation of the software, under one domain name.
* Technical support for as long as your lease is active.
* Access to upgrades (future releases of the software) for as long as your lease is active.
* The license for your installation is only yours for as long as your lease is active.

10. Refunds
ModenaCam is a software product, no warranties are applied and no refunds are offered.

11. Software Delivery
You will receive the zip archive containing all the files or the service activation within 48 hours from your order, depending on the package you ordered.
PHP, MySQL and HTML coding is Open source, but the flash components are compiled and reverse engineering is prohibited.

12. Web Hosting / FMS Hosting
We offer no uptime, speed or data safety guarantees. We cannot be held liable for any damage a downtime or data loss has caused to your company.

13. Software Support
We guarantee at least one reply within 1 business day.
Attacking, threating or acting in an inappropiate manner towards ModenaCam staff will result in immediat license and service cancellation without notice or refunds.
				</textarea><br /><br /><br />
				<textarea class="field" style="width: 97%; height: 140px; font-size: 12px;" readonly="readonly">

ModenaCam for One (1) Computer/Domain Software License Agreement
------------------------------------

By purchasing ModenaCam you read, understand and agree the following terms:

Notice to User:
This End User License Agreement (EULA) is a CONTRACT between you (either an individual or a single entity) and ModenaCam.com ("ModenaCam"), which covers your use of the ModenaCam software product that accompanies this EULA and related software components, which may include associated media, printed materials, and "online" or electronic documentation. All such software and materials are referred to herein as the "Software Product." A software license, issued to a designated user only by ModenaCam or its authorized agents, is required for each user of the Software Product. If you do not agree to the terms of this EULA, then do not install or use the Software Product or the Software Product License. By explicitly accepting this EULA, however, or by installing, copying, downloading, accessing, or otherwise using the Software Product and/or Software Product License, you are acknowledging and agreeing to be bound by the following terms:

By installing, copying, accessing, downloading or using the Software (or authorizing any other person to do so) you are indicating that you are 18 years of age or older (any parent or guardian of a person under the age of 18 may accept this Agreement on behalf of a user), are capable of entering into a binding legal agreement, have read and understand this Agreement and you accept its terms and conditions. If you do not agree with the terms and conditions of this Agreement, do not install, copy, access, download or use the Software.

1. Grant of License
Subject to the terms and conditions of this Agreement, ModenaCam grants to you a limited, non-exclusive, worldwide license to install, download and use a single instance of the Software on a single website server ("License") through a single installation. Each License may run one instance of the Software on one domain. Any modification of the Software intended to circumvent the foregoing is prohibited and will result in revocation of the License.

If you are the original licensee of the Software, you may make a one-time, permanent transfer of your license rights in the Software to a third party ("Subsequent Licensee") provided that five (5) conditions are met. The conditions are: (a) you are the original licensee, (b) the Software was purchased by you more than 90 days prior to the transfer, (c) you do not keep a copy of the Software for yourself, (d) the Subsequent Licensee agrees to the terms of this Agreement and the License, and (e) the Subsequent Licensee agrees to assume your license rights in the Software, excluding this transfer right. For sake of clarity, the right to transfer the Software belongs solely to the original licensee; the Subsequent Licensee is prohibited from transferring its rights to any third party. You must disclose the domain where you are using (or plan to use) the License, which may be disclosed in the ModenaCam registered members area. You may set up one additional temporary test ModenaCam setup for the purpose of testing code, template and database modifications. Such a test ModenaCam setup must be password protected, and not made available to the general public at any time.

For purposes of this Agreement, "Software" includes (and the terms and conditions of this Agreement will apply to) any updates, updated or replacement features enhancements, bug fixes or modified versions (collectively, "Update"). "Update" means a release of the Software which adds minor functionality enhancements to the current version. This class of release is identified by the change of the version number to the right of the decimal point, i.e. 4.1 to 4.2. Notwithstanding any other provision of this Agreement, you have no License or right to use any such Update unless, at the time of acquiring such Update, you already hold a valid License to the original Software and have paid any applicable fee for the Update.

2. Restrictions
You may not give copies to another person, or duplicate the Software by any other means, including electronic transmission. You may make one copy of the Software in machine-readable form for backup purposes only; provided that the backup copy must include all copyright or other proprietary notices contained on the original. You may not rent, sublicense, assign, lease, loan, resell for profit, distribute, publish or network the Software or related materials or create derivative works based upon the Software or any part thereof.

You may not use the Software to engage in or allow others to engage in any illegal activity where the Software is accessed and used. You may not use the Software to engage in any activity that will violate the rights of third parties, including, without limitation, through the use, public display, public performance, reproduction, distribution, or modification of communications or materials that infringe copyrights, trademarks, publicity rights, privacy rights, other proprietary rights, or rights against defamation of third parties.

3. Ownership Rights
The Software is licensed to you by ModenaCam for use only under the terms and conditions of the License. ModenaCam reserves all rights not granted to you. The Software in its entirety is protected by U.S. and international copyright laws and treaty provisions. ModenaCam owns and retains all right, title and interest in and to the Software, including all copyrights, patents, trade secret rights, trademarks, service marks and other intellectual property rights therein. Your possession, installation, or use of the Software does not transfer to you any title to the intellectual property in the Software, and you will not acquire any rights to the Software except as expressly set forth in this Agreement. All copies of the Software made hereunder must contain the same proprietary notices that appear on and in the Software, including all Software copyright notices embedded in any design template which must remain unaltered from the original and visible at all times.

4. Termination
The License for the Software is effective until terminated. You may terminate the License at any time by uninstalling the Software and destroying all copies of the Software in any media. This Agreement may be terminated by ModenaCam immediately and without notice if you fail to comply with any term or condition of the License or this Agreement. Upon such termination, you must immediately cease using the Software, and destroy all complete and partial copies of the Software.

Leased-License Holders Only. For leased-license holders, the License terminates on the last day of your current leased-license agreement with ModenaCam. You may, however, purchase the Software prior to such end date, in which case the License will continue as specified in the first paragraph of this Section 4. Use of the Software after that end date without purchase makes the License void and you must immediately cease using the Software, and destroy all complete and partial copies of the Software.

ModenaCam reserves the right to change or add to the terms of this Agreement at any time (including but not limited to Internet-based Services, pricing, technical support options, and other product-related policies), and to change, discontinue or impose conditions on any feature or aspect of the Software, or any Internet-based Services provided to you or made available to you through use of the Software. Such changes will be effective upon notification by any means reasonable to give you actual or constructive notice including by posting such terms on the ModenaCam.com website, or another website designated by ModenaCam. Your continued use of the Software will indicate your agreement to any such change.

5. Registration Data
You must register to use the Software and Services and (a) provide true, accurate, current and complete information as prompted by the sign-up process (the "Registration Data"), and (b) maintain and promptly update the Registration Data to keep it accurate, current and complete. If you provide any Registration Data that is inaccurate, not current or incomplete, or we have reasonable grounds to suspect is inaccurate, not current or incomplete, we may suspend or terminate your account unless and until such data is corrected or completed, or we may refuse any and all current or future access to and use of the Software or Services (or any portion thereof).

6. Account Access Information and Data
You are solely responsible for (a) maintaining the confidentiality and security of your access number(s), password(s), security question(s) and answer(s), account number(s), login information, and any other security or access information, used by you to access the Software and Services (collectively, "Access Information"), and (b) preventing unauthorized access to or use of the information, files or data that you store or use in or with the Software and Services (collectively, "Account Data"). We will assume that any communications we receive through use of the Access Information were sent or authorized by you.

7. Fees and Payments
We reserve the right to charge fees for future Services in our sole discretion. If we decide to charge for the Services, such charges will be disclosed to you prior to our charging for them.

8. Feedback
We may provide you with a mechanism to provide feedback, suggestions and ideas about the Software. You agree that we may use the feedback you provide in any way, including in future modifications of the Software. You grant us a perpetual, worldwide, fully transferable, non-revocable, royalty free license to use, modify, create derivative works from, distribute and display any information you provide to us in the feedback.

9. DISCLAIMER OF WARRANTIES
THE SOFTWARE IS PROVIDED "AS-IS," AND TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, ModenaCam DISCLAIMS ALL OTHER WARRANTIES, EXPRESS OR IMPLIED, BY STATUTE OR OTHERWISE, REGARDING THE SOFTWARE AND ANY RELATED MATERIALS, INCLUDING THEIR FITNESS FOR A PARTICULAR PURPOSE, THEIR QUALITY, THEIR MERCHANTABILITY, OR THEIR NONINFRINGEMENT. ModenaCam DOES NOT WARRANT THAT THE SOFTWARE OR ANY RELATED SERVICES OR CONTENT IS SECURE, OR IS FREE FROM BUGS, VIRUSES, ERRORS, OR OTHER PROGRAM LIMITATIONS NOR DOES IT WARRANT ACCESS TO THE INTERNET OR TO ANY OTHER SERVICE THROUGH THE SOFTWARE. SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF IMPLIED WARRANTIES, SO THE ABOVE EXCLUSIONS MAY NOT APPLY TO YOU. IN THAT EVENT, ANY IMPLIED WARRANTIES ARE LIMITED IN DURATION TO 30 DAYS FROM THE DATE OF PURCHASE OF THE SOFTWARE. THIS WARRANTY GIVES YOU SPECIFIC LEGAL RIGHTS. YOU MAY HAVE OTHER RIGHTS, WHICH VARY FROM JURISDICTION TO JURISDICTION. THE ENTIRE RISK AS TO THE RESULTS, QUALITY AND PERFORMANCE OF THE SOFTWARE IS WITH YOU.

10. LIMITATION OF LIABILITY
TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, ModenaCam, INTERNET BRANDS AND ITS AFFILIATES WILL NOT BE LIABLE FOR ANY INDIRECT, SPECIAL, INCIDENTAL, OR CONSEQUENTIAL DAMAGES (INCLUDING DAMAGES FOR LOSS OF BUSINESS, LOSS OF PROFITS, OR THE LIKE), WHETHER BASED ON BREACH OF CONTRACT, TORT (INCLUDING NEGLIGENCE), PRODUCT LIABILITY OR OTHERWISE, EVEN IF ModenaCam, INTERNET BRANDS OR ITS REPRESENTATIVES OR AFFILIATES HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES AND EVEN IF A REMEDY SET FORTH HEREIN IS FOUND TO HAVE FAILED OF ITS ESSENTIAL PURPOSE. ModenaCam’ AND INTERNET BRANDS’ TOTAL LIABILITY TO YOU FOR ACTUAL DAMAGES FOR ANY CAUSE WHATSOEVER WILL BE LIMITED TO THE PURCHASE PRICE AMOUNT PAID BY YOU FOR THE SOFTWARE. SOME JURISDICTIONS DO NOT ALLOW THE LIMITATION OR EXCLUSION OF LIABILITY FOR INCIDENTAL OR CONSEQUENTIAL DAMAGES, SO THE ABOVE LIMITATION OR EXCLUSION MAY NOT APPLY TO YOU. THE LIMITATIONS OF THE DAMAGES SET FORTH HEREIN ARE FUNDAMENTAL ELEMENTS OF THE BASIS OF THE BARGAIN BETWEEN ModenaCam AND YOU; ModenaCam WOULD NOT HAVE BEEN ABLE TO PROVIDE THE SOFTWARE TO YOU WITHOUT SUCH LIMITATIONS.

11. Indemnification
You agree to defend, indemnify and hold ModenaCam, Internet Brands, and our officers, directors, employees, agents or affiliates, harmless from and against any and all claims, losses, liability costs and expenses (including but not limited to attorneys' fees) arising from your use of the Software or your ModenaCam forum users' use of the Software, laws or regulations, or any third party's rights, including but not limited to infringement of any copyright, violation of any proprietary right or invasion of any privacy rights. This obligation will survive the termination of this Agreement.

12. U.S. Government End Users
The Software and any related documentation are "Commercial Items", as that term is defined at 48 C.F.R. §2.101, consisting of "Commercial Computer Software" and "Commercial Computer Software Documentation", as such terms are used in 48 C.F.R. §12.212 or 48 C.F.R. §227.7202, as applicable. Consistent with 48 C.F.R. §12.212 or 48 C.F.R. §227.7202-1 through 227.7202-4, as applicable, the Commercial Computer Software and Commercial Computer Software Documentation are being licensed to U.S. Government end users (a) only as Commercial Items, and (b) with only those rights as are granted to all other end users pursuant to the terms and conditions herein. Unpublished-rights are reserved under the copyright laws of the United States.

13. Export Control
The manufacture and sale of the Software is subject to the export control laws of the United States. You may not use or otherwise export or re-export the Software except as authorized by United States law and the laws of the jurisdiction in which the Software was purchased. In particular, but without limitation, the Software may not be exported or re-exported (a) into any U.S. embargoed countries, or (b) to anyone on the U.S. Treasury Department's list of Specially Designated Nationals or the U.S. Department of Commerce Denied Person’s List or Entity List. By using the Software, you represent and warrant that you are not located in any such country or jurisdiction, or on any such list. You also agree that you will not use these products for any purposes prohibited by United States law or the law of the jurisdiction in which the Software was purchased, including, without limitation, the development, design, manufacture or production of missiles, or nuclear, chemical or biological weapons.

14. Controlling Law; Severability
The License and this Agreement are governed by and construed in accordance with the laws of the State of California, United States of America. You hereby consent to the exclusive jurisdiction and venue in the state and federal courts of the County of Los Angeles, California and the Central District of California, respectively. The License will not be governed by the United Nations Convention on Contracts for the International Sale of Goods, the application of which is expressly excluded. If for any reason a court of competent jurisdiction finds any provision, or portion thereof, to be unenforceable, the remainder of the License will continue in full force and effect. Unless otherwise required by law, an action or proceeding by you to enforce an obligation, duty, or right arising under the License or this Agreement or by law with respect to the Software or Services must be commenced within one (1) year after the cause of action accrues.

15. Refund Policy for Purchases of ModenaCam Products
No refunds will be offered for the Software once it has been sold. No refunds will be offered for the purchase of other ModenaCam products or services.

16. Miscellaneous
You acknowledge that, in providing you with the Software and/or Services, ModenaCam has relied upon your agreement to be bound by the terms of this Agreement. You further acknowledge that you have read, understood, and agreed to be bound by the terms of the License and this Agreement, and hereby reaffirm your acceptance of those terms. You further acknowledge that this Agreement constitutes the complete statement of the agreement between you and ModenaCam, and that this Agreement does not include any other prior or contemporaneous promises, representations, or descriptions regarding the Software. The unauthorized agents, employees or distributors of ModenaCam or its affiliates are not authorized to make modifications to this Agreement, or to make any additional representations, commitments, or warranties binding on ModenaCam. Accordingly, additional statements, whether oral or written, do not constitute representations or warranties by ModenaCam and should not be relied upon.
				</textarea>				
				
<br /><br />
					<?php echo form_open()?>
						<label><?php echo form_checkbox('agree',1,FALSE,' id="agreeCheckbox" style="vertical-align: middle;"')?>&nbsp;I agree you Terms of service and License Agreement!</label><br>
						<?php echo (form_error('agree'))?'<br />You must agree with our Terms ':NULL?><br/>
						<div class="btnDiv">						
							<?php echo form_submit('Continue','Continue','class="blackBtn"')?>
						</div>
					<?php echo form_close()?>
				 				
			</div>
			<div class="pageBottomBg">&nbsp;</div>
		</div>
	</body>
</html>