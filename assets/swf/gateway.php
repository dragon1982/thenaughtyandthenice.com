<?php
	//default gateway
	include "http://thenaughtyandthenice.east-wolf.com/amfphp/Core/Gateway.php";	
	$gateway = new Gateway();
	$gateway->setBaseClassPath("./services/");
	$gateway->service();
?>