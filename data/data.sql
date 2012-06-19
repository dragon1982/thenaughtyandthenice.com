# --------------------------------------------------------
# Host:                         debian
# Server version:               5.5.18-1~dotdeb.1
# Server OS:                    debian-linux-gnu
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2012-06-19 22:12:45
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
# Dumping data for table east_wolf_com_thenaughtyandthenice.admins: ~1 rows (approximately)
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`id`, `username`, `password`, `hash`, `status`) VALUES
	(1, 'admin', 'aa44fa09098a7b2ef951a46f6d17009d6dba7f9a814aa92ed1ea461500cc6b77', '0877b6d4e433d6e59f537b2c8bd4da1a7f571120', 'approved');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.ad_traffic: ~0 rows (approximately)
/*!40000 ALTER TABLE `ad_traffic` DISABLE KEYS */;
/*!40000 ALTER TABLE `ad_traffic` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.ad_zones: ~0 rows (approximately)
/*!40000 ALTER TABLE `ad_zones` DISABLE KEYS */;
/*!40000 ALTER TABLE `ad_zones` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.affiliates: ~0 rows (approximately)
/*!40000 ALTER TABLE `affiliates` DISABLE KEYS */;
/*!40000 ALTER TABLE `affiliates` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.banned_countries: ~0 rows (approximately)
/*!40000 ALTER TABLE `banned_countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `banned_countries` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.banned_states: ~0 rows (approximately)
/*!40000 ALTER TABLE `banned_states` DISABLE KEYS */;
/*!40000 ALTER TABLE `banned_states` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.categories: ~17 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `parent_id`, `name`, `link`, `performers_online`, `performers_total`) VALUES
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
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.chat_logs: ~0 rows (approximately)
/*!40000 ALTER TABLE `chat_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_logs` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.contracts: ~15 rows (approximately)
/*!40000 ALTER TABLE `contracts` DISABLE KEYS */;
INSERT INTO `contracts` (`id`, `date`, `name_on_disk`, `status`, `performer_id`, `studio_id`) VALUES
	(1, 1322686951, 'd8d7bf028cf8c900ec609ef5660bb986.pdf', 'approved', 1, NULL),
	(2, 1322687028, '296d26603cbe79802f4f02b99c860d5c.pdf', 'approved', 2, NULL),
	(3, 1322687101, '5eb6cfa87a45c00c2af89f50eda64a3d.pdf', 'approved', 3, NULL),
	(4, 1322687173, '461b8e1284beffd17d3fbe70943456c2.pdf', 'approved', 4, NULL),
	(5, 1322687265, 'e10e527f13e6bb14cb851ca4a6fdaf37.pdf', 'approved', 5, NULL),
	(6, 1322687341, 'a4c3ef776ed141b2ad9144e3fa384ddf.pdf', 'approved', 6, NULL),
	(7, 1322687400, '3d373e73ccced773557199bcc19bd488.pdf', 'approved', 7, NULL),
	(8, 1322687470, 'b0a767c260b10892265e2727a83419c9.pdf', 'approved', 8, NULL),
	(9, 1322687543, '24b784996df6a714e09e2a92e93f25c3.pdf', 'approved', 9, NULL),
	(10, 1322687640, '68dd5689e3bc80ea7f63f2ea69653fa5.pdf', 'approved', 10, NULL),
	(11, 1322688094, 'b0c4753a48fdeff29f7e30eac13987cd.pdf', 'approved', 11, NULL),
	(12, 1322688167, '6ac6aeec563e1440b4ea1bb53226070b.pdf', 'approved', 12, NULL),
	(13, 1322688243, '738735045a06ac6eddf2c22cad0c68d3.pdf', 'approved', 13, NULL),
	(14, 1322688309, 'c7d24282078ae26740d405b3fd6e93fa.pdf', 'approved', 14, NULL),
	(15, 1322688374, '7dd2e6926cce7cadbd404180c21cf6ee.pdf', 'approved', 15, NULL);
