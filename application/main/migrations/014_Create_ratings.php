<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_ratings extends Migration {
	
	function up() {
		
		
		$this->migrations->verbose AND print "Creating table performers_ratings...";
				
		if ( ! $this->db->table_exists('performers_ratings'))
		{	

            $this->dbforge->add_key('performer_id');
            $this->dbforge->add_key('user_id');

			$this->dbforge->add_field(array(
				'performer_id'  => array('type' => 'INT',       'constraint' => 11,      'unsigned' => TRUE,     'null' => FALSE),
				'user_id'       => array('type' => 'INT',       'constraint' => 11,      'unsigned' => TRUE,     'null' => FALSE),
				'rating'        => array('type' => 'DOUBLE',    'null' => FALSE),
			));
			
			$this->dbforge->create_table('performers_ratings', TRUE);			
		}			
	}
		
	
	function down(){
		$this->dbforge->drop_table('performers_ratings');
	}
}
