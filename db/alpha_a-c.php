<?php

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

$create = "DROP TABLE IF EXISTS `v155_attribute_group`;
CREATE TABLE IF NOT EXISTS `v155_attribute_group` (
	`attribute_group_id` int(11) NOT NULL AUTO_INCREMENT,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`attribute_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert  = "INSERT INTO v155_attribute_group (attribute_group_id,sort_order)";
$insert .= "VALUES (1,0)";
$pdo->query($insert);

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

$insert  = "INSERT INTO v155_attribute_group_description (attribute_group_id,language_id,name)";
$insert .= "VALUES (1,1,'General')";
$pdo->query($insert);

echo 'Attribute Group Description Rows Done.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_attribute`;
CREATE TABLE IF NOT EXISTS `v155_attribute` (
	`attribute_id` int(11) NOT NULL AUTO_INCREMENT,
	`attribute_group_id` int(11) NOT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`attribute_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_attribute` (`attribute_id`, `attribute_group_id`, `sort_order`) VALUES
	(1, 1, 0),
	(2, 1, 0),
	(3, 1, 0);";
$pdo->query($insert);

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

$insert = "INSERT INTO `v155_attribute_description` (`attribute_id`, `language_id`, `name`) VALUES
	(1, 1, 'size'),
	(2, 1, 'color'),
	(3, 1, 'condition');";
$pdo->query($insert);

echo 'Attribute Description Rows Done.';
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

$create = "DROP TABLE IF EXISTS `v155_category_path`;
CREATE TABLE IF NOT EXISTS `v155_category_path` (
	`category_id` int(11) NOT NULL,
	`path_id` int(11) NOT NULL,
	`level` int(11) NOT NULL,
	PRIMARY KEY (`category_id`,`path_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

function insertCategoryPath($parent, $paths) {
	global $pdo;
	$sql = "SELECT * FROM category WHERE parent_id = :parent_id";
	$select = $pdo->prepare($sql);
	$select->execute(array(':parent_id' => $parent));
	while ($row = $select->fetch()){
		$sql  = "INSERT INTO v155_category_path (category_id,path_id,level)";
		$sql .= "VALUES (:category_id,:path_id,:level)";
		$q = $pdo->prepare($sql);
		foreach ($paths as $index => $path) {
			$q->execute(array(
				':category_id' => $row['category_id'],
				':path_id' => $path,
				':level' => $index,
			));
		}
		$q->execute(array(
			':category_id' => $row['category_id'],
			':path_id' => $row['category_id'],
			':level' => count($paths),
		));
		insertCategoryPath($row['category_id'], $paths + array($row['category_id']));
	}
}

insertCategoryPath(0, array());

echo 'Category Path Rows Done.';
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
    $sql  = "UPDATE v155_coupon SET name = :name ";
	$sql .= "WHERE coupon_id = :coupon_id";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':name' => $row['name'] . ' : ' . $row['description'],
		':coupon_id' => $row['coupon_id'],
	));
}

echo 'Coupon Rows Done.';
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

$rows = $pdo->query('SELECT * FROM `order` WHERE coupon_id > 0');
foreach($rows as $row) {
	$sql  = "SELECT value FROM order_total ";
	$sql .= "WHERE order_id = :order_id AND value < 0";
	$select = $pdo->prepare($sql);
	$select->execute(array(':order_id' => $row['order_id']));
	$value = $select->fetchColumn();

	$sql  = "INSERT INTO v155_coupon_history (coupon_id,order_id,customer_id,amount,date_added)";
	$sql .= "VALUES (:coupon_id,:order_id,:customer_id,:amount,:date_added)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':coupon_id' => $row['coupon_id'],
		':order_id' => $row['order_id'],
		':customer_id' => $row['customer_id'],
		':amount' => $value,
		':date_added' => $row['date_added'],
	));
}

echo 'Coupon History Rows Created Guys.';
echo '<br />';

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

$create = "DROP TABLE IF EXISTS `v155_customer_group_description`;
CREATE TABLE IF NOT EXISTS `v155_customer_group_description` (
	`customer_group_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`name` varchar(32) NOT NULL,
	`description` text NOT NULL,
	PRIMARY KEY (`customer_group_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM customer_group');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_customer_group_description (customer_group_id,language_id,name,description)";
	$sql .= "VALUES (:customer_group_id,:language_id,:name,:description)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':customer_group_id' => $row['customer_group_id'],
		':language_id' => 1,
		':name' => $row['name'],
		':description' => $row['name'],
	));
}

echo 'Customer Group Discription Rows Done.';
echo '<br />';