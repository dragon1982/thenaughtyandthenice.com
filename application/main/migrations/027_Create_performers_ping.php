<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_performers_ping extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Creating table songs..";
		if ( ! $this->db->table_exists('performers_ping'))
		{	
            $this->dbforge->add_key('performer_id', TRUE);         

			$this->dbforge->add_field(array(
				'performer_id'			=> array('type' => 'INT',   	'constraint' => 11,     'unsigned' => TRUE),
				'last_ping' 			=> array('type' => 'INT',		'constraint' => 11, 	'unsigned' => TRUE),											
			));
			$this->dbforge->create_table('performers_ping', TRUE,'Memory');			
		}			

	}
		
	function down(){
		$this->dbforge->drop_table('performers_ping');
	}
}

