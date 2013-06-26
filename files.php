<?php

// Functions Copied from PHPdoc
function rrmdir($dir) {
	foreach (glob($dir . '/*') as $file) {
		if (is_dir($file))
			rrmdir($file);
		else
			unlink($file);
	} rmdir($dir);
}

function recurse_copy($src, $dst) {
	$dir = opendir($src);
	@mkdir($dst);
	while (false !== ( $file = readdir($dir))) {
		if (( $file != '.' ) && ( $file != '..' )) {
			if (is_dir($src . '/' . $file)) {
				recurse_copy($src . '/' . $file, $dst . '/' . $file);
			} else {
				copy($src . '/' . $file, $dst . '/' . $file);
			}
		}
	}
	closedir($dir);
}

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
			fwrite($write, str_replace('/admin/', '/', $server));
		}
	}
}
fclose($read);
fclose($write);

unlink ('../config.php');
rename ('../config-new.php', '../config.php');

rename ('../index.php', '../archive-index.php');
rename ('../admin/index.php', '../archive-admin-index.php');


chmod('../download', 0777);
chmod('../image', 0777);
rrmdir('../image/cache');
rrmdir('../system/cache');
mkdir('../system/cache');
chmod('../system/cache', 0777);
chmod('../system/logs', 0777);

rrmdir('../vqmod');
recurse_copy('vqmod', '../vqmod');
copy('vqmod/install/home-index.php', '../index.php');
copy('vqmod/install/admin-index.php', '../admin/index.php');
rrmdir('vqmod/install');

chmod('../vqmod', 0777);
chmod('../vqmod/vqcache', 0777);