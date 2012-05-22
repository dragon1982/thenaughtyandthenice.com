<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_schedules extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Creating table performers_schedules..";
		if ( ! $this->db->table_exists('performers_schedules'))
		{	
            $this->dbforge->add_key('performer_id');
			$this->dbforge->add_field(array(
				'performer_id'  	    => array('type' => 'INT',       'constraint' => 11,      'unsigned' => TRUE,     'auto_increment' => TRUE),
				'day_of_week'           => array('type' => 'TINYINT',   'constraint' => 10,      'null' => FALSE),
				'hour'       			=> array('type' => 'TINYINT',	'constraint' => 10,	     'null' => FALSE),
			));
			$this->dbforge->create_table('performers_schedules', TRUE);			
		}			
	}
		
	function down(){
		$this->dbforge->drop_table('performers_schedules');
	}
}