/*!40000 ALTER TABLE `contracts` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.countries: ~247 rows (approximately)
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` (`id`, `code`, `name`) VALUES
	(1, 'AF', 'Afghanistan'),
	(2, 'AX', 'Aland Islands'),
	(3, 'AL', 'Albania'),
	(4, 'DZ', 'Algeria'),
	(5, 'AS', 'American Samoa'),
	(6, 'AD', 'Andorra'),
	(7, 'AO', 'Angola'),
	(8, 'AI', 'Anguilla'),
	(9, 'AQ', 'Antarctica'),
	(10, 'AG', 'Antigua and Barbuda'),
	(11, 'AR', 'Argentina'),
	(12, 'AM', 'Armenia'),
	(13, 'AW', 'Aruba'),
	(14, 'AU', 'Australia'),
	(15, 'AT', 'Austria'),
	(16, 'AZ', 'Azerbaijan'),
	(17, 'BS', 'Bahamas'),
	(18, 'BH', 'Bahrain'),
	(19, 'BD', 'Bangladesh'),
	(20, 'BB', 'Barbados'),
	(21, 'BY', 'Belarus'),
	(22, 'BE', 'Belgium'),
	(23, 'BZ', 'Belize'),
	(24, 'BJ', 'Benin'),
	(25, 'BM', 'Bermuda'),
	(26, 'BT', 'Bhutan'),
	(27, 'BO', 'Bolivia'),
	(28, 'BA', 'Bosnia and Herzegovina'),
	(29, 'BW', 'Botswana'),
	(30, 'BV', 'Bouvet Island'),
	(31, 'BR', 'Brazil'),
	(32, 'IO', 'British Indian Ocean Territory'),
	(33, 'BN', 'Brunei Darussalam'),
	(34, 'BG', 'Bulgaria'),
	(35, 'BF', 'Burkina Faso'),
	(36, 'BI', 'Burundi'),
	(37, 'KH', 'Cambodia'),
	(38, 'CM', 'Cameroon'),
	(39, 'CA', 'Canada'),
	(40, 'CV', 'Cape Verde'),
	(41, 'KY', 'Cayman Islands'),
	(42, 'CF', 'Central African Republic'),
	(43, 'TD', 'Chad'),
	(44, 'CL', 'Chile'),
	(45, 'CN', 'China'),
	(46, 'CX', 'Christmas Island'),
	(47, 'CC', 'Cocos (Keeling) Islands'),
	(48, 'CO', 'Colombia'),
	(49, 'KM', 'Comoros'),
	(50, 'CG', 'Congo'),
	(51, 'CD', 'Congo, The Democratic Republic of the'),
	(52, 'CK', 'Cook Islands'),
	(53, 'CR', 'Costa Rica'),
	(54, 'CI', 'Cote D\'Ivoire'),
	(55, 'HR', 'Croatia'),
	(56, 'CU', 'Cuba'),
	(57, 'CY', 'Cyprus'),
	(58, 'CZ', 'Czech Republic'),
	(59, 'DK', 'Denmark'),
	(60, 'DJ', 'Djibouti'),
	(61, 'DM', 'Dominica'),
	(62, 'DO', 'Dominican Republic'),
	(63, 'EC', 'Ecuador'),
	(64, 'EG', 'Egypt'),
	(65, 'SV', 'El Salvador'),
	(66, 'GQ', 'Equatorial Guinea'),
	(67, 'ER', 'Eritrea'),
	(68, 'EE', 'Estonia'),
	(69, 'ET', 'Ethiopia'),
	(70, 'FK', 'Falkland Islands (Malvinas)'),
	(71, 'FO', 'Faroe Islands'),
	(72, 'FJ', 'Fiji'),
	(73, 'FI', 'Finland'),
	(74, 'FR', 'France'),
	(75, 'GF', 'French Guiana'),
	(76, 'PF', 'French Polynesia'),
	(77, 'TF', 'French Southern Territories'),
	(78, 'GA', 'Gabon'),
	(79, 'GM', 'Gambia'),
	(80, 'GE', 'Georgia'),
	(81, 'DE', 'Germany'),
	(82, 'GH', 'Ghana'),
	(83, 'GI', 'Gibraltar'),
	(84, 'GR', 'Greece'),
	(85, 'GL', 'Greenland'),
	(86, 'GD', 'Grenada'),
	(87, 'GP', 'Guadeloupe'),
	(88, 'GU', 'Guam'),
	(89, 'GT', 'Guatemala'),
	(90, 'GG', 'Guernsey'),
	(91, 'GN', 'Guinea'),
	(92, 'GW', 'Guinea-Bissau'),
	(93, 'GY', 'Guyana'),
	(94, 'HT', 'Haiti'),
	(95, 'HM', 'Heard Island and McDonald Islands'),
	(96, 'VA', 'Holy See (Vatican City State)'),
	(97, 'HN', 'Honduras'),
	(98, 'HK', 'Hong Kong'),
	(99, 'HU', 'Hungary'),
	(100, 'IS', 'Iceland'),
	(101, 'IN', 'India'),
	(102, 'ID', 'Indonesia'),
	(103, 'IR', 'Iran, Islamic Republic of'),
	(104, 'IQ', 'Iraq'),
	(105, 'IE', 'Ireland'),
	(106, 'IM', 'Isle of Man'),
	(107, 'IL', 'Israel'),
	(108, 'IT', 'Italy'),
	(109, 'JM', 'Jamaica'),
	(110, 'JP', 'Japan'),
	(111, 'JE', 'Jersey'),
	(112, 'JO', 'Jordan'),
	(113, 'KZ', 'Kazakstan'),
	(114, 'KE', 'Kenya'),
	(115, 'KI', 'Kiribati'),
	(116, 'KP', 'Korea, Democratic People\'s Republic of'),
	(117, 'KR', 'Korea, Republic of'),
	(118, 'KW', 'Kuwait'),
	(119, 'KG', 'Kyrgyzstan'),
	(120, 'LA', 'Lao People\'s Democratic Republic'),
	(121, 'LV', 'Latvia'),
	(122, 'LB', 'Lebanon'),
	(123, 'LS', 'Lesotho'),
	(124, 'LR', 'Liberia'),
	(125, 'LY', 'Libyan Arab Jamahiriya'),
	(126, 'LI', 'Liechtenstein'),
	(127, 'LT', 'Lithuania'),
	(128, 'LU', 'Luxembourg'),
	(129, 'MO', 'Macau'),
	(130, 'MK', 'Macedonia'),
	(131, 'MG', 'Madagascar'),
	(132, 'MW', 'Malawi'),
	(133, 'MY', 'Malaysia'),
	(134, 'MV', 'Maldives'),
	(135, 'ML', 'Mali'),
	(136, 'MT', 'Malta'),
	(137, 'MH', 'Marshall Islands'),
	(138, 'MQ', 'Martinique'),
	(139, 'MR', 'Mauritania'),
	(140, 'MU', 'Mauritius'),
	(141, 'YT', 'Mayotte'),
	(142, 'MX', 'Mexico'),
	(143, 'FM', 'Micronesia, Federated States of'),
	(144, 'MD', 'Moldova, Republic of'),
	(145, 'MC', 'Monaco'),
	(146, 'MN', 'Mongolia'),
	(147, 'ME', 'Montenegro'),
	(148, 'MS', 'Montserrat'),
	(149, 'MA', 'Morocco'),
	(150, 'MZ', 'Mozambique'),
	(151, 'MM', 'Myanmar'),
	(152, 'NA', 'Namibia'),
	(153, 'NR', 'Nauru'),
	(154, 'NP', 'Nepal'),
	(155, 'NL', 'Netherlands'),
	(156, 'AN', 'Netherlands Antilles'),
	(157, 'NC', 'New Caledonia'),
	(158, 'NZ', 'New Zealand'),
	(159, 'NI', 'Nicaragua'),
	(160, 'NE', 'Niger'),
	(161, 'NG', 'Nigeria'),
	(162, 'NU', 'Niue'),
	(163, 'NF', 'Norfolk Island'),
	(164, 'MP', 'Northern Mariana Islands'),
	(165, 'NO', 'Norway'),
	(166, 'OM', 'Oman'),
	(167, 'O1', 'Other'),
	(168, 'PK', 'Pakistan'),
	(169, 'PW', 'Palau'),
	(170, 'PS', 'Palestinian Territory'),
	(171, 'PA', 'Panama'),
	(172, 'PG', 'Papua New Guinea'),
	(173, 'PY', 'Paraguay'),
	(174, 'PE', 'Peru'),
	(175, 'PH', 'Philippines'),
	(176, 'PN', 'Pitcairn Islands'),
	(177, 'PL', 'Poland'),
	(178, 'PT', 'Portugal'),
	(179, 'PR', 'Puerto Rico'),
	(180, 'QA', 'Qatar'),
	(181, 'RE', 'Reunion'),
	(182, 'RO', 'Romania'),
	(183, 'RU', 'Russian Federation'),
	(184, 'RW', 'Rwanda'),
	(185, 'BL', 'Saint Barthelemy'),
	(186, 'SH', 'Saint Helena'),
	(187, 'KN', 'Saint Kitts and Nevis'),
	(188, 'LC', 'Saint Lucia'),
	(189, 'MF', 'Saint Martin'),
	(190, 'PM', 'Saint Pierre and Miquelon'),
	(191, 'VC', 'Saint Vincent and the Grenadines'),
	(192, 'WS', 'Samoa'),
	(193, 'SM', 'San Marino'),
	(194, 'ST', 'Sao Tome and Principe'),
	(195, 'SA', 'Saudi Arabia'),
	(196, 'SN', 'Senegal'),
	(197, 'RS', 'Serbia'),
	(198, 'SC', 'Seychelles'),
	(199, 'SL', 'Sierra Leone'),
	(200, 'SG', 'Singapore'),
	(201, 'SK', 'Slovakia'),
	(202, 'SI', 'Slovenia'),
	(203, 'SB', 'Solomon Islands'),
	(204, 'SO', 'Somalia'),
	(205, 'ZA', 'South Africa'),
	(206, 'GS', 'South Georgia and the South Sandwich Islands'),
	(207, 'ES', 'Spain'),
	(208, 'LK', 'Sri Lanka'),
	(209, 'SD', 'Sudan'),
	(210, 'SR', 'Suriname'),
	(211, 'SJ', 'Svalbard and Jan Mayen'),
	(212, 'SZ', 'Swaziland'),
	(213, 'SE', 'Sweden'),
	(214, 'CH', 'Switzerland'),
	(215, 'SY', 'Syrian Arab Republic'),
	(216, 'TW', 'Taiwan'),
	(217, 'TJ', 'Tajikistan'),
	(218, 'TZ', 'Tanzania, United Republic of'),
	(219, 'TH', 'Thailand'),
	(220, 'TL', 'Timor-Leste'),
	(221, 'TG', 'Togo'),
	(222, 'TK', 'Tokelau'),
	(223, 'TO', 'Tonga'),
	(224, 'TT', 'Trinidad and Tobago'),
	(225, 'TN', 'Tunisia'),
	(226, 'TR', 'Turkey'),
	(227, 'TM', 'Turkmenistan'),
	(228, 'TC', 'Turks and Caicos Islands'),
	(229, 'TV', 'Tuvalu'),
	(230, 'UG', 'Uganda'),
	(231, 'UA', 'Ukraine'),
	(232, 'AE', 'United Arab Emirates'),
	(233, 'GB', 'United Kingdom'),
	(234, 'US', 'United States'),
	(235, 'UM', 'United States Minor Outlying Islands'),
	(236, 'UY', 'Uruguay'),
	(237, 'UZ', 'Uzbekistan'),
	(238, 'VU', 'Vanuatu'),
	(239, 'VE', 'Venezuela'),
	(240, 'VN', 'Vietnam'),
	(241, 'VG', 'Virgin Islands, British'),
	(242, 'VI', 'Virgin Islands, U.S.'),
	(243, 'WF', 'Wallis and Futuna'),
	(244, 'EH', 'Western Sahara'),
	(245, 'YE', 'Yemen'),
	(246, 'ZM', 'Zambia'),
	(247, 'ZW', 'Zimbabwe');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.credits: ~0 rows (approximately)
/*!40000 ALTER TABLE `credits` DISABLE KEYS */;
/*!40000 ALTER TABLE `credits` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.credits_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `credits_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `credits_detail` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.failure_logins: ~2 rows (approximately)
/*!40000 ALTER TABLE `failure_logins` DISABLE KEYS */;
INSERT INTO `failure_logins` (`id`, `ip`, `failed_logins`, `last_failure`, `username`) VALUES
	(1, 2147483647, 1, 1338813970, 'sample1'),
	(2, 2147483647, 1, 1340012472, 'thibaut1');
