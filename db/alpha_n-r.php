<?php

$create = "DROP TABLE IF EXISTS `v155_option`;
CREATE TABLE IF NOT EXISTS `v155_option` (
	`option_id` int(11) NOT NULL AUTO_INCREMENT,
	`type` varchar(32) NOT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`option_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_option` (`option_id`, `type`, `sort_order`) VALUES
	(1, 'radio', 2),
	(2, 'checkbox', 3),
	(4, 'text', 4),
	(5, 'select', 1),
	(6, 'textarea', 5),
	(7, 'file', 6),
	(8, 'date', 7),
	(9, 'time', 8),
	(10, 'datetime', 9),
	(11, 'select', 1),
	(12, 'date', 1);";
$pdo->query($insert);

echo 'Option Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_option_description`;
CREATE TABLE IF NOT EXISTS `v155_option_description` (
	`option_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`name` varchar(128) NOT NULL,
	PRIMARY KEY (`option_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_option_description` (`option_id`, `language_id`, `name`) VALUES
	(1, 1, 'Radio'),
	(2, 1, 'Checkbox'),
	(4, 1, 'Text'),
	(6, 1, 'Textarea'),
	(8, 1, 'Date'),
	(7, 1, 'File'),
	(5, 1, 'Select'),
	(9, 1, 'Time'),
	(10, 1, 'Date &amp; Time'),
	(12, 1, 'Delivery Date'),
	(11, 1, 'Size');";
$pdo->query($insert);

echo 'Option Description Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_option_value`;
CREATE TABLE IF NOT EXISTS `v155_option_value` (
	`option_value_id` int(11) NOT NULL AUTO_INCREMENT,
	`option_id` int(11) NOT NULL,
	`image` varchar(255) NOT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`option_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_option_value` (`option_value_id`, `option_id`, `image`, `sort_order`) VALUES
	(43, 1, '', 3),
	(32, 1, '', 1),
	(45, 2, '', 4),
	(44, 2, '', 3),
	(42, 5, '', 4),
	(41, 5, '', 3),
	(39, 5, '', 1),
	(40, 5, '', 2),
	(31, 1, '', 2),
	(23, 2, '', 1),
	(24, 2, '', 2),
	(46, 11, '', 1),
	(47, 11, '', 2),
	(48, 11, '', 3);";
$pdo->query($insert);

echo 'Option Value Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_option_value_description`;
CREATE TABLE IF NOT EXISTS `v155_option_value_description` (
	`option_value_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`option_id` int(11) NOT NULL,
	`name` varchar(128) NOT NULL,
	PRIMARY KEY (`option_value_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_option_value_description` (`option_value_id`, `language_id`, `option_id`, `name`) VALUES
	(43, 1, 1, 'Large'),
	(32, 1, 1, 'Small'),
	(45, 1, 2, 'Checkbox 4'),
	(44, 1, 2, 'Checkbox 3'),
	(31, 1, 1, 'Medium'),
	(42, 1, 5, 'Yellow'),
	(41, 1, 5, 'Green'),
	(39, 1, 5, 'Red'),
	(40, 1, 5, 'Blue'),
	(23, 1, 2, 'Checkbox 1'),
	(24, 1, 2, 'Checkbox 2'),
	(48, 1, 11, 'Large'),
	(47, 1, 11, 'Medium'),
	(46, 1, 11, 'Small');";
$pdo->query($insert);

echo 'Option Value Description Rows Done.';
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