<?php

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
		':points' => 0,
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

$create = "DROP TABLE IF EXISTS `v155_product_attribute`;
CREATE TABLE IF NOT EXISTS `v155_product_attribute` (
	`product_id` int(11) NOT NULL,
	`attribute_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`text` text NOT NULL,
	PRIMARY KEY (`product_id`,`attribute_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `product`');
foreach($rows as $row) {
	if ($row['size']) {
		$data[] = array(
			'product' => $row['product_id'],
			'attribute' => 1,
			'text' => $row['size'],
		);
	}
	if ($row['color']) {
		$data[] = array(
			'product' => $row['product_id'],
			'attribute' => 2,
			'text' => $row['color'],
		);
	}
	if ($row['product_condition']) {
		$data[] = array(
			'product' => $row['product_id'],
			'attribute' => 3,
			'text' => $row['product_condition'],
		);
	}
}

foreach ($data as $data) {
	$sql  = "INSERT INTO v155_product_attribute (product_id,attribute_id,language_id,text)";
	$sql .= "VALUES (:product_id,:attribute_id,:language_id,:text)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_id' => $data['product'],
		':attribute_id' => $data['attribute'],
		':language_id' => 1,
		':text' => $data['text'],
	));
}

echo 'Product Attribute Rows Done.';
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
		':sort_order' => 0,
	));
}

echo 'Product Image Rows Done.';
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

$select = 'SELECT * FROM `product_option`
	JOIN product_option_description on product_option.product_option_id = product_option_description.product_option_id';
$rows = $pdo->query($select);
foreach($rows as $row) {
	$sql  = "SELECT option_id FROM v155_option_description
		WHERE LOWER(name) = :name";
	$select = $pdo->prepare($sql);
	$select->execute(array(':name' => strtolower($row['name'])));
	$optionId = $select->fetchColumn();

	$sql  = "INSERT INTO v155_product_option (product_option_id,product_id,option_id,option_value,required)";
	$sql .= "VALUES (:product_option_id,:product_id,:option_id,:option_value,:required)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_option_id' => $row['product_option_id'],
		':product_id' => $row['product_id'],
		':option_id' => $optionId,
		':option_value' => '',
		':required' => 1,
	));
}

