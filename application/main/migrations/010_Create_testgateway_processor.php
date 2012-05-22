<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_testgateway_processor extends Migration {
	
	
	/**
	 * Migration with repository  112
	 * (non-PHPdoc)
	 * @see web/application/libraries/Migration#up()
	 */
	function up() 
	{	
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table test_gateway_processor...";
		
		if ( ! $this->db->table_exists('test_gateway_processor'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			
			$this->dbforge->add_field(array(
				'id' 			=> array('type' => 'INT', 		'constraint' => 11, 	'unsigned' => TRUE, 'auto_increment' => TRUE),
				'amount' 		=> array('type' => 'DECIMAL',	'constraint' => '6,2', 	'null' => FALSE),
				'currency' 		=> array('type' => 'CHAR', 		'constraint' => 3, 		'null' => FALSE),
				'ip' 			=> array('type' => 'INT', 		'constraint' => 11, 	'null' => FALSE),
			));
			
			$this->dbforge->create_table('test_gateway_processor', TRUE);
		}
		
		
	
	}

	
	/**
	 * Blame this migration
	 * (non-PHPdoc)
	 * @see web/application/libraries/Migration#down()
	 */
	function down() 
	{
		$this->dbforge->drop_table('test_gateway_processor');	
	}
	
}
