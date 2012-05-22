<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_performers_reviews extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Creating table performers_reviews..";
		if ( ! $this->db->table_exists('performers_reviews'))
		{	
            $this->dbforge->add_key('id', TRUE);

			$this->dbforge->add_field(array(
				'id'					=> array('type' => 'INT',   	'constraint' => 11,     'unsigned' => TRUE,	'auto_increment' => TRUE),
				'user_id'				=> array('type' => 'INT',   	'constraint' => 11,		'unsigned' => TRUE,	'null' => FALSE),
				'performer_id' 			=> array('type' => 'INT',		'constraint' => 11, 	'unsigned' => TRUE,	'null' => FALSE),
				'add_date'				=> array('type' => 'INT',		'constraint' => 11, 	'unsigned' => TRUE,	'null' => FALSE),
				'unique_id'    			=> array('type' => 'CHAR',		'constraint' => 64, 	'null' => FALSE),
				'message'      			=> array('type' => 'varchar',	'constraint' => 255,	'null' => FALSE),
				'rating'      			=> array('type' => 'DOUBLE',	'null' => FALSE)
			));
			$this->dbforge->create_table('performers_reviews', TRUE);			
		}			
	
	}
		
	function down(){
		$this->dbforge->drop_table('performers_reviews');
	}
}

