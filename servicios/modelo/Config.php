<?php
// MYSQL
define('MYSQL_CONFIG', serialize([
    'database_type' => 'mysql',
    'database_name' => 'mispruebas',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // [optional]
    'port' => 3306,
//driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
    'option' => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]));
