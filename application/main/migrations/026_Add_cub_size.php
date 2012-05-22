<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_cub_size extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Adding field cub_size";
		$this->dbforge->add_column('performers_profile',
			array('cup_size'=>array(
				'type' 			=> 'ENUM',
				'constraint' 	=> "'A', 'B', 'C', 'D', 'E', 'F'",
				'null'			=> TRUE
			)
		));
		
	}
		
	function down(){
		$this->dbforge->drop_column('performers_profile','cup_size');
	}
}

