<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_ad_traffic extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Creating table ad_traffic..";
		if ( ! $this->db->table_exists('ad_traffic'))
		{	
            $this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_field(array(
				'id'					=> array('type' => 'INT',       'constraint' => 11,      'unsigned' => TRUE,	'auto_increment' => TRUE),
				'ad_id'					=> array('type' => 'INT',		'constraint' => 11),
				'affiliate_id'			=> array('type' => 'INT',		'constraint' => 11),
				'date'					=> array('type' => 'INT',		'constraint' => 11),
				'action'				=> array('type' => 'ENUM',		'constraint' => "'hit','view','transaction','register'"),
				'earnings'				=> array('type' => 'INT',		'constraint' => 11,		'default'=>'0')
			));
			$this->dbforge->create_table('ad_traffic', TRUE);			
		}			
	}
		
	function down(){
		$this->dbforge->drop_table('ad_traffic');
	}
}

