<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// --------------------------------------------------------------------------
// Servers
// --------------------------------------------------------------------------
$memcache['servers'] = array(
		'default' => array(
			'hostname' => MEMCACHE_HOST,
			'port' => MEMCACHE_PORT,
			'weight' => '1',
			'persistent' => FALSE
		)
);

// --------------------------------------------------------------------------
// Configuration
// --------------------------------------------------------------------------


$config['memcache'] = $memcache;

/* End of file memcached.php */
/* Location: ./system/application/config/memcached.php */