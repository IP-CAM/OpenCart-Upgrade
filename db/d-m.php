<?php

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