echo 'Product Option Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_option_value`;
CREATE TABLE IF NOT EXISTS `v155_product_option_value` (
	`product_option_value_id` int(11) NOT NULL AUTO_INCREMENT,
	`product_option_id` int(11) NOT NULL,
	`product_id` int(11) NOT NULL,
	`option_id` int(11) NOT NULL,
	`option_value_id` int(11) NOT NULL,
	`quantity` int(3) NOT NULL,
	`subtract` tinyint(1) NOT NULL,
	`price` decimal(15,4) NOT NULL,
	`price_prefix` varchar(1) NOT NULL,
	`points` int(8) NOT NULL,
	`points_prefix` varchar(1) NOT NULL,
	`weight` decimal(15,8) NOT NULL,
	`weight_prefix` varchar(1) NOT NULL,
	PRIMARY KEY (`product_option_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `product_option_value`');
foreach($rows as $row) {
	$sql  = "SELECT
		LOWER(product_option_value_description.name) AS value_name,
		LOWER(product_option_description.name) AS option_name
		FROM product_option_value_description
		JOIN product_option_value ON product_option_value_description.product_option_value_id = product_option_value.product_option_value_id
		JOIN product_option_description ON product_option_value.product_option_id = product_option_description.product_option_id
		WHERE product_option_value_description.product_option_value_id = :product_option_value_id";
	$select = $pdo->prepare($sql);
	$select->execute(array(':product_option_value_id' => $row['product_option_value_id']));
	$values = $select->fetch();

	$sql  = "SELECT v155_option_value.option_value_id AS value_id, v155_option_value.option_id AS option_id
		FROM v155_option_description
		JOIN v155_option_value ON v155_option_description.option_id = v155_option_value.option_id
		JOIN v155_option_value_description ON v155_option_value.option_value_id = v155_option_value_description.option_value_id
		WHERE v155_option_value_description.name = :value_name
		AND v155_option_description.name = :option_name";
	$select = $pdo->prepare($sql);
	$select->execute(array(
		':value_name' => $values['value_name'],
		':option_name' => $values['option_name'],
	));
	$optionIDs = $select->fetch();

	$sql  = "INSERT INTO v155_product_option_value (product_option_value_id,product_option_id,product_id,option_id,option_value_id,quantity,subtract,price,price_prefix,points,points_prefix,weight,weight_prefix)";
	$sql .= "VALUES (:product_option_value_id,:product_option_id,:product_id,:option_id,:option_value_id,:quantity,:subtract,:price,:price_prefix,:points,:points_prefix,:weight,:weight_prefix)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_option_value_id' => $row['product_option_value_id'],
		':product_option_id' => $row['product_option_id'],
		':product_id' => $row['product_id'],
		':option_id' => $optionIDs['option_id'],
		':option_value_id' => $optionIDs['value_id'],
		':quantity' => $row['quantity'],
		':subtract' => $row['subtract'],
		':price' => $row['price'],
		':price_prefix' => $row['prefix'],
		':points' => 0,
		':points_prefix' => '',
		':weight' => 0,
		':weight_prefix' => '',
	));
}

echo 'Product Option Value Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_related`;
CREATE TABLE IF NOT EXISTS `v155_product_related` (
	`product_id` int(11) NOT NULL,
	`related_id` int(11) NOT NULL,
	PRIMARY KEY (`product_id`,`related_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `product_related`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_product_related (product_id,related_id)";
	$sql .= "VALUES (:product_id,:related_id)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_id' => $row['product_id'],
		':related_id' => $row['related_id'],
	));
}

echo 'Product Related Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_special`;
CREATE TABLE IF NOT EXISTS `v155_product_special` (
	`product_special_id` int(11) NOT NULL AUTO_INCREMENT,
	`product_id` int(11) NOT NULL,
	`customer_group_id` int(11) NOT NULL,
	`priority` int(5) NOT NULL DEFAULT '1',
	`price` decimal(15,4) NOT NULL DEFAULT '0.0000',
	`date_start` date NOT NULL DEFAULT '0000-00-00',
	`date_end` date NOT NULL DEFAULT '0000-00-00',
	PRIMARY KEY (`product_special_id`),
	KEY `product_id` (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `product_special`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_product_special (product_special_id,product_id,customer_group_id,priority,price,date_start,date_end)";
	$sql .= "VALUES (:product_special_id,:product_id,:customer_group_id,:priority,:price,:date_start,:date_end)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_special_id' => $row['product_special_id'],
		':product_id' => $row['product_id'],
		':customer_group_id' => $row['customer_group_id'],
		':priority' => $row['priority'],
		':price' => $row['price'],
		':date_start' => $row['date_start'],
		':date_end' => $row['date_end'],
	));
}

echo 'Product Special Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_to_category`;
CREATE TABLE IF NOT EXISTS `v155_product_to_category` (
	`product_id` int(11) NOT NULL,
	`category_id` int(11) NOT NULL,
	PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `product_to_category`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_product_to_category (product_id,category_id)";
	$sql .= "VALUES (:product_id,:category_id)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_id' => $row['product_id'],
		':category_id' => $row['category_id'],
	));
}

echo 'Product To Categories Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_to_store`;
CREATE TABLE IF NOT EXISTS `v155_product_to_store` (
	`product_id` int(11) NOT NULL,
	`store_id` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`product_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `product_to_store`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_product_to_store (product_id,store_id)";
	$sql .= "VALUES (:product_id,:store_id)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_id' => $row['product_id'],
		':store_id' => $row['store_id'],
	));
}

echo 'Product To Store Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_return_action`;
CREATE TABLE IF NOT EXISTS `v155_return_action` (
	`return_action_id` int(11) NOT NULL AUTO_INCREMENT,
	`language_id` int(11) NOT NULL DEFAULT '0',
	`name` varchar(64) NOT NULL,
	PRIMARY KEY (`return_action_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_return_action` (`return_action_id`, `language_id`, `name`) VALUES
	(1, 1, 'Refunded'),
	(2, 1, 'Credit Issued'),
	(3, 1, 'Replacement Sent');";
$pdo->query($insert);

echo 'Return Action Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_return_reason`;
CREATE TABLE IF NOT EXISTS `v155_return_reason` (
	`return_reason_id` int(11) NOT NULL AUTO_INCREMENT,
	`language_id` int(11) NOT NULL DEFAULT '0',
	`name` varchar(128) NOT NULL,
	PRIMARY KEY (`return_reason_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_return_reason` (`return_reason_id`, `language_id`, `name`) VALUES
	(1, 1, 'Dead On Arrival'),
	(2, 1, 'Received Wrong Item'),
	(3, 1, 'Order Error'),
	(4, 1, 'Faulty, please supply details'),
	(5, 1, 'Other, please supply details');";
$pdo->query($insert);

echo 'Return Reason Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_return_status`;
CREATE TABLE IF NOT EXISTS `v155_return_status` (
	`return_status_id` int(11) NOT NULL AUTO_INCREMENT,
	`language_id` int(11) NOT NULL DEFAULT '0',
	`name` varchar(32) NOT NULL,
	PRIMARY KEY (`return_status_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_return_status` (`return_status_id`, `language_id`, `name`) VALUES
	(1, 1, 'Pending'),
	(3, 1, 'Complete'),
	(2, 1, 'Awaiting Products');";
$pdo->query($insert);

echo 'Return Status Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_review`;
CREATE TABLE IF NOT EXISTS `v155_review` (
	`review_id` int(11) NOT NULL AUTO_INCREMENT,
	`product_id` int(11) NOT NULL,
	`customer_id` int(11) NOT NULL,
	`author` varchar(64) NOT NULL,
	`text` text NOT NULL,
	`rating` int(1) NOT NULL,
	`status` tinyint(1) NOT NULL DEFAULT '0',
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`review_id`),
	KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `review`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_review (review_id,product_id,customer_id,author,text,rating,status,date_added,date_modified)";
	$sql .= "VALUES (:review_id,:product_id,:customer_id,:author,:text,:rating,:status,:date_added,:date_modified)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':review_id' => $row['review_id'],
		':product_id' => $row['product_id'],
		':customer_id' => $row['customer_id'],
		':author' => $row['author'],
		':text' => $row['text'],
		':rating' => $row['rating'],
		':status' => $row['status'],
		':date_added' => $row['date_added'],
		':date_modified' => $row['date_modified'],
	));
}

echo 'Review Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_setting`;
CREATE TABLE IF NOT EXISTS `v155_setting` (
	`setting_id` int(11) NOT NULL AUTO_INCREMENT,
	`store_id` int(11) NOT NULL DEFAULT '0',
	`group` varchar(32) NOT NULL,
	`key` varchar(64) NOT NULL,
	`value` text NOT NULL,
	`serialized` tinyint(1) NOT NULL,
	PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `setting`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_setting (setting_id,store_id,`group`,`key`,value,serialized)";
	$sql .= "VALUES (:setting_id,:store_id,:group,:key,:value,:serialized)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':setting_id' => $row['setting_id'],
		':store_id' => 0,
		':group' => $row['group'],
		':key' => $row['key'],
		':value' => $row['value'],
		':serialized' => 0,
	));
}

$rows = $pdo->query('SELECT * FROM store WHERE store_id = 2');
foreach($rows as $row) {
	$skip = array('store_id');
	foreach($row as $key => $value) {
		if ($key == 'store_id') continue;
		if (is_int($key)) continue;

		$sql  = "INSERT INTO v155_setting (store_id,`group`,`key`,value,serialized)";
		$sql .= "VALUES (:store_id,:group,:key,:value,:serialized)";
		$q = $pdo->prepare($sql);
		$q->execute(array(
			':store_id' => 2,
			':group' => 'config',
			':key' => 'config_' . $key,
			':value' => $value,
			':serialized' => 0,
		));
	}
}

echo 'Setting Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_stock_status`;
CREATE TABLE IF NOT EXISTS `v155_stock_status` (
	`stock_status_id` int(11) NOT NULL AUTO_INCREMENT,
	`language_id` int(11) NOT NULL,
	`name` varchar(32) NOT NULL,
	PRIMARY KEY (`stock_status_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_stock_status` (`stock_status_id`, `language_id`, `name`) VALUES
	(7, 1, 'In Stock'),
	(5, 1, 'Out Of Stock'),
	(6, 1, '2 - 3 Days'),
	(9, 1, 'Orderable');";
$pdo->query($insert);

echo 'Stock Status Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_store`;
CREATE TABLE IF NOT EXISTS `v155_store` (
	`store_id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(64) NOT NULL,
	`url` varchar(255) NOT NULL,
	`ssl` varchar(255) NOT NULL,
	PRIMARY KEY (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM `store`');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_store (store_id,name,url,`ssl`)";
	$sql .= "VALUES (:store_id,:name,:url,:ssl)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':store_id' => $row['store_id'],
		':name' => $row['name'],
		':url' => $row['url'],
		':ssl' => $row['ssl'],
	));
}

echo 'Store Rows Done.';
echo '<br />';