<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_chat_logs extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Creating table chat_logs..";
		if ( ! $this->db->table_exists('chat_logs'))
		{	
            $this->dbforge->add_key('id', TRUE);

			$this->dbforge->add_field(array(
				'id'					=> array('type' => 'INT',   	'constraint' => 11,     'unsigned' => TRUE,	'auto_increment' => TRUE),
				'performer_id' 			=> array('type' => 'INT',		'constraint' => 11, 	'unsigned' => TRUE,	'null' => FALSE),
				'add_date'				=> array('type' => 'INT',		'constraint' => 11, 	'unsigned' => TRUE,	'null' => FALSE),
				'log'      				=> array('type' => 'TEXT',	 	'null' => TRUE),
				
			));
			$this->dbforge->create_table('chat_logs', TRUE);			
		}			
	
	}
		
	function down(){
		$this->dbforge->drop_table('chat_logs');
	}
}

