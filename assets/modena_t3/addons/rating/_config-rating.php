<?php
	//Connect to  your rating database
	$rating_dbhost = 'my11328.d18632.myhost.ro';
	$rating_dbuser = '18632dev';
	$rating_dbpass = 'devEW123';
	$rating_dbname = 'east_wolf_com_thenaughtyandthenice';

	$rating_tableName     = 'performers_ratings';
	$rating_path_db       = ''; // the path to your db.php file (not used yet!)
	$rating_path_rpc      = ''; // the path to your rpc.php file (not used yet!)

	$location_url = 'http://thenaughtyandthenice.east-wolf.com/assets/modena_t3/addons/rating/';

	$rating_unitwidth     = 16; // the width (in pixels) of each rating unit (star, etc.)
	// if you changed your graphic to be 50 pixels wide, you should change the value above

$rating_conn = mysql_connect($rating_dbhost, $rating_dbuser, $rating_dbpass) or die  ('Error connecting to mysql');
mysql_select_db($rating_dbname);
?>