<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_admin_setting extends Migration {
	
	function up() {
		$this->migrations->verbose AND print "Adding license field";
		
		$this->db->query("INSERT INTO `settings` (`name`, `value`, `type`, `title`, `description`) VALUES 
				('website_license',			'trial',						'string',	'Application License Key',	null)
		");
		
	}
		
	function down(){
		
	}
}

