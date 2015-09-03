<?php

require_once 'DB.php';

$dsn = array(
    'phptype'  => 'mysqli',
    'username' => 'thisisbook',
    'password' => '25380280',
    'hostspec' => '10.16.90.215',
    'database' => 'asset',
);

$options = array(
    'debug'       => 1,
    'portability' => DB_PORTABILITY_ALL,
);

$db =& DB::connect($dsn, $options);
if (PEAR::isError($db)) {
    die($db->getMessage());
}

$db->setFetchMode(DB_FETCHMODE_ASSOC);

$db->query("SET CHARACTER SET UTF8");
$db->query("SET NAMES UTF8");
