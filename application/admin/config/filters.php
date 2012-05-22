<?php
//accepted filters for admin
$config['filters']['users'] = array (
		'id' 			=> 'id',
		'username' 		=> 'username',
		'email' 		=> 'email',
		'country_code'	=> 'country_code',
		'status'		=> 'status',
		'gateway' 		=> 'gateway',
		'affiliate_id'	=> 'affiliate_id',
		'credits'		=> 'credits'
);
$config['filters']['performers'] = array (
		'id' 			=> 'id',
		'username' 		=> 'username',
		'nickname' 		=> 'nickname',
		'country_code'	=> 'country_code',
		'email' 		=> 'email',
		'first_name' 	=> 'first_name',
		'last_name' 	=> 'last_name',
		'status'		=> 'status',
		'contract_status'	=> 'contract_status',
		'photo_id_status'	=> 'photo_id_status',
		'is_online'			=> 'is_online',
		'is_online_hd'		=> 'is_online_hd',
		'is_online_type'	=> 'is_online_type',
		'is_in_private'		=> 'is_in_private',
		'enable_peek_mode'	=> 'enable_peek_mode',
		'studio_id'			=> 'studio_id',
		'credits'			=> 'credits'
);
$config['filters']['studios'] = array (
		'id' 			=> 'id',
		'username' 		=> 'username',
		'email' 		=> 'email',
		'country_code'	=> 'country_code',
		'first_name' 	=> 'first_name',
		'last_name' 	=> 'last_name',
		'status'		=> 'status',
		'contract_status' => 'contract_status',
		'percentage'	=> 'percentage',
		'credits'		=> 'credits'
);
$config['filters']['affiliates'] = array (
		'id' 			=> 'id',
		'username' 		=> 'username',
		'email' 		=> 'email',
		'country_code'	=> 'country_code',
		'first_name' 	=> 'first_name',
		'last_name' 	=> 'last_name',
		'register_ip'	=> 'register_ip',
		'register_date' => 'register_date',
		'status'		=> 'status',
		'credits'		=> 'credits'
);
$config['filters']['system_logs'] = array(
		'date'			=> 'date',
		'actor'			=> 'actor',
		'actor_id'		=> 'actor_id',
		'action_on'		=> 'action_on',
		'action_on_id'	=> 'action_on_id',
		'ip'			=> 'ip',
		'action'		=> 'action'
);
$config['filters']['categories'] = array(
		'id' 			=> 'id',
		'name' 			=> 'name',
		'link' 			=> 'link',
		'parent_id'		=> 'parent_id',		
);
$config['filters']['admins'] = array(
		'id' 			=> 'id',
		'username' 		=> 'username',
);
//$config['filters']['performers'] = $performers;