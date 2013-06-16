<?php

$options = array();
$rows = $pdo->query('SELECT DISTINCT LOWER(name) AS name FROM `product_option_description`');
foreach($rows as $row) {
	$name = $row['name'];
	$options[] = array('lower' => $name, 'name' => ucwords($name));
}

$create = "DROP TABLE IF EXISTS `v155_option`;
CREATE TABLE IF NOT EXISTS `v155_option` (
	`option_id` int(11) NOT NULL AUTO_INCREMENT,
	`type` varchar(32) NOT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`option_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

foreach($options as $index => $option) {
	$sql  = "INSERT INTO v155_option (option_id,type,sort_order)";
	$sql .= "VALUES (:option_id,:type,:sort_order)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':option_id' => $index + 1,
		':type' => 'select',
		':sort_order' => 0,
	));
}

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

foreach($options as $index => $option) {
	$sql  = "INSERT INTO v155_option_description (option_id,language_id,name)";
	$sql .= "VALUES (:option_id,:language_id,:name)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':option_id' => $index + 1,
		':language_id' => 1,
		':name' => $option['name'],
	));
}

echo 'Option Description Rows Done.';
echo '<br />';

$sql = 'SELECT DISTINCT
	LOWER(product_option_value_description.name) AS value,
	LOWER(product_option_description.name) AS name,
	MIN(product_option_value.sort_order) AS sort
	FROM product_option_value_description
	JOIN product_option_value ON product_option_value_description.product_option_value_id=product_option_value.product_option_value_id
	JOIN product_option_description ON product_option_value.product_option_id=product_option_description.product_option_id
	GROUP BY value,name;';
$rows = $pdo->query($sql);

$create = "DROP TABLE IF EXISTS `v155_option_value`;
CREATE TABLE IF NOT EXISTS `v155_option_value` (
	`option_value_id` int(11) NOT NULL AUTO_INCREMENT,
	`option_id` int(11) NOT NULL,
	`image` varchar(255) NOT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`option_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$create = "DROP TABLE IF EXISTS `v155_option_value_description`;
CREATE TABLE IF NOT EXISTS `v155_option_value_description` (
	`option_value_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`option_id` int(11) NOT NULL,
	`name` varchar(128) NOT NULL,
	PRIMARY KEY (`option_value_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

foreach($rows as $index => $row) {
	$key = 0;
	foreach($options as $i => $option) {
		if ($option['lower'] == $row['name']) {
			$key = $i;
			break;
		}
	}

	$sql  = "INSERT INTO v155_option_value (option_id,image,sort_order)";
	$sql .= "VALUES (:option_id,:image,:sort_order)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':option_id' => $key + 1,
		':image' => '',
		':sort_order' => $row['sort'],
	));
	$id = $pdo->lastInsertId();

	$sql  = "INSERT INTO v155_option_value_description (option_value_id,language_id,option_id,name)";
	$sql .= "VALUES (:option_value_id,:language_id,:option_id,:name)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':option_value_id' => $id,
		':language_id' => 1,
		':option_id' => $key + 1,
		':name' => ucwords($row['value']),
	));
}

echo 'Option Value Rows Done.';
echo '<br />';

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
	$sql  = "SELECT product_option_id FROM product_option_value ";
	$sql .= "WHERE product_option_value_id = :product_option_value_id";
	$select = $pdo->prepare($sql);
	$select->execute(array(':product_option_value_id' => $row['product_option_value_id']));
	$value = $select->fetchColumn();

	$sql  = "INSERT INTO v155_order_option (order_option_id,order_id,order_product_id,product_option_id,product_option_value_id,name,value,type)";
	$sql .= "VALUES (:order_option_id,:order_id,:order_product_id,:product_option_id,:product_option_value_id,:name,:value,:type)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':order_option_id' => $row['order_option_id'],
		':order_id' => $row['order_id'],
		':order_product_id' => $row['order_product_id'],
		':product_option_id' => $value,
		':product_option_value_id' => $row['product_option_value_id'],
		':name' => $row['name'],
		':value' => $row['value'],
		':type' => 'select',
	));
}

echo 'Order Option Rows Done.';
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
		':reward' => 0,
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