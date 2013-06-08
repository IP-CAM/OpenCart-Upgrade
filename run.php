<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../config.php';
$pdo = new PDO('mysql:host='.DB_HOSTNAME.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD, array(
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
));

$create = "DROP TABLE IF EXISTS `v155_address`;
CREATE TABLE IF NOT EXISTS `v155_address` (
	`address_id` int(11) NOT NULL AUTO_INCREMENT,
	`customer_id` int(11) NOT NULL,
	`firstname` varchar(32) NOT NULL,
	`lastname` varchar(32) NOT NULL,
	`company` varchar(32) NOT NULL,
	`company_id` varchar(32) NOT NULL,
	`tax_id` varchar(32) NOT NULL,
	`address_1` varchar(128) NOT NULL,
	`address_2` varchar(128) NOT NULL,
	`city` varchar(128) NOT NULL,
	`postcode` varchar(10) NOT NULL,
	`country_id` int(11) NOT NULL DEFAULT '0',
	`zone_id` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`address_id`),
	KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM address');
foreach($rows as $row) {
	$sql = "INSERT INTO v155_address (address_id,customer_id,firstname,lastname,company,address_1,address_2,city,postcode,country_id,zone_id)";
	$sql .= "VALUES (:address_id,:customer_id,:firstname,:lastname,:company,:address_1,:address_2,:city,:postcode,:country_id,:zone_id)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':address_id' => $row['address_id'],
		':customer_id' => $row['customer_id'],
		':firstname' => $row['firstname'],
		':lastname' => $row['lastname'],
		':company' => $row['company'],
		':address_1' => $row['address_1'],
		':address_2' => $row['address_2'],
		':city' => $row['city'],
		':postcode' => $row['postcode'],
		':country_id' => $row['country_id'],
		':zone_id' => $row['zone_id'],
	));
}
echo 'Address Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_category`;
CREATE TABLE IF NOT EXISTS `v155_category` (
	`category_id` int(11) NOT NULL AUTO_INCREMENT,
	`image` varchar(255) DEFAULT NULL,
	`parent_id` int(11) NOT NULL DEFAULT '0',
	`top` tinyint(1) NOT NULL,
	`column` int(3) NOT NULL,
	`sort_order` int(3) NOT NULL DEFAULT '0',
	`status` tinyint(1) NOT NULL,
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM category');
foreach($rows as $row) {	
    $sql  = "INSERT INTO v155_category (category_id,image,parent_id,top,`column`,sort_order,status,date_added,date_modified)";
	$sql .= "VALUES (:category_id,:image,:parent_id,:top,:column,:sort_order,:status,:date_added,:date_modified)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':category_id' => $row['category_id'],
		':image' => $row['image'],
		':parent_id' => $row['parent_id'],
		':top' => 0,
		':column' => 0,
		':sort_order' => $row['sort_order'],
		':status' => $row['status'],
		':date_added' => $row['date_added'],
		':date_modified' => $row['date_modified'],
	));
}
echo 'Category Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Category Images.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_category_description`;
CREATE TABLE IF NOT EXISTS `v155_category_description` (
	`category_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`name` varchar(255) NOT NULL,
	`description` text NOT NULL,
	`meta_description` varchar(255) NOT NULL,
	`meta_keyword` varchar(255) NOT NULL,
	PRIMARY KEY (`category_id`,`language_id`),
	KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM category_description');
foreach($rows as $row) {	
    $sql  = "INSERT INTO v155_category_description (category_id,language_id,name,description,meta_description,meta_keyword)";
	$sql .= "VALUES (:category_id,:language_id,:name,:description,:meta_description,:meta_keyword)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':category_id' => $row['category_id'],
		':language_id' => $row['language_id'],
		':name' => $row['name'],
		':description' => $row['description'],
		':meta_description' => $row['meta_description'],
		':meta_keyword' => $row['meta_keywords'],
	));
}
echo 'Category Description Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_category_to_store`;
CREATE TABLE IF NOT EXISTS `v155_category_to_store` (
	`category_id` int(11) NOT NULL,
	`store_id` int(11) NOT NULL,
	PRIMARY KEY (`category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM category_to_store');
foreach($rows as $row) {	
    $sql  = "INSERT INTO v155_category_to_store (category_id,store_id)";
	$sql .= "VALUES (:category_id,:store_id)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':category_id' => $row['category_id'],
		':store_id' => $row['store_id'],
	));
}
echo 'Category To Store Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_country`;
	CREATE TABLE IF NOT EXISTS `v155_country` (
	`country_id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(128) NOT NULL,
	`iso_code_2` varchar(2) NOT NULL,
	`iso_code_3` varchar(3) NOT NULL,
	`address_format` text NOT NULL,
	`postcode_required` tinyint(1) NOT NULL,
	`status` tinyint(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_country` (`country_id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`, `postcode_required`, `status`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', '', 0, 1),
(2, 'Albania', 'AL', 'ALB', '', 0, 1),
(3, 'Algeria', 'DZ', 'DZA', '', 0, 1),
(4, 'American Samoa', 'AS', 'ASM', '', 0, 1),
(5, 'Andorra', 'AD', 'AND', '', 0, 1),
(6, 'Angola', 'AO', 'AGO', '', 0, 1),
(7, 'Anguilla', 'AI', 'AIA', '', 0, 1),
(8, 'Antarctica', 'AQ', 'ATA', '', 0, 1),
(9, 'Antigua and Barbuda', 'AG', 'ATG', '', 0, 1),
(10, 'Argentina', 'AR', 'ARG', '', 0, 1),
(11, 'Armenia', 'AM', 'ARM', '', 0, 1),
(12, 'Aruba', 'AW', 'ABW', '', 0, 1),
(13, 'Australia', 'AU', 'AUS', '', 0, 1),
(14, 'Austria', 'AT', 'AUT', '', 0, 1),
(15, 'Azerbaijan', 'AZ', 'AZE', '', 0, 1),
(16, 'Bahamas', 'BS', 'BHS', '', 0, 1),
(17, 'Bahrain', 'BH', 'BHR', '', 0, 1),
(18, 'Bangladesh', 'BD', 'BGD', '', 0, 1),
(19, 'Barbados', 'BB', 'BRB', '', 0, 1),
(20, 'Belarus', 'BY', 'BLR', '', 0, 1),
(21, 'Belgium', 'BE', 'BEL', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 0, 1),
(22, 'Belize', 'BZ', 'BLZ', '', 0, 1),
(23, 'Benin', 'BJ', 'BEN', '', 0, 1),
(24, 'Bermuda', 'BM', 'BMU', '', 0, 1),
(25, 'Bhutan', 'BT', 'BTN', '', 0, 1),
(26, 'Bolivia', 'BO', 'BOL', '', 0, 1),
(27, 'Bosnia and Herzegovina', 'BA', 'BIH', '', 0, 1),
(28, 'Botswana', 'BW', 'BWA', '', 0, 1),
(29, 'Bouvet Island', 'BV', 'BVT', '', 0, 1),
(30, 'Brazil', 'BR', 'BRA', '', 0, 1),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', '', 0, 1),
(32, 'Brunei Darussalam', 'BN', 'BRN', '', 0, 1),
(33, 'Bulgaria', 'BG', 'BGR', '', 0, 1),
(34, 'Burkina Faso', 'BF', 'BFA', '', 0, 1),
(35, 'Burundi', 'BI', 'BDI', '', 0, 1),
(36, 'Cambodia', 'KH', 'KHM', '', 0, 1),
(37, 'Cameroon', 'CM', 'CMR', '', 0, 1),
(38, 'Canada', 'CA', 'CAN', '', 0, 1),
(39, 'Cape Verde', 'CV', 'CPV', '', 0, 1),
(40, 'Cayman Islands', 'KY', 'CYM', '', 0, 1),
(41, 'Central African Republic', 'CF', 'CAF', '', 0, 1),
(42, 'Chad', 'TD', 'TCD', '', 0, 1),
(43, 'Chile', 'CL', 'CHL', '', 0, 1),
(44, 'China', 'CN', 'CHN', '', 0, 1),
(45, 'Christmas Island', 'CX', 'CXR', '', 0, 1),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', '', 0, 1),
(47, 'Colombia', 'CO', 'COL', '', 0, 1),
(48, 'Comoros', 'KM', 'COM', '', 0, 1),
(49, 'Congo', 'CG', 'COG', '', 0, 1),
(50, 'Cook Islands', 'CK', 'COK', '', 0, 1),
(51, 'Costa Rica', 'CR', 'CRI', '', 0, 1),
(52, 'Cote D''Ivoire', 'CI', 'CIV', '', 0, 1),
(53, 'Croatia', 'HR', 'HRV', '', 0, 1),
(54, 'Cuba', 'CU', 'CUB', '', 0, 1),
(55, 'Cyprus', 'CY', 'CYP', '', 0, 1),
(56, 'Czech Republic', 'CZ', 'CZE', '', 0, 1),
(57, 'Denmark', 'DK', 'DNK', '', 0, 1),
(58, 'Djibouti', 'DJ', 'DJI', '', 0, 1),
(59, 'Dominica', 'DM', 'DMA', '', 0, 1),
(60, 'Dominican Republic', 'DO', 'DOM', '', 0, 1),
(61, 'East Timor', 'TL', 'TLS', '', 0, 1),
(62, 'Ecuador', 'EC', 'ECU', '', 0, 1),
(63, 'Egypt', 'EG', 'EGY', '', 0, 1),
(64, 'El Salvador', 'SV', 'SLV', '', 0, 1),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', '', 0, 1),
(66, 'Eritrea', 'ER', 'ERI', '', 0, 1),
(67, 'Estonia', 'EE', 'EST', '', 0, 1),
(68, 'Ethiopia', 'ET', 'ETH', '', 0, 1),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', '', 0, 1),
(70, 'Faroe Islands', 'FO', 'FRO', '', 0, 1),
(71, 'Fiji', 'FJ', 'FJI', '', 0, 1),
(72, 'Finland', 'FI', 'FIN', '', 0, 1),
(74, 'France, Metropolitan', 'FR', 'FRA', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 1),
(75, 'French Guiana', 'GF', 'GUF', '', 0, 1),
(76, 'French Polynesia', 'PF', 'PYF', '', 0, 1),
(77, 'French Southern Territories', 'TF', 'ATF', '', 0, 1),
(78, 'Gabon', 'GA', 'GAB', '', 0, 1),
(79, 'Gambia', 'GM', 'GMB', '', 0, 1),
(80, 'Georgia', 'GE', 'GEO', '', 0, 1),
(81, 'Germany', 'DE', 'DEU', '{company}\r\n{firstname} {lastname}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 1),
(82, 'Ghana', 'GH', 'GHA', '', 0, 1),
(83, 'Gibraltar', 'GI', 'GIB', '', 0, 1),
(84, 'Greece', 'GR', 'GRC', '', 0, 1),
(85, 'Greenland', 'GL', 'GRL', '', 0, 1),
(86, 'Grenada', 'GD', 'GRD', '', 0, 1),
(87, 'Guadeloupe', 'GP', 'GLP', '', 0, 1),
(88, 'Guam', 'GU', 'GUM', '', 0, 1),
(89, 'Guatemala', 'GT', 'GTM', '', 0, 1),
(90, 'Guinea', 'GN', 'GIN', '', 0, 1),
(91, 'Guinea-Bissau', 'GW', 'GNB', '', 0, 1),
(92, 'Guyana', 'GY', 'GUY', '', 0, 1),
(93, 'Haiti', 'HT', 'HTI', '', 0, 1),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', '', 0, 1),
(95, 'Honduras', 'HN', 'HND', '', 0, 1),
(96, 'Hong Kong', 'HK', 'HKG', '', 0, 1),
(97, 'Hungary', 'HU', 'HUN', '', 0, 1),
(98, 'Iceland', 'IS', 'ISL', '', 0, 1),
(99, 'India', 'IN', 'IND', '', 0, 1),
(100, 'Indonesia', 'ID', 'IDN', '', 0, 1),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', '', 0, 1),
(102, 'Iraq', 'IQ', 'IRQ', '', 0, 1),
(103, 'Ireland', 'IE', 'IRL', '', 0, 1),
(104, 'Israel', 'IL', 'ISR', '', 0, 1),
(105, 'Italy', 'IT', 'ITA', '', 0, 1),
(106, 'Jamaica', 'JM', 'JAM', '', 0, 1),
(107, 'Japan', 'JP', 'JPN', '', 0, 1),
(108, 'Jordan', 'JO', 'JOR', '', 0, 1),
(109, 'Kazakhstan', 'KZ', 'KAZ', '', 0, 1),
(110, 'Kenya', 'KE', 'KEN', '', 0, 1),
(111, 'Kiribati', 'KI', 'KIR', '', 0, 1),
(112, 'North Korea', 'KP', 'PRK', '', 0, 1),
(113, 'Korea, Republic of', 'KR', 'KOR', '', 0, 1),
(114, 'Kuwait', 'KW', 'KWT', '', 0, 1),
(115, 'Kyrgyzstan', 'KG', 'KGZ', '', 0, 1),
(116, 'Lao People''s Democratic Republic', 'LA', 'LAO', '', 0, 1),
(117, 'Latvia', 'LV', 'LVA', '', 0, 1),
(118, 'Lebanon', 'LB', 'LBN', '', 0, 1),
(119, 'Lesotho', 'LS', 'LSO', '', 0, 1),
(120, 'Liberia', 'LR', 'LBR', '', 0, 1),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', '', 0, 1),
(122, 'Liechtenstein', 'LI', 'LIE', '', 0, 1),
(123, 'Lithuania', 'LT', 'LTU', '', 0, 1),
(124, 'Luxembourg', 'LU', 'LUX', '', 0, 1),
(125, 'Macau', 'MO', 'MAC', '', 0, 1),
(126, 'FYROM', 'MK', 'MKD', '', 0, 1),
(127, 'Madagascar', 'MG', 'MDG', '', 0, 1),
(128, 'Malawi', 'MW', 'MWI', '', 0, 1),
(129, 'Malaysia', 'MY', 'MYS', '', 0, 1),
(130, 'Maldives', 'MV', 'MDV', '', 0, 1),
(131, 'Mali', 'ML', 'MLI', '', 0, 1),
(132, 'Malta', 'MT', 'MLT', '', 0, 1),
(133, 'Marshall Islands', 'MH', 'MHL', '', 0, 1),
(134, 'Martinique', 'MQ', 'MTQ', '', 0, 1),
(135, 'Mauritania', 'MR', 'MRT', '', 0, 1),
(136, 'Mauritius', 'MU', 'MUS', '', 0, 1),
(137, 'Mayotte', 'YT', 'MYT', '', 0, 1),
(138, 'Mexico', 'MX', 'MEX', '', 0, 1),
(139, 'Micronesia, Federated States of', 'FM', 'FSM', '', 0, 1),
(140, 'Moldova, Republic of', 'MD', 'MDA', '', 0, 1),
(141, 'Monaco', 'MC', 'MCO', '', 0, 1),
(142, 'Mongolia', 'MN', 'MNG', '', 0, 1),
(143, 'Montserrat', 'MS', 'MSR', '', 0, 1),
(144, 'Morocco', 'MA', 'MAR', '', 0, 1),
(145, 'Mozambique', 'MZ', 'MOZ', '', 0, 1),
(146, 'Myanmar', 'MM', 'MMR', '', 0, 1),
(147, 'Namibia', 'NA', 'NAM', '', 0, 1),
(148, 'Nauru', 'NR', 'NRU', '', 0, 1),
(149, 'Nepal', 'NP', 'NPL', '', 0, 1),
(150, 'Netherlands', 'NL', 'NLD', '', 0, 1),
(151, 'Netherlands Antilles', 'AN', 'ANT', '', 0, 1),
(152, 'New Caledonia', 'NC', 'NCL', '', 0, 1),
(153, 'New Zealand', 'NZ', 'NZL', '', 0, 1),
(154, 'Nicaragua', 'NI', 'NIC', '', 0, 1),
(155, 'Niger', 'NE', 'NER', '', 0, 1),
(156, 'Nigeria', 'NG', 'NGA', '', 0, 1),
(157, 'Niue', 'NU', 'NIU', '', 0, 1),
(158, 'Norfolk Island', 'NF', 'NFK', '', 0, 1),
(159, 'Northern Mariana Islands', 'MP', 'MNP', '', 0, 1),
(160, 'Norway', 'NO', 'NOR', '', 0, 1),
(161, 'Oman', 'OM', 'OMN', '', 0, 1),
(162, 'Pakistan', 'PK', 'PAK', '', 0, 1),
(163, 'Palau', 'PW', 'PLW', '', 0, 1),
(164, 'Panama', 'PA', 'PAN', '', 0, 1),
(165, 'Papua New Guinea', 'PG', 'PNG', '', 0, 1),
(166, 'Paraguay', 'PY', 'PRY', '', 0, 1),
(167, 'Peru', 'PE', 'PER', '', 0, 1),
(168, 'Philippines', 'PH', 'PHL', '', 0, 1),
(169, 'Pitcairn', 'PN', 'PCN', '', 0, 1),
(170, 'Poland', 'PL', 'POL', '', 0, 1),
(171, 'Portugal', 'PT', 'PRT', '', 0, 1),
(172, 'Puerto Rico', 'PR', 'PRI', '', 0, 1),
(173, 'Qatar', 'QA', 'QAT', '', 0, 1),
(174, 'Reunion', 'RE', 'REU', '', 0, 1),
(175, 'Romania', 'RO', 'ROM', '', 0, 1),
(176, 'Russian Federation', 'RU', 'RUS', '', 0, 1),
(177, 'Rwanda', 'RW', 'RWA', '', 0, 1),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', '', 0, 1),
(179, 'Saint Lucia', 'LC', 'LCA', '', 0, 1),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', '', 0, 1),
(181, 'Samoa', 'WS', 'WSM', '', 0, 1),
(182, 'San Marino', 'SM', 'SMR', '', 0, 1),
(183, 'Sao Tome and Principe', 'ST', 'STP', '', 0, 1),
(184, 'Saudi Arabia', 'SA', 'SAU', '', 0, 1),
(185, 'Senegal', 'SN', 'SEN', '', 0, 1),
(186, 'Seychelles', 'SC', 'SYC', '', 0, 1),
(187, 'Sierra Leone', 'SL', 'SLE', '', 0, 1),
(188, 'Singapore', 'SG', 'SGP', '', 0, 1),
(189, 'Slovak Republic', 'SK', 'SVK', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{city} {postcode}\r\n{zone}\r\n{country}', 0, 1),
(190, 'Slovenia', 'SI', 'SVN', '', 0, 1),
(191, 'Solomon Islands', 'SB', 'SLB', '', 0, 1),
(192, 'Somalia', 'SO', 'SOM', '', 0, 1),
(193, 'South Africa', 'ZA', 'ZAF', '', 0, 1),
(194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', '', 0, 1),
(195, 'Spain', 'ES', 'ESP', '', 0, 1),
(196, 'Sri Lanka', 'LK', 'LKA', '', 0, 1),
(197, 'St. Helena', 'SH', 'SHN', '', 0, 1),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', '', 0, 1),
(199, 'Sudan', 'SD', 'SDN', '', 0, 1),
(200, 'Suriname', 'SR', 'SUR', '', 0, 1),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '', 0, 1),
(202, 'Swaziland', 'SZ', 'SWZ', '', 0, 1),
(203, 'Sweden', 'SE', 'SWE', '{company}\r\n{firstname} {lastname}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 1),
(204, 'Switzerland', 'CH', 'CHE', '', 0, 1),
(205, 'Syrian Arab Republic', 'SY', 'SYR', '', 0, 1),
(206, 'Taiwan', 'TW', 'TWN', '', 0, 1),
(207, 'Tajikistan', 'TJ', 'TJK', '', 0, 1),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', '', 0, 1),
(209, 'Thailand', 'TH', 'THA', '', 0, 1),
(210, 'Togo', 'TG', 'TGO', '', 0, 1),
(211, 'Tokelau', 'TK', 'TKL', '', 0, 1),
(212, 'Tonga', 'TO', 'TON', '', 0, 1),
(213, 'Trinidad and Tobago', 'TT', 'TTO', '', 0, 1),
(214, 'Tunisia', 'TN', 'TUN', '', 0, 1),
(215, 'Turkey', 'TR', 'TUR', '', 0, 1),
(216, 'Turkmenistan', 'TM', 'TKM', '', 0, 1),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', '', 0, 1),
(218, 'Tuvalu', 'TV', 'TUV', '', 0, 1),
(219, 'Uganda', 'UG', 'UGA', '', 0, 1),
(220, 'Ukraine', 'UA', 'UKR', '', 0, 1),
(221, 'United Arab Emirates', 'AE', 'ARE', '', 0, 1),
(222, 'United Kingdom', 'GB', 'GBR', '', 1, 1),
(223, 'United States', 'US', 'USA', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{city}, {zone} {postcode}\r\n{country}', 0, 1),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', '', 0, 1),
(225, 'Uruguay', 'UY', 'URY', '', 0, 1),
(226, 'Uzbekistan', 'UZ', 'UZB', '', 0, 1),
(227, 'Vanuatu', 'VU', 'VUT', '', 0, 1),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', '', 0, 1),
(229, 'Venezuela', 'VE', 'VEN', '', 0, 1),
(230, 'Viet Nam', 'VN', 'VNM', '', 0, 1),
(231, 'Virgin Islands (British)', 'VG', 'VGB', '', 0, 1),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', '', 0, 1),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', '', 0, 1),
(234, 'Western Sahara', 'EH', 'ESH', '', 0, 1),
(235, 'Yemen', 'YE', 'YEM', '', 0, 1),
(237, 'Democratic Republic of Congo', 'CD', 'COD', '', 0, 1),
(238, 'Zambia', 'ZM', 'ZMB', '', 0, 1),
(239, 'Zimbabwe', 'ZW', 'ZWE', '', 0, 1),
(240, 'Jersey', 'JE', 'JEY', '', 1, 1),
(241, 'Guernsey', 'GG', 'GGY', '', 1, 1),
(242, 'Montenegro', 'ME', 'MNE', '', 0, 1),
(243, 'Serbia', 'RS', 'SRB', '', 0, 1),
(244, 'Aaland Islands', 'AX', 'ALA', '', 0, 1),
(245, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES', '', 0, 1),
(246, 'Curacao', 'CW', 'CUW', '', 0, 1),
(247, 'Palestinian Territory, Occupied', 'PS', 'PSE', '', 0, 1),
(248, 'South Sudan', 'SS', 'SSD', '', 0, 1),
(249, 'St. Barthelemy', 'BL', 'BLM', '', 0, 1),
(250, 'St. Martin (French part)', 'MF', 'MAF', '', 0, 1),
(251, 'Canary Islands', 'IC', 'ICA', '', 0, 1);";
$pdo->query($insert);

echo 'Country Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_coupon`;
CREATE TABLE IF NOT EXISTS `v155_coupon` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `code` varchar(10) NOT NULL,
  `type` char(1) NOT NULL,
  `discount` decimal(15,4) NOT NULL,
  `logged` tinyint(1) NOT NULL,
  `shipping` tinyint(1) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `uses_total` int(11) NOT NULL,
  `uses_customer` varchar(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM coupon');
foreach($rows as $row) {
    $sql  = "INSERT INTO v155_coupon (coupon_id,name,code,type,discount,logged,shipping,total,date_start,date_end,uses_total,uses_customer,status,date_added)";
	$sql .= "VALUES (:coupon_id,:name,:code,:type,:discount,:logged,:shipping,:total,:date_start,:date_end,:uses_total,:uses_customer,:status,:date_added)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':coupon_id' => $row['coupon_id'],
		':name' => $row['code'],
		':code' => $row['code'],
		':type' => $row['type'],
		':discount' => $row['discount'],
		':logged' => $row['logged'],
		':shipping' => $row['shipping'],
		':total' => $row['total'],
		':date_start' => $row['date_start'],
		':date_end' => $row['date_end'],
		':uses_total' => $row['uses_total'],
		':uses_customer' => $row['uses_customer'],
		':status' => $row['status'],
		':date_added' => $row['date_added'],
	));
}

$rows = $pdo->query('SELECT * FROM coupon_description');
foreach($rows as $row) {
	// Nowhere Man
	// $row['description']);
    $sql  = "UPDATE v155_coupon SET name = :name ";
	$sql .= "WHERE coupon_id = :coupon_id";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':name' => $row['name'],
		':coupon_id' => $row['coupon_id'],
	));
}

echo 'Coupon Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Does Coupon Description Go Anywhere?';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_coupon_category`;
CREATE TABLE IF NOT EXISTS `v155_coupon_category` (
  `coupon_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`coupon_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$create = "DROP TABLE IF EXISTS `v155_coupon_history`;
CREATE TABLE IF NOT EXISTS `v155_coupon_history` (
  `coupon_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`coupon_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$create = "DROP TABLE IF EXISTS `v155_coupon_product`;
CREATE TABLE IF NOT EXISTS `v155_coupon_product` (
  `coupon_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`coupon_product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM coupon_product');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_coupon_product (coupon_product_id,coupon_id,product_id)";
	$sql .= "VALUES (:coupon_product_id,:coupon_id,:product_id)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':coupon_product_id' => $row['coupon_product_id'],
		':coupon_id' => $row['coupon_id'],
		':product_id' => $row['product_id'],
	));
}
echo 'Coupon Product Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_currency`;
CREATE TABLE IF NOT EXISTS `v155_currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL,
  `symbol_left` varchar(12) NOT NULL,
  `symbol_right` varchar(12) NOT NULL,
  `decimal_place` char(1) NOT NULL,
  `value` float(15,8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$sql  = "INSERT INTO v155_currency (currency_id,title,code,symbol_left,symbol_right,decimal_place,value,status,date_modified)";
$sql .= "VALUES (:currency_id,:title,:code,:symbol_left,:symbol_right,:decimal_place,:value,:status,NOW())";
$q = $pdo->prepare($sql);
$q->execute(array(
	':currency_id' => 1,
	':title' => 'US Dollar',
	':code' => 'USD',
	':symbol_left' => '$',
	':symbol_right' => '',
	':decimal_place' => '2',
	':value' => '1.00000000',
	':status' => 1,
));
echo 'Currency Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_customer`;
CREATE TABLE IF NOT EXISTS `v155_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `cart` text,
  `wishlist` text,
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `address_id` int(11) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `token` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM customer');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_customer (customer_id,store_id,firstname,lastname,email,telephone,fax,password,salt,cart,wishlist,newsletter,address_id,customer_group_id,ip,status,approved,token,date_added)";
	$sql .= "VALUES (:customer_id,:store_id,:firstname,:lastname,:email,:telephone,:fax,:password,:salt,:cart,:wishlist,:newsletter,:address_id,:customer_group_id,:ip,:status,:approved,:token,:date_added)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':customer_id' => $row['customer_id'],
		':store_id' => $row['store_id'],
		':firstname' => $row['firstname'],
		':lastname' => $row['lastname'],
		':email' => $row['email'],
		':telephone' => $row['telephone'],
		':fax' => $row['fax'],
		':password' => $row['password'],
		':salt' => '',
		':cart' => $row['cart'],
		':wishlist' => '',
		':newsletter' => $row['newsletter'],
		':address_id' => $row['address_id'],
		':customer_group_id' => $row['customer_group_id'],
		':ip' => $row['ip'],
		':status' => $row['status'],
		':approved' => $row['approved'],
		':token' => '',
		':date_added' => $row['date_added'],
	));
}

echo 'Customer Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Check Logging In Works.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_customer_group`;
CREATE TABLE IF NOT EXISTS `v155_customer_group` (
	`customer_group_id` int(11) NOT NULL AUTO_INCREMENT,
	`approval` int(1) NOT NULL,
	`company_id_display` int(1) NOT NULL,
	`company_id_required` int(1) NOT NULL,
	`tax_id_display` int(1) NOT NULL,
	`tax_id_required` int(1) NOT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`customer_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM customer_group');
foreach($rows as $row) {
	// Nowhere Man
	// $row['name']
	$sql  = "INSERT INTO v155_customer_group (customer_group_id,approval,company_id_display,company_id_required,tax_id_display,tax_id_required,sort_order)";
	$sql .= "VALUES (:customer_group_id,:approval,:company_id_display,:company_id_required,:tax_id_display,:tax_id_required,:sort_order)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':customer_group_id' => $row['customer_group_id'],
		':approval' => 0,
		':company_id_display' => 0,
		':company_id_required' => 0,
		':tax_id_display' => 0,
		':tax_id_required' => 0,
		':sort_order' => 0,
	));
}

echo 'Customer Group Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Customer Group Name? Probably Becomes Company Name.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_extension`;
CREATE TABLE IF NOT EXISTS `v155_extension` (
	`extension_id` int(11) NOT NULL AUTO_INCREMENT,
	`type` varchar(32) NOT NULL,
	`code` varchar(32) NOT NULL,
	PRIMARY KEY (`extension_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM extension');
foreach($rows as $row) {	
	$sql  = "INSERT INTO v155_extension (extension_id,type,code)";
	$sql .= "VALUES (:extension_id,:type,:code)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':extension_id' => $row['extension_id'],
		':type' => $row['type'],
		':code' => $row['key'],
	));
}

echo 'Extension Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_geo_zone`;
CREATE TABLE IF NOT EXISTS `v155_geo_zone` (
	`geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(32) NOT NULL,
	`description` varchar(255) NOT NULL,
	`date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`geo_zone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM geo_zone');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_geo_zone (geo_zone_id,name,description,date_modified,date_added)";
	$sql .= "VALUES (:geo_zone_id,:name,:description,:date_modified,:date_added)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':geo_zone_id' => $row['geo_zone_id'],
		':name' => $row['name'],
		':description' => $row['description'],
		':date_modified' => $row['date_modified'],
		':date_added' => $row['date_added'],
	));
}

echo 'Geo Zone Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_information`;
CREATE TABLE IF NOT EXISTS `v155_information` (
	`information_id` int(11) NOT NULL AUTO_INCREMENT,
	`bottom` int(1) NOT NULL DEFAULT '0',
	`sort_order` int(3) NOT NULL DEFAULT '0',
	`status` tinyint(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (`information_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM information');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_information (information_id,bottom,sort_order,status)";
	$sql .= "VALUES (:information_id,:bottom,:sort_order,:status)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':information_id' => $row['information_id'],
		':bottom' => 1,
		':sort_order' => $row['sort_order'],
		':status' => $row['status'],
	));
}

echo 'Information Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_information_description`;
CREATE TABLE IF NOT EXISTS `v155_information_description` (
	`information_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`title` varchar(64) NOT NULL,
	`description` text NOT NULL,
	PRIMARY KEY (`information_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM information_description');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_information_description (information_id,language_id,title,description)";
	$sql .= "VALUES (:information_id,:language_id,:title,:description)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':information_id' => $row['information_id'],
		':language_id' => $row['language_id'],
		':title' => $row['title'],
		':description' => $row['description'],
	));
}

echo 'Information Description Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_information_to_store`;
CREATE TABLE IF NOT EXISTS `v155_information_to_store` (
  `information_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`information_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM information_to_store');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_information_to_store (information_id,store_id)";
	$sql .= "VALUES (:information_id,:store_id)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':information_id' => $row['information_id'],
		':store_id' => $row['store_id'],
	));
}

echo 'Information To Store Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_language`;
CREATE TABLE IF NOT EXISTS `v155_language` (
	`language_id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
	`code` varchar(5) COLLATE utf8_bin NOT NULL,
	`locale` varchar(255) COLLATE utf8_bin NOT NULL,
	`image` varchar(64) COLLATE utf8_bin NOT NULL,
	`directory` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
	`filename` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
	`sort_order` int(3) NOT NULL DEFAULT '0',
	`status` int(1) NOT NULL,
	PRIMARY KEY (`language_id`),
	KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM language');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_language (language_id,name,code,locale,image,directory,filename,sort_order,status)";
	$sql .= "VALUES (:language_id,:name,:code,:locale,:image,:directory,:filename,:sort_order,:status)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':language_id' => $row['language_id'],
		':name' => $row['name'],
		':code' => $row['code'],
		':locale' => $row['locale'],
		':image' => $row['image'],
		':directory' => $row['directory'],
		':filename' => $row['filename'],
		':sort_order' => $row['sort_order'],
		':status' => $row['status'],
	));
}

echo 'Language Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_length_class`;
CREATE TABLE IF NOT EXISTS `v155_length_class` (
	`length_class_id` int(11) NOT NULL AUTO_INCREMENT,
	`value` decimal(15,8) NOT NULL,
	PRIMARY KEY (`length_class_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM length_class');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_length_class (length_class_id,value)";
	$sql .= "VALUES (:length_class_id,:value)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':length_class_id' => $row['length_class_id'],
		':value' => $row['value'],
	));
}

echo 'Length Class Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_length_class_description`;
CREATE TABLE IF NOT EXISTS `v155_length_class_description` (
	`length_class_id` int(11) NOT NULL AUTO_INCREMENT,
	`language_id` int(11) NOT NULL,
	`title` varchar(32) NOT NULL,
	`unit` varchar(4) NOT NULL,
	PRIMARY KEY (`length_class_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM length_class_description');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_length_class_description (length_class_id,language_id,title,unit)";
	$sql .= "VALUES (:length_class_id,:language_id,:title,:unit)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':length_class_id' => $row['length_class_id'],
		':language_id' => $row['language_id'],
		':title' => $row['title'],
		':unit' => $row['unit'],
	));
}

echo 'Length Class Description Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_manufacturer`;
CREATE TABLE IF NOT EXISTS `v155_manufacturer` (
	`manufacturer_id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(64) NOT NULL,
	`image` varchar(255) DEFAULT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`manufacturer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM manufacturer');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_manufacturer (manufacturer_id,name,image,sort_order)";
	$sql .= "VALUES (:manufacturer_id,:name,:image,:sort_order)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':manufacturer_id' => $row['manufacturer_id'],
		':name' => $row['name'],
		':image' => $row['image'],
		':sort_order' => $row['sort_order'],
	));
}

echo 'Manufacturer Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_manufacturer_to_store`;
CREATE TABLE IF NOT EXISTS `v155_manufacturer_to_store` (
	`manufacturer_id` int(11) NOT NULL,
	`store_id` int(11) NOT NULL,
	PRIMARY KEY (`manufacturer_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM manufacturer_to_store');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_manufacturer_to_store (manufacturer_id,store_id)";
	$sql .= "VALUES (:manufacturer_id,:store_id)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':manufacturer_id' => $row['manufacturer_id'],
		':store_id' => $row['store_id'],
	));
}

echo 'Manufacturer To Store Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_order`;
CREATE TABLE IF NOT EXISTS `v155_order` (
	`order_id` int(11) NOT NULL AUTO_INCREMENT,
	`invoice_no` int(11) NOT NULL DEFAULT '0',
	`invoice_prefix` varchar(26) NOT NULL,
	`store_id` int(11) NOT NULL DEFAULT '0',
	`store_name` varchar(64) NOT NULL,
	`store_url` varchar(255) NOT NULL,
	`customer_id` int(11) NOT NULL DEFAULT '0',
	`customer_group_id` int(11) NOT NULL DEFAULT '0',
	`firstname` varchar(32) NOT NULL,
	`lastname` varchar(32) NOT NULL,
	`email` varchar(96) NOT NULL,
	`telephone` varchar(32) NOT NULL,
	`fax` varchar(32) NOT NULL,
	`payment_firstname` varchar(32) NOT NULL,
	`payment_lastname` varchar(32) NOT NULL,
	`payment_company` varchar(32) NOT NULL,
	`payment_company_id` varchar(32) NOT NULL,
	`payment_tax_id` varchar(32) NOT NULL,
	`payment_address_1` varchar(128) NOT NULL,
	`payment_address_2` varchar(128) NOT NULL,
	`payment_city` varchar(128) NOT NULL,
	`payment_postcode` varchar(10) NOT NULL,
	`payment_country` varchar(128) NOT NULL,
	`payment_country_id` int(11) NOT NULL,
	`payment_zone` varchar(128) NOT NULL,
	`payment_zone_id` int(11) NOT NULL,
	`payment_address_format` text NOT NULL,
	`payment_method` varchar(128) NOT NULL,
	`payment_code` varchar(128) NOT NULL,
	`shipping_firstname` varchar(32) NOT NULL,
	`shipping_lastname` varchar(32) NOT NULL,
	`shipping_company` varchar(32) NOT NULL,
	`shipping_address_1` varchar(128) NOT NULL,
	`shipping_address_2` varchar(128) NOT NULL,
	`shipping_city` varchar(128) NOT NULL,
	`shipping_postcode` varchar(10) NOT NULL,
	`shipping_country` varchar(128) NOT NULL,
	`shipping_country_id` int(11) NOT NULL,
	`shipping_zone` varchar(128) NOT NULL,
	`shipping_zone_id` int(11) NOT NULL,
	`shipping_address_format` text NOT NULL,
	`shipping_method` varchar(128) NOT NULL,
	`shipping_code` varchar(128) NOT NULL,
	`comment` text NOT NULL,
	`total` decimal(15,4) NOT NULL DEFAULT '0.0000',
	`order_status_id` int(11) NOT NULL DEFAULT '0',
	`affiliate_id` int(11) NOT NULL,
	`commission` decimal(15,4) NOT NULL,
	`language_id` int(11) NOT NULL,
	`currency_id` int(11) NOT NULL,
	`currency_code` varchar(3) NOT NULL,
	`currency_value` decimal(15,8) NOT NULL DEFAULT '1.00000000',
	`ip` varchar(40) NOT NULL,
	`forwarded_ip` varchar(40) NOT NULL,
	`user_agent` varchar(255) NOT NULL,
	`accept_language` varchar(255) NOT NULL,
	`date_added` datetime NOT NULL,
	`date_modified` datetime NOT NULL,
	PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `order`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_order (order_id,invoice_no,invoice_prefix,store_id,store_name,store_url,customer_id,customer_group_id,firstname,lastname,email,telephone,fax,payment_firstname,payment_lastname,payment_company,payment_company_id,payment_tax_id,payment_address_1,payment_address_2,payment_city,payment_postcode,payment_country,payment_country_id,payment_zone,payment_zone_id,payment_address_format,payment_method,payment_code,shipping_firstname,shipping_lastname,shipping_company,shipping_address_1,shipping_address_2,shipping_city,shipping_postcode,shipping_country,shipping_country_id,shipping_zone,shipping_zone_id,shipping_address_format,shipping_method,shipping_code,comment,total,order_status_id,affiliate_id,commission,language_id,currency_id,currency_code,currency_value,ip,forwarded_ip,user_agent,accept_language,date_added,date_modified)";
	$sql .= "VALUES (:order_id,:invoice_no,:invoice_prefix,:store_id,:store_name,:store_url,:customer_id,:customer_group_id,:firstname,:lastname,:email,:telephone,:fax,:payment_firstname,:payment_lastname,:payment_company,:payment_company_id,:payment_tax_id,:payment_address_1,:payment_address_2,:payment_city,:payment_postcode,:payment_country,:payment_country_id,:payment_zone,:payment_zone_id,:payment_address_format,:payment_method,:payment_code,:shipping_firstname,:shipping_lastname,:shipping_company,:shipping_address_1,:shipping_address_2,:shipping_city,:shipping_postcode,:shipping_country,:shipping_country_id,:shipping_zone,:shipping_zone_id,:shipping_address_format,:shipping_method,:shipping_code,:comment,:total,:order_status_id,:affiliate_id,:commission,:language_id,:currency_id,:currency_code,:currency_value,:ip,:forwarded_ip,:user_agent,:accept_language,:date_added,:date_modified)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':order_id' => $row['order_id'],
		':invoice_no' => $row['invoice_id'],
		':invoice_prefix' => $row['invoice_prefix'],
		':store_id' => $row['store_id'],
		':store_name' => $row['store_name'],
		':store_url' => $row['store_url'],
		':customer_id' => $row['customer_id'],
		':customer_group_id' => $row['customer_group_id'],
		':firstname' => $row['firstname'],
		':lastname' => $row['lastname'],
		':email' => $row['email'],
		':telephone' => $row['telephone'],
		':fax' => $row['fax'],
		':payment_firstname' => $row['payment_firstname'],
		':payment_lastname' => $row['payment_lastname'],
		':payment_company' => $row['payment_company'],
		':payment_company_id' => '',
		':payment_tax_id' => '',
		':payment_address_1' => $row['payment_address_1'],
		':payment_address_2' => $row['payment_address_2'],
		':payment_city' => $row['payment_city'],
		':payment_postcode' => $row['payment_postcode'],
		':payment_country' => $row['payment_country'],
		':payment_country_id' => $row['payment_country_id'],
		':payment_zone' => $row['payment_zone'],
		':payment_zone_id' => $row['payment_zone_id'],
		':payment_address_format' => $row['payment_address_format'],
		':payment_method' => $row['payment_method'],
		':payment_code' => '',
		':shipping_firstname' => $row['shipping_firstname'],
		':shipping_lastname' => $row['shipping_lastname'],
		':shipping_company' => $row['shipping_company'],
		':shipping_address_1' => $row['shipping_address_1'],
		':shipping_address_2' => $row['shipping_address_2'],
		':shipping_city' => $row['shipping_city'],
		':shipping_postcode' => $row['shipping_postcode'],
		':shipping_country' => $row['shipping_country'],
		':shipping_country_id' => $row['shipping_country_id'],
		':shipping_zone' => $row['shipping_zone'],
		':shipping_zone_id' => $row['shipping_zone_id'],
		':shipping_address_format' => $row['shipping_address_format'],
		':shipping_method' => $row['shipping_method'],
		':shipping_code' => '',
		':comment' => $row['comment'],
		':total' => $row['total'],
		':order_status_id' => $row['order_status_id'],
		':affiliate_id' => '',
		':commission' => '',
		':language_id' => $row['language_id'],
		':currency_id' => 1,
		':currency_code' => $row['currency'],
		':currency_value' => $row['value'],
		':ip' => $row['ip'],
		':forwarded_ip' => '',
		':user_agent' => '',
		':accept_language' => '',
		':date_added' => $row['date_added'],
		':date_modified' => $row['date_modified'],
	));
}

echo 'Order Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Double Check Currency Code and Currency Value';
echo '<br />';
echo '<b>TODO:</b> Fill in Customer Group ID.';
echo '<br />';
echo '<b>TODO:</b> Put Coupon ID and Invoice Date somewhere else';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_order_history`;
CREATE TABLE IF NOT EXISTS `v155_order_history` (
	`order_history_id` int(11) NOT NULL AUTO_INCREMENT,
	`order_id` int(11) NOT NULL,
	`order_status_id` int(5) NOT NULL,
	`notify` tinyint(1) NOT NULL DEFAULT '0',
	`comment` text NOT NULL,
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`order_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `order_history`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_order_history (order_history_id,order_id,order_status_id,notify,comment,date_added)";
	$sql .= "VALUES (:order_history_id,:order_id,:order_status_id,:notify,:comment,:date_added)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':order_history_id' => $row['order_history_id'],
		':order_id' => $row['order_id'],
		':order_status_id' => $row['order_status_id'],
		':notify' => $row['notify'],
		':comment' => $row['comment'],
		':date_added' => $row['date_added'],
	));
}

echo 'Order History Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_order_option`;
CREATE TABLE IF NOT EXISTS `v155_order_option` (
  `order_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `product_option_id` int(11) NOT NULL,
  `product_option_value_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` varchar(32) NOT NULL,
  PRIMARY KEY (`order_option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `order_option`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_order_option (order_option_id,order_id,order_product_id,product_option_id,product_option_value_id,name,value,type)";
	$sql .= "VALUES (:order_option_id,:order_id,:order_product_id,:product_option_id,:product_option_value_id,:name,:value,:type)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':order_option_id' => $row['order_option_id'],
		':order_id' => $row['order_id'],
		':order_product_id' => $row['order_product_id'],
		':product_option_id' => '',
		':product_option_value_id' => $row['product_option_value_id'],
		':name' => $row['name'],
		':value' => $row['value'],
		':type' => $row['price'],
	));
}

echo 'Order Option Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Fill in Product Option ID.';
echo '<br />';
echo '<b>TODO:</b> Put Prefix somewhere else';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_order_product`;
CREATE TABLE IF NOT EXISTS `v155_order_product` (
  `order_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `model` varchar(64) NOT NULL,
  `quantity` int(4) NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `reward` int(8) NOT NULL,
  PRIMARY KEY (`order_product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `order_product`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_order_product (order_product_id,order_id,product_id,name,model,quantity,price,total,tax,reward)";
	$sql .= "VALUES (:order_product_id,:order_id,:product_id,:name,:model,:quantity,:price,:total,:tax,:reward)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':order_product_id' => $row['order_product_id'],
		':order_id' => $row['order_id'],
		':product_id' => $row['product_id'],
		':name' => $row['name'],
		':model' => $row['model'],
		':quantity' => $row['quantity'],
		':price' => $row['price'],
		':total' => $row['total'],
		':tax' => $row['tax'],
		':reward' => $row['subtract'],
	));
}

echo 'Order Product Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_order_status`;
CREATE TABLE IF NOT EXISTS `v155_order_status` (
	`order_status_id` int(11) NOT NULL AUTO_INCREMENT,
	`language_id` int(11) NOT NULL,
	`name` varchar(32) NOT NULL,
	PRIMARY KEY (`order_status_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_order_status` (`order_status_id`, `language_id`, `name`) VALUES
	(1, 1, 'Pending'),
	(2, 1, 'Processing'),
	(3, 1, 'Shipped'),
	(5, 1, 'Complete'),
	(7, 1, 'Canceled'),
	(8, 1, 'Denied'),
	(9, 1, 'Canceled Reversal'),
	(10, 1, 'Failed'),
	(11, 1, 'Refunded'),
	(12, 1, 'Reversed'),
	(13, 1, 'Chargeback'),
	(14, 1, 'Expired'),
	(15, 1, 'Processed'),
	(16, 1, 'Voided');";
$pdo->query($insert);

echo 'Order Status Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_order_total`;
CREATE TABLE IF NOT EXISTS `v155_order_total` (
	`order_total_id` int(10) NOT NULL AUTO_INCREMENT,
	`order_id` int(11) NOT NULL,
	`code` varchar(32) NOT NULL,
	`title` varchar(255) NOT NULL,
	`text` varchar(255) NOT NULL,
	`value` decimal(15,4) NOT NULL DEFAULT '0.0000',
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`order_total_id`),
	KEY `idx_orders_total_orders_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `order_total`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_order_total (order_total_id,order_id,code,title,text,value,sort_order)";
	$sql .= "VALUES (:order_total_id,:order_id,:code,:title,:text,:value,:sort_order)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':order_total_id' => $row['order_total_id'],
		':order_id' => $row['order_id'],
		':code' => '',
		':title' => $row['title'],
		':text' => $row['text'],
		':value' => $row['value'],
		':sort_order' => $row['sort_order'],
	));
}

echo 'Order Total Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Fill in Code.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product`;
CREATE TABLE IF NOT EXISTS `v155_product` (
	`product_id` int(11) NOT NULL AUTO_INCREMENT,
	`model` varchar(64) NOT NULL,
	`sku` varchar(64) NOT NULL,
	`upc` varchar(12) NOT NULL,
	`ean` varchar(14) NOT NULL,
	`jan` varchar(13) NOT NULL,
	`isbn` varchar(13) NOT NULL,
	`mpn` varchar(64) NOT NULL,
	`location` varchar(128) NOT NULL,
	`quantity` int(4) NOT NULL DEFAULT '0',
	`stock_status_id` int(11) NOT NULL,
	`image` varchar(255) DEFAULT NULL,
	`manufacturer_id` int(11) NOT NULL,
	`shipping` tinyint(1) NOT NULL DEFAULT '1',
	`price` decimal(15,4) NOT NULL DEFAULT '0.0000',
	`points` int(8) NOT NULL DEFAULT '0',
	`tax_class_id` int(11) NOT NULL,
	`date_available` date NOT NULL,
	`weight` decimal(15,8) NOT NULL DEFAULT '0.00000000',
	`weight_class_id` int(11) NOT NULL DEFAULT '0',
	`length` decimal(15,8) NOT NULL DEFAULT '0.00000000',
	`width` decimal(15,8) NOT NULL DEFAULT '0.00000000',
	`height` decimal(15,8) NOT NULL DEFAULT '0.00000000',
	`length_class_id` int(11) NOT NULL DEFAULT '0',
	`subtract` tinyint(1) NOT NULL DEFAULT '1',
	`minimum` int(11) NOT NULL DEFAULT '1',
	`sort_order` int(11) NOT NULL DEFAULT '0',
	`status` tinyint(1) NOT NULL DEFAULT '0',
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`viewed` int(5) NOT NULL DEFAULT '0',
	PRIMARY KEY (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `product`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_product (product_id,model,sku,upc,ean,jan,isbn,mpn,location,quantity,stock_status_id,image,manufacturer_id,shipping,price,points,tax_class_id,date_available,weight,weight_class_id,length,width,height,length_class_id,subtract,minimum,sort_order,status,date_added,date_modified,viewed)";
	$sql .= "VALUES (:product_id,:model,:sku,:upc,:ean,:jan,:isbn,:mpn,:location,:quantity,:stock_status_id,:image,:manufacturer_id,:shipping,:price,:points,:tax_class_id,:date_available,:weight,:weight_class_id,:length,:width,:height,:length_class_id,:subtract,:minimum,:sort_order,:status,:date_added,:date_modified,:viewed)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_id' => $row['product_id'],
		':model' => $row['model'],
		':sku' => $row['sku'],
		':upc' => '',
		':ean' => '',
		':jan' => '',
		':isbn' => '',
		':mpn' => '',
		':location' => $row['location'],
		':quantity' => $row['quantity'],
		':stock_status_id' => $row['stock_status_id'],
		':image' => $row['image'],
		':manufacturer_id' => $row['manufacturer_id'],
		':shipping' => $row['shipping'],
		':price' => $row['price'],
		':points' => '',
		':tax_class_id' => $row['tax_class_id'],
		':date_available' => $row['date_available'],
		':weight' => $row['weight'],
		':weight_class_id' => $row['weight_class_id'],
		':length' => $row['length'],
		':width' => $row['width'],
		':height' => $row['height'],
		':length_class_id' => $row['length_class_id'],
		':subtract' => $row['subtract'],
		':minimum' => $row['minimum'],
		':sort_order' => $row['sort_order'],
		':status' => $row['status'],
		':date_added' => $row['date_added'],
		':date_modified' => $row['date_modified'],
		':viewed' => $row['viewed'],
	));
}
		
echo 'Product Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Fill in UPC, EAN, JAN, ISBN, MPN, Points';
echo '<br />';
echo '<b>TODO:</b> Put Measurement Class ID, Cost, Vendor ID, Size, Color, Production Condition somewhere else';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_description`;
CREATE TABLE IF NOT EXISTS `v155_product_description` (
  `product_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  `tag` text NOT NULL,
  PRIMARY KEY (`product_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `product_description`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_product_description (product_id,language_id,name,description,meta_description,meta_keyword,tag)";
	$sql .= "VALUES (:product_id,:language_id,:name,:description,:meta_description,:meta_keyword,:tag)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_id' => $row['product_id'],
		':language_id' => $row['language_id'],
		':name' => $row['name'],
		':description' => $row['description'],
		':meta_description' => $row['meta_description'],
		':meta_keyword' => $row['meta_keywords'],
		':tag' => '',
	));
}

echo 'Product Description Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Fill in Tag';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_discount`;
CREATE TABLE IF NOT EXISTS `v155_product_discount` (
  `product_discount_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`product_discount_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `product_discount`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_product_discount (product_discount_id,product_id,customer_group_id,quantity,priority,price,date_start,date_end)";
	$sql .= "VALUES (:product_discount_id,:product_id,:customer_group_id,:quantity,:priority,:price,:date_start,:date_end)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_discount_id' => $row['product_discount_id'],
		':product_id' => $row['product_id'],
		':customer_group_id' => $row['customer_group_id'],
		':quantity' => $row['quantity'],
		':priority' => $row['priority'],
		':price' => $row['price'],
		':date_start' => $row['date_start'],
		':date_end' => $row['date_end'],
	));
}

echo 'Product Discount Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_image`;
CREATE TABLE IF NOT EXISTS `v155_product_image` (
  `product_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `product_image`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_product_image (product_image_id,product_id,image,sort_order)";
	$sql .= "VALUES (:product_image_id,:product_id,:image,:sort_order)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_image_id' => $row['product_image_id'],
		':product_id' => $row['product_id'],
		':image' => $row['image'],
		':sort_order' => '',
	));
}

echo 'Product Image Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Fill in Sort Order';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_notes`;
CREATE TABLE IF NOT EXISTS `v155_product_notes` (
  `product_id` int(11) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `product_notes`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_product_notes (product_id,note)";
	$sql .= "VALUES (:product_id,:note)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_id' => $row['product_id'],
		':note' => $row['note'],
	));
}

echo 'Product Notes Rows Done.';
echo '<br />';

echo '<b>TODO:</b> This was a customization. Maybe something else?';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_option`;
CREATE TABLE IF NOT EXISTS `v155_product_option` (
  `product_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value` text NOT NULL,
  `required` tinyint(1) NOT NULL,
  PRIMARY KEY (`product_option_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `product_option`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_product_option (product_option_id,product_id,option_id,option_value,required)";
	$sql .= "VALUES (:product_option_id,:product_id,:option_id,:option_value,:required)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_option_id' => $row['product_option_id'],
		':product_id' => $row['product_id'],
		':option_id' => '',
		':option_value' => '',
		':required' => '',
	));
}

echo 'Product Option Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Fill in Option ID, Option Value, Required';
echo '<br />';
echo '<b>TODO:</b> Put Sort Order somewhere else';
echo '<br />';