<?php
Class Migration_Create_watchers extends Migration{
	
	function up(){
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table watchers...";
		
		//Watchers table
		if ( ! $this->db->table_exists('watchers'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('unique_id');						
			$this->dbforge->add_key('user_id');
			$this->dbforge->add_key('performer_id');
			
			
			$this->dbforge->add_field(array(
				'id' 					=> array('type' => 'INT', 			'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'type' 					=> array('type' => 'ENUM', 			'constraint' => "'private','true_private','peek','nude','free','premium_video','photos','gift','admin_action','spy'",	'default' => 'free'),
				'start_date' 			=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'end_date' 				=> array('type' => 'INT',	 		'constraint' => 11,		'null' => FALSE),
				'duration'				=> array('type' => 'INT', 			'constraint' => 6,		'null' => FALSE),			
				'show_is_over'			=> array('type' => 'TINYINT', 		'constraint' => 1,		'default' => 0),			
				'ip' 					=> array('type' => 'INT',			'constraint' => 11,		'null' => TRUE,'unsigned'=>TRUE),
				'fee_per_minute' 		=> array('type' => 'DECIMAL',		'constraint' => '8,2',	'null' => TRUE),
				'user_paid_chips' 		=> array('type' => 'DECIMAL', 		'constraint' => '8,2',	'default' => 0),
				'site_chips'			=> array('type' => 'DECIMAL', 		'constraint' => '8,2',	'default' => 0,00),
				'studio_chips'			=> array('type' => 'DECIMAL', 		'constraint' => '8,2',	'default' => 0,00),
				'performer_chips'		=> array('type' => 'DECIMAL', 		'constraint' => '8,2',	'default' => 0,00),				
				'unique_id' 			=> array('type' => 'CHAR', 			'constraint' => 64,		'null' => FALSE),
				'was_banned' 			=> array('type' => 'TINYINT', 		'constraint' => 1,		'null' => TRUE),
				'ban_date' 				=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'ban_expire_date' 		=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'user_id' 				=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'username'				=> array('type' => 'CHAR', 			'constraint' => 25,		'null' => TRUE), 	
				'studio_id'				=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'performer_id' 			=> array('type' => 'INT', 			'constraint' => 11, 	'null' => TRUE),
				'is_imported' 			=> array('type' => 'TINYINT', 		'constraint' => 1, 		'default' => 0),
				'performer_video_id'	=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'paid' 					=> array('type' => 'TINYINT', 		'constraint' => 1,		'default' => 0),
			));
			
			$this->dbforge->create_table('watchers', TRUE , 'Memory');			
		}	

		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table watchers_old...";
		
		//Watchers table
		if ( ! $this->db->table_exists('watchers_old'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('unique_id');			
			$this->dbforge->add_key('user_id');
			$this->dbforge->add_key('performer_id');
			
			
			$this->dbforge->add_field(array(
				'id' 					=> array('type' => 'INT', 			'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'type' 					=> array('type' => 'ENUM', 			'constraint' => "'private','true_private','peek','nude','free','premium_video','photos','gift','admin_action','spy'",	'default' => 'free'),
				'start_date' 			=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'end_date' 				=> array('type' => 'INT',	 		'constraint' => 11,		'null' => FALSE),
				'duration'				=> array('type' => 'INT', 			'constraint' => 6,		'null' => FALSE),			
				'show_is_over'			=> array('type' => 'TINYINT', 		'constraint' => 1,		'default' => 0),			
				'ip' 					=> array('type' => 'INT',			'constraint' => 11,		'null' => TRUE,'unsigned'=>TRUE),
				'fee_per_minute' 		=> array('type' => 'DECIMAL',		'constraint' => '8,2',	'null' => TRUE),
				'user_paid_chips' 		=> array('type' => 'DECIMAL', 		'constraint' => '8,2',	'default' => 0),
				'site_chips'			=> array('type' => 'DECIMAL', 		'constraint' => '8,2',	'default' => 0,00),
				'studio_chips'			=> array('type' => 'DECIMAL', 		'constraint' => '8,2',	'default' => 0,00),
				'performer_chips'		=> array('type' => 'DECIMAL', 		'constraint' => '8,2',	'default' => 0,00),				
				'unique_id' 			=> array('type' => 'CHAR', 			'constraint' => 64,		'null' => FALSE),
				'was_banned' 			=> array('type' => 'TINYINT', 		'constraint' => 1,		'null' => TRUE),
				'ban_date' 				=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'ban_expire_date' 		=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'user_id' 				=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'username'				=> array('type' => 'CHAR', 			'constraint' => 25,		'null' => TRUE), 	
				'studio_id'				=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'performer_id' 			=> array('type' => 'INT', 			'constraint' => 11, 	'null' => TRUE),
				'is_imported' 			=> array('type' => 'TINYINT', 		'constraint' => 1, 		'default' => 0),
				'performer_video_id'	=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'paid' 					=> array('type' => 'TINYINT', 		'constraint' => 1,		'default' => 0),
			));
			
			$this->dbforge->create_table('watchers_old', TRUE , 'InnoDB');			
		}		
	}
	
	
	function down(){
			$this->dbforge->drop_table('watchers');
			$this->dbforge->drop_table('watchers_old');			
	}
}