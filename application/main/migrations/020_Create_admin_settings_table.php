<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_admin_settings_table extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Creating table settings..";
		if ( ! $this->db->table_exists('settings'))
		{	
            $this->dbforge->add_key('id', TRUE);

			$this->dbforge->add_field(array(
				'id'					=> array('type' => 'INT',   	'constraint' => 11,     'unsigned' => TRUE,	'auto_increment' => TRUE),
				'name'					=> array('type' => 'VARCHAR',   'constraint' => 255,	'null' => FALSE),
				'value'      			=> array('type' => 'TEXT',								'null' => FALSE),
				'type'      			=> array('type' => 'VARCHAR',	'constraint' => 255, 	'null' => FALSE),
				'title'      			=> array('type' => 'VARCHAR',	'constraint' => 255, 	'null' => FALSE),
				'description'  			=> array('type' => 'VARCHAR',	'constraint' => 255, 	'null' => TRUE)
			));
			$this->dbforge->create_table('settings', TRUE);			
		}			
	
		$this->migrations->verbose AND print "Populating settings...";
			$this->db->query("INSERT INTO `settings` (`name`, `value`, `type`, `title`, `description`) VALUES 
					('separator_Site settings',				'null',						'separator',	'Application Configuration Settings',	null),
					('settings_debug',						'0',						'boolean',		'Enable debugging',						null),
					('email_activation',					'1',						'boolean',		'Email Activation',						null),
					('email_unique',						'0',						'boolean',		'Require unique emails',				null),
					('support_email',						'yoursite@yoursite.com',	'string',		'Support email',						null),
					('support_name',						'Your support name',		'string',		'Support name',							null),
					('website_name',						'Your site name',			'string',		'Website name',							null),
					('settings_default_theme',				'modena_t3',				'select', 		'Default theme',						null),
					('settings_site_title',					'Modena4',					'string',		'Website title',						null),
					('settings_site_description',			'Modena4',					'string',		'Website description',					null),
					('settings_site_keywords',				'modena',					'string',		'Website keywords',						null),
					('separator_Memcache settings',			'null',						'separator',	'Memcache settings',					null),
					('memcache_enable',						'0',						'boolean',		'Enable memcache',						null),
					('memcache_host',						'127.0.0.1',				'string',		'Enable memcache',						null),
					('memcache_port',						'11211',					'integer',		'Enable memcache',						null),
					
					('separator_Currency settings',			'null',						'separator',	'Website currency settings',			null),
					('settings_currency_type',				'0',						'string',		'Website Currency Type',				null),
					('settings_real_currency_name',			'dollars',					'string',		'Real currency name',					null),
					('settings_real_currency_symbol',		'$',						'string',		'Real currency other symbol',			null),
					('settings_virtual_currency_name',		'chips',					'string',		'Chips name',							null),
					('settings_cents_per_credit',			'50',						'integer',		'Chips per currency unit',						null),
					('settings_shown_currency',				'string',					'string',		'What currency will be printed in lang',null),
					
					('separator_Price settings',			'null',						'separator',	'Website prices settings',				null),
					('website_percentage',					'50',						'integer',		'Website percentage',					null),
					('min_true_private_chips_price',		'10',						'integer',		'Min true private chips price',			null),
					('max_true_private_chips_price',		'100',						'integer',		'Max true private chips price',			null),
					('min_private_chips_price',				'10',						'integer',		'Min private chips price',				null),
					('max_private_chips_price',				'100',						'integer',		'Max private chips price',				null),
					('min_peek_chips_price',				'5',						'integer',		'Min peek chips price',					null),
					('max_peek_chips_price',				'100',						'integer',		'Max peek chips price',					null),
					('min_nude_chips_price',				'5',						'integer',		'Min nude chips price',					null),
					('max_nude_chips_price',				'100',						'integer',		'Max nude chips price',					null),
					('min_paid_video_chips_price',			'5',						'integer',		'Min paid video chips price',			null),
					('max_paid_video_chips_price',			'100',						'integer',		'Max paid video chips price',			null),
					('min_photos_chips_price',				'10',						'integer',		'Min paid photo chips price',			null),
					('max_photos_chips_price',				'100',						'integer',		'Max  paid photo chips price',			null),
					
					('separator_Chat_settings',				'null',						'separator',	'Chat settings',						null),
					('free_chat_limit_notlogged',			'100',						'integer',		'Free chat time limit for nonlogged users',		null),
					('free_chat_limit_logged_no_credits',	'100',						'integer',		'Free chat time limit for logged with no credits',null),
					('free_chat_limit_logged_with_credits',	'100',						'integer',		'Free chat time limit for logged with credits',				null),
					('minimum_paid_chat_time',				'100',						'integer',		'Minimum paid chat time',				null),
					
					('separator_User settings',				'null',						'separator',	'Users settings',						null),
					('ban_expire_date',						'84000',					'integer',		'Ban expiration time',					null),
					
					('separator_Affiliate settings',		'null',						'separator',	'Affiliate settings',					null),
					('settings_transaction_percentage',		'30',						'integer',		'Transaction percentage',				null),
					
					('separator_Fms settings',				'null',						'separator',	'FMS settings',							null),
					('fms_secret_hash',						'MY_SECRET_HASH',			'string',		'FMS secret hash',						null);
					
			");
	}
		
	function down(){
		$this->dbforge->drop_table('settings');
	}
}