/*!40000 ALTER TABLE `failure_logins` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.fms: ~1 rows (approximately)
/*!40000 ALTER TABLE `fms` DISABLE KEYS */;
INSERT INTO `fms` (`fms_id`, `name`, `max_hosted_performers`, `current_hosted_performers`, `status`, `fms`, `fms_for_video`, `fms_for_preview`, `fms_for_delete`, `fms_test`) VALUES
	(1, 'FMS', 999, 0, 'active', 'rtmp://fmsus.modenacam.com/thenaughtyandthenice_main/', 'rtmp://fmsus.modenacam.com/thenaughtyandthenice_main/', 'rtmp://fmsus.modenacam.com/thenaughtyandthenice_main/', 'rtmp://fmsus.modenacam.com/thenaughtyandthenice_main/', 'rtmp://fmsus.modenacam.com/thenaughtyandthenice_main/');
/*!40000 ALTER TABLE `fms` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.logins: ~27 rows (approximately)
/*!40000 ALTER TABLE `logins` DISABLE KEYS */;
INSERT INTO `logins` (`user_id`, `ip`, `count`, `first_login`, `last_login`) VALUES
	(2, 2147483647, 1, 1338654557, 1338654557),
	(2, 2147483647, 1, 1338658066, 1338658066),
	(2, 2147483647, 1, 1338658397, 1338658397),
	(2, 2147483647, 1, 1338756525, 1338756525),
	(2, 2147483647, 1, 1338814068, 1338814068),
	(2, 2147483647, 1, 1338814173, 1338814173),
	(3, 2147483647, 1, 1338814405, 1338814405),
	(2, 2147483647, 1, 1338814459, 1338814459),
	(1, 2147483647, 1, 1338817464, 1338817464),
	(3, 2147483647, 1, 1338817478, 1338817478),
	(2, 2147483647, 1, 1338817495, 1338817495),
	(1, 2147483647, 1, 1339962467, 1339962467),
	(2, 2147483647, 1, 1339966009, 1339966009),
	(1, 2147483647, 1, 1339978329, 1339978329),
	(1, 2147483647, 1, 1339978475, 1339978475),
	(1, 2147483647, 1, 1339978495, 1339978495),
	(2, 2147483647, 1, 1339984627, 1339984627),
	(1, 2147483647, 1, 1339984659, 1339984659),
	(1, 2147483647, 1, 1339985038, 1339985038),
	(1, 2147483647, 1, 1339996610, 1339996610),
	(1, 2147483647, 1, 1340000651, 1340000651),
	(1, 2147483647, 1, 1340007854, 1340007854),
	(1, 2147483647, 1, 1340011775, 1340011775),
	(1, 2147483647, 1, 1340012481, 1340012481),
	(1, 2147483647, 1, 1340088592, 1340088592),
	(1, 2147483647, 1, 1340088786, 1340088786),
	(1, 2147483647, 1, 1340109177, 1340109177),
	(1, 2147483647, 1, 1340116134, 1340116134),
	(1, 2147483647, 1, 1340126314, 1340126314),
	(1, 2147483647, 1, 1340127042, 1340127042),
	(1, 2147483647, 1, 1340127065, 1340127065),
	(2, 2147483647, 1, 1340127225, 1340127225),
	(1, 2147483647, 1, 1340127242, 1340127242),
	(3, 2147483647, 1, 1340127395, 1340127395),
	(1, 2147483647, 1, 1340127929, 1340127929),
	(2, 2147483647, 1, 1340127940, 1340127940),
	(1, 2147483647, 1, 1340128534, 1340128534);
