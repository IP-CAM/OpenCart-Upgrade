<?php

echo '**** Empty Row Creation';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_affiliate`;
CREATE TABLE IF NOT EXISTS `v155_affiliate` (
	`affiliate_id` int(11) NOT NULL AUTO_INCREMENT,
	`firstname` varchar(32) NOT NULL,
	`lastname` varchar(32) NOT NULL,
	`email` varchar(96) NOT NULL,
	`telephone` varchar(32) NOT NULL,
	`fax` varchar(32) NOT NULL,
	`password` varchar(40) NOT NULL,
	`salt` varchar(9) NOT NULL,
	`company` varchar(32) NOT NULL,
	`website` varchar(255) NOT NULL,
	`address_1` varchar(128) NOT NULL,
	`address_2` varchar(128) NOT NULL,
	`city` varchar(128) NOT NULL,
	`postcode` varchar(10) NOT NULL,
	`country_id` int(11) NOT NULL,
	`zone_id` int(11) NOT NULL,
	`code` varchar(64) NOT NULL,
	`commission` decimal(4,2) NOT NULL DEFAULT '0.00',
	`tax` varchar(64) NOT NULL,
	`payment` varchar(6) NOT NULL,
	`cheque` varchar(100) NOT NULL,
	`paypal` varchar(64) NOT NULL,
	`bank_name` varchar(64) NOT NULL,
	`bank_branch_number` varchar(64) NOT NULL,
	`bank_swift_code` varchar(64) NOT NULL,
	`bank_account_name` varchar(64) NOT NULL,
	`bank_account_number` varchar(64) NOT NULL,
	`ip` varchar(40) NOT NULL,
	`status` tinyint(1) NOT NULL,
	`approved` tinyint(1) NOT NULL,
	`date_added` datetime NOT NULL,
	PRIMARY KEY (`affiliate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Affiliate Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_affiliate_transaction`;
CREATE TABLE IF NOT EXISTS `v155_affiliate_transaction` (
	`affiliate_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
	`affiliate_id` int(11) NOT NULL,
	`order_id` int(11) NOT NULL,
	`description` text NOT NULL,
	`amount` decimal(15,4) NOT NULL,
	`date_added` datetime NOT NULL,
	PRIMARY KEY (`affiliate_transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Affiliate Transaction Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_attribute`;
CREATE TABLE IF NOT EXISTS `v155_attribute` (
	`attribute_id` int(11) NOT NULL AUTO_INCREMENT,
	`attribute_group_id` int(11) NOT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`attribute_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Attribute Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_attribute_description`;
CREATE TABLE IF NOT EXISTS `v155_attribute_description` (
	`attribute_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`name` varchar(64) NOT NULL,
	PRIMARY KEY (`attribute_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Attribute Description Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_attribute_group`;
CREATE TABLE IF NOT EXISTS `v155_attribute_group` (
	`attribute_group_id` int(11) NOT NULL AUTO_INCREMENT,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`attribute_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Attribute Group Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_attribute_group_description`;
CREATE TABLE IF NOT EXISTS `v155_attribute_group_description` (
	`attribute_group_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`name` varchar(64) NOT NULL,
	PRIMARY KEY (`attribute_group_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Attribute Group Description Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_coupon_category`;
CREATE TABLE IF NOT EXISTS `v155_coupon_category` (
	`coupon_id` int(11) NOT NULL,
	`category_id` int(11) NOT NULL,
	PRIMARY KEY (`coupon_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Coupon Category Rows Done.';
echo '<br />';

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

echo 'Coupon History Rows Done.';
echo '<br />';