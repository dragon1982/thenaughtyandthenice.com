<?php
/*
Page:           db.php
Created:        Aug 2006
Last Mod:       Mar 18 2007
This page handles the database update if the user
does NOT have Javascript enabled.
---------------------------------------------------------
ryan masuga, masugadesign.com
ryan@masugadesign.com
--------------------------------------------------------- */
header("Cache-Control: no-cache");
header("Pragma: nocache");
require('_config-rating.php'); // get the db connection info

//getting the values
$vote_sent = preg_replace("/[^0-9]/","",$_REQUEST['j']);
$user_id = preg_replace("/[^0-9a-zA-Z]/","",$_REQUEST['q']);
$performer_id = preg_replace("/[^0-9a-zA-Z]/","",$_REQUEST['p']);
$referer = preg_replace("/[^0-9\.]/","",$_REQUEST['t']);
$units = preg_replace("/[^0-9]/","",$_REQUEST['c']);
$ip = $_SERVER['REMOTE_ADDR'];
$referer  = $_SERVER['HTTP_REFERER'];

if ($vote_sent > $units) die("Sorry, vote appears to be invalid."); // kill the script because normal users will never see this.

//connecting to the database to get some information
//$query = mysql_query("SELECT total_votes, total_value, used_ips FROM $rating_dbname.$rating_tableName WHERE id='$id_sent' ")or die(" Error: ".mysql_error());
//if($query):
//	$numbers = mysql_fetch_assoc($query);
//endif;
//$checkIP = unserialize($numbers['used_ips']);
//$count = $numbers['total_votes']; //how many votes total
//$current_rating = $numbers['total_value']; //total number of rating added together and stored
//$sum = $vote_sent+$current_rating; // add together the current vote value and the total vote value
//$tense = ($count==1) ? "vote" : "votes"; //plural form votes/vote
//
//// checking to see if the first vote has been tallied
//// or increment the current number of votes
//($sum==0 ? $added=0 : $added=$count+1);
//
////IP check when voting
//if (is_array($checkIP)):
//	$test = in_array($ip,$checkIP);
//else:
//	$test = false;
//endif;
//
//// if it is an array i.e. already has entries the push in another value
//((is_array($checkIP)) ? array_push($checkIP,$ip_num) : $checkIP=array($ip_num));
//$insertip=serialize($checkIP);

if (!$test)
//$voted=mysql_query("SELECT used_ips FROM $rating_dbname.$rating_tableName WHERE used_ips LIKE '%\"".$ip."\"%' AND id='".$id_sent."' ");
//if (mysql_num_rows($voted) > 0) //if the user hasn't yet voted, then vote normally...
{

/*	if (($vote_sent >= 1 && $vote_sent <= $units) && ($ip == $ip_num))
		{ // keep votes within range*/

			//check repeated 1 votes
			$result = mysql_query("SELECT * FROM $rating_dbname.$rating_tableName WHERE user_id='".$user_id."' and performer_id = '".$performer_id."' ORDER BY id DESC LIMIT 1;");
			$nr = 0;
			if(!$result)
			{
				mysql_query("INSERT INTO $rating_dbname.$rating_tableName  VALUES('".$performer_id."','".$user_id."','".$vote_sent."');");
			}

		//$update = "UPDATE $rating_dbname.$rating_tableName SET total_votes='".$added."', total_value='".$sum."', used_ips='".$insertip."' WHERE id='$id_sent'";
		//$result = mysql_query($update);
		//}
header("Location: $referer"); // go back to the page we came from
exit;
} //end for the "if(!$voted)"
?>