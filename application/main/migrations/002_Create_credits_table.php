<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_credits_table extends Migration {
	
	/**
	 * Migration with repository 6
	 * (non-PHPdoc)
	 * @see web/application/libraries/Migration#up()
	 */
	function up() 
	{	
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table credits...";
		
		if ( ! $this->db->table_exists('credits'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('user_id');
			$this->dbforge->add_key('invoice_id');
			
			
			$this->dbforge->add_field(array(
				'id' 				=> array('type' => 'INT', 		'constraint' => 11, 			'unsigned' => TRUE, 'auto_increment' => TRUE),
				'amount_paid' 		=> array('type' => 'DECIMAL', 	'constraint' => '7,2', 			'null' => FALSE),
				'currency_paid' 	=> array('type' => 'CHAR',		'constraint' => 30, 			'null' => FALSE),
				'amount_received' 	=> array('type' => 'DECIMAL', 	'constraint' => '7,2', 			'null' => FALSE),
				'currency_received' => array('type' => 'ENUM', 		'constraint' => "'CHIPS'", 		'null' => FALSE),
				'date' 				=> array('type' => 'INT', 		'constraint' => 11,				'null' => FALSE),
				'type' 				=> array('type' => 'ENUM', 		'constraint' =>"'credit','bonus','chargeback','void'", 'null' => TRUE),
				'invoice_id'		=> array('type' => 'INT', 		'constraint' => 11,	'default'=>0),
				'refunded'			=> array('type' => 'INT', 		'constraint' => 11,	'null'=>TRUE),
				'status'			=> array('type' => 'ENUM', 		'constraint' => "'approved','pending','rejected'",	'null'=>TRUE),
				'user_id'			=> array('type' => 'INT', 		'constraint' => 11,	'default'=>0),
			));
			
			$this->dbforge->create_table('credits', TRUE);			
		}
		
		$this->migrations->verbose AND print "Creating table credits details...";
		
		if ( ! $this->db->table_exists('credits_detail'))
		{	
			// Setup Keys
			$this->dbforge->add_key('credit_id', TRUE);
		
			
			$this->dbforge->add_field(array(
				'credit_id'			=> array('type' => 'INT', 		'constraint' => 11, 'unsigned' => TRUE,'auto_increment' => TRUE),
				'log_table' 		=> array('type' => 'ENUM', 		'constraint' => '"test_gateway_processor"', 'null' => TRUE),
				'log_id' 			=> array('type' => 'INT', 		'constraint' => 11, 'null' => TRUE),
				'special' 			=> array('type' => 'TINYINT', 	'constraint' => 1, 	'null' => TRUE),
				'extra_field' 		=> array('type' => 'CHAR', 		'constraint' => 11,	'null' => TRUE),
			));
			
			$this->dbforge->create_table('credits_detail', TRUE);			
		}
			
		$this->db->query('set foreign_key_checks = 0');
		$this->db->query('ALTER TABLE credits_detail ADD FOREIGN KEY(`credit_id`) REFERENCES credits(id) on update cascade on delete cascade');
		$this->db->query('set foreign_key_checks = 1');
		
	}

	/**
	 * Blame this migration
	 * (non-PHPdoc)
	 * @see web/application/libraries/Migration#down()
	 */
	function down() 
	{
		$this->dbforge->drop_table('credits');
		$this->dbforge->drop_table('credits_detail');		
	}	
}