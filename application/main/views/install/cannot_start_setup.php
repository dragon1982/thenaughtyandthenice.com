<?php
        function dinamic_base_url() {
                $url = explode('index.php',$_SERVER['PHP_SELF']);
                return $url[0];
        }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>	
	<head>
		<title>ModenaCam Install ERROR</title>
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
			<div class="titleSteps">ModenaCam Installation Error</div>
			<div class="pageTopBg">&nbsp;</div>
			<div class="pageBg">

				<h1>In order to start the installation please make sure all the listed files are writeble</h1>
				<?php $chmodes = '';?>
				<table class="widefat widefatFix" style="width: 780px;" cellpadding="0" cellspacing="0" border="0" align="center">
					<thead>
						<tr>
							<th>Checkpoint</th>
							<th style="width: 1%; white-space: nowrap;">Request</th>
							<th style="width: 1%; white-space: nowrap;">Current</th>
							<th style="width: 1%; text-align: center;">Status</th>
						</tr>
					</thead>

					<tbody>
						<?php
						$errors = 0;
						foreach($list as $itemKey => $item) :
							$trClass = ($itemKey%2 == 0) ? 'widefatBlueLight' : 'widefatBlueDark';
						?>
							<tr class="<?php echo $trClass;?>" onmouseover="this.className='widefatBlueHover'" onmouseout="this.className='<?php echo $trClass;?>'" align="left">
								<td>
									<?php if($item['why']):?>
										<img src="<?php echo dinamic_base_url()?>assets/install/images/exclamation.png" onmouseover="Tip('<?php echo addslashes($item['why']);?>', BGCOLOR, '#DEDEDE', BORDERCOLOR, '#C2C2C2', TITLEFONTCOLOR, '#000000', FONTCOLOR, '#FF0000')" onmouseout="UnTip()" style="border: none; padding-right: 5px; padding-bottom: 1px; vertical-align: middle;" /><?php echo $item['name'];?>
									<?php else:?>
										<img src="<?php echo dinamic_base_url()?>assets/install/images/exclamation_off.png" style="border: none; padding-right: 5px; padding-bottom: 1px; vertical-align: middle;" /><?php echo $item['name'];?>
									<?php endif?>
								</td>
								<td align="center"><?php echo $item['request'];?></td>
								<td align="center"><?php echo $item['current'];?></td>
								<td align="center">
								<?php
									switch ($item['type']) :
										case 'phpVersion':
											if( abs($item['current'])  < $item['request'] ){
												$icon = 'cross';
												$errors++;
											} else {
												$icon = 'accept';
											}
											
											break;
										case 'maxUploadSize':
											if( abs($item['current'])  < $item['request'] ){
												$icon = 'cross';
												$errors++;
											} else {
												$icon = 'accept';
											}
											break;											
										case 'fil':
											if($item['current'] != 'writable'){
												$path = explode('CHMOD 0777', $item['name']);	
												if(sizeof($path) == 2){			
													if(strlen($chmodes) > 4){
														$chmodes = $chmodes . ' '.$path[1];
													} else {					
														$chmodes = $chmodes . 'chmod 777 ' . $path[1];
													}
												}
											}
											($item['current'] == $item['request']) ? $icon = 'accept' : $icon = 'cross';
											($item['current'] == $item['request']) ? null : $errors++;
											break;											
										case 'maxExecutionTime':
											($item['current'] >= intval($item['request'])) ? $icon = 'accept' : $icon = 'cross';
											($item['current'] >= intval($item['request'])) ? null : $errors++;
											break;

										default:
											($item['current'] == $item['request']) ? $icon = 'accept' : $icon = 'cross';
											($item['current'] == $item['request']) ? null : $errors++;
									endswitch;
								?><img class="<?php echo $icon?>" src="<?php echo dinamic_base_url()?>assets/install/images/<?php echo $icon;?>.png" style="border: none;" />
								</td>
							</tr>
					<?php endforeach ?>
					</tbody>
				</table>
				
				<br />

				<?php if($errors > 0):?>
					<div>In order to fix the problems please execute: <br /> <?php echo $chmodes?></div>
					<div style="width: 96%; text-align: center; margin: auto; color: #FF0000; font-weight: bold; font-size: 18px;">Must resolve all requirements, after that you can continue instalation!</div>
				<?php else:?>
					<div class="btnDiv"><input type="button" value="Continue"  onclick="document.reload()" class="blackBtn" /></div>				
				<?php endif?>				
			</div>
			<div class="pageBottomBg">&nbsp;</div>
		</div>
	</body>
</html>