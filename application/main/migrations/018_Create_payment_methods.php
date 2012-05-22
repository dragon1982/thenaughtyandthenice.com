<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_payment_methods extends Migration {
	
	function up(){
		$this->migrations->verbose AND print "Creating payments methods..";
		if ( ! $this->db->table_exists('payment_methods'))
		{	
            $this->dbforge->add_key('id', TRUE);

			$this->dbforge->add_field(array(
				'id'				=> array('type' => 'TINYINT',   'constraint' => 1,      'unsigned' => TRUE,	'auto_increment' => TRUE),
				'name'				=> array('type' => 'VARCHAR',   'constraint' => 100,	'null'=>TRUE),
				'minim_amount'      => array('type' => 'MEDIUMINT',	'constraint' => 5, 		'default'=>0),
				'fields'       		=> array('type' => 'TEXT',		'null' => TRUE),
				'status'       		=> array('type' => 'ENUM',		'constraint' => '"approved","rejected"','default'=>'rejected'),
			));
			$this->dbforge->create_table('payment_methods', TRUE);			
		}


		$this->db->insert('payment_methods',array('name'=>'Paypal','minim_amount'=>100,'fields'=>'a:2:{i:0;s:4:"Name";i:1;s:5:"Email";}','status'=>'approved'));
	}
		
	function down(){
		$this->dbforge->drop_table('payment_methods');
	}
	
}