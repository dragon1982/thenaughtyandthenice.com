<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_affiliates extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Creating table affiliates..";
		if ( ! $this->db->table_exists('affiliates'))
		{	
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('username');
            $this->dbforge->add_key('email');
            $this->dbforge->add_key('token');
			$this->dbforge->add_field(array(
				'id'					=> array('type' => 'INT',       'constraint' => 11,      'unsigned' => TRUE,	'auto_increment' => TRUE),
				'username'				=> array('type' => 'CHAR',   	'constraint' => 25),
				'password'       		=> array('type' => 'CHAR',		'constraint' => 64),
				'email'					=> array('type' => 'CHAR',		'constraint' => 64),
				'credits'				=> array('type' => 'DECIMAL', 	'constraint' => '7,2',	'default'=>0),				
				'first_name'       		=> array('type' => 'VARCHAR',	'constraint' => 30,	'null'=>true,	'default'=>null),
				'last_name'       		=> array('type' => 'VARCHAR',	'constraint' => 30,	'null'=>true,	'default'=>null),
				'register_date'       	=> array('type' => 'INT',		'constraint' => 11),
				'register_ip'       	=> array('type' => 'INT',		'constraint' => 11),
				'register_country_code' => array('type' => 'CHAR',		'constraint' => 2),
				'payment'				=> array('type' => 'INT',		'constraint' => 11),
				'account'				=> array('type' => 'TEXT',),
				'release' 				=> array('type' => 'DECIMAL', 	'constraint' => '7,2',	'default' => 0),
				'country_code'			=> array('type' => 'CHAR',		'constraint' => 2,		'null'=>true,	'default'=>null),
				'address'				=> array('type' => 'VARCHAR',	'constraint' => 80,		'null'=>true,	'default'=>null),
				'state'					=> array('type' => 'VARCHAR',	'constraint' => 32,		'null'=>true,	'default'=>null),
				'city'					=> array('type' => 'VARCHAR',	'constraint' => 32,		'null'=>true,	'default'=>null),
				'zip'					=> array('type' => 'VARCHAR',	'constraint' => 32,		'null'=>true,	'default'=>null),
				'status'				=> array('type' => 'ENUM',		'constraint' => "'pending','approved','rejected'",	'default'=>'pending'),
				'phone'					=> array('type' => 'VARCHAR',	'constraint' => 32,		'null'=>true,	'default'=>null),
				'percentage'			=> array('type' => 'TINYINT',	'constraint' => 1),
				'token'					=> array('type' => 'CHAR',		'constraint' => 64),
				'hash'					=> array('type' => 'VARCHAR',	'constraint' => 255,	'null'=>true),
				'site_url'				=> array('type' => 'VARCHAR',	'constraint' => 255,	'null'=>true),
				'site_name'				=> array('type' => 'VARCHAR',	'constraint' => 255,	'null'=>true),
				'comision_type'			=> array('type' => 'ENUM',	'constraint' => "'initial', 'transaction'", 'default'=>'initial'),
			));
			$this->dbforge->create_table('affiliates', TRUE);			
		}			
	}
		
	function down(){
		$this->dbforge->drop_table('affiliates');
	}
}
