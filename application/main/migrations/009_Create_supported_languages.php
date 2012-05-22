<?php 
/*
 * @author VladG
 * 
 */
Class Migration_Create_supported_languages extends Migration{
	
	function up(){
	
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table supported languages...";
				
		//suported_languages table
		if ( ! $this->db->table_exists('supported_languages'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			
			
			$this->dbforge->add_field(array(
				'id' 						=> array('type' => 'TINYINT', 	'constraint' => 3,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'code' 						=> array('type' => 'CHAR',		'constraint' => 2,		'null' => FALSE),
				'title'						=> array('type' => 'VARCHAR',	'constraint' => 50,		'null' => FALSE),
			));
			
			$this->dbforge->create_table('supported_languages', TRUE);			
		}
	}
	
	function down() {		
		$this->dbforge->drop_table('supported_languages');
	}
}