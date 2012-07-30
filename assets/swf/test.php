<?php
	//Include database connection details
	require_once('config.php');

    //Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}

//Function to sanitize values received from the form. Prevents SQL injection, duh
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}

	//Sanitize the POST values
	$performerStatus = clean($_POST['status']);

	//Create INSERT query
	$qry = "UPDATE performers(is_in_pause) VALUE('$performerStatus')";
	//$result = @mysql_query($qry);
	
echo "writing=Ok";
exit();
mysql_close();
	
?>