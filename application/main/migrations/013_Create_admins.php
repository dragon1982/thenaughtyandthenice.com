<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_admins extends Migration {

	/**
	 * (non-PHPdoc)
	 * @see web/application/libraries/Migration#up()
	 */
	
	function up() {
		
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table admins...";
				
		if ( ! $this->db->table_exists('admins'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('username');
			
			
			$this->dbforge->add_field(array(
				'id' 						=> array('type' => 'INT', 			'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'username' 					=> array('type' => 'CHAR', 			'constraint' => 64,		'null' => FALSE),
				'password' 					=> array('type' => 'CHAR', 			'constraint' => 64,		'null' => FALSE),
				'hash' 						=> array('type' => 'CHAR', 			'constraint' => 64,		'null' => FALSE),
				'status'					=> array('type' => 'ENUM',			'constraint' => '"approved","rejected"', 'default'=>'approved')
			));
			
			$this->dbforge->create_table('admins', TRUE);			
		}			
	}
		
	
	function down(){
		$this->dbforge->drop_table('admins');
	}
}
