<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../config.php';
$pdo = new PDO('mysql:host='.DB_HOSTNAME.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD, array(
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
));

require_once './db/country.php';
require_once './db/zone.php';
require_once './db/extensions.php';

require_once './db/alpha_a-c.php';
require_once './db/alpha_d-m.php';
require_once './db/alpha_n-o.php';
require_once './db/alpha_p-s.php';

require_once './db/custom.php';
require_once './db/emptyTables.php';

echo '<b>TODO:</b> The Store Description table should go somewhere.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_tax_class`;
CREATE TABLE IF NOT EXISTS `v155_tax_class` (
	`tax_class_id` int(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(32) NOT NULL,
	`description` varchar(255) NOT NULL,
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`tax_class_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_tax_class` (`tax_class_id`, `title`, `description`, `date_added`, `date_modified`) VALUES
(9, 'Taxable Goods', 'Taxed Stuff', '2009-01-06 23:21:53', '2010-11-12 08:16:37'),
(10, 'Non-taxable', 'Non-taxable Goods', '2010-01-05 13:26:19', '2010-01-05 13:26:27');";
$pdo->query($insert);

echo 'Tax Class Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_tax_rate`;
CREATE TABLE IF NOT EXISTS `v155_tax_rate` (
	`tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
	`geo_zone_id` int(11) NOT NULL DEFAULT '0',
	`name` varchar(32) NOT NULL,
	`rate` decimal(15,4) NOT NULL DEFAULT '0.0000',
	`type` char(1) NOT NULL,
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`tax_rate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_tax_rate` (`tax_rate_id`, `geo_zone_id`, `name`, `rate`, `type`, `date_added`, `date_modified`) VALUES
	(71, 7, 'MN Sales Tax', 7.6250, 'P', '0000-00-00 00:00:00', '2010-11-12 08:16:37');";
$pdo->query($insert);

echo 'Tax Rate Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_tax_rate_to_customer_group`;
CREATE TABLE IF NOT EXISTS `v155_tax_rate_to_customer_group` (
	`tax_rate_id` int(11) NOT NULL,
	`customer_group_id` int(11) NOT NULL,
	PRIMARY KEY (`tax_rate_id`,`customer_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `customer_group`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_tax_rate_to_customer_group (tax_rate_id,customer_group_id)";
	$sql .= "VALUES (:tax_rate_id,:customer_group_id)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':tax_rate_id' => 71,
		':customer_group_id' => $row['customer_group_id'],
	));
}

echo 'Tax Rate To Customer Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_tax_rule`;
CREATE TABLE IF NOT EXISTS `v155_tax_rule` (
	`tax_rule_id` int(11) NOT NULL AUTO_INCREMENT,
	`tax_class_id` int(11) NOT NULL,
	`tax_rate_id` int(11) NOT NULL,
	`based` varchar(10) NOT NULL,
	`priority` int(5) NOT NULL DEFAULT '1',
	PRIMARY KEY (`tax_rule_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_tax_rule` (`tax_rule_id`, `tax_class_id`, `tax_rate_id`, `based`, `priority`) VALUES
	(1, 9, 71, 'store', 0);";
$pdo->query($insert);

echo 'Tax Rule Rows Done.';
echo '<br />';

echo '<b>TODO</b> I think this should always be shipping based.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_url_alias`;
CREATE TABLE IF NOT EXISTS `v155_url_alias` (
	`url_alias_id` int(11) NOT NULL AUTO_INCREMENT,
	`query` varchar(255) NOT NULL,
	`keyword` varchar(255) NOT NULL,
	PRIMARY KEY (`url_alias_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `url_alias`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_url_alias (url_alias_id,query,keyword)";
	$sql .= "VALUES (:url_alias_id,:query,:keyword)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':url_alias_id' => $row['url_alias_id'],
		':query' => $row['query'],
		':keyword' => $row['keyword'],
	));
}

echo 'URL Alias Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_user`;
CREATE TABLE IF NOT EXISTS `v155_user` (
	`user_id` int(11) NOT NULL AUTO_INCREMENT,
	`user_group_id` int(11) NOT NULL,
	`username` varchar(20) NOT NULL,
	`password` varchar(40) NOT NULL,
	`salt` varchar(9) NOT NULL,
	`firstname` varchar(32) NOT NULL,
	`lastname` varchar(32) NOT NULL,
	`email` varchar(96) NOT NULL,
	`code` varchar(40) NOT NULL,
	`ip` varchar(40) NOT NULL,
	`status` tinyint(1) NOT NULL,
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `user`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_user (user_id,user_group_id,username,password,salt,firstname,lastname,email,code,ip,status,date_added)";
	$sql .= "VALUES (:user_id,:user_group_id,:username,:password,:salt,:firstname,:lastname,:email,:code,:ip,:status,:date_added)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':user_id' => $row['user_id'],
		':user_group_id' => $row['user_group_id'],
		':username' => $row['username'],
		':password' => $row['password'],
		':salt' => '',
		':firstname' => $row['firstname'],
		':lastname' => $row['lastname'],
		':email' => $row['email'],
		':code' => '',
		':ip' => $row['ip'],
		':status' => $row['status'],
		':date_added' => $row['date_added'],
	));
}

echo 'User Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Make sure I can login.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_user_group`;
CREATE TABLE IF NOT EXISTS `v155_user_group` (
	`user_group_id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(64) NOT NULL,
	`permission` text NOT NULL,
	PRIMARY KEY (`user_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `user_group`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_user_group (user_group_id,name,permission)";
	$sql .= "VALUES (:user_group_id,:name,:permission)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':user_group_id' => $row['user_group_id'],
		':name' => $row['name'],
		':permission' => $row['permission'],
	));
}

echo 'User Group Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_vendor`;
CREATE TABLE IF NOT EXISTS `v155_vendor` (
	`vendor_id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(64) NOT NULL,
	`image` varchar(255) DEFAULT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`vendor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `vendor`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_vendor (vendor_id,name,image,sort_order)";
	$sql .= "VALUES (:vendor_id,:name,:image,:sort_order)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':vendor_id' => $row['vendor_id'],
		':name' => $row['name'],
		':image' => $row['image'],
		':sort_order' => $row['sort_order']
	));
}

echo 'Vendor Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_weight_class`;
CREATE TABLE IF NOT EXISTS `v155_weight_class` (
	`weight_class_id` int(11) NOT NULL AUTO_INCREMENT,
	`value` decimal(15,8) NOT NULL DEFAULT '0.00000000',
	PRIMARY KEY (`weight_class_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `weight_class` (`weight_class_id`, `value`) VALUES
	(1, 1.00000000),
	(2, 1000.00000000),
	(5, 2.20460000),
	(6, 35.27400000);";

echo 'Weight Class Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_weight_class_description`;
CREATE TABLE IF NOT EXISTS `v155_weight_class_description` (
	`weight_class_id` int(11) NOT NULL AUTO_INCREMENT,
	`language_id` int(11) NOT NULL,
	`title` varchar(32) NOT NULL,
	`unit` varchar(4) NOT NULL,
	PRIMARY KEY (`weight_class_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_weight_class_description` (`weight_class_id`, `language_id`, `title`, `unit`) VALUES
	(1, 1, 'Kilogram', 'kg'),
	(2, 1, 'Gram', 'g'),
	(5, 1, 'Pound ', 'lb'),
	(6, 1, 'Ounce', 'oz');";
$pdo->query($insert);

echo 'Weight Class Description Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Make sure only allowed Weight Classes are used.';
echo '<br />';

$create = "CREATE TABLE IF NOT EXISTS `zone_to_geo_zone` (
  `zone_to_geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL DEFAULT '0',
  `geo_zone_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`zone_to_geo_zone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo '<b>TODO:</b> Fill In Data for Zone To Geo Zone.';
echo '<br />';

echo '<b>TODO:</b> Move Category Images Around.';
echo '<br />';

echo '<b>TODO:</b> Move Product Images Around.';
echo '<br />';