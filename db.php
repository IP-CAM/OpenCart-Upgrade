<?php

$pdo = new PDO('mysql:host='.DB_HOSTNAME.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD, array(
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
));

require_once './db/country.php';
require_once './db/zone.php';
require_once './db/extensions.php';

require_once './db/alpha_a-c.php';
require_once './db/alpha_d-m.php';
require_once './db/alpha_n-o.php';
require_once './db/alpha_p-s.php';
require_once './db/alpha_t-z.php';

require_once './db/custom.php';
require_once './db/emptyTables.php';
require_once './db/finalize.php';