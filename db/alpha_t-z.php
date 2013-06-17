<?php

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
	(1, 9, 71, 'shipping', 0);";
$pdo->query($insert);

echo 'Tax Rule Rows Done.';
echo '<br />';