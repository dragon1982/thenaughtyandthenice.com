<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_users extends	Migration {
	
	
	/**
	 * Migration with repository 6
	 * (non-PHPdoc)
	 * @see web/application/libraries/Migration#up()
	 */
	function up() 
	{	
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table users...";
		
		if ( ! $this->db->table_exists('users'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			
			$this->dbforge->add_field(array(
				'id' 			=> array('type' => 'INT', 		'constraint' => 11, 	'unsigned' => TRUE, 'auto_increment' => TRUE),
				'username' 		=> array('type' => 'CHAR', 		'constraint' => 25, 	'null' => FALSE),
				'password' 		=> array('type' => 'CHAR', 		'constraint' => 64, 	'null' => FALSE),
				'hash' 			=> array('type' => 'CHAR', 		'constraint' => 64, 	'null' => FALSE),
				'email' 		=> array('type' => 'CHAR', 		'constraint' => 64, 	'null' => FALSE),
				'status' 		=> array('type' => 'ENUM', 		'constraint' =>"'approved','pending','rejected'",'null' => FALSE),
				'gateway' 		=> array('type' => 'ENUM', 		'constraint' =>"'test_gateway'", 'null' => TRUE),
				'credits'		=> array('type' => 'DECIMAL', 	'constraint' => '7,2',	'default'=>0)
			));
			
			$this->dbforge->create_table('users', TRUE);
		}
		
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table users detail...";
		
		if ( ! $this->db->table_exists('users_detail'))
		{	
			// Setup Keys
			$this->dbforge->add_key('user_id');
			
			$this->dbforge->add_field(array(
				'user_id' 		=> array('type' => 'INT', 		'constraint' => 11, 	'unsigned' => TRUE),
				'register_ip'	=> array('type' => 'INT', 		'constraint' => 11, 	'null' => FALSE),
				'register_date'	=> array('type' => 'INT', 		'constraint' => 11, 	'null' => FALSE),
				'cancel_date'	=> array('type' => 'INT', 		'constraint' => 11, 	'null' => TRUE),			
				'country_code'	=> array('type' => 'CHAR', 		'constraint' => 2, 		'null' => FALSE),
				'newsletter'	=> array('type' => 'TINYINT',	'constraint' => 1, 		'null' => FALSE,'default'=>1),
				'affiliate_id' 	=> array('type' => 'INT', 		'constraint' => 11, 	'null' => TRUE),
				'affiliate_ad_id'=> array('type' => 'INT', 		'constraint' => 11,		'null' => TRUE),
			));
			
			$this->dbforge->create_table('users_detail', TRUE);
			
			$this->db->query('set foreign_key_checks = 0');
			$this->db->query('ALTER TABLE users_detail ADD FOREIGN KEY(`user_id`) REFERENCES users(id)  on update cascade on delete cascade');
			$this->db->query('set foreign_key_checks = 1');
		}
		
		
		
		// -----------------------------------------------------------------------------------------		
		$this->migrations->verbose AND print "Creating table logins...";
		
		if ( ! $this->db->table_exists('logins'))
		{	
			// Setup Keys
			$this->dbforge->add_key('user_id');
			
			$this->dbforge->add_field(array(
				'user_id' 		=> array('type' => 'INT', 		'constraint' => 11, 	'unsigned' => TRUE),
				'ip'			=> array('type' => 'INT', 		'constraint' => 11, 	'null' => FALSE),
				'count'			=> array('type' => 'MEDIUMINT',	'constraint' => 5, 		'null' => FALSE),
				'first_login'	=> array('type' => 'INT', 		'constraint' => 11, 	'null' => FALSE),			
				'last_login' 	=> array('type' => 'INT', 		'constraint' => 11, 	'null' => FALSE),
			));
			
			$this->dbforge->create_table('logins', TRUE);
		}		
		
		
		// -----------------------------------------------------------------------------------------		
		$this->migrations->verbose AND print "Creating table failure logins...";
		
		if ( ! $this->db->table_exists('failure_logins'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id',TRUE);
			$this->dbforge->add_key('ip');
			
			$this->dbforge->add_field(array(
				'id' 			=> array('type' => 'INT', 		'constraint' => 11, 	'unsigned' => TRUE,'auto_increment' => TRUE),
				'ip'			=> array('type' => 'INT', 		'constraint' => 11, 	'null' => FALSE),
				'failed_logins'	=> array('type' => 'MEDIUMINT',	'constraint' => 4, 		'null' => FALSE),
				'last_failure'	=> array('type' => 'INT', 		'constraint' => 11, 	'null' => FALSE),			
				'username' 		=> array('type' => 'CHAR', 		'constraint' => 25, 	'null' => FALSE),
			));
			
			$this->dbforge->create_table('failure_logins', TRUE);
		}
	}

	
	/**
	 * Blame this migration
	 * (non-PHPdoc)
	 * @see web/application/libraries/Migration#down()
	 */
	function down() 
	{
		$this->dbforge->drop_table('users');
		$this->dbforge->drop_table('users_detail');
		$this->dbforge->drop_table('logins');
		$this->dbforge->drop_table('failure_logins');		
	}
	
}