/*!40000 ALTER TABLE `logins` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.messages: ~9 rows (approximately)
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`id`, `subject`, `body`, `readed_by_recipient`, `trashed_by_recipient`, `deleted_by_recipient`, `deleted_by_sender`, `date`, `from_type`, `from_id`, `to_type`, `to_id`) VALUES
	(1, 'test', 'test', 1, 1, 0, 0, 1339993511, 'user', 2, 'user', 1),
	(5, 'test1', 'test1', 1, 0, 0, 0, 1339993511, 'user', 2, 'user', 1),
	(6, 'test2', 'test2', 1, 0, 0, 0, 1339993511, 'user', 1, 'user', 2),
	(7, 'test3', 'test3', 1, 0, 0, 0, 1339993511, 'performer', 1, 'user', 1),
	(8, 'RE: test', 'dsadasd', 1, 0, 0, 1, 1339984532, 'user', 1, 'user', 2),
	(9, 'RE: RE: test', 'bfdbfdgdfg', 1, 0, 0, 0, 1339984647, 'user', 2, 'user', 1),
	(10, 'TEST', 'TEST', 0, 0, 0, 1, 1339984900, 'user', 1, 'user', 2),
	(11, 'testate', 'testare', 1, 0, 0, 0, 1340015637, 'performer', 2, 'performer', 1),
	(12, 'RE: testate', 'xczxc', 1, 0, 0, 0, 1340001288, 'performer', 1, 'performer', 2);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.newsletter_cron: ~0 rows (approximately)
/*!40000 ALTER TABLE `newsletter_cron` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_cron` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.payments: ~0 rows (approximately)
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.payment_methods: ~1 rows (approximately)
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` (`id`, `name`, `minim_amount`, `fields`, `status`) VALUES
	(1, 'Paypal', 100, 'a:2:{i:0;s:4:"Name";i:1;s:5:"Email";}', 'approved');
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.performers: ~15 rows (approximately)
/*!40000 ALTER TABLE `performers` DISABLE KEYS */;
INSERT INTO `performers` (`id`, `username`, `password`, `hash`, `email`, `nickname`, `first_name`, `last_name`, `status`, `avatar`, `register_date`, `register_ip`, `country_code`, `is_online`, `is_online_hd`, `is_online_type`, `is_in_private`, `enable_peek_mode`, `max_nude_watchers`, `is_imported`, `is_imported_id`, `is_imported_category_id`, `contract_status`, `photo_id_status`, `address`, `state`, `city`, `zip`, `phone`, `country`, `true_private_chips_price`, `private_chips_price`, `nude_chips_price`, `peek_chips_price`, `paid_photo_gallery_price`, `website_percentage`, `fms_id`, `studio_id`, `register_step`, `payment`, `account`, `release`, `credits`) VALUES
	(1, 'sample1', 'fdcbd4746c0a34bc630298628ae47fccadb00cdec9d093239a595e76131954bb', '97830f6b2faac2912dc1b02b77f2ad54167dade7', 'sample1@sample1.com', 'Sample1', 'sample1', 'sample1', 'approved', 'c2630d34abca3eed4ee9ed7a9a02df93.jpg', 1322686951, 1348550660, 'RO', 1, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample1', 'state', 'sample1', 'sample1', '23452345235', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, 1, NULL, 6, 1, '', 100.00, 0.00),
	(2, 'sample2', '2c69305cba42174f42c258f131c2941b9e1b235a80b80d761728452363fc0a9a', '132441114da06d3b2266d98270c131fe643b388f', 'sample2@sample2.com', 'Sample2', 'sample2', 'sample2', 'approved', '12493640474747cd13f69ce9f0bcd0cb.jpg', 1322687028, 1348550660, 'RO', 1, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample2', 'state', 'sample2', 'sample2', '23452345235', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, 1, NULL, 6, 1, '', 100.00, 0.00),
	(3, 'sample3', '77b735f7857c43ce64ffd0744e62281db6c8771f0dfd593a1dfb96b382eb63bf', '46fe6c7fa63fbeda0978e3607ef932ef6eecb7c2', 'sample3@sample3.com', 'Sample3', 'sample3', 'sample3', 'approved', 'e1b727cdac41a5530d0d53fab67b25d1.jpg', 1322687101, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample3', 'state', 'sample3', 'sample3', '234234234234', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00),
	(4, 'sample4', '5bd093141c470e6a0c461c1e5c95b7544719ce5770eb19aa495e53c70e6c8d79', '2c15b0a7256365a15d1ed462bbffac0ed197fce0', 'sample4@sample4.com', 'Sample4', 'sample4', 'sample4', 'approved', '156e28b61ed397d9ad7aed47cc82645b.jpg', 1322687173, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample4', 'state', 'sample4', 'sample4', '23452352345', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00),
	(5, 'sample5', '38a615c3edd59e03ad6db2e47363e206ef3baedea237879f7325c7cfa0dd5599', 'b0a97cef1edeada05be91dd3a3f438786b722881', 'sample5@sample5.com', 'Sample5', 'sample5', 'sample5', 'approved', 'd6532725580b78b8b858209a2453d7f7.jpg', 1322687265, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample5', 'state', 'sample5', 'sample5', '23452345235', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00),
	(6, 'sample6', '42efcd4b314dda666a4a4f5d16dd07af7d08f9e7cdede7f6699d16bee4312279', '5407e1f0616b63df9549063c82e4f1329be9b9c1', 'sample6@sample6.com', 'sample6', 'sample6', 'sample6', 'approved', '30102f51cd5d360a47222f26bc61125b.jpg', 1322687341, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample6', 'state', 'sample6', 'sample6', '234523452345234', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00),
	(7, 'sample7', '49e1fad472ece631e6c601648bb6396baf5210441fc86626a2f902021b1d263f', '0fae9d120f5f8eee6ea01883f6a3d946c7a6e534', 'sample7@sample7.com', 'Sample7', 'sample7', 'sample7', 'approved', 'ed7bd74c04e89d8a5eb5c8229e7dcf7d.jpg', 1322687400, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample7', 'state', 'sample7', 'sample7', '3454325435345', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00),
	(8, 'sample8', '1aa1b3ade9fd75e8b5508966cd2cc5866ae418f48d3950c811db9f0cde3e80de', '79dd189ed05774c098a3037a640cfd1a80975db8', 'sample8@sample8.com', 'Sample8', 'sample8', 'sample8', 'approved', 'e83c019a6247fc253cbcd1ffa8db165e.jpg', 1322687470, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample8', 'state', 'sample8', 'sample8', '45234523452345', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00),
	(9, 'sample9', '427d4d6b0f604d7e6ffce1a9228339ba74063c5214f33061e562d592a1ce5a6c', '4a323f03195f6be687c0d75bd5c4e05d61e2ea47', 'sample9@sample9.com', 'Sample9', 'sample9', 'sample9', 'approved', 'c21bac4e1ba81a20740dc7c92e984214.jpg', 1322687543, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample9', 'state', 'sample9', 'sample9', '234523452345234', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00),
	(10, 'sample10', '774233d044d288df09ccae77966ee825a870e21688219016cf2266b124536ef0', '87a69d834f8a5b944ea00de86beccbc93c7f5d2b', 'sample10@sample10.com', 'Sample10', 'sample10', 'sample10', 'approved', '34b0826c65ab00b27740878435b7f41c.jpg', 1322687640, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample10', 'state', 'sample10', 'sample10', '42542352345345', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00),
	(11, 'sample11', 'b06fe6770653a8774090e8ccd32b1ef9f2c9047d981ea9771faedd4cf5538cae', '16cd8410bc16a3b1d35436b6ff48528ee7fd76ed', 'sample11@sample11.com', 'Sample11', 'sample11', 'sample11', 'approved', 'e1535bc81c847be4b7215340c80b5812.jpg', 1322688094, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample11', 'state', 'sample11', 'sample11', '24352345234', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00),
	(12, 'sample12', '122e36ffdcfdf7f9c5463e1f93984c7143b5b0dcfdb8aef50fede4ade82c1569', 'fc47c87122885a1a2b9942a6e579fa44d0fc7953', 'sample12@sample12.com', 'Sample12', 'sample12', 'sample12', 'approved', 'e8f2f3b750cd31a8a638652b4b24d6ce.jpg', 1322688167, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample12', 'state', 'sample12', 'sample12', '24523452345', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00),
	(13, 'sample13', '864a1620d5becd91e94cf5506037ecd09b5d84f0e18a9d03ede7987504e02774', '7c5d50e6be411c531902c57ff6421c413268557a', 'sample13@sample13.com', 'Sample13', 'sample13', 'sample13', 'approved', 'cc7b9c0743b5d6c4542aa35b58f148a9.jpg', 1322688243, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample13', 'state', 'sample13', 'sample13', '234523452345', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00),
	(14, 'sample14', 'e81bdf02cfb35e03602642430fc6d7fd89584298940ae4d84f472a96b658cab1', 'dc05b7f5fcd32e04308fb1ec957ae72efe90ab9b', 'sample14@sample14.com', 'Sample14', 'sample14', 'sample14', 'approved', '55c97b0b09a7372d8b0dd09400bb1114.jpg', 1322688309, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample14', 'state', 'sample14', 'sample14', '214524352345', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00),
	(15, 'sample15', 'c9db8e9450677b3d6d513b53b7259753f7fc993659d605617e8c04628015d9cb', '1baa6445bd1fc87ebbc2a8f04589d8cb06ff44c7', 'sample15@sample15.com', 'Sample15', 'sample15', 'sample15', 'approved', '2aeea00ec18dc11d7038e457df2d404a.jpg', 1322688374, 1348550660, 'RO', 0, 0, NULL, 0, 0, 5, 0, NULL, NULL, 'approved', 'approved', 'sample15', 'state', 'sample15', 'sample15', '234523452345', 'AF', 100.00, 100.00, 100.00, 100.00, 100.00, 50.00, NULL, NULL, 6, 1, '', 100.00, 0.00);
/*!40000 ALTER TABLE `performers` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.performers_categories: ~45 rows (approximately)
/*!40000 ALTER TABLE `performers_categories` DISABLE KEYS */;
INSERT INTO `performers_categories` (`performers_categories_id`, `performer_id`, `category_id`) VALUES
	(1, 1, 1),
	(2, 1, 5),
	(3, 1, 7),
	(4, 2, 1),
	(5, 2, 5),
	(6, 2, 7),
	(7, 3, 1),
	(8, 3, 5),
	(9, 3, 7),
	(10, 4, 1),
	(11, 4, 5),
	(12, 4, 7),
	(13, 5, 1),
	(14, 5, 5),
	(15, 5, 7),
	(16, 6, 1),
	(17, 6, 5),
	(18, 6, 8),
	(19, 7, 1),
	(20, 7, 5),
	(21, 7, 7),
	(22, 8, 1),
	(23, 8, 5),
	(24, 8, 7),
	(25, 9, 1),
	(26, 9, 5),
	(27, 9, 7),
	(28, 10, 1),
	(29, 10, 5),
	(30, 10, 7),
	(31, 11, 1),
	(32, 11, 5),
	(33, 11, 7),
	(34, 12, 1),
	(35, 12, 5),
	(36, 12, 7),
	(37, 13, 1),
	(38, 13, 5),
	(39, 13, 7),
	(40, 14, 1),
	(41, 14, 5),
	(42, 14, 7),
	(43, 15, 1),
	(44, 15, 5),
	(45, 15, 7);
/*!40000 ALTER TABLE `performers_categories` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.performers_favorites: ~0 rows (approximately)
/*!40000 ALTER TABLE `performers_favorites` DISABLE KEYS */;
/*!40000 ALTER TABLE `performers_favorites` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.performers_languages: ~15 rows (approximately)
/*!40000 ALTER TABLE `performers_languages` DISABLE KEYS */;
INSERT INTO `performers_languages` (`language_id`, `language_code`, `performer_id`) VALUES
	(1, 'en', 1),
	(2, 'en', 2),
	(3, 'en', 3),
	(4, 'en', 4),
	(5, 'en', 5),
	(6, 'en', 6),
	(7, 'en', 7),
	(8, 'en', 8),
	(9, 'en', 9),
	(10, 'en', 10),
	(11, 'en', 11),
	(12, 'en', 12),
	(13, 'en', 13),
	(14, 'en', 14),
	(15, 'en', 15);
/*!40000 ALTER TABLE `performers_languages` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.performers_photos: ~90 rows (approximately)
/*!40000 ALTER TABLE `performers_photos` DISABLE KEYS */;
INSERT INTO `performers_photos` (`photo_id`, `title`, `name_on_disk`, `add_date`, `main_photo`, `is_paid`, `performer_id`) VALUES
	(1, 'Avatar', 'c2630d34abca3eed4ee9ed7a9a02df93.jpg', 1322687002, 1, 0, 1),
	(2, 'Avatar', '12493640474747cd13f69ce9f0bcd0cb.jpg', 1322687076, 1, 0, 2),
	(3, 'Avatar', 'e1b727cdac41a5530d0d53fab67b25d1.jpg', 1322687148, 1, 0, 3),
	(4, 'Avatar', '156e28b61ed397d9ad7aed47cc82645b.jpg', 1322687240, 1, 0, 4),
	(5, 'Avatar', 'd6532725580b78b8b858209a2453d7f7.jpg', 1322687312, 1, 0, 5),
	(6, 'Avatar', '30102f51cd5d360a47222f26bc61125b.jpg', 1322687380, 1, 0, 6),
	(7, 'Avatar', 'ed7bd74c04e89d8a5eb5c8229e7dcf7d.jpg', 1322687447, 1, 0, 7),
	(8, 'Avatar', 'e83c019a6247fc253cbcd1ffa8db165e.jpg', 1322687519, 1, 0, 8),
	(9, 'Avatar', 'c21bac4e1ba81a20740dc7c92e984214.jpg', 1322687591, 1, 0, 9),
	(10, 'Avatar', '34b0826c65ab00b27740878435b7f41c.jpg', 1322687684, 1, 0, 10),
	(11, 'Avatar', 'e1535bc81c847be4b7215340c80b5812.jpg', 1322688136, 1, 0, 11),
	(12, 'Avatar', 'e8f2f3b750cd31a8a638652b4b24d6ce.jpg', 1322688224, 1, 0, 12),
	(13, 'Avatar', 'cc7b9c0743b5d6c4542aa35b58f148a9.jpg', 1322688280, 1, 0, 13),
	(14, 'Avatar', '55c97b0b09a7372d8b0dd09400bb1114.jpg', 1322688354, 1, 0, 14),
	(15, 'Avatar', '2aeea00ec18dc11d7038e457df2d404a.jpg', 1322688435, 1, 0, 15),
	(16, '', '63adf28f31d52edf36348a2bd15e562e.jpg', 1322688612, 0, 0, 1),
	(17, '', '30935b01714b559d7c44e1577d8387b0.jpg', 1322688618, 0, 0, 1),
	(18, '', '084b20cdc369c8f9f3c24da5a2f8c922.jpg', 1322688623, 0, 0, 1),
	(19, '', 'd6c42b78601903abeb271204e8a8a203.jpg', 1322688638, 0, 0, 1),
	(20, '', 'c8d985836af28585ed73e0ec384e2868.jpg', 1322688647, 0, 0, 1),
	(21, '', '08f897fce7b6a08bc40ef967a382c5ee.jpg', 1322688682, 0, 0, 2),
	(22, '', 'ff6ca7e244737cdc53ea4475f2b34341.jpg', 1322688688, 0, 0, 2),
	(23, '', '972f83c1d1d1d3938a35cea01bdfdaa5.jpg', 1322688700, 0, 0, 2),
	(24, '', '6c46ff04f29922050717525de412f620.jpg', 1322688709, 0, 0, 2),
	(25, '', 'eafe66f41871b91de78463d8d606c4c0.jpg', 1322688715, 0, 0, 2),
	(26, '', '2507b726fa560698b2b8932745cfd12e.jpg', 1322688732, 0, 0, 3),
	(27, '', '17afbd41d81d55dc103e58e4de0f709a.jpg', 1322688740, 0, 0, 3),
	(28, '', 'e97b8495cdf110528506fd8db50b2e6c.jpg', 1322688745, 0, 0, 3),
	(29, '', '08cbf8c896266152bc4d3c172f0fb5dd.jpg', 1322688751, 0, 0, 3),
	(30, '', '3788ecb70a012b60a5f72748272135d2.jpg', 1322688756, 0, 0, 3),
	(31, '', '23e89f37ee05b26b03b321d00c1d1418.jpg', 1322688771, 0, 0, 4),
	(32, '', 'e9ae7b93e0c6dd68ad20ded615d8eb8a.jpg', 1322688776, 0, 0, 4),
	(33, '', '80a48eca560335a0170a77688188f7e6.jpg', 1322688782, 0, 0, 4),
	(34, '', '59f463adc683ce30fcb0e891c781b01b.jpg', 1322688787, 0, 0, 4),
	(35, '', '12d32257e010b5b745fe7e557f556d2e.jpg', 1322688792, 0, 0, 4),
	(36, '', 'cefa95c027695be40cc07231a2b7dd00.jpg', 1322688807, 0, 0, 5),
	(37, '', '4d63b8e298a6cc24b019005731dfa494.jpg', 1322688811, 0, 0, 5),
	(38, '', '5a6368eba15974701281b66c4d8f0898.jpg', 1322688816, 0, 0, 5),
	(39, '', '89aea296f2a6689f296d5eec9f366d73.jpg', 1322688823, 0, 0, 5),
	(40, '', '910dff53aca1ff8f98c6c4dd5beca5d4.jpg', 1322688831, 0, 0, 5),
	(41, '', '7182335e211848998e1933f3e225e9f7.jpg', 1322688846, 0, 0, 6),
	(42, '', '89703bc79f165445b94ba4b84285c4ad.jpg', 1322688854, 0, 0, 6),
	(43, '', '25663b0906714d8ad13639334fe68d52.jpg', 1322688860, 0, 0, 6),
	(44, '', '0677bf54248b22360f20751ad2bd0c7a.jpg', 1322688865, 0, 0, 6),
	(45, '', 'd92855f907875eaf07bae3cca011fbe0.jpg', 1322688874, 0, 0, 6),
	(46, '', '4360e0d72ecaef754e3b431c8c38803f.jpg', 1322688894, 0, 0, 7),
	(47, '', 'd2f29ffb4c629e75901b0d3c1a454f45.jpg', 1322688901, 0, 0, 7),
	(48, '', 'c7b7262be0c85732378a9b5f709af238.jpg', 1322688906, 0, 0, 7),
	(49, '', '0e3a1c17f836b2aee928c644a67e01a7.jpg', 1322688913, 0, 0, 7),
	(50, '', '42342af4ecbd554248e3f67f4cde2a56.jpg', 1322688918, 0, 0, 7),
	(51, '', 'c6be1e79957ac9553979961f751323ef.jpg', 1322688955, 0, 0, 8),
	(52, '', '46a81d3e0be5ba4a375419f1cb9325ad.jpg', 1322688960, 0, 0, 8),
	(53, '', '9f5c59a0f109eb5fa4a62275a7f98b26.jpg', 1322688967, 0, 0, 8),
	(54, '', '2a15903754d724ed4698796ca8d11f79.jpg', 1322688976, 0, 0, 8),
	(55, '', '1d9e9b24465a1f6efd395f923a149cdb.jpg', 1322688982, 0, 0, 8),
	(56, '', '08a33d2814a65f2715a4446ce69130aa.jpg', 1322689022, 0, 0, 9),
	(57, '', '4b1fe3b42e522d550a1e325f3cc1bbc5.jpg', 1322689029, 0, 0, 9),
	(58, '', '6beea173e5d33a9111941b70d75caeed.jpg', 1322689041, 0, 0, 9),
	(59, '', 'c96ef14822c789dcfbfd9ad757fd2925.jpg', 1322689050, 0, 0, 9),
	(60, '', '03e84846f93f73f01630f968127e2fbd.jpg', 1322689057, 0, 0, 9),
	(61, '', '0fbf3b7ec749c23fe58610b349f2e230.jpg', 1322689074, 0, 0, 10),
	(62, '', 'fd22ee6f8dc33b72258a5cb05e32caed.jpg', 1322689080, 0, 0, 10),
	(63, '', 'a28a82ba61db79b1da3dc375a505cb4e.jpg', 1322689086, 0, 0, 10),
	(64, '', '13c1d85875ef16a16d6febbff2bee0ee.jpg', 1322689093, 0, 0, 10),
	(65, '', 'f15b963b0c3d9fc2c10a9b692081e5b4.jpg', 1322689100, 0, 0, 10),
	(66, '', '005998418662200b7d1a232b23878b05.jpg', 1322689115, 0, 0, 11),
	(67, '', '9d5ec7773ceea39049830904a87e9ac5.jpg', 1322689122, 0, 0, 11),
	(68, '', 'bea908c6772632513ff14e82932bcc23.jpg', 1322689127, 0, 0, 11),
	(69, '', 'b214e9e1fe24512523590396f458f690.jpg', 1322689132, 0, 0, 11),
	(70, '', '391a13ed10bd755db858b255d9451bd7.jpg', 1322689141, 0, 0, 11),
	(71, '', 'd8d2753215933208ea88cf64c7f69675.jpg', 1322689161, 0, 0, 12),
	(72, '', '5eb6ef34ecb713f046eb373eff010cfd.jpg', 1322689167, 0, 0, 12),
	(73, '', '883a5b70fe1715af3ddaf03636708e58.jpg', 1322689177, 0, 0, 12),
	(74, '', '2f94de63dae118c8fcce9f9814adff7e.jpg', 1322689185, 0, 0, 12),
	(75, '', 'ee7c51adb5d8830a3290fb5d5b14f929.jpg', 1322689190, 0, 0, 12),
	(76, '', 'c802d9f1f74b53aee4fcd609bc53682f.jpg', 1322689208, 0, 0, 13),
	(77, '', '1d3372a8c330e10f496acb467ade9fcc.jpg', 1322689214, 0, 0, 13),
	(78, '', 'b9e1daae78f5d26e0daa65e310915344.jpg', 1322689219, 0, 0, 13),
	(79, '', '12c560e73af95f62f01cee503932d983.jpg', 1322689224, 0, 0, 13),
	(80, '', 'f3d12809b89d335517911f60c3a4bff1.jpg', 1322689232, 0, 0, 13),
	(81, '', '4650ae88eee3a2b1b2e18926a49ddfd1.jpg', 1322689277, 0, 0, 14),
	(82, '', '0274857366fa2c1906251d9304b9d053.jpg', 1322689283, 0, 0, 14),
	(83, '', '2d252fe215b681db1b4a3f4ea3796851.jpg', 1322689297, 0, 0, 14),
	(84, '', '9101390309086a5e0f8b0c1ee634b49c.jpg', 1322689305, 0, 0, 14),
	(85, '', '8bdb101de9c6b1ad80b6e5b84a3c9688.jpg', 1322689311, 0, 0, 14),
	(86, '', '5ded0eee44c2a6b4ebb56173ab63ba95.jpg', 1322689328, 0, 0, 15),
	(87, '', '6182f319756354fef95435d13ae610b5.jpg', 1322689333, 0, 0, 15),
	(88, '', 'e26ff0d4ebcf18eeb5e3e320dd7dd3a0.jpg', 1322689341, 0, 0, 15),
	(89, '', '0b4da76b3742e2e55c7c8f31d334538a.jpg', 1322689346, 0, 0, 15),
	(90, '', '820a7cb91703371a585889d72b011a21.jpg', 1322689352, 0, 0, 15);
/*!40000 ALTER TABLE `performers_photos` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.performers_photo_id: ~15 rows (approximately)
/*!40000 ALTER TABLE `performers_photo_id` DISABLE KEYS */;
INSERT INTO `performers_photo_id` (`id`, `date`, `name_on_disk`, `status`, `performer_id`) VALUES
	(1, 1322686951, '674e77f288f92fb234c836f213e12b9b.pdf', 'approved', 1),
	(2, 1322687028, '573e9948782a566e325a005551831187.pdf', 'approved', 2),
	(3, 1322687101, '30406031fd52188fda9dc6ce7a82726e.pdf', 'approved', 3),
	(4, 1322687173, '61d511176e75f4463e3f73270485a237.pdf', 'approved', 4),
	(5, 1322687265, '667e106a388f98f91c7382e46444ac7c.pdf', 'approved', 5),
	(6, 1322687341, '7b70110dcb5ca4672e46d9feba06bcd2.pdf', 'approved', 6),
	(7, 1322687400, 'dc6510b0fa5a4575e089f99fc9fbe95e.pdf', 'approved', 7),
	(8, 1322687470, 'f9a917189da96e92bb65b4235c3978b4.pdf', 'approved', 8),
	(9, 1322687543, 'd64b11934981a7183e476e53fff66ac2.pdf', 'approved', 9),
	(10, 1322687640, 'b15d1510b4a3820964e9cb5dcc22bd67.pdf', 'approved', 10),
	(11, 1322688094, 'e518fea38f885a4b8bfe8778efb182c4.pdf', 'approved', 11),
	(12, 1322688167, '9e3a6683615474ebb7117df8a7b0f6b3.pdf', 'approved', 12),
	(13, 1322688243, '0111969c3e4359c208a04e99d6737cce.pdf', 'approved', 13),
	(14, 1322688309, 'af8b3416438623fdebf1db56210349f1.pdf', 'approved', 14),
	(15, 1322688374, '7d3353ae84ec3adaf9b07af4d6a5b014.pdf', 'approved', 15);
/*!40000 ALTER TABLE `performers_photo_id` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.performers_ping: 0 rows
/*!40000 ALTER TABLE `performers_ping` DISABLE KEYS */;
/*!40000 ALTER TABLE `performers_ping` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.performers_profile: ~15 rows (approximately)
/*!40000 ALTER TABLE `performers_profile` DISABLE KEYS */;
INSERT INTO `performers_profile` (`performer_id`, `gender`, `description`, `what_turns_me_on`, `what_turns_me_off`, `sexual_prefference`, `ethnicity`, `height`, `weight`, `hair_color`, `hair_length`, `eye_color`, `build`, `birthday`, `cup_size`, `performer_status`) VALUES
	(1, 'female', 'sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1', 'sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1', 'sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1 sample1', 'straight', 'asian', '174-184 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'large', 322088400, 'A', NULL),
	(2, 'female', 'sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2', 'sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2', 'sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2 sample2', 'straight', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'large', 293317200, 'C', NULL),
	(3, 'female', 'sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3', 'sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3', 'sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3 sample3', 'straight', 'asian', '185-195 cm', '67-73 kg', 'auburn', 'bald', 'black', 'athletic', 298414800, 'A', NULL),
	(4, 'female', 'sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4', 'sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4', 'sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4 sample4', 'straight', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'athletic', 290293200, 'A', NULL),
	(5, 'female', 'sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5', 'sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5', 'sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5 sample5', 'straight', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'athletic', 398376000, 'A', NULL),
	(6, 'female', 'sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6', 'sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6', 'sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6 sample6', 'straight', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'athletic', 288046800, 'A', NULL),
	(7, 'female', 'sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7', 'sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7', 'sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7 sample7', 'gay', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'athletic', 353710800, 'A', NULL),
	(8, 'female', 'sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8', 'sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8', 'sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8 sample8', 'straight', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'athletic', 256510800, 'A', NULL),
	(9, 'female', 'sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9', 'sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9', 'sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9 sample9', 'gay', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'athletic', 290466000, 'A', NULL),
	(10, 'female', 'sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10', 'sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10', 'sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10 sample10', 'straight', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'average', 274827600, 'A', NULL),
	(11, 'female', 'sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11', 'sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11', 'sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11 sample11', 'straight', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'athletic', 453585600, 'A', NULL),
	(12, 'female', 'sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12', 'sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12', 'sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12 sample12', 'straight', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'athletic', 293144400, 'A', NULL),
	(13, 'female', 'sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13', 'sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13', 'sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13 sample13', 'straight', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'average', 295822800, 'A', NULL),
	(14, 'female', 'sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14', 'sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14', 'sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14 sample14', 'straight', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'athletic', 390513600, 'A', NULL),
	(15, 'female', 'sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15', 'sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15', 'sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15 sample15', 'straight', 'asian', 'over 195 cm', 'over 73 kg', 'auburn', 'bald', 'black', 'athletic', 327272400, 'A', NULL);
/*!40000 ALTER TABLE `performers_profile` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.performers_ratings: ~0 rows (approximately)
/*!40000 ALTER TABLE `performers_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `performers_ratings` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.performers_reviews: ~0 rows (approximately)
/*!40000 ALTER TABLE `performers_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `performers_reviews` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.performers_schedules: ~0 rows (approximately)
/*!40000 ALTER TABLE `performers_schedules` DISABLE KEYS */;
/*!40000 ALTER TABLE `performers_schedules` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.performers_videos: ~0 rows (approximately)
/*!40000 ALTER TABLE `performers_videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `performers_videos` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.relations: ~2 rows (approximately)
/*!40000 ALTER TABLE `relations` DISABLE KEYS */;
INSERT INTO `relations` (`id`, `from_id`, `from_type`, `to_id`, `to_type`, `status`) VALUES
	(1, 1, 'user', 1, 'performer', 'accepted'),
	(2, 1, 'user', 2, 'performer', 'accepted');
/*!40000 ALTER TABLE `relations` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.schema_version: ~1 rows (approximately)
/*!40000 ALTER TABLE `schema_version` DISABLE KEYS */;
INSERT INTO `schema_version` (`version`, `sub_version`) VALUES
	(28, 0);
/*!40000 ALTER TABLE `schema_version` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.settings: ~48 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `name`, `value`, `type`, `title`, `description`) VALUES
	(1, 'separator_Site settings', 'null', 'separator', 'Application Configuration Settings', NULL),
	(2, 'settings_debug', '0', 'boolean', 'Enable debugging', NULL),
	(3, 'email_activation', '1', 'boolean', 'Email Activation', NULL),
	(4, 'email_unique', '0', 'boolean', 'Require unique emails', NULL),
	(5, 'support_email', 'office@east-wolf.com', 'string', 'Support email', NULL),
	(6, 'support_name', 'east-wolf.com', 'string', 'Support name', NULL),
	(7, 'website_name', 'Your site name', 'string', 'Website name', NULL),
	(8, 'settings_default_theme', 'modena_t3', 'select', 'Default theme', NULL),
	(9, 'settings_site_title', 'thenaughtyandthenice.com', 'string', 'Website title', NULL),
	(10, 'settings_site_description', 'thenaughtyandthenice.com', 'string', 'Website description', NULL),
	(11, 'settings_site_keywords', 'modena', 'string', 'Website keywords', NULL),
	(12, 'separator_Memcache settings', 'null', 'separator', 'Memcache settings', NULL),
	(13, 'memcache_enable', '0', 'boolean', 'Enable memcache', NULL),
	(14, 'memcache_host', '127.0.0.1', 'string', 'Enable memcache', NULL),
	(15, 'memcache_port', '11211', 'integer', 'Enable memcache', NULL),
	(16, 'separator_Currency settings', 'null', 'separator', 'Website currency settings', NULL),
	(17, 'settings_currency_type', '0', 'string', 'Website Currency Type', NULL),
	(18, 'settings_real_currency_name', 'USD', 'string', 'Real currency name', NULL),
	(19, 'settings_real_currency_symbol', '$', 'string', 'Real currency other symbol', NULL),
	(20, 'settings_virtual_currency_name', 'chips', 'string', 'Chips name', NULL),
	(21, 'settings_cents_per_credit', '1', 'integer', 'Chips per currency unit', NULL),
	(22, 'settings_shown_currency', 'USD', 'string', 'What currency will be printed in lang', NULL),
	(23, 'separator_Price settings', 'null', 'separator', 'Website prices settings', NULL),
	(24, 'website_percentage', '50', 'integer', 'Website percentage', NULL),
	(25, 'min_true_private_chips_price', '10', 'integer', 'Min true private chips price', NULL),
	(26, 'max_true_private_chips_price', '100', 'integer', 'Max true private chips price', NULL),
	(27, 'min_private_chips_price', '10', 'integer', 'Min private chips price', NULL),
	(28, 'max_private_chips_price', '100', 'integer', 'Max private chips price', NULL),
	(29, 'min_peek_chips_price', '5', 'integer', 'Min peek chips price', NULL),
	(30, 'max_peek_chips_price', '100', 'integer', 'Max peek chips price', NULL),
	(31, 'min_nude_chips_price', '5', 'integer', 'Min nude chips price', NULL),
	(32, 'max_nude_chips_price', '100', 'integer', 'Max nude chips price', NULL),
	(33, 'min_paid_video_chips_price', '5', 'integer', 'Min paid video chips price', NULL),
	(34, 'max_paid_video_chips_price', '100', 'integer', 'Max paid video chips price', NULL),
	(35, 'min_photos_chips_price', '10', 'integer', 'Min paid photo chips price', NULL),
	(36, 'max_photos_chips_price', '100', 'integer', 'Max  paid photo chips price', NULL),
	(37, 'separator_Chat_settings', 'null', 'separator', 'Chat settings', NULL),
	(38, 'free_chat_limit_notlogged', '60', 'integer', 'Free chat time limit for nonlogged users', NULL),
	(39, 'free_chat_limit_logged_no_credits', '120', 'integer', 'Free chat time limit for logged with no credits', NULL),
	(40, 'free_chat_limit_logged_with_credits', '9999', 'integer', 'Free chat time limit for logged with credits', NULL),
	(41, 'minimum_paid_chat_time', '60', 'integer', 'Minimum paid chat time', NULL),
	(42, 'separator_User settings', 'null', 'separator', 'Users settings', NULL),
	(43, 'ban_expire_date', '84000', 'integer', 'Ban expiration time', NULL),
	(44, 'separator_Affiliate settings', 'null', 'separator', 'Affiliate settings', NULL),
	(45, 'settings_transaction_percentage', '30', 'integer', 'Transaction percentage', NULL),
	(46, 'separator_Fms settings', 'null', 'separator', 'FMS settings', NULL),
	(47, 'fms_secret_hash', 'vHDdpNyAz9xCnnzANAY8', 'string', 'FMS secret hash', NULL),
	(48, 'website_license', 'trial', 'string', 'Application License Key', NULL);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.songs: ~1 rows (approximately)
/*!40000 ALTER TABLE `songs` DISABLE KEYS */;
INSERT INTO `songs` (`id`, `title`, `src`) VALUES
	(1, 'Sample Track', 'sample_track.mp3');
/*!40000 ALTER TABLE `songs` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.studios: ~0 rows (approximately)
/*!40000 ALTER TABLE `studios` DISABLE KEYS */;
/*!40000 ALTER TABLE `studios` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.supported_languages: ~6 rows (approximately)
/*!40000 ALTER TABLE `supported_languages` DISABLE KEYS */;
INSERT INTO `supported_languages` (`id`, `code`, `title`) VALUES
	(1, 'de', 'deutsch'),
	(2, 'en', 'english'),
	(3, 'es', 'espanol'),
	(4, 'fr', 'francais'),
	(5, 'it', 'italiano'),
	(6, 'ro', 'romana');
/*!40000 ALTER TABLE `supported_languages` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.system_logs: ~107 rows (approximately)
/*!40000 ALTER TABLE `system_logs` DISABLE KEYS */;
INSERT INTO `system_logs` (`id`, `date`, `actor`, `actor_id`, `action_on`, `action_on_id`, `action`, `ip`, `key`, `action_comment`) VALUES
	(1, 1337708093, 'admin', 1, 'admin', 1, 'login', 1588620210, NULL, 'Admin has logged in.'),
	(2, 1337708124, 'admin', 1, 'performer', 1, 'edit_account', 1588620210, NULL, 'Admin edited performer account information.'),
	(3, 1337708194, 'performer', 1, 'performer', 1, 'login', 1588620210, NULL, 'Performer has logged in.'),
	(4, 1337704439, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(5, 1337704461, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(6, 1337954087, 'admin', 1, 'admin', 1, 'login', 2147483647, NULL, 'Admin has logged in.'),
	(7, 1337954385, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(8, 1337954456, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(9, 1337954468, 'admin', 1, 'admin', 1, 'login', 2147483647, NULL, 'Admin has logged in.'),
	(10, 1337954485, 'admin', 1, 'performer', 2, 'edit_account', 2147483647, NULL, 'Admin edited performer account information.'),
	(11, 1337954506, 'performer', 2, 'performer', 2, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(12, 1337954538, 'performer', 2, 'performer', 2, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(13, 1337954543, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(14, 1337954611, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(15, 1337954617, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(16, 1337954680, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(17, 1337954685, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(18, 1337955008, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(19, 1337955096, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(20, 1337955106, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(21, 1337955144, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(22, 1337955152, 'performer', 2, 'performer', 2, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(23, 1337955194, 'admin', 1, 'admin', 1, 'login', 2147483647, NULL, 'Admin has logged in.'),
	(24, 1337955210, 'admin', 1, 'performer', 2, 'edit_account', 2147483647, NULL, 'Admin edited performer account information.'),
	(25, 1337955422, 'performer', 2, 'performer', 2, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(26, 1337955459, 'performer', 2, 'performer', 2, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(27, 1337955526, 'user', -1, 'user', -1, 'start_chat', 2147483647, NULL, 'User has entered chat with 0 chips , performer 0.00 .'),
	(28, 1337955758, 'admin', 1, 'admin', 1, 'login', 2147483647, NULL, 'Admin has logged in.'),
	(29, 1337955870, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(30, 1337955883, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(31, 1337955897, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(32, 1337955933, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(33, 1337955969, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(34, 1337956004, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(35, 1337956051, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(36, 1337956065, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(37, 1338652530, 'user', 1, 'user', 1, 'register', 2147483647, NULL, 'New user has registered.'),
	(38, 1338652622, 'user', 2, 'user', 2, 'register', 2147483647, NULL, 'New user has registered.'),
	(39, 1338653105, 'user', 2, 'user', 2, 'register', 2147483647, NULL, 'User activated the account.'),
	(40, 1338654536, 'user', 2, 'user', 2, 'logout', 2147483647, NULL, 'User has logged out.'),
	(41, 1338654557, 'user', 2, 'user', 2, 'login', 2147483647, NULL, 'User has logged in.'),
	(42, 1338658056, 'user', 2, 'user', 2, 'logout', 2147483647, NULL, 'User has logged out.'),
	(43, 1338658066, 'user', 2, 'user', 2, 'login', 2147483647, NULL, 'User has logged in.'),
	(44, 1338658280, 'user', 2, 'user', 2, 'logout', 2147483647, NULL, 'User has logged out.'),
	(45, 1338658322, 'user', 3, 'user', 3, 'register', 2147483647, NULL, 'New user has registered.'),
	(46, 1338658397, 'user', 2, 'user', 2, 'login', 2147483647, NULL, 'User has logged in.'),
	(47, 1338756525, 'user', 2, 'user', 2, 'login', 2147483647, NULL, 'User has logged in.'),
	(48, 1338813765, 'admin', 1, 'admin', 1, 'login', 2147483647, NULL, 'Admin has logged in.'),
	(49, 1338813987, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(50, 1338814058, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(51, 1338814067, 'user', 2, 'user', 2, 'login', 2147483647, NULL, 'User has logged in.'),
	(52, 1338814088, 'user', 2, 'user', 2, 'logout', 2147483647, NULL, 'User has logged out.'),
	(53, 1338814116, 'user', 4, 'user', 4, 'register', 2147483647, NULL, 'New user has registered.'),
	(54, 1338814173, 'user', 2, 'user', 2, 'login', 2147483647, NULL, 'User has logged in.'),
	(55, 1338814376, 'user', 2, 'user', 2, 'logout', 2147483647, NULL, 'User has logged out.'),
	(56, 1338814393, 'admin', 1, 'admin', 1, 'login', 2147483647, NULL, 'Admin has logged in.'),
	(57, 1338814405, 'user', 3, 'user', 3, 'login', 2147483647, NULL, 'User has logged in.'),
	(58, 1338814453, 'user', 3, 'user', 3, 'logout', 2147483647, NULL, 'User has logged out.'),
	(59, 1338814459, 'user', 2, 'user', 2, 'login', 2147483647, NULL, 'User has logged in.'),
	(60, 1338817456, 'user', 2, 'user', 2, 'logout', 2147483647, NULL, 'User has logged out.'),
	(61, 1338817464, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(62, 1338817469, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(63, 1338817478, 'user', 3, 'user', 3, 'login', 2147483647, NULL, 'User has logged in.'),
	(64, 1338817484, 'user', 3, 'user', 3, 'logout', 2147483647, NULL, 'User has logged out.'),
	(65, 1338817495, 'user', 2, 'user', 2, 'login', 2147483647, NULL, 'User has logged in.'),
	(66, 1338822868, 'user', 2, 'user', 2, 'logout', 2147483647, NULL, 'User has logged out.'),
	(67, 1338822876, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(68, 1339962467, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(69, 1339966002, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(70, 1339966009, 'user', 2, 'user', 2, 'login', 2147483647, NULL, 'User has logged in.'),
	(71, 1339977856, 'user', 2, 'user', 2, 'logout', 2147483647, NULL, 'User has logged out.'),
	(72, 1339977872, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(73, 1339978262, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(74, 1339978280, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(75, 1339978320, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(76, 1339978329, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(77, 1339978469, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(78, 1339978475, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(79, 1339978487, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(80, 1339978495, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(81, 1339984620, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(82, 1339984627, 'user', 2, 'user', 2, 'login', 2147483647, NULL, 'User has logged in.'),
	(83, 1339984653, 'user', 2, 'user', 2, 'logout', 2147483647, NULL, 'User has logged out.'),
	(84, 1339984659, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(85, 1339984952, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(86, 1339984965, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(87, 1339985031, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(88, 1339985038, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(89, 1339985046, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(90, 1339996610, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(91, 1340000002, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(92, 1340000016, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(93, 1340000642, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(94, 1340000651, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(95, 1340000670, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(96, 1340000681, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(97, 1340001301, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(98, 1340001307, 'performer', 2, 'performer', 2, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(99, 1340007844, 'performer', 2, 'performer', 2, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(100, 1340007854, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(101, 1340011775, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(102, 1340012481, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(103, 1340088266, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(104, 1340088592, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(105, 1340088639, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(106, 1340088786, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(107, 1340109177, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(108, 1340115784, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(109, 1340116071, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(110, 1340116134, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(111, 1340125741, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(112, 1340125811, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(113, 1340126314, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(114, 1340126406, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(115, 1340127042, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(116, 1340127054, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(117, 1340127065, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(118, 1340127219, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(119, 1340127225, 'user', 2, 'user', 2, 'login', 2147483647, NULL, 'User has logged in.'),
	(120, 1340127233, 'user', 2, 'user', 2, 'logout', 2147483647, NULL, 'User has logged out.'),
	(121, 1340127242, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(122, 1340127389, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(123, 1340127395, 'user', 3, 'user', 3, 'login', 2147483647, NULL, 'User has logged in.'),
	(124, 1340127923, 'user', 3, 'user', 3, 'logout', 2147483647, NULL, 'User has logged out.'),
	(125, 1340127929, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(126, 1340127934, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.'),
	(127, 1340127940, 'user', 2, 'user', 2, 'login', 2147483647, NULL, 'User has logged in.'),
	(128, 1340127957, 'user', 2, 'user', 2, 'logout', 2147483647, NULL, 'User has logged out.'),
	(129, 1340128054, 'performer', 1, 'performer', 1, 'login', 2147483647, NULL, 'Performer has logged in.'),
	(130, 1340128174, 'performer', 1, 'performer', 1, 'logout', 2147483647, NULL, 'Performer has logged out.'),
	(131, 1340128534, 'user', 1, 'user', 1, 'login', 2147483647, NULL, 'User has logged in.'),
	(132, 1340128540, 'user', 1, 'user', 1, 'logout', 2147483647, NULL, 'User has logged out.');
/*!40000 ALTER TABLE `system_logs` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.test_gateway_processor: ~0 rows (approximately)
/*!40000 ALTER TABLE `test_gateway_processor` DISABLE KEYS */;
/*!40000 ALTER TABLE `test_gateway_processor` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.users: ~3 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `hash`, `email`, `status`, `gateway`, `credits`, `is_chat_online`) VALUES
	(1, 'thibaut1', '8699705c3e11bea3b8d858b608878dd31fe7c851ed22a1460469df2bbdf553ad', '4c5907d21f7df3e94acc6544a6af1d8023cfd906', 'thibaut@mail.debian', 'approved', NULL, 0.00, 0),
	(2, 'thibaut2', '9adb7e6aa2f6721779b84586f3060aa687f109df93615bd389a5066008cf4be6', '2f3d610f289fcc756df5635fbd481d032a381d5d', 'thibaut.mbega@gmail.com', 'approved', NULL, 0.00, 0),
	(3, 'thibaut3', 'd160af13bbaabd0586e4ffe355e0c37913972341e1260016a15d7335ce717f49', 'a247f2d8bf2057a6cd20bcb15cf58bbdf1bfa92f', 'thibaut.mbega@yahoo.com', 'approved', NULL, 0.00, 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.users_detail: ~3 rows (approximately)
/*!40000 ALTER TABLE `users_detail` DISABLE KEYS */;
INSERT INTO `users_detail` (`user_id`, `register_ip`, `register_date`, `cancel_date`, `country_code`, `newsletter`, `affiliate_id`, `affiliate_ad_id`) VALUES
	(1, 2147483647, 1338652622, NULL, '-', 1, NULL, NULL),
	(2, 2147483647, 1338658322, NULL, '-', 1, NULL, NULL),
	(3, 2147483647, 1338814116, NULL, '-', 1, NULL, NULL);
/*!40000 ALTER TABLE `users_detail` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.watchers: 0 rows
/*!40000 ALTER TABLE `watchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `watchers` ENABLE KEYS */;

# Dumping data for table east_wolf_com_thenaughtyandthenice.watchers_old: ~0 rows (approximately)
/*!40000 ALTER TABLE `watchers_old` DISABLE KEYS */;
/*!40000 ALTER TABLE `watchers_old` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
