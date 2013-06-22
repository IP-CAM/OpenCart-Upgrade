<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!file_exists('../upload/config-dist.php')) {
	echo '<h1>Upload folder not in place.</h1>';
	die;
}


require_once '../config.php';
require_once 'db.php';

require_once 'files.php';

echo '<b>TODO:</b> Move Category Images Around.';
echo '<br />';

echo '<b>TODO:</b> Move Product Images Around.';
echo '<br />';