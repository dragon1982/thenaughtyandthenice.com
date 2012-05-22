<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_system_logs extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Creating system logs..";
		if ( ! $this->db->table_exists('system_logs'))
		{	
            $this->dbforge->add_key('id', TRUE);
            
			$this->dbforge->add_field(array(
				'id'					=> array('type' => 'INT',       'constraint' => 11,      'unsigned' => TRUE,	'auto_increment' => TRUE),
				'date'					=> array('type' => 'INT',  	 	'constraint' => 11),
				'actor'					=> array('type' => 'ENUM',   	'constraint' => "'user','performer','studio','admin', 'affiliate' ,'cron','fms'"),
				'actor_id'       		=> array('type' => 'INT',		'constraint' => 11,		'null'=>TRUE),
				'action_on'       		=> array('type' => 'ENUM',		'constraint' => "'user','performer','studio', 'affiliate', 'admin','other'"),
				'action_on_id'		    => array('type' => 'INT',		'constraint' => 11,		'null'=>TRUE),
				'action'       			=> array('type' => 'ENUM',		'constraint' => "'add_photo',
																						'delete_photo',
																						'edit_photo',
																						'add_video',
																						'delete_video',
																						'edit_video',
																						'buy_video',
																						'edit_account',
																						'edit_profile',
																						'delete_account',
																						'add_credits',
																						'remove_credits',
																						'performers_photo_id_status',
																						'contracts_status',
																						'add_admin',
																						'delete_admin',
																						'edit_admin',
																						'add_category',
																						'edit_category',
																						'delete_category',
																						'register',
																						'reset_password',
																						'change_password',
																						'add_payment_method',
																						'edit_payment_method',
																						'delete_payment_method',
																						'set_payment_method',
																						'edit_payment_details',
																						'logout',
																						'login',
																						'start_chat',
																						'end_chat',
																						'tip',
																						'edit_settings',
																						'delete_supported_language',
																						'generate_payment',
																						'ban',
																						'newsletter'
																						"),
				'ip'					=> array('type' => 'INT',		'constraint' => 11,		'null'=>TRUE),
				'key'					=> array('type' => 'INT',		'constraint' => 11,		'null'=>TRUE),
				'action_comment'		=> array('type' => 'VARCHAR',	'constraint' => 255,	'null'=>TRUE),

			));
			$this->dbforge->create_table('system_logs', TRUE);			
		}			
	}

	function down() {
		$this->dbforge->drop_table('system_logs');		
	}
}