<?php

$pngs = glob('*.png');

foreach($pngs as $png) {
	$paths = pathinfo($png);

	rename($png, strtoupper($paths['filename']) .'.'. $paths['extension']);
}

?>