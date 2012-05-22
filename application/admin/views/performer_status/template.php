<?php 
$this->load->view('performer_status/header');

if(isset($page)) { 
	$this->load->view($page); 
} else {
	echo lang('No page set.');
}

?>
</body>
</html>