<?php

$create = "DROP TABLE IF EXISTS `v155_extension`;
CREATE TABLE IF NOT EXISTS `v155_extension` (
	`extension_id` int(11) NOT NULL AUTO_INCREMENT,
	`type` varchar(32) NOT NULL,
	`code` varchar(32) NOT NULL,
	PRIMARY KEY (`extension_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
$pdo->query($create);

$rows = $pdo->query('SELECT * FROM extension');
foreach($rows as $row) {
	$sql  = "INSERT INTO v155_extension (extension_id,type,code)";
	$sql .= "VALUES (:extension_id,:type,:code)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':extension_id' => $row['extension_id'],
		':type' => $row['type'],
		':code' => $row['key'],
	));
}

echo 'Extension Rows Copied.';
echo '<br />';

echo '<b>TODO</b> Merge Extension Rows, Remove Useless, Copy Files';
echo '<br />';

/* CURRENT CART
 *
INSERT INTO `extension` (`extension_id`, `type`, `key`) VALUES
(81, 'module', 'manufacturer'),
(80, 'module', 'information'),
(296, 'module', 'latest'),
(78, 'module', 'category'),
(77, 'module', 'cart'),
(59, 'total', 'total'),
(58, 'total', 'tax'),
(57, 'total', 'sub_total'),
(63, 'total', 'low_order_fee'),
(22, 'total', 'shipping'),
(23, 'payment', 'cod'),
(115, 'module', 'bestseller'),
(126, 'feed', 'google_base'),
(128, 'total', 'coupon'),
(184, 'shipping', 'free'),
(297, 'shipping', 'usps'),
(186, 'shipping', 'weight'),
(187, 'payment', 'cheque'),
(188, 'payment', 'pp_standard'),
(189, 'feed', 'google_sitemap'),
(190, 'shipping', 'flat'),
(192, 'payment', 'pp_pro'),
(193, 'shipping', 'pickup'),
(194, 'module', 'google_analytics'),
(196, 'module', 'featured'),
(197, 'module', 'special'),
(298, 'shipping', 'ups');
*/

/* NEW EMPTY CART
 *
INSERT INTO `extension` (`extension_id`, `type`, `code`) VALUES
(23, 'payment', 'cod'),
(22, 'total', 'shipping'),
(57, 'total', 'sub_total'),
(58, 'total', 'tax'),
(59, 'total', 'total'),
(410, 'module', 'banner'),
(426, 'module', 'carousel'),
(390, 'total', 'credit'),
(387, 'shipping', 'flat'),
(349, 'total', 'handling'),
(350, 'total', 'low_order_fee'),
(389, 'total', 'coupon'),
(413, 'module', 'category'),
(411, 'module', 'affiliate'),
(408, 'module', 'account'),
(393, 'total', 'reward'),
(398, 'total', 'voucher'),
(407, 'payment', 'free_checkout'),
(427, 'module', 'featured'),
(419, 'module', 'slideshow');
 */