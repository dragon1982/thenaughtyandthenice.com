<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_studios extends Migration {

	/**
	 * (non-PHPdoc)
	 * @see web/application/libraries/Migration#up()
	 */
	
	function up() {
		
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table studios...";
				
		if ( ! $this->db->table_exists('studios'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('username');
			
			
			$this->dbforge->add_field(array(
				'id' 						=> array('type' => 'INT', 			'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'username' 					=> array('type' => 'CHAR', 			'constraint' => 25,		'null' => FALSE),
				'password' 					=> array('type' => 'CHAR', 			'constraint' => 64,		'null' => FALSE),
				'hash' 						=> array('type' => 'CHAR', 			'constraint' => 64,		'null' => FALSE),
				'email' 					=> array('type' => 'CHAR',	 		'constraint' => 64,		'null' => FALSE),
				'first_name' 				=> array('type' => 'VARCHAR',		'constraint' => 30,		'null' => TRUE),
				'last_name' 				=> array('type' => 'VARCHAR',		'constraint' => 30,		'null' => TRUE),
				'status' 					=> array('type' => 'ENUM', 			'constraint' =>"'approved','pending','rejected'", 'default'=>"pending", 'null' => FALSE),
				'register_date'				=> array('type' => 'INT', 			'constraint' => 11),
				'register_ip'				=> array('type' => 'INT', 			'constraint' => 11),				
				'contract_status' 			=> array('type' => 'ENUM', 			'constraint' =>"'approved','pending','rejected'", 'default'=>"pending", 'default'=>'pending',  'null' => FALSE),
				'country_code'				=> array('type' => 'CHAR', 			'constraint' => 2,		'null' => TRUE ),
				'address' 					=> array('type' => 'VARCHAR', 		'constraint' => 80,		'null' => TRUE),
				'state' 					=> array('type' => 'VARCHAR', 		'constraint' => 40,		'null' => TRUE),
				'city' 						=> array('type' => 'VARCHAR', 		'constraint' => 40,		'null' => TRUE),
				'zip' 						=> array('type' => 'VARCHAR', 		'constraint' => 40,		'null' => TRUE),
				'phone' 					=> array('type' => 'VARCHAR', 		'constraint' => 15,		'null' => TRUE),
				'payment' 					=> array('type' => 'TINYINT', 		'constraint' => 3,		'default' => 0),
				'account' 					=> array('type' => 'VARCHAR', 		'constraint' => 800,	'null' => TRUE),
				'release' 					=> array('type' => 'DECIMAL', 		'constraint' => '7,2',	'default' => 0),			
				'credits'					=> array('type' => 'DECIMAL', 		'constraint' => '7,2',	'default' => 0),
				'percentage'				=> array('type' => 'TINYINT', 		'constraint' => 1,		'default' => 0),
			));
			
			$this->dbforge->create_table('studios', TRUE);			
		}			
	}
		
	
	function down(){
		$this->dbforge->drop_table('studios');
	}
}
