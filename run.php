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
require_once './db/alpha_n-r.php';

require_once './db/emptyTables.php';


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

$rows = $pdo->query('SELECT * FROM `product_option_description`');
foreach($rows as $row) {
	//`product_option_id`, `language_id`, `product_id`, `name`
	break;
}

echo '<b>TODO:</b> Put Product Option Description table someplace';
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
	$sql  = "INSERT INTO v155_product_option_value (product_option_value_id,product_option_id,product_id,option_id,option_value_id,quantity,subtract,price,price_prefix,points,points_prefix,weight,weight_prefix)";
	$sql .= "VALUES (:product_option_value_id,:product_option_id,:product_id,:option_id,:option_value_id,:quantity,:subtract,:price,:price_prefix,:points,:points_prefix,:weight,:weight_prefix)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_option_value_id' => $row['product_option_value_id'],
		':product_option_id' => $row['product_option_id'],
		':product_id' => $row['product_id'],
		':option_id' => '',
		':option_value_id' => '',
		':quantity' => $row['quantity'],
		':subtract' => $row['subtract'],
		':price' => $row['price'],
		':price_prefix' => $row['prefix'],
		':points' => '',
		':points_prefix' => '',
		':weight' => '',
		':weight_prefix' => '',
	));
}

echo 'Product Option Value Rows Done.';
echo '<br />';

echo '<b>TODO:</b> Fill in Option ID, Option Value ID, Points, Points Prefix, Weight, Weight Prefix';
echo '<br />';
echo '<b>TODO:</b> Put Sort Order somewhere else';
echo '<br />';

$rows = $pdo->query('SELECT * FROM `product_option_value_description`');
foreach($rows as $row) {
	//`product_option_value_id`, `language_id`, `product_id`, `name`
	break;
}

echo '<b>TODO:</b> Put Product Option Value Description table someplace';
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

echo 'Product Tags Aren\'t a Thing We Use. Ignore Table';
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

echo '<b>TODO:</b> Do something with the Settings table. It is probably important.';
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

echo 'Stock Status Rows Done.';
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

echo '<b>TODO:</b> There is a lot of information in the old Store table that should go somewhere.';
echo '<br />';

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