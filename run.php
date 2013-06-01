<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../config.php';
$pdo = new PDO('mysql:host='.DB_HOSTNAME.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);

$rows = $pdo->query('SELECT * FROM address');

foreach($rows as $row) {
    echo $row['address_id'];
	echo ' : ';
}