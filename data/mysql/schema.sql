-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.1.63-0+squeeze1 - (Debian)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2012-10-02 03:53:03
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table east_wolf_com_thenaughtyandthenice.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(64) NOT NULL,
  `password` char(64) NOT NULL,
  `hash` char(64) NOT NULL,
  `status` enum('approved','rejected') DEFAULT 'approved',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.ad_traffic
CREATE TABLE IF NOT EXISTS `ad_traffic` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) DEFAULT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `action` enum('hit','view','transaction','register') DEFAULT NULL,
  `earnings` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.ad_zones
CREATE TABLE IF NOT EXISTS `ad_zones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `add_date` int(11) DEFAULT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `bg_color` varchar(7) DEFAULT NULL,
  `border_color` varchar(7) DEFAULT NULL,
  `text_color` varchar(7) DEFAULT NULL,
  `performers_status` varchar(50) DEFAULT NULL,
  `category_link` varchar(100) DEFAULT NULL,
  `link_location` int(2) DEFAULT NULL,
  `views` int(16) DEFAULT '0',
  `hits` int(16) DEFAULT '0',
  `registers` int(16) DEFAULT '0',
  `earnings` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.affiliates
CREATE TABLE IF NOT EXISTS `affiliates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(25) DEFAULT NULL,
  `password` char(64) DEFAULT NULL,
  `email` char(64) DEFAULT NULL,
  `credits` decimal(7,2) DEFAULT '0.00',
  `first_name` varchar(30) DEFAULT '',
  `last_name` varchar(30) DEFAULT '',
  `register_date` int(11) DEFAULT NULL,
  `register_ip` int(11) DEFAULT NULL,
  `register_country_code` char(2) DEFAULT NULL,
  `payment` int(11) DEFAULT NULL,
  `account` text,
  `release` decimal(7,2) DEFAULT '0.00',
  `country_code` char(2) DEFAULT '',
  `address` varchar(80) DEFAULT '',
  `state` varchar(32) DEFAULT '',
  `city` varchar(32) DEFAULT '',
  `zip` varchar(32) DEFAULT '',
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `phone` varchar(32) DEFAULT '',
  `percentage` tinyint(1) DEFAULT NULL,
  `token` char(64) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `site_url` varchar(255) DEFAULT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `comision_type` enum('initial','transaction') DEFAULT 'initial',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.banned_countries
CREATE TABLE IF NOT EXISTS `banned_countries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `performer_id` int(11) DEFAULT '0',
  `country_code` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `performer_id` (`performer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.banned_states
