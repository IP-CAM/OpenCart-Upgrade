<?php

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