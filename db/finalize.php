<?php

$rows = $pdo->query('SHOW TABLES');
foreach($rows as $row) {
    $prefix = substr($row[0], 0, 5);
	if ($prefix != 'v155_') {
		$pdo->query("DROP TABLE IF EXISTS `{$row[0]}`;");
	}
}
$rows = $pdo->query('SHOW TABLES');
foreach($rows as $row) {
    $prefix = substr($row[0], 0, 5);
	if ($prefix == 'v155_') {
		$suffix = substr($row[0], 5);
		$pdo->query("RENAME TABLE `{$row[0]}` TO `{$suffix}`;");
	}
}