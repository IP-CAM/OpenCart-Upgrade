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

$permission = 'a:2:{s:6:"access";a:125:{i:0;s:17:"catalog/attribute";i:1;s:23:"catalog/attribute_group";i:2;s:16:"catalog/category";i:3;s:16:"catalog/download";i:4;s:14:"catalog/filter";i:5;s:19:"catalog/information";i:6;s:20:"catalog/manufacturer";i:7;s:14:"catalog/option";i:8;s:15:"catalog/product";i:9;s:14:"catalog/review";i:10;s:18:"common/filemanager";i:11;s:13:"design/banner";i:12;s:19:"design/custom_field";i:13;s:13:"design/layout";i:14;s:14:"extension/feed";i:15;s:17:"extension/manager";i:16;s:16:"extension/module";i:17;s:17:"extension/payment";i:18;s:18:"extension/shipping";i:19;s:15:"extension/total";i:20;s:16:"feed/google_base";i:21;s:19:"feed/google_sitemap";i:22;s:20:"localisation/country";i:23;s:21:"localisation/currency";i:24;s:21:"localisation/geo_zone";i:25;s:21:"localisation/language";i:26;s:25:"localisation/length_class";i:27;s:25:"localisation/order_status";i:28;s:26:"localisation/return_action";i:29;s:26:"localisation/return_reason";i:30;s:26:"localisation/return_status";i:31;s:25:"localisation/stock_status";i:32;s:22:"localisation/tax_class";i:33;s:21:"localisation/tax_rate";i:34;s:25:"localisation/weight_class";i:35;s:17:"localisation/zone";i:36;s:14:"module/account";i:37;s:16:"module/affiliate";i:38;s:13:"module/banner";i:39;s:17:"module/bestseller";i:40;s:15:"module/carousel";i:41;s:15:"module/category";i:42;s:15:"module/featured";i:43;s:13:"module/filter";i:44;s:18:"module/google_talk";i:45;s:18:"module/information";i:46;s:13:"module/latest";i:47;s:16:"module/slideshow";i:48;s:14:"module/special";i:49;s:12:"module/store";i:50;s:14:"module/welcome";i:51;s:24:"payment/authorizenet_aim";i:52;s:21:"payment/bank_transfer";i:53;s:14:"payment/cheque";i:54;s:11:"payment/cod";i:55;s:21:"payment/free_checkout";i:56;s:22:"payment/klarna_account";i:57;s:22:"payment/klarna_invoice";i:58;s:14:"payment/liqpay";i:59;s:20:"payment/moneybookers";i:60;s:14:"payment/nochex";i:61;s:15:"payment/paymate";i:62;s:16:"payment/paypoint";i:63;s:13:"payment/payza";i:64;s:26:"payment/perpetual_payments";i:65;s:14:"payment/pp_pro";i:66;s:17:"payment/pp_pro_uk";i:67;s:19:"payment/pp_standard";i:68;s:15:"payment/sagepay";i:69;s:22:"payment/sagepay_direct";i:70;s:18:"payment/sagepay_us";i:71;s:19:"payment/twocheckout";i:72;s:28:"payment/web_payment_software";i:73;s:16:"payment/worldpay";i:74;s:27:"report/affiliate_commission";i:75;s:22:"report/customer_credit";i:76;s:22:"report/customer_online";i:77;s:21:"report/customer_order";i:78;s:22:"report/customer_reward";i:79;s:24:"report/product_purchased";i:80;s:21:"report/product_viewed";i:81;s:18:"report/sale_coupon";i:82;s:17:"report/sale_order";i:83;s:18:"report/sale_return";i:84;s:20:"report/sale_shipping";i:85;s:15:"report/sale_tax";i:86;s:14:"sale/affiliate";i:87;s:12:"sale/contact";i:88;s:11:"sale/coupon";i:89;s:13:"sale/customer";i:90;s:20:"sale/customer_ban_ip";i:91;s:19:"sale/customer_group";i:92;s:10:"sale/order";i:93;s:11:"sale/return";i:94;s:12:"sale/voucher";i:95;s:18:"sale/voucher_theme";i:96;s:15:"setting/setting";i:97;s:13:"setting/store";i:98;s:16:"shipping/auspost";i:99;s:17:"shipping/citylink";i:100;s:14:"shipping/fedex";i:101;s:13:"shipping/flat";i:102;s:13:"shipping/free";i:103;s:13:"shipping/item";i:104;s:23:"shipping/parcelforce_48";i:105;s:15:"shipping/pickup";i:106;s:19:"shipping/royal_mail";i:107;s:12:"shipping/ups";i:108;s:13:"shipping/usps";i:109;s:15:"shipping/weight";i:110;s:11:"tool/backup";i:111;s:14:"tool/error_log";i:112;s:12:"total/coupon";i:113;s:12:"total/credit";i:114;s:14:"total/handling";i:115;s:16:"total/klarna_fee";i:116;s:19:"total/low_order_fee";i:117;s:12:"total/reward";i:118;s:14:"total/shipping";i:119;s:15:"total/sub_total";i:120;s:9:"total/tax";i:121;s:11:"total/total";i:122;s:13:"total/voucher";i:123;s:9:"user/user";i:124;s:20:"user/user_permission";}s:6:"modify";a:125:{i:0;s:17:"catalog/attribute";i:1;s:23:"catalog/attribute_group";i:2;s:16:"catalog/category";i:3;s:16:"catalog/download";i:4;s:14:"catalog/filter";i:5;s:19:"catalog/information";i:6;s:20:"catalog/manufacturer";i:7;s:14:"catalog/option";i:8;s:15:"catalog/product";i:9;s:14:"catalog/review";i:10;s:18:"common/filemanager";i:11;s:13:"design/banner";i:12;s:19:"design/custom_field";i:13;s:13:"design/layout";i:14;s:14:"extension/feed";i:15;s:17:"extension/manager";i:16;s:16:"extension/module";i:17;s:17:"extension/payment";i:18;s:18:"extension/shipping";i:19;s:15:"extension/total";i:20;s:16:"feed/google_base";i:21;s:19:"feed/google_sitemap";i:22;s:20:"localisation/country";i:23;s:21:"localisation/currency";i:24;s:21:"localisation/geo_zone";i:25;s:21:"localisation/language";i:26;s:25:"localisation/length_class";i:27;s:25:"localisation/order_status";i:28;s:26:"localisation/return_action";i:29;s:26:"localisation/return_reason";i:30;s:26:"localisation/return_status";i:31;s:25:"localisation/stock_status";i:32;s:22:"localisation/tax_class";i:33;s:21:"localisation/tax_rate";i:34;s:25:"localisation/weight_class";i:35;s:17:"localisation/zone";i:36;s:14:"module/account";i:37;s:16:"module/affiliate";i:38;s:13:"module/banner";i:39;s:17:"module/bestseller";i:40;s:15:"module/carousel";i:41;s:15:"module/category";i:42;s:15:"module/featured";i:43;s:13:"module/filter";i:44;s:18:"module/google_talk";i:45;s:18:"module/information";i:46;s:13:"module/latest";i:47;s:16:"module/slideshow";i:48;s:14:"module/special";i:49;s:12:"module/store";i:50;s:14:"module/welcome";i:51;s:24:"payment/authorizenet_aim";i:52;s:21:"payment/bank_transfer";i:53;s:14:"payment/cheque";i:54;s:11:"payment/cod";i:55;s:21:"payment/free_checkout";i:56;s:22:"payment/klarna_account";i:57;s:22:"payment/klarna_invoice";i:58;s:14:"payment/liqpay";i:59;s:20:"payment/moneybookers";i:60;s:14:"payment/nochex";i:61;s:15:"payment/paymate";i:62;s:16:"payment/paypoint";i:63;s:13:"payment/payza";i:64;s:26:"payment/perpetual_payments";i:65;s:14:"payment/pp_pro";i:66;s:17:"payment/pp_pro_uk";i:67;s:19:"payment/pp_standard";i:68;s:15:"payment/sagepay";i:69;s:22:"payment/sagepay_direct";i:70;s:18:"payment/sagepay_us";i:71;s:19:"payment/twocheckout";i:72;s:28:"payment/web_payment_software";i:73;s:16:"payment/worldpay";i:74;s:27:"report/affiliate_commission";i:75;s:22:"report/customer_credit";i:76;s:22:"report/customer_online";i:77;s:21:"report/customer_order";i:78;s:22:"report/customer_reward";i:79;s:24:"report/product_purchased";i:80;s:21:"report/product_viewed";i:81;s:18:"report/sale_coupon";i:82;s:17:"report/sale_order";i:83;s:18:"report/sale_return";i:84;s:20:"report/sale_shipping";i:85;s:15:"report/sale_tax";i:86;s:14:"sale/affiliate";i:87;s:12:"sale/contact";i:88;s:11:"sale/coupon";i:89;s:13:"sale/customer";i:90;s:20:"sale/customer_ban_ip";i:91;s:19:"sale/customer_group";i:92;s:10:"sale/order";i:93;s:11:"sale/return";i:94;s:12:"sale/voucher";i:95;s:18:"sale/voucher_theme";i:96;s:15:"setting/setting";i:97;s:13:"setting/store";i:98;s:16:"shipping/auspost";i:99;s:17:"shipping/citylink";i:100;s:14:"shipping/fedex";i:101;s:13:"shipping/flat";i:102;s:13:"shipping/free";i:103;s:13:"shipping/item";i:104;s:23:"shipping/parcelforce_48";i:105;s:15:"shipping/pickup";i:106;s:19:"shipping/royal_mail";i:107;s:12:"shipping/ups";i:108;s:13:"shipping/usps";i:109;s:15:"shipping/weight";i:110;s:11:"tool/backup";i:111;s:14:"tool/error_log";i:112;s:12:"total/coupon";i:113;s:12:"total/credit";i:114;s:14:"total/handling";i:115;s:16:"total/klarna_fee";i:116;s:19:"total/low_order_fee";i:117;s:12:"total/reward";i:118;s:14:"total/shipping";i:119;s:15:"total/sub_total";i:120;s:9:"total/tax";i:121;s:11:"total/total";i:122;s:13:"total/voucher";i:123;s:9:"user/user";i:124;s:20:"user/user_permission";}}';
$sql  = "UPDATE v155_user_group SET permission = :permission WHERE user_group_id = :user_group_id";
$q = $pdo->prepare($sql);
$q->execute(array(
	':user_group_id' => 1,
	':permission' => $permission,
));

echo 'User Group Rows Done.';
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

$create = "DROP TABLE IF EXISTS `v155_zone_to_geo_zone`;
CREATE TABLE IF NOT EXISTS `v155_zone_to_geo_zone` (
	`zone_to_geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
	`country_id` int(11) NOT NULL,
	`zone_id` int(11) NOT NULL DEFAULT '0',
	`geo_zone_id` int(11) NOT NULL,
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`zone_to_geo_zone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$insert = "INSERT INTO `v155_zone_to_geo_zone` (`zone_to_geo_zone_id`, `country_id`, `zone_id`, `geo_zone_id`, `date_added`, `date_modified`) VALUES
	(62, 223, 3646, 7, '2011-03-28 13:46:19', '0000-00-00 00:00:00'),
	(63, 38, 0, 8, '2012-01-27 06:02:57', '0000-00-00 00:00:00');";
$pdo->query($insert);

echo 'Zone To Geo Zone Rows Done.';
echo '<br />';