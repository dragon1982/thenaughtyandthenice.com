<?php 
$this->load->view('studio_status/header');

if(isset($page)) { 
	$this->load->view($page); 
} else {
	echo lang('No page set.');
}

?>
</body>
</html>