<?php
class Migration_Create_performers_maintenance_stuff extends Migration{
	
	function up(){
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table performers_photo_id...";
		
		//Photo id table
		if ( ! $this->db->table_exists('performers_photo_id'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('performer_id');
						
			$this->dbforge->add_field(array(
				'id'				=> array('type' => 'INT',		'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'date'				=> array('type' => 'INT',		'constraint' => 11,		'null' => TRUE),
				'name_on_disk'		=> array('type' => 'VARCHAR',	'constraint' => 255,	'null' => TRUE),
				'status'			=> array('type' => 'ENUM',		'constraint' => "'approved','pending','rejected'",		'default' => "pending"),
				'performer_id'		=> array('type' => 'INT',		'constraint' => 11,		'null' => TRUE),
			));
			
			$this->dbforge->create_table('performers_photo_id', TRUE);			
		}	
		
		
		

		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table contracts...";
		
		//Contracts table
		if ( ! $this->db->table_exists('contracts'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('performer_id');
			$this->dbforge->add_key('studio_id');
			
			
			$this->dbforge->add_field(array(
				'id'				=> array('type' => 'INT',		'constraint' => 10,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'date'				=> array('type' => 'INT',		'constraint' => 11,		'null' => FALSE),
				'name_on_disk'		=> array('type' => 'VARCHAR',	'constraint' => 255,	'null' => TRUE),
				'status'			=> array('type' => 'ENUM',		'constraint' => "'approved','pending','rejected'",		'default' => "pending"),
				'performer_id'		=> array('type' => 'INT',		'constraint' => 11,		'null' => TRUE),
				'studio_id'			=> array('type' => 'INT',		'constraint' => 11,		'null' => TRUE),
			));
			
			$this->dbforge->create_table('contracts', TRUE);			
		}			
		
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table payments...";
		
		//Payments table
		if ( ! $this->db->table_exists('payments'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('performer_id');
			$this->dbforge->add_key('studio_id');			
						
			$this->dbforge->add_field(array(
				'id'					=> array('type' => 'INT',		'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'paid_date'				=> array('type' => 'INT',		'constraint' => 11,		'null' => FALSE,'unsigned' => TRUE),
				'from_date'				=> array('type' => 'INT',		'constraint' => 11,		'null' => FALSE,'unsigned' => TRUE),
				'to_date'				=> array('type' => 'INT',		'constraint' => 11,		'null' => FALSE,'unsigned' => TRUE),
				'amount_chips'			=> array('type' => 'DECIMAL',	'constraint' => "9,2",	'null' => FALSE),
				'status'				=> array('type' => 'ENUM',		'constraint' => "'paid', 'pending', 'rejected','invalid'",	'null' => FALSE),
				'comments'				=> array('type' => 'TEXT',		'null' => TRUE),
				'payment_fields_data'	=> array('type' => 'TEXT',		'null' => TRUE),
				'payment_name'			=> array('type' => 'varchar',	'constraint' => 255,	'null' => FALSE),
				'studio_id'				=> array('type' => 'INT',		'constraint' => 11,		'null' => TRUE),
				'performer_id'			=> array('type' => 'INT',		'constraint' => 11,		'null' => TRUE),
				'affiliate_id'			=> array('type' => 'INT',		'constraint' => 11,		'null' => TRUE),
			));
			
			$this->dbforge->create_table('payments', TRUE);					
		}		
	
	}
	
	function down(){				
		$this->dbforge->drop_table('contracts');
		$this->dbforge->drop_table('performers_photo_id');
		$this->dbforge->drop_table('payments');				
	}
}