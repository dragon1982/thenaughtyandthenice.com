<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_performers extends Migration {

	/**
	 * Migration with repository 6
	 * (non-PHPdoc)
	 * @see web/application/libraries/Migration#up()
	 */
	
	function up() {
		
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table categories (general categories)...";
		
		//Categories table
		if ( ! $this->db->table_exists('categories'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			
			
			$this->dbforge->add_field(array(
				'id'			=> array('type' => 'SMALLINT',	'constraint' => 6,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'parent_id'		=> array('type' => 'SMALLINT',	'constraint' => 6,		'null' => TRUE),
				'name'			=> array('type' => 'VARCHAR',	'constraint' => 40,		'null' => FALSE),
				'link'			=> array('type' => 'VARCHAR',	'constraint' => 40,		'null' => FALSE),
				'performers_online'	=> array('type' => 'TINYINT',	'constraint' => 1,	'default' => 0),
				'performers_total'	=> array('type' => 'TINYINT',	'constraint' => 1,	'default' => 0)
			));
			
			$this->dbforge->create_table('categories', TRUE);			
		}		
	
		
		$this->migrations->verbose AND print "Populating categories...";
		$this->db->query("INSERT INTO `categories` (`id`, `parent_id`, `name`, `link`, `performers_online`, `performers_total`) VALUES
				(1, NULL, 'Woman', 'woman', 0, 0),
				(2, NULL, 'Man', 'man', 0, 0),
				(3, NULL, 'Couples', 'couples', 0, 0),
				(4, NULL, 'Fetish', 'fetish', 0, 0),
				(5, 1, 'Babes', 'babes', 0, 0),
				(6, 1, 'MILF', 'milf', 0, 0),
				(7, 1, 'Big Boobs', 'big_boobs', 0, 0),
				(8, 1, 'BBW', 'bbw', 0, 0),
				(9, 1, 'Tattoos/Piercings', 'tattoospiercings', 0, 0),
				(11, 3, 'Woman/Man', 'womanman', 0, 0),
				(12, 3, 'Woman/Woman', 'womanwoman', 0, 0),
				(13, 4, 'Dominant', 'dominant', 0, 0),
				(14, 4, 'Submissive', 'submissive', 0, 0),
				(15, 4, 'Leather/Latex', 'leatherlatex', 0, 0),
				(16, 4, 'BDSM', 'bdsm', 0, 0),
				(17, 4, 'Bondage', 'bondage', 0, 0),
				(18, 4, 'Foot Fetish', 'foot_fetish', 0, 0);
		");
		
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table performers...";
				
		if ( ! $this->db->table_exists('performers'))
		{	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('nickname');
			
			
			$this->dbforge->add_field(array(
				'id' 						=> array('type' => 'INT', 			'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'username' 					=> array('type' => 'CHAR', 			'constraint' => 25,		'null' => FALSE),
				'password' 					=> array('type' => 'CHAR', 			'constraint' => 64,		'null' => FALSE),
				'hash' 						=> array('type' => 'CHAR', 			'constraint' => 64,		'null' => FALSE),
				'email' 					=> array('type' => 'CHAR',	 		'constraint' => 64,		'null' => FALSE),
				'nickname'					=> array('type' => 'CHAR', 			'constraint' => 25,		'null' => FALSE),			
				'first_name' 				=> array('type' => 'VARCHAR',		'constraint' => 30,		'null' => TRUE),
				'last_name' 				=> array('type' => 'VARCHAR',		'constraint' => 30,		'null' => TRUE),
				'status' 					=> array('type' => 'ENUM', 			'constraint' =>"'approved','pending','rejected'", 'default'=>"pending", 'null' => FALSE),
				'avatar'					=> array('type' => 'VARCHAR', 		'constraint' => 40,		'null' => TRUE),
				'register_date'				=> array('type' => 'INT', 			'constraint' => 11),
				'register_ip'				=> array('type' => 'INT', 			'constraint' => 11),
				'country_code'				=> array('type' => 'CHAR', 			'constraint' => 2,		'null'	=> TRUE ),				
				'is_online'					=> array('type' => 'TINYINT',		'constraint' => 1,		'default' => 0), 	
				'is_online_hd' 				=> array('type' => 'TINYINT', 		'constraint' => 1,		'default' => 0),
				'is_online_type' 			=> array('type' => 'ENUM', 			'constraint' =>"'free','nude','private'",'null' => TRUE),
				'is_in_private' 			=> array('type' => 'TINYINT', 		'constraint' => 1,		'default' => 0),
				'enable_peek_mode' 			=> array('type' => 'TINYINT', 		'constraint' => 1,		'default' => 0),			
				'max_nude_watchers' 		=> array('type' => 'INT', 			'constraint' => 5,		'default' => 5),
				'is_imported' 				=> array('type' => 'TINYINT', 		'constraint' => 1,		'default' => 0),
				'is_imported_id'			=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE), 	
				'is_imported_category_id'	=> array('type' => 'INT', 			'constraint' => 11,		'null' => TRUE),
				'contract_status' 			=> array('type' => 'ENUM', 			'constraint' =>"'approved','pending','rejected'", 'default'=>"pending", 'default'=>'pending',  'null' => FALSE),
				'photo_id_status' 			=> array('type' => 'ENUM', 			'constraint' =>"'approved','pending','rejected'", 'default'=>"pending", 'default'=>'pending',  'null' => FALSE),
				'address' 					=> array('type' => 'VARCHAR', 		'constraint' => 80,		'null' => TRUE),
				'state' 					=> array('type' => 'VARCHAR', 		'constraint' => 40,		'null' => TRUE),
				'city' 						=> array('type' => 'VARCHAR', 		'constraint' => 40,		'null' => TRUE),
				'zip' 						=> array('type' => 'VARCHAR', 		'constraint' => 40,		'null' => TRUE),
				'phone' 					=> array('type' => 'VARCHAR', 		'constraint' => 15,		'null' => TRUE),
				'country' 					=> array('type' => 'VARCHAR', 		'constraint' => 4,		'null' => TRUE),
				'true_private_chips_price'	=> array('type' => 'DECIMAL',		'constraint' => '7,2',	'null' => TRUE),
				'private_chips_price' 		=> array('type' => 'DECIMAL',		'constraint' => '7,2',	'null' => TRUE),
				'nude_chips_price' 			=> array('type' => 'DECIMAL',		'constraint' => '7,2',	'null' => TRUE),
				'peek_chips_price' 			=> array('type' => 'DECIMAL',		'constraint' => '7,2',	'null' => TRUE),							
				'paid_photo_gallery_price'	=> array('type' => 'DECIMAL', 		'constraint' => '7,2',	'null' => TRUE),
				'website_percentage' 		=> array('type' => 'FLOAT', 		'constraint' => '7,2',	'null' => TRUE),
				'fms_id' 					=> array('type' => 'TINYINT', 		'constraint' => 1,		'null' => TRUE),
				'studio_id' 				=> array('type' => 'MEDIUMINT', 	'constraint' => 4,		'null' => TRUE),
				'register_step' 			=> array('type' => 'TINYINT', 		'constraint' => 3,		'default' => 0),
				'payment' 					=> array('type' => 'TINYINT', 		'constraint' => 3,		'default' => 0),
				'account' 					=> array('type' => 'VARCHAR', 		'constraint' => 800,	'null' => TRUE),
				'release' 					=> array('type' => 'DECIMAL', 		'constraint' => '7,2',	'default' => 0),
				'credits'					=> array('type' => 'DECIMAL', 		'constraint' => '8,2',	'default' => 0),
			));
			
			$this->dbforge->create_table('performers', TRUE);			
		}
						
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table performers categories...";
				
		//Performers categories table
		if ( ! $this->db->table_exists('performers_categories'))
		{	
			// Setup Keys
			$this->dbforge->add_key('performers_categories_id', TRUE);
			$this->dbforge->add_key('performer_id');
						
			$this->dbforge->add_field(array(
				'performers_categories_id' => array('type' => 'INT', 		'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),			
				'performer_id'		=> array('type' => 'INT',	'constraint' => 10,		'default' => 0),
				'category_id'		=> array('type' => 'INT',	'constraint' => 10,		'default' => 0),
			));
			
						
			$this->dbforge->create_table('performers_categories', TRUE);
	
		}
									
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table performers photos...";		
		
		//Performers Photos table
		if ( ! $this->db->table_exists('performers_photos'))
		{	
			// Setup Keys
			$this->dbforge->add_key('photo_id', TRUE);
			$this->dbforge->add_key('performer_id');
			
			
			$this->dbforge->add_field(array(
				'photo_id' 				=> array('type' => 'INT', 		'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'title' 				=> array('type' => 'VARCHAR',	'constraint' => 30,		'null' => TRUE),
				'name_on_disk' 			=> array('type' => 'VARCHAR', 	'constraint' => 255,	'null' => TRUE),
				'add_date' 				=> array('type' => 'INT',		'constraint' => 11, 	'null' => TRUE),
				'main_photo' 			=> array('type' => 'TINYINT',	'constraint' => 1, 		'default'=>0),
				'is_paid'				=> array('type'	=> 'TINYINT',	'constraint' => 1,		'default'=>0),
				'performer_id'			=> array('type' => 'INT', 		'constraint' => 11,		'unsigned' => TRUE,'null' => TRUE)
			));
			
			$this->dbforge->create_table('performers_photos', TRUE);
				
			$this->db->query('set foreign_key_checks = 0');
			$this->db->query('ALTER TABLE performers_photos ADD FOREIGN KEY(`performer_id`) REFERENCES performers(id) on delete cascade');
			$this->db->query('set foreign_key_checks = 1');
				
			
		}
		
		
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table performers videos...";
				
		//Performer videos table
		if ( ! $this->db->table_exists('performers_videos'))
		{	
			// Setup Keys
			$this->dbforge->add_key('video_id', TRUE);
			$this->dbforge->add_key('performer_id');
			
			
			$this->dbforge->add_field(array(
				'video_id' 				=> array('type' => 'INT', 		'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'description' 			=> array('type' => 'VARCHAR', 	'constraint' => 255,	'null' => TRUE),
				'flv_file_name' 		=> array('type' => 'VARCHAR', 	'constraint' => 255,	'null' => TRUE),
				'add_date' 				=> array('type' => 'INT',	 	'constraint' => 1, 		'null' => TRUE),
				'length'				=> array('type' => 'INT', 		'constraint' => 11,		'default' => 0),			
				'is_paid' 				=> array('type' => 'TINYINT',	'constraint' => 1,		'default' => 0),
				'price'					=> array('type' => 'INT', 		'constraint' => 11,		'null' => FALSE),
				'fms_id'				=> array('type' => 'TINYINT',	'constraint' => 11, 	'default' => 1),
				'performer_id' 			=> array('type' => 'INT', 		'constraint' => 11,		'unsigned' => TRUE,'null' => TRUE)
			));
			
			$this->dbforge->create_table('performers_videos', TRUE);		

			$this->db->query('set foreign_key_checks = 0');
			$this->db->query('ALTER TABLE performers_videos ADD FOREIGN KEY(`performer_id`) REFERENCES performers(id) on delete cascade');
			$this->db->query('set foreign_key_checks = 1');			
		}
		
		
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table performers profiles...";
				
		//Performer profiles table
		if ( ! $this->db->table_exists('performers_profile'))
		{	
			// Setup Keys
			$this->dbforge->add_key('performer_id', TRUE);
			
			
			$this->dbforge->add_field(array(
				'performer_id' 				=> array('type' => 'INT', 		'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'gender' 					=> array('type' => 'ENUM', 		'constraint' => "'male','female','transsexual'",	'null' => TRUE),
				'description' 				=> array('type' => 'MEDIUMTEXT','null' => TRUE),
				'what_turns_me_on' 			=> array('type' => 'MEDIUMTEXT','null' => TRUE),
				'what_turns_me_off'			=> array('type' => 'MEDIUMTEXT','null' => TRUE),			
				'sexual_prefference'		=> array('type' => 'ENUM', 		'constraint' => "'straight','gay','bisexual'",		'null' => TRUE),			
				'ethnicity' 				=> array('type' => 'ENUM',		'constraint' => "'asian','ebony','latin','white'", 	'null' => TRUE),
				'height' 					=> array('type' => 'ENUM',		'constraint' => "'over 195 cm','185-195 cm','174-184 cm','163-173 cm','152-162 cm','under 152 cm'",		'null' => TRUE),
				'weight' 					=> array('type' => 'ENUM',		'constraint' => "'over 73 kg','67-73 kg','60-66 kg','53-59 kg','46-52 kg','under 46 kg'",		'null' => TRUE),
				'hair_color'				=> array('type' => 'ENUM', 		'constraint' => "'auburn','black','blonde','blue','brown','clown hair','fire red','orange','pink','other'",		'null' => TRUE),
				'hair_length'				=> array('type' => 'ENUM', 		'constraint' => "'bald','crew cut','long','short','shoulder length'", 	'null' => TRUE),
				'eye_color'					=> array('type' => 'ENUM', 		'constraint' => "'black','blue','brown','green','grey','other'", 		'null' => TRUE),				
				'build'						=> array('type' => 'ENUM',		'constraint' => "'above average','athletic','average','large','muscular','obese','petite'",		'null' => TRUE), 	
				'birthday' 					=> array('type' => 'INT', 		'constraint' => 11,		'null' => TRUE),
			));
			
			$this->dbforge->create_table('performers_profile', TRUE);

			$this->db->query('set foreign_key_checks = 0');
			$this->db->query('ALTER TABLE performers_profile ADD FOREIGN KEY(`performer_id`) REFERENCES performers(id) on update cascade on delete cascade');
			$this->db->query('set foreign_key_checks = 1');			
		}
		

		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table performers languages...";
				
		//Language table
		if ( ! $this->db->table_exists('performers_languages'))
		{	
			// Setup Keys
			$this->dbforge->add_key('language_id', TRUE);
			$this->dbforge->add_key('performer_id');
			
			
			$this->dbforge->add_field(array(
				'language_id' 		=> array('type' => 'INT', 		'constraint' => 7,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'language_code'		=> array('type' => 'CHAR',		'constraint' => 3,		'null'=>FALSE),
				'performer_id' 		=> array('type' => 'INT', 		'constraint' => 11,		'null'=>FALSE),
			));			
			
			$this->dbforge->create_table('performers_languages', TRUE);	
		}		
		
		
		
		// -----------------------------------------------------------------------------------------
		$this->migrations->verbose AND print "Creating table performers favorites...";
			
		//Performers favorites table
		if ( ! $this->db->table_exists('performers_favorites'))
		{	
			// Setup Keys
			$this->dbforge->add_key('favorite_id', TRUE);
			$this->dbforge->add_key('user_id');
			$this->dbforge->add_key('performer_id');
								
			$this->dbforge->add_field(array(
				'favorite_id'		=> array('type' => 'INT',	'constraint' => 11,		'unsigned' => TRUE, 'auto_increment' => TRUE),
				'performer_id'		=> array('type' => 'INT',	'constraint' => 11,		'default' => 0),
				'user_id'			=> array('type' => 'INT',	'constraint' => 11,		'default' => 0),
				'add_date'			=> array('type' => 'INT ',	'constraint' => 11,		'null' => TRUE),
			));
			
			$this->dbforge->create_table('performers_favorites', TRUE);
		}		

	}
	
	function down(){
		$this->dbforge->drop_table('categories');
		$this->dbforge->drop_table('performers');
		$this->dbforge->drop_table('performers_profile');
		$this->dbforge->drop_table('performers_categories');
		$this->dbforge->drop_table('performers_photos');
		$this->dbforge->drop_table('performers_videos');
		$this->dbforge->drop_table('performers_profile');		
		$this->dbforge->drop_table('performers_languages');		
		$this->dbforge->drop_table('performers_favorites');
	}
}
