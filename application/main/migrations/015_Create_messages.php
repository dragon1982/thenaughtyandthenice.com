<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_messages extends Migration {
	
	function up() {
		
		
		$this->migrations->verbose AND print "Creating table messages..";
				
		if ( ! $this->db->table_exists('messages'))
		{	

            $this->dbforge->add_key('id',TRUE);
            $this->dbforge->add_key('from_id');
            $this->dbforge->add_key('to_id');

			$this->dbforge->add_field(array(
				'id'  					=> array('type' => 'INT',       'constraint' => 11,      'unsigned' => TRUE,     'auto_increment' => TRUE),
				'subject'       		=> array('type' => 'varchar',   'constraint' => 255,     'null' => FALSE),
				'body'       			=> array('type' => 'text',		 'null' => FALSE),
				'readed_by_recipient'	=> array('type' => 'TINYINT',   'constraint' => 1,      'unsigned' => TRUE,     'default' => 0),
				'trashed_by_recipient'	=> array('type' => 'TINYINT',   'constraint' => 1,      'unsigned' => TRUE,     'default' => 0),
				'deleted_by_recipient'	=> array('type' => 'TINYINT',   'constraint' => 1,      'unsigned' => TRUE,     'default' => 0),
				'deleted_by_sender'		=> array('type' => 'TINYINT',   'constraint' => 1,      'unsigned' => TRUE,     'default' => 0),
				'date'       			=> array('type' => 'INT',   	'constraint' => 11,		'unsigned' => TRUE,     'default' => 0),
				'from_type'       		=> array('type' => 'ENUM',   	'constraint' => '"user","performer","studio","admin"','null'=> TRUE),
				'from_id'       		=> array('type' => 'INT',   	'constraint' => 11,		'unsigned' => TRUE,     'null' => FALSE),
				'to_type'       		=> array('type' => 'ENUM',   	'constraint' =>'"user","performer","studio","admin","affiliate"',  'null' => TRUE),
				'to_id'       			=> array('type' => 'INT',   	'constraint' => 11,		'unsigned' => TRUE,     'null' => FALSE),						
			));
			
			$this->dbforge->create_table('messages', TRUE);			
		}			
	}
		
	
	function down(){
		$this->dbforge->drop_table('messages');
	}
}

