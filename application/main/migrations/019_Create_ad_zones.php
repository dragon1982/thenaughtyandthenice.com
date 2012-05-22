<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_ad_zones extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Creating table ad_zones..";
		if ( ! $this->db->table_exists('ad_zones'))
		{	
            $this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_field(array(
				'id'					=> array('type' => 'INT',       'constraint' => 11,      'unsigned' => TRUE,	'auto_increment' => TRUE),
				'hash'					=> array('type' => 'VARCHAR',   'constraint' => 255),
				'name'					=> array('type' => 'VARCHAR',   'constraint' => 255),
				'add_date'       		=> array('type' => 'INT',		'constraint' => 11),
				'affiliate_id'       	=> array('type' => 'INT',		'constraint' => 11),
				'type'		      		=> array('type' => 'VARCHAR',	'constraint' => 100),
				'bg_color'	      		=> array('type' => 'VARCHAR',	'constraint' => 7),
				'border_color'     		=> array('type' => 'VARCHAR',	'constraint' => 7),
				'text_color'     		=> array('type' => 'VARCHAR',	'constraint' => 7),
				'performers_status'    	=> array('type' => 'VARCHAR',	'constraint' =>	50,		'null'=>TRUE),
				'category_link'       	=> array('type' => 'VARCHAR',	'constraint' => 100,	'null'=>TRUE),
				'link_location'       	=> array('type' => 'INT',		'constraint' => 2,		'comment'=>'0 - Profile, 1 - Home page, 2 - Free chat'),
				'views'					=> array('type' => 'INT',		'constraint' => 16,		'default'=>'0'),
				'hits'					=> array('type' => 'INT',		'constraint' => 16,		'default'=>'0'),
				'registers'				=> array('type' => 'INT',		'constraint' => 16,		'default'=>'0'),
				'earnings'				=> array('type' => 'INT',		'constraint' => 11,		'default'=>'0')
			));
			$this->dbforge->create_table('ad_zones', TRUE);			
		}			
	}
		
	function down(){
		$this->dbforge->drop_table('ad_zones');
	}
}

