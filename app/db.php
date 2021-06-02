<?php

$db = null;

try {
    $config = include($_SERVER['DOCUMENT_ROOT'].'/blog_simple/configuration.php');

    $db = new PDO("mysql:host=" . $config['database_host'] . ";dbname=" . $config['database_database'] . ";port=" . $config['database_port'], $config['database_user'], $config['database_password']);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
    $db = null;
}
