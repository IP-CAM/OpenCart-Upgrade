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

echo 'Affiliate Table Created.';
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

echo 'Affiliate Transaction Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_banner`;
CREATE TABLE IF NOT EXISTS `v155_banner` (
	`banner_id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(64) NOT NULL,
	`status` tinyint(1) NOT NULL,
	PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Banner Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_banner_image`;
CREATE TABLE IF NOT EXISTS `v155_banner_image` (
	`banner_image_id` int(11) NOT NULL AUTO_INCREMENT,
	`banner_id` int(11) NOT NULL,
	`link` varchar(255) NOT NULL,
	`image` varchar(255) NOT NULL,
	PRIMARY KEY (`banner_image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Banner Image Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_banner_image_description`;
CREATE TABLE IF NOT EXISTS `v155_banner_image_description` (
	`banner_image_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`banner_id` int(11) NOT NULL,
	`title` varchar(64) NOT NULL,
	PRIMARY KEY (`banner_image_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Banner Image Description Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_category_filter`;
CREATE TABLE IF NOT EXISTS `v155_category_filter` (
	`category_id` int(11) NOT NULL,
	`filter_id` int(11) NOT NULL,
	PRIMARY KEY (`category_id`,`filter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Category Filter Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_category_to_layout`;
CREATE TABLE IF NOT EXISTS `v155_category_to_layout` (
	`category_id` int(11) NOT NULL,
	`store_id` int(11) NOT NULL,
	`layout_id` int(11) NOT NULL,
	PRIMARY KEY (`category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Category To Layout Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_coupon_category`;
CREATE TABLE IF NOT EXISTS `v155_coupon_category` (
	`coupon_id` int(11) NOT NULL,
	`category_id` int(11) NOT NULL,
	PRIMARY KEY (`coupon_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Coupon Category Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_custom_field`;
CREATE TABLE IF NOT EXISTS `v155_custom_field` (
	`custom_field_id` int(11) NOT NULL AUTO_INCREMENT,
	`type` varchar(32) NOT NULL,
	`value` text NOT NULL,
	`required` tinyint(1) NOT NULL,
	`location` varchar(32) NOT NULL,
	`position` int(3) NOT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`custom_field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Custom Field Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_custom_field_description`;
CREATE TABLE IF NOT EXISTS `v155_custom_field_description` (
	`custom_field_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`name` varchar(128) NOT NULL,
	PRIMARY KEY (`custom_field_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Custom Field Description Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_custom_field_to_customer_group`;
CREATE TABLE IF NOT EXISTS `v155_custom_field_to_customer_group` (
	`custom_field_id` int(11) NOT NULL,
	`customer_group_id` int(11) NOT NULL,
	PRIMARY KEY (`custom_field_id`,`customer_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Custom Field To Customer Group Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_custom_field_value`;
CREATE TABLE IF NOT EXISTS `v155_custom_field_value` (
	`custom_field_value_id` int(11) NOT NULL AUTO_INCREMENT,
	`custom_field_id` int(11) NOT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`custom_field_value_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Custom Field Value Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_custom_field_value_description`;
CREATE TABLE IF NOT EXISTS `v155_custom_field_value_description` (
	`custom_field_value_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`custom_field_id` int(11) NOT NULL,
	`name` varchar(128) NOT NULL,
	PRIMARY KEY (`custom_field_value_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Custom Field Value Description Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_customer_ban_ip`;
CREATE TABLE IF NOT EXISTS `v155_customer_ban_ip` (
	`customer_ban_ip_id` int(11) NOT NULL AUTO_INCREMENT,
	`ip` varchar(40) NOT NULL,
	PRIMARY KEY (`customer_ban_ip_id`),
	KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Customer Ban IP Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_customer_field`;
CREATE TABLE IF NOT EXISTS `v155_customer_field` (
	`customer_id` int(11) NOT NULL,
	`custom_field_id` int(11) NOT NULL,
	`custom_field_value_id` int(11) NOT NULL,
	`name` int(128) NOT NULL,
	`value` text NOT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`customer_id`,`custom_field_id`,`custom_field_value_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Customer Field Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_customer_history`;
CREATE TABLE IF NOT EXISTS `v155_customer_history` (
	`customer_history_id` int(11) NOT NULL AUTO_INCREMENT,
	`customer_id` int(11) NOT NULL,
	`comment` text NOT NULL,
	`date_added` datetime NOT NULL,
	PRIMARY KEY (`customer_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Customer History Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_customer_ip`;
	CREATE TABLE IF NOT EXISTS `v155_customer_ip` (
	`customer_ip_id` int(11) NOT NULL AUTO_INCREMENT,
	`customer_id` int(11) NOT NULL,
	`ip` varchar(40) NOT NULL,
	`date_added` datetime NOT NULL,
	PRIMARY KEY (`customer_ip_id`),
	KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Customer IP Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_customer_online`;
	CREATE TABLE IF NOT EXISTS `v155_customer_online` (
	`ip` varchar(40) NOT NULL,
	`customer_id` int(11) NOT NULL,
	`url` text NOT NULL,
	`referer` text NOT NULL,
	`date_added` datetime NOT NULL,
	PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Customer Online Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_customer_reward`;
	CREATE TABLE IF NOT EXISTS `v155_customer_reward` (
	`customer_reward_id` int(11) NOT NULL AUTO_INCREMENT,
	`customer_id` int(11) NOT NULL DEFAULT '0',
	`order_id` int(11) NOT NULL DEFAULT '0',
	`description` text NOT NULL,
	`points` int(8) NOT NULL DEFAULT '0',
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`customer_reward_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Customer Reward Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_customer_transaction`;
	CREATE TABLE IF NOT EXISTS `v155_customer_transaction` (
	`customer_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
	`customer_id` int(11) NOT NULL,
	`order_id` int(11) NOT NULL,
	`description` text NOT NULL,
	`amount` decimal(15,4) NOT NULL,
	`date_added` datetime NOT NULL,
	PRIMARY KEY (`customer_transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Customer Transaction Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_download`;
CREATE TABLE IF NOT EXISTS `v155_download` (
	`download_id` int(11) NOT NULL AUTO_INCREMENT,
	`filename` varchar(128) NOT NULL,
	`mask` varchar(128) NOT NULL,
	`remaining` int(11) NOT NULL DEFAULT '0',
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Download Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_download_description`;
CREATE TABLE IF NOT EXISTS `v155_download_description` (
	`download_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`name` varchar(64) NOT NULL,
	PRIMARY KEY (`download_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Download Description Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_filter`;
CREATE TABLE IF NOT EXISTS `v155_filter` (
	`filter_id` int(11) NOT NULL AUTO_INCREMENT,
	`filter_group_id` int(11) NOT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`filter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Filter Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_filter_description`;
CREATE TABLE IF NOT EXISTS `v155_filter_description` (
	`filter_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`filter_group_id` int(11) NOT NULL,
	`name` varchar(64) NOT NULL,
	PRIMARY KEY (`filter_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Filter Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_filter_group`;
CREATE TABLE IF NOT EXISTS `v155_filter_group` (
	`filter_group_id` int(11) NOT NULL AUTO_INCREMENT,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`filter_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Filter Group Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_filter_group_description`;
CREATE TABLE IF NOT EXISTS `v155_filter_group_description` (
	`filter_group_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`name` varchar(64) NOT NULL,
	PRIMARY KEY (`filter_group_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Filter Group Description Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_information_to_layout`;
CREATE TABLE IF NOT EXISTS `v155_information_to_layout` (
	`information_id` int(11) NOT NULL,
	`store_id` int(11) NOT NULL,
	`layout_id` int(11) NOT NULL,
	PRIMARY KEY (`information_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Information To Layout Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_layout_route`;
CREATE TABLE `v155_layout_route` (
	`layout_route_id` int(11) NOT NULL AUTO_INCREMENT,
	`layout_id` int(11) NOT NULL,
	`store_id` int(11) NOT NULL,
	`route` varchar(255) NOT NULL,
	PRIMARY KEY (`layout_route_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Layout Route Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_order_download`;
CREATE TABLE IF NOT EXISTS `v155_order_download` (
	`order_download_id` int(11) NOT NULL AUTO_INCREMENT,
	`order_id` int(11) NOT NULL,
	`order_product_id` int(11) NOT NULL,
	`name` varchar(64) NOT NULL,
	`filename` varchar(128) NOT NULL,
	`mask` varchar(128) NOT NULL,
	`remaining` int(3) NOT NULL DEFAULT '0',
	PRIMARY KEY (`order_download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Order Download Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_order_field`;
CREATE TABLE IF NOT EXISTS `v155_order_field` (
	`order_id` int(11) NOT NULL,
	`custom_field_id` int(11) NOT NULL,
	`custom_field_value_id` int(11) NOT NULL,
	`name` int(128) NOT NULL,
	`value` text NOT NULL,
	`sort_order` int(3) NOT NULL,
	PRIMARY KEY (`order_id`,`custom_field_id`,`custom_field_value_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Order Field Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_order_fraud`;
CREATE TABLE IF NOT EXISTS `v155_order_fraud` (
	`order_id` int(11) NOT NULL,
	`customer_id` int(11) NOT NULL,
	`country_match` varchar(3) NOT NULL,
	`country_code` varchar(2) NOT NULL,
	`high_risk_country` varchar(3) NOT NULL,
	`distance` int(11) NOT NULL,
	`ip_region` varchar(255) NOT NULL,
	`ip_city` varchar(255) NOT NULL,
	`ip_latitude` decimal(10,6) NOT NULL,
	`ip_longitude` decimal(10,6) NOT NULL,
	`ip_isp` varchar(255) NOT NULL,
	`ip_org` varchar(255) NOT NULL,
	`ip_asnum` int(11) NOT NULL,
	`ip_user_type` varchar(255) NOT NULL,
	`ip_country_confidence` varchar(3) NOT NULL,
	`ip_region_confidence` varchar(3) NOT NULL,
	`ip_city_confidence` varchar(3) NOT NULL,
	`ip_postal_confidence` varchar(3) NOT NULL,
	`ip_postal_code` varchar(10) NOT NULL,
	`ip_accuracy_radius` int(11) NOT NULL,
	`ip_net_speed_cell` varchar(255) NOT NULL,
	`ip_metro_code` int(3) NOT NULL,
	`ip_area_code` int(3) NOT NULL,
	`ip_time_zone` varchar(255) NOT NULL,
	`ip_region_name` varchar(255) NOT NULL,
	`ip_domain` varchar(255) NOT NULL,
	`ip_country_name` varchar(255) NOT NULL,
	`ip_continent_code` varchar(2) NOT NULL,
	`ip_corporate_proxy` varchar(3) NOT NULL,
	`anonymous_proxy` varchar(3) NOT NULL,
	`proxy_score` int(3) NOT NULL,
	`is_trans_proxy` varchar(3) NOT NULL,
	`free_mail` varchar(3) NOT NULL,
	`carder_email` varchar(3) NOT NULL,
	`high_risk_username` varchar(3) NOT NULL,
	`high_risk_password` varchar(3) NOT NULL,
	`bin_match` varchar(10) NOT NULL,
	`bin_country` varchar(2) NOT NULL,
	`bin_name_match` varchar(3) NOT NULL,
	`bin_name` varchar(255) NOT NULL,
	`bin_phone_match` varchar(3) NOT NULL,
	`bin_phone` varchar(32) NOT NULL,
	`customer_phone_in_billing_location` varchar(8) NOT NULL,
	`ship_forward` varchar(3) NOT NULL,
	`city_postal_match` varchar(3) NOT NULL,
	`ship_city_postal_match` varchar(3) NOT NULL,
	`score` decimal(10,5) NOT NULL,
	`explanation` text NOT NULL,
	`risk_score` decimal(10,5) NOT NULL,
	`queries_remaining` int(11) NOT NULL,
	`maxmind_id` varchar(8) NOT NULL,
	`error` text NOT NULL,
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Order Fraud Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_order_voucher`;
CREATE TABLE IF NOT EXISTS `v155_order_voucher` (
	`order_voucher_id` int(11) NOT NULL AUTO_INCREMENT,
	`order_id` int(11) NOT NULL,
	`voucher_id` int(11) NOT NULL,
	`description` varchar(255) NOT NULL,
	`code` varchar(10) NOT NULL,
	`from_name` varchar(64) NOT NULL,
	`from_email` varchar(96) NOT NULL,
	`to_name` varchar(64) NOT NULL,
	`to_email` varchar(96) NOT NULL,
	`voucher_theme_id` int(11) NOT NULL,
	`message` text NOT NULL,
	`amount` decimal(15,4) NOT NULL,
	PRIMARY KEY (`order_voucher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Order Voucher Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_filter`;
CREATE TABLE IF NOT EXISTS `v155_product_filter` (
	`product_id` int(11) NOT NULL,
	`filter_id` int(11) NOT NULL,
	PRIMARY KEY (`product_id`,`filter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Product Filter Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_reward`;
CREATE TABLE IF NOT EXISTS `v155_product_reward` (
	`product_reward_id` int(11) NOT NULL AUTO_INCREMENT,
	`product_id` int(11) NOT NULL DEFAULT '0',
	`customer_group_id` int(11) NOT NULL DEFAULT '0',
	`points` int(8) NOT NULL DEFAULT '0',
	PRIMARY KEY (`product_reward_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Product Reward Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_to_download`;
CREATE TABLE IF NOT EXISTS `v155_product_to_download` (
	`product_id` int(11) NOT NULL,
	`download_id` int(11) NOT NULL,
	PRIMARY KEY (`product_id`,`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Product To Download Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_product_to_layout`;
CREATE TABLE IF NOT EXISTS `v155_product_to_layout` (
	`product_id` int(11) NOT NULL,
	`store_id` int(11) NOT NULL,
	`layout_id` int(11) NOT NULL,
	PRIMARY KEY (`product_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Product To Layout Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_return`;
CREATE TABLE IF NOT EXISTS `v155_return` (
	`return_id` int(11) NOT NULL AUTO_INCREMENT,
	`order_id` int(11) NOT NULL,
	`product_id` int(11) NOT NULL,
	`customer_id` int(11) NOT NULL,
	`firstname` varchar(32) NOT NULL,
	`lastname` varchar(32) NOT NULL,
	`email` varchar(96) NOT NULL,
	`telephone` varchar(32) NOT NULL,
	`product` varchar(255) NOT NULL,
	`model` varchar(64) NOT NULL,
	`quantity` int(4) NOT NULL,
	`opened` tinyint(1) NOT NULL,
	`return_reason_id` int(11) NOT NULL,
	`return_action_id` int(11) NOT NULL,
	`return_status_id` int(11) NOT NULL,
	`comment` text,
	`date_ordered` date NOT NULL,
	`date_added` datetime NOT NULL,
	`date_modified` datetime NOT NULL,
	PRIMARY KEY (`return_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Return Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_return_history`;
CREATE TABLE IF NOT EXISTS `v155_return_history` (
	`return_history_id` int(11) NOT NULL AUTO_INCREMENT,
	`return_id` int(11) NOT NULL,
	`return_status_id` int(11) NOT NULL,
	`notify` tinyint(1) NOT NULL,
	`comment` text NOT NULL,
	`date_added` datetime NOT NULL,
	PRIMARY KEY (`return_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Return History Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_voucher`;
CREATE TABLE IF NOT EXISTS `v155_voucher` (
	`voucher_id` int(11) NOT NULL AUTO_INCREMENT,
	`order_id` int(11) NOT NULL,
	`code` varchar(10) NOT NULL,
	`from_name` varchar(64) NOT NULL,
	`from_email` varchar(96) NOT NULL,
	`to_name` varchar(64) NOT NULL,
	`to_email` varchar(96) NOT NULL,
	`voucher_theme_id` int(11) NOT NULL,
	`message` text NOT NULL,
	`amount` decimal(15,4) NOT NULL,
	`status` tinyint(1) NOT NULL,
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`voucher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Voucher Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_voucher_history`;
CREATE TABLE IF NOT EXISTS `v155_voucher_history` (
	`voucher_history_id` int(11) NOT NULL AUTO_INCREMENT,
	`voucher_id` int(11) NOT NULL,
	`order_id` int(11) NOT NULL,
	`amount` decimal(15,4) NOT NULL,
	`date_added` datetime NOT NULL,
	PRIMARY KEY (`voucher_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Voucher History Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_voucher_theme`;
CREATE TABLE IF NOT EXISTS `v155_voucher_theme` (
  `voucher_theme_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`voucher_theme_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Voucher Theme Table Created.';
echo '<br />';

$create = "DROP TABLE IF EXISTS `v155_voucher_theme_description`;
CREATE TABLE IF NOT EXISTS `v155_voucher_theme_description` (
  `voucher_theme_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`voucher_theme_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

echo 'Voucher Theme Discription Table Created.';
echo '<br />';