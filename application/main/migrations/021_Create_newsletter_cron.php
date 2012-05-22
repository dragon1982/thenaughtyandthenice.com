<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_newsletter_cron extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Creating table newsletter_cron..";
		if ( ! $this->db->table_exists('newsletter_cron'))
		{	
            $this->dbforge->add_key('id', TRUE);

			$this->dbforge->add_field(array(
				'id'					=> array('type' => 'INT',   	'constraint' => 11,     'unsigned' => TRUE,	'auto_increment' => TRUE),
				'recipient_email'		=> array('type' => 'VARCHAR',   'constraint' => 255,	'null' => FALSE),
				'email_subject'      	=> array('type' => 'VARCHAR',	'constraint' => 255, 	'null' => FALSE),
				'email_body'			=> array('type' => 'TEXT',								'null' => FALSE),
				'add_date'      		=> array('type' => 'BIGINT',	'constraint' => 20, 	'null' => FALSE),
				'sent'					=> array('type'	=> 'TINYINT',	'constraint' => 1,		'default'=>0)
			));
			$this->dbforge->create_table('newsletter_cron', TRUE);			
		}			
	
		
	}
		
	function down(){
		$this->dbforge->drop_table('newsletter_cron');
	}
}

