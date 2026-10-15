<?php

$local_config = __DIR__ . '/db.local.php';
if (!is_file($local_config)) {
    echo 'Database config is missing. Copy admin/auth/db.local.example.php to admin/auth/db.local.php.';
    exit;
}

require $local_config;

$db_connect = mysqli_connect($hostname, $username, $password, $db_name);
