<?php
Class Migration_Create_ban_regions_table extends Migration{

	function up(){
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table banned countries...";

		//Banned countries table
		if ( ! $this->db->table_exists('banned_countries'))
		{	
					
			// Setup Keys
			$this->dbforge->add_key('id',TRUE);
			$this->dbforge->add_key('performer_id');
			
			$this->dbforge->add_field(array(
				'id'				=> array('type' => 'INT',	'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),			
				'performer_id'		=> array('type' => 'INT',	'constraint' => 11,		'default' => 0),
				'country_code'		=> array('type' => 'CHAR',	'constraint' => 2,		'null' => TRUE),
			));
			
			$this->dbforge->create_table('banned_countries', TRUE);			
		}		

		
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table banned states...";
		
		//performer states categories table
		if ( ! $this->db->table_exists('banned_states'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id',TRUE);
			$this->dbforge->add_key('performer_id');
			
			
			$this->dbforge->add_field(array(
				'id'				=> array('type' => 'INT',	'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'performer_id'		=> array('type' => 'INT',	'constraint' => 11,		'default' => 0),
				'state_code'		=> array('type' => 'ENUM',	'constraint' => "'AL','AK','AZ','AR','CA','CO','CT','DE','DC','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY'",	'null' => FALSE),
			));
			
			$this->dbforge->create_table('banned_states', TRUE);			
		}		
	}
	
	function down(){
		$this->dbforge->drop_table('banned_countries');
		$this->dbforge->drop_table('banned_states');		
	}

}