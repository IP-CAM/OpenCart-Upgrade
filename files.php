<?php

rename ('../admin', '../archive-admin');
rename ('../catalog', '../archive-catalog');
rename ('../system', '../archive-system');

rename ('../upload/admin', '../admin');
rename ('../upload/catalog', '../catalog');
rename ('../upload/system', '../system');

unlink ('../admin/config-dist.php');
copy ('../archive-admin/config.php', '../admin/config.php');

$servers = array();
$read = fopen('../admin/config.php', 'r');
$write = fopen('../admin/config-new.php', 'w');
while (!feof($read)){
	$line = fgets($read);
	$skip = strpos($line, 'HTTP_CATALOG') || strpos($line, 'HTTP_IMAGE') || strpos($line, 'HTTPS_IMAGE');
	if (!$skip) {
		fwrite($write, $line);
	}
	if (strpos($line, 'HTTP_SERVER') || strpos($line, 'HTTPS_SERVER')) {
		$servers[] = $line;
		$new = str_replace(array('_SERVER', '/admin/'), array('_CATALOG', '/'), $line);
		fwrite($write, $new);
	}
}
fclose($read);
fclose($write);

unlink ('../admin/config.php');
rename ('../admin/config-new.php', '../admin/config.php');

$read = fopen('../config.php', 'r');
$write = fopen('../config-new.php', 'w');
while (!feof($read)){
	$line = fgets($read);
	fwrite($write, $line);
	if (strpos($line, 'php')) {
		foreach ($servers as $server) {
			fwrite($write, $server);
		}
	}
}
fclose($read);
fclose($write);

unlink ('../config.php');
rename ('../config-new.php', '../config.php');

chmod('../download', 0777);
chmod('../image', 0777);
chmod('../image/cache', 0777);
chmod('../system/cache', 0777);
chmod('../system/logs', 0777);