CREATE TABLE IF NOT EXISTS `banned_states` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `performer_id` int(11) DEFAULT '0',
  `state_code` enum('AL','AK','AZ','AR','CA','CO','CT','DE','DC','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `performer_id` (`performer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) DEFAULT NULL,
  `name` varchar(40) NOT NULL,
  `link` varchar(40) NOT NULL,
  `performers_online` tinyint(1) DEFAULT '0',
  `performers_total` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.champagne_rooms
CREATE TABLE IF NOT EXISTS `champagne_rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `performer_id` int(10) unsigned NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_private` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type` enum('girl','girl/girl','girl/boy') COLLATE utf8_unicode_ci NOT NULL,
  `ticket_price` float unsigned NOT NULL DEFAULT '0',
  `min_tickets` int(10) unsigned NOT NULL DEFAULT '0',
  `max_tickets` int(10) unsigned DEFAULT NULL,
  `join_in_session` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `start_time` int(10) unsigned NOT NULL COMMENT 'datetime to timestamp',
  `duration` int(10) unsigned NOT NULL COMMENT 'seconds',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'available/unavailable',
  PRIMARY KEY (`id`),
  KEY `FK_champagne_room_performers` (`performer_id`),
  CONSTRAINT `FK_champagne_room_performers` FOREIGN KEY (`performer_id`) REFERENCES `performers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.champagne_rooms_users
CREATE TABLE IF NOT EXISTS `champagne_rooms_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `champagne_room_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__champagne_room` (`champagne_room_id`),
  KEY `FK__users` (`user_id`),
  CONSTRAINT `FK__champagne_room` FOREIGN KEY (`champagne_room_id`) REFERENCES `champagne_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK__users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.chat_logs
CREATE TABLE IF NOT EXISTS `chat_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `performer_id` int(11) unsigned NOT NULL,
  `add_date` int(11) unsigned NOT NULL,
  `log` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.contracts
CREATE TABLE IF NOT EXISTS `contracts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `name_on_disk` varchar(255) DEFAULT NULL,
  `status` enum('approved','pending','rejected') DEFAULT 'pending',
  `performer_id` int(11) DEFAULT NULL,
  `studio_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `performer_id` (`performer_id`),
  KEY `studio_id` (`studio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.countries
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.credits
CREATE TABLE IF NOT EXISTS `credits` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `amount_paid` decimal(7,2) NOT NULL,
  `currency_paid` char(30) NOT NULL,
  `amount_received` decimal(7,2) NOT NULL,
  `currency_received` enum('CHIPS') NOT NULL,
  `date` int(11) NOT NULL,
  `type` enum('credit','bonus','chargeback','void') DEFAULT NULL,
  `invoice_id` int(11) DEFAULT '0',
  `refunded` int(11) DEFAULT NULL,
  `status` enum('approved','pending','rejected') DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.credits_detail
CREATE TABLE IF NOT EXISTS `credits_detail` (
  `credit_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `log_table` enum('test_gateway_processor') DEFAULT NULL,
  `log_id` int(11) DEFAULT NULL,
  `special` tinyint(1) DEFAULT NULL,
  `extra_field` char(11) DEFAULT NULL,
  PRIMARY KEY (`credit_id`),
  CONSTRAINT `credits_detail_ibfk_1` FOREIGN KEY (`credit_id`) REFERENCES `credits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.failure_logins
CREATE TABLE IF NOT EXISTS `failure_logins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` int(11) NOT NULL,
  `failed_logins` mediumint(4) NOT NULL,
  `last_failure` int(11) NOT NULL,
  `username` char(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.fms
CREATE TABLE IF NOT EXISTS `fms` (
  `fms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `max_hosted_performers` int(10) DEFAULT '0',
  `current_hosted_performers` int(10) DEFAULT '0',
  `status` enum('active','inactive') DEFAULT NULL,
  `fms` varchar(255) DEFAULT NULL,
  `fms_for_video` varchar(255) DEFAULT NULL,
  `fms_for_preview` varchar(255) DEFAULT NULL,
  `fms_for_delete` varchar(255) DEFAULT NULL,
  `fms_test` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.logins
CREATE TABLE IF NOT EXISTS `logins` (
  `user_id` int(11) unsigned DEFAULT NULL,
  `ip` int(11) NOT NULL,
  `count` mediumint(5) NOT NULL,
  `first_login` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `readed_by_recipient` tinyint(1) unsigned DEFAULT '0',
  `trashed_by_recipient` tinyint(1) unsigned DEFAULT '0',
  `deleted_by_recipient` tinyint(1) unsigned DEFAULT '0',
  `deleted_by_sender` tinyint(1) unsigned DEFAULT '0',
  `date` int(11) unsigned DEFAULT '0',
  `from_type` enum('user','performer','studio','admin') DEFAULT NULL,
  `from_id` int(11) unsigned NOT NULL,
  `to_type` enum('user','performer','studio','admin','affiliate') DEFAULT NULL,
  `to_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `from_id` (`from_id`),
  KEY `to_id` (`to_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.newsletter_cron
CREATE TABLE IF NOT EXISTS `newsletter_cron` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recipient_email` varchar(255) NOT NULL,
  `email_subject` varchar(255) NOT NULL,
  `email_body` text NOT NULL,
  `add_date` bigint(20) NOT NULL,
  `sent` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `paid_date` int(11) unsigned NOT NULL,
  `from_date` int(11) unsigned NOT NULL,
  `to_date` int(11) unsigned NOT NULL,
  `amount_chips` decimal(9,2) NOT NULL,
  `status` enum('paid','pending','rejected','invalid') NOT NULL,
  `comments` text,
  `payment_fields_data` text,
  `payment_name` varchar(255) NOT NULL,
  `studio_id` int(11) DEFAULT NULL,
  `performer_id` int(11) DEFAULT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `performer_id` (`performer_id`),
  KEY `studio_id` (`studio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.payment_methods
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `minim_amount` mediumint(5) DEFAULT '0',
  `fields` text,
  `status` enum('approved','rejected') DEFAULT 'rejected',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.performers
CREATE TABLE IF NOT EXISTS `performers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(25) NOT NULL,
  `password` char(64) NOT NULL,
  `hash` char(64) NOT NULL,
  `email` char(64) NOT NULL,
  `nickname` char(25) NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `status` enum('approved','pending','rejected') NOT NULL DEFAULT 'pending',
  `avatar` varchar(40) DEFAULT NULL,
  `register_date` int(11) DEFAULT NULL,
  `register_ip` int(11) DEFAULT NULL,
  `country_code` char(2) DEFAULT NULL,
  `is_online` tinyint(1) DEFAULT '0',
  `is_online_hd` tinyint(1) DEFAULT '0',
  `is_online_type` enum('free','nude','private') DEFAULT NULL,
  `is_in_private` tinyint(1) DEFAULT '0',
  `enable_peek_mode` tinyint(1) DEFAULT '0',
  `max_nude_watchers` int(5) DEFAULT '5',
  `is_imported` tinyint(1) DEFAULT '0',
  `is_imported_id` int(11) DEFAULT NULL,
  `is_imported_category_id` int(11) DEFAULT NULL,
  `contract_status` enum('approved','pending','rejected') NOT NULL DEFAULT 'pending',
  `photo_id_status` enum('approved','pending','rejected') NOT NULL DEFAULT 'pending',
  `address` varchar(80) DEFAULT NULL,
  `state` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `zip` varchar(40) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `country` varchar(4) DEFAULT NULL,
  `true_private_chips_price` decimal(7,2) DEFAULT NULL,
  `private_chips_price` decimal(7,2) DEFAULT NULL,
  `nude_chips_price` decimal(7,2) DEFAULT NULL,
  `peek_chips_price` decimal(7,2) DEFAULT NULL,
  `paid_photo_gallery_price` decimal(7,2) DEFAULT NULL,
  `website_percentage` float(7,2) DEFAULT NULL,
  `fms_id` tinyint(1) DEFAULT NULL,
  `studio_id` mediumint(4) DEFAULT NULL,
  `register_step` tinyint(3) DEFAULT '0',
  `payment` tinyint(3) DEFAULT '0',
  `account` varchar(800) DEFAULT NULL,
  `release` decimal(7,2) DEFAULT '0.00',
  `credits` decimal(8,2) DEFAULT '0.00',
  `status_message` varchar(255) DEFAULT NULL,
  `is_in_pause` tinyint(1) unsigned DEFAULT NULL,
  `pause_time` int(10) unsigned DEFAULT NULL,
  `pause_timestamp` int(10) unsigned DEFAULT NULL,
  `pause_message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nickname` (`nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.performers_categories
CREATE TABLE IF NOT EXISTS `performers_categories` (
  `performers_categories_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `performer_id` int(10) DEFAULT '0',
  `category_id` int(10) DEFAULT '0',
  PRIMARY KEY (`performers_categories_id`),
  KEY `performer_id` (`performer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.performers_favorites
CREATE TABLE IF NOT EXISTS `performers_favorites` (
  `favorite_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `performer_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `add_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`favorite_id`),
  KEY `user_id` (`user_id`),
  KEY `performer_id` (`performer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.performers_languages
CREATE TABLE IF NOT EXISTS `performers_languages` (
  `language_id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `language_code` char(3) NOT NULL,
  `performer_id` int(11) NOT NULL,
  PRIMARY KEY (`language_id`),
  KEY `performer_id` (`performer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.performers_photos
CREATE TABLE IF NOT EXISTS `performers_photos` (
  `photo_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `name_on_disk` varchar(255) DEFAULT NULL,
  `add_date` int(11) DEFAULT NULL,
  `main_photo` tinyint(1) DEFAULT '0',
  `is_paid` tinyint(1) DEFAULT '0',
  `performer_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`photo_id`),
  KEY `performer_id` (`performer_id`),
  CONSTRAINT `performers_photos_ibfk_1` FOREIGN KEY (`performer_id`) REFERENCES `performers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.performers_photo_id
CREATE TABLE IF NOT EXISTS `performers_photo_id` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) DEFAULT NULL,
  `name_on_disk` varchar(255) DEFAULT NULL,
  `status` enum('approved','pending','rejected') DEFAULT 'pending',
  `performer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `performer_id` (`performer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.performers_ping
CREATE TABLE IF NOT EXISTS `performers_ping` (
  `performer_id` int(11) unsigned NOT NULL DEFAULT '0',
  `last_ping` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`performer_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.performers_profile
CREATE TABLE IF NOT EXISTS `performers_profile` (
  `performer_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gender` enum('male','female','transsexual') DEFAULT NULL,
  `description` mediumtext,
  `what_turns_me_on` mediumtext,
  `what_turns_me_off` mediumtext,
  `sexual_prefference` enum('straight','gay','bisexual') DEFAULT NULL,
  `ethnicity` enum('asian','ebony','latin','white') DEFAULT NULL,
  `height` enum('over 195 cm','185-195 cm','174-184 cm','163-173 cm','152-162 cm','under 152 cm') DEFAULT NULL,
  `weight` enum('over 73 kg','67-73 kg','60-66 kg','53-59 kg','46-52 kg','under 46 kg') DEFAULT NULL,
  `hair_color` enum('auburn','black','blonde','blue','brown','clown hair','fire red','orange','pink','other') DEFAULT NULL,
  `hair_length` enum('bald','crew cut','long','short','shoulder length') DEFAULT NULL,
  `eye_color` enum('black','blue','brown','green','grey','other') DEFAULT NULL,
  `build` enum('above average','athletic','average','large','muscular','obese','petite') DEFAULT NULL,
  `birthday` int(11) DEFAULT NULL,
  `cup_size` enum('A','B','C','D','E','F') DEFAULT NULL,
  `performer_status` tinytext,
  PRIMARY KEY (`performer_id`),
  CONSTRAINT `performers_profile_ibfk_1` FOREIGN KEY (`performer_id`) REFERENCES `performers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.performers_ratings
CREATE TABLE IF NOT EXISTS `performers_ratings` (
  `performer_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `rating` double NOT NULL,
  KEY `performer_id` (`performer_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.performers_reviews
CREATE TABLE IF NOT EXISTS `performers_reviews` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `performer_id` int(11) unsigned NOT NULL,
  `add_date` int(11) unsigned NOT NULL,
  `unique_id` char(64) NOT NULL,
  `message` varchar(255) NOT NULL,
  `rating` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.performers_schedules
CREATE TABLE IF NOT EXISTS `performers_schedules` (
  `performer_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `day_of_week` tinyint(10) NOT NULL,
  `hour` tinyint(10) NOT NULL,
  KEY `performer_id` (`performer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.performers_videos
CREATE TABLE IF NOT EXISTS `performers_videos` (
  `video_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `flv_file_name` varchar(255) DEFAULT NULL,
  `add_date` int(1) DEFAULT NULL,
  `length` int(11) DEFAULT '0',
  `is_paid` tinyint(1) DEFAULT '0',
  `price` int(11) NOT NULL,
  `fms_id` tinyint(11) DEFAULT '1',
  `performer_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`video_id`),
  KEY `performer_id` (`performer_id`),
  CONSTRAINT `performers_videos_ibfk_1` FOREIGN KEY (`performer_id`) REFERENCES `performers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.relations
CREATE TABLE IF NOT EXISTS `relations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_id` int(11) unsigned NOT NULL,
  `from_type` enum('user','performer') NOT NULL,
  `to_id` int(11) unsigned NOT NULL,
  `to_type` enum('user','performer') NOT NULL,
  `status` enum('pending','accepted','ban','banned') NOT NULL DEFAULT 'pending' COMMENT 'ban : user_id bans rel_user_id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`from_id`,`from_type`,`to_id`,`to_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.schema_version
CREATE TABLE IF NOT EXISTS `schema_version` (
  `version` int(3) DEFAULT NULL,
  `sub_version` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.songs
CREATE TABLE IF NOT EXISTS `songs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `src` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.studios
CREATE TABLE IF NOT EXISTS `studios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(25) NOT NULL,
  `password` char(64) NOT NULL,
  `hash` char(64) NOT NULL,
  `email` char(64) NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `status` enum('approved','pending','rejected') NOT NULL DEFAULT 'pending',
  `register_date` int(11) DEFAULT NULL,
  `register_ip` int(11) DEFAULT NULL,
  `contract_status` enum('approved','pending','rejected') NOT NULL DEFAULT 'pending',
  `country_code` char(2) DEFAULT NULL,
  `address` varchar(80) DEFAULT NULL,
  `state` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `zip` varchar(40) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `payment` tinyint(3) DEFAULT '0',
  `account` varchar(800) DEFAULT NULL,
  `release` decimal(7,2) DEFAULT '0.00',
  `credits` decimal(7,2) DEFAULT '0.00',
  `percentage` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.supported_languages
CREATE TABLE IF NOT EXISTS `supported_languages` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(2) NOT NULL,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.system_logs
CREATE TABLE IF NOT EXISTS `system_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) DEFAULT NULL,
  `actor` enum('user','performer','studio','admin','affiliate','cron','fms') DEFAULT NULL,
  `actor_id` int(11) DEFAULT NULL,
  `action_on` enum('user','performer','studio','affiliate','admin','other') DEFAULT NULL,
  `action_on_id` int(11) DEFAULT NULL,
  `action` enum('add_photo','delete_photo','edit_photo','add_video','delete_video','edit_video','buy_video','edit_account','edit_profile','delete_account','add_credits','remove_credits','performers_photo_id_status','contracts_status','add_admin','delete_admin','edit_admin','add_category','edit_category','delete_category','register','reset_password','change_password','add_payment_method','edit_payment_method','delete_payment_method','set_payment_method','edit_payment_details','logout','login','start_chat','end_chat','tip','edit_settings','delete_supported_language','generate_payment','ban','newsletter') DEFAULT NULL,
  `ip` int(11) DEFAULT NULL,
  `key` int(11) DEFAULT NULL,
  `action_comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.test_gateway_processor
CREATE TABLE IF NOT EXISTS `test_gateway_processor` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `amount` decimal(6,2) NOT NULL,
  `currency` char(3) NOT NULL,
  `ip` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(25) NOT NULL,
  `password` char(64) NOT NULL,
  `hash` char(64) NOT NULL,
  `email` char(64) NOT NULL,
  `status` enum('approved','pending','rejected') NOT NULL,
  `gateway` enum('test_gateway') DEFAULT NULL,
  `credits` decimal(7,2) DEFAULT '0.00',
  `is_chat_online` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.users_detail
CREATE TABLE IF NOT EXISTS `users_detail` (
  `user_id` int(11) unsigned DEFAULT NULL,
  `register_ip` int(11) NOT NULL,
  `register_date` int(11) NOT NULL,
  `cancel_date` int(11) DEFAULT NULL,
  `country_code` char(2) NOT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT '1',
  `affiliate_id` int(11) DEFAULT NULL,
  `affiliate_ad_id` int(11) DEFAULT NULL,
  KEY `user_id` (`user_id`),
  CONSTRAINT `users_detail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.watchers
CREATE TABLE IF NOT EXISTS `watchers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('private','true_private','peek','nude','free','premium_video','photos','gift','admin_action','spy') DEFAULT 'free',
  `start_date` int(11) DEFAULT NULL,
  `end_date` int(11) NOT NULL,
  `duration` int(6) NOT NULL,
  `show_is_over` tinyint(1) DEFAULT '0',
  `ip` int(11) unsigned DEFAULT NULL,
  `fee_per_minute` decimal(8,2) DEFAULT NULL,
  `user_paid_chips` decimal(8,2) DEFAULT '0.00',
  `site_chips` decimal(8,2) DEFAULT '0.00',
  `studio_chips` decimal(8,2) DEFAULT '0.00',
  `performer_chips` decimal(8,2) DEFAULT '0.00',
  `unique_id` char(64) NOT NULL,
  `was_banned` tinyint(1) DEFAULT NULL,
  `ban_date` int(11) DEFAULT NULL,
  `ban_expire_date` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` char(25) DEFAULT NULL,
  `studio_id` int(11) DEFAULT NULL,
  `performer_id` int(11) DEFAULT NULL,
  `is_imported` tinyint(1) DEFAULT '0',
  `performer_video_id` int(11) DEFAULT NULL,
  `paid` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `unique_id` (`unique_id`),
  KEY `user_id` (`user_id`),
  KEY `performer_id` (`performer_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table east_wolf_com_thenaughtyandthenice.watchers_old
CREATE TABLE IF NOT EXISTS `watchers_old` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('private','true_private','peek','nude','free','premium_video','photos','gift','admin_action','spy') DEFAULT 'free',
  `start_date` int(11) DEFAULT NULL,
  `end_date` int(11) NOT NULL,
  `duration` int(6) NOT NULL,
  `show_is_over` tinyint(1) DEFAULT '0',
  `ip` int(11) unsigned DEFAULT NULL,
  `fee_per_minute` decimal(8,2) DEFAULT NULL,
  `user_paid_chips` decimal(8,2) DEFAULT '0.00',
  `site_chips` decimal(8,2) DEFAULT '0.00',
  `studio_chips` decimal(8,2) DEFAULT '0.00',
  `performer_chips` decimal(8,2) DEFAULT '0.00',
  `unique_id` char(64) NOT NULL,
  `was_banned` tinyint(1) DEFAULT NULL,
  `ban_date` int(11) DEFAULT NULL,
  `ban_expire_date` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` char(25) DEFAULT NULL,
  `studio_id` int(11) DEFAULT NULL,
  `performer_id` int(11) DEFAULT NULL,
  `is_imported` tinyint(1) DEFAULT '0',
  `performer_video_id` int(11) DEFAULT NULL,
  `paid` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `unique_id` (`unique_id`),
  KEY `user_id` (`user_id`),
  KEY `performer_id` (`performer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
