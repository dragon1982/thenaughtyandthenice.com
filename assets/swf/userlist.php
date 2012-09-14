<?php
    // Grab username and password variables
    $listusers = $_POST['userlist'];

    $myFile = "userlist.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, $listusers);
fclose($fh);
?>