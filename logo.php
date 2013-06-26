<?php

copy('images/weblogo.sized.jpg', '../image/data/compulsion_logos/weblogo.sized.jpg');

$update = "UPDATE `setting` SET `value` = 'data/compulsion_logos/weblogo.sized.jpg' WHERE `key` = 'config_logo' AND `store_id` = 0";
$pdo->query($update);

echo "Logo Copied.\n";
