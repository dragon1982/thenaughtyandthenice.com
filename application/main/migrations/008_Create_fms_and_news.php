<?php
Class Migration_Create_fms_and_news extends Migration{
	
	function up(){
		
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table fms...";
				
		//FMS table
		if ( ! $this->db->table_exists('fms'))
		{	
			// Setup Keys
			$this->dbforge->add_key('fms_id', TRUE);
			
			
			$this->dbforge->add_field(array(
				'fms_id' 					=> array('type' => 'INT', 		'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'name' 						=> array('type' => 'VARCHAR',	'constraint' => 255,	'null' => FALSE),
				'max_hosted_performers'		=> array('type' => 'INT', 		'constraint' => 10,		'default' => 0),
				'current_hosted_performers'	=> array('type' => 'INT',		'constraint' => 10, 	'default' => 0),
				'status'					=> array('type'	=> 'ENUM',		'constraint' => "'active','inactive'"),
				'fms'						=> array('type' => 'VARCHAR', 	'constraint' => 255,	'null' => TRUE),			
				'fms_for_video'				=> array('type' => 'VARCHAR', 	'constraint' => 255,	'null' => TRUE),			
				'fms_for_preview'			=> array('type' => 'VARCHAR', 	'constraint' => 255,	'null' => TRUE),
				'fms_for_delete'			=> array('type' => 'VARCHAR', 	'constraint' => 255,	'null' => TRUE),
				'fms_test'					=> array('type' => 'VARCHAR', 	'constraint' => 255,	'null' => TRUE),
			));
			
			$this->dbforge->create_table('fms', TRUE);			
		}
		
	}
	
	function down(){		
		$this->dbforge->drop_table('fms');
	}
}