<?php
/*
Page:           _drawrating.php
Created:        Aug 2006
Last Mod:       Mar 18 2007
The function that draws the rating bar.
---------------------------------------------------------
ryan masuga, masugadesign.com
ryan@masugadesign.com
--------------------------------------------------------- */
function rating_bar($id,$units='',$static='', $user_id = null, $redirect = '') {

require('_config-rating.php'); // get the db connection info

//set some variables
//$redirect = $_SERVER['REMOTE_ADDR'];
if (!$units) {$units = 10;}
if (!$static) {$static = FALSE;}

// get votes, values, ips for the current rating bar
$query=mysql_query("SELECT sum(rating) as total_value, count(*) as total_votes, rating FROM $rating_dbname.$rating_tableName WHERE performer_id='$id' ")or die(" Error: ".mysql_error());


// insert the id in the DB if it doesn't exist already
if (mysql_num_rows($query) == 0) {
$sql = "INSERT INTO $rating_dbname.$rating_tableName (`user_id`,`performer_id`, `rating`) VALUES ('0', '$id', '0')";
$result = mysql_query($sql);
}

$numbers=mysql_fetch_assoc($query);


if ($numbers['total_votes'] < 1) {
	$count = 0;
} else {
	$count=$numbers['total_votes']; //how many votes total
}
$current_rating=$numbers['total_value']; //total number of rating added together and stored
$tense=($count==1) ? "vot" : "voturi"; //plural form votes/vote

// determine whether the user has voted, so we know how to draw the ul/li
$voted=mysql_num_rows(mysql_query("SELECT rating FROM $rating_dbname.$rating_tableName WHERE user_id = '".$user_id."' AND performer_id='".$id."' "));

// now draw the rating bar
$rating_unitwidth = 15;

$rating_width = ($count == 0) ? 0 : (number_format($current_rating/$count,2)*$rating_unitwidth);
$rating1 = ($count == 0) ? 0 : (number_format($current_rating/$count,1));
$rating2 = ($count == 0) ? 0 : (number_format($current_rating/$count,2));


if ($static == 'static') {

		$static_rater = array();
		$static_rater[] .= "\n".'<div class="ratingblock">';
		$static_rater[] .= '<div id="unit_long'.$id.'">';
		$static_rater[] .= '<ul id="unit_ul'.$id.'" class="unit-rating" style="width:'.$rating_unitwidth*$units.'px;">';
		$static_rater[] .= '<li class="current-rating" style="width:'.$rating_width.'px;">Acum '.$rating2.'/'.$units.'</li>';
		$static_rater[] .= '</ul>';
		//$static_rater[] .= '<p class="static">'.$id.'. Rating: <strong> '.$rating1.'</strong>/'.$units.' ('.$count.' '.$tense.' cast) <em>This is \'static\'.</em></p>';
		$static_rater[] .= '</div>';
		$static_rater[] .= '</div>'."\n\n";

		return join("\n", $static_rater);


} else {

      $rater ='';
//      $rater.='<div class="ratingblock">';

      $rater.='<div id="ratingblock">';
      $rater.='  <ul id="unit_ul'.$id.'" class="unit-rating" style="width:'.$rating_unitwidth*$units.'px;">';
      $rater.='     <li class="current-rating" style="width:'.$rating_width.'px;">Acum '.$rating2.'/'.$units.'</li>';

      for ($ncount = 1; $ncount <= $units; $ncount++) { // loop from 1 to the number of units
           if(!$voted) { // if the user hasn't yet voted, draw the voting stars
              $rater.='<li><a href="'.$location_url.'db.php?j='.$ncount.'&amp;q='.$user_id.'&amp;p='.$id.'&amp;redirect='.$redirect.'&amp;c='.$units.'" title="'.$ncount.' din '.$units.'" class="r'.$ncount.'-unit rater" rel="nofollow">'.$ncount.'</a></li>';
           }
      }
      $ncount=0; // resets the count

      $rater.='  </ul>';
      $rater.='  <p';
      if($voted){ $rater.=' class="voted"'; }else{ $rater.=' class="not_voted"'; }
      //$rater.='><strong> '.$rating1.'</strong> - '.$count.' '.$tense;
      $rater.='  </p>';
//      $rater.='</div>';
      $rater.='</div>';
      return $rater;
 }
}

function getPerformerScore($id = null){
require('_config-rating.php'); // get the db connection info

// get votes, values, ips for the current rating bar
$query=mysql_query("SELECT sum(rating) as total_value, count(*) as total_votes, rating FROM $rating_dbname.$rating_tableName WHERE performer_id='$id' ")or die(" Error: ".mysql_error());


$numbers=mysql_fetch_assoc($query);


if ($numbers['total_votes'] < 1) {
	$count = 0;
} else {
	$count=$numbers['total_votes']; //how many votes total
}
$current_rating=$numbers['total_value']; //total number of rating added together and stored
$tense=($count==1) ? "vot" : "voturi"; //plural form votes/vote
$return = ($count == 0) ? 0 : (number_format($current_rating/$count,1));
return $return;
}
?>