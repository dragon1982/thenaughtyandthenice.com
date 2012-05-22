<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_music extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Creating table songs..";
		if ( ! $this->db->table_exists('songs'))
		{	
            $this->dbforge->add_key('id', TRUE);

			$this->dbforge->add_field(array(
				'id'					=> array('type' => 'INT',   	'constraint' => 11,     'unsigned' => TRUE,	'auto_increment' => TRUE),
				'title' 				=> array('type' => 'varchar',	'constraint' => 255, 	'null' => FALSE),
				'src'					=> array('type' => 'varchar',	'constraint' => 255, 	'null' => FALSE),				
				
			));
			$this->dbforge->create_table('songs', TRUE);			
		}			
		$this->migrations->verbose AND print "Populating songs...";
			$this->db->query("INSERT INTO `songs` (`title`, `src`) VALUES ('Sample Track', 'sample_track.mp3')");
	}
		
	function down(){
		$this->dbforge->drop_table('songs');
	}
}

