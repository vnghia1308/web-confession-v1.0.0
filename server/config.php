<?php
/* >_ Developed by Vy Nghia */
require 'lib/class/confession.class.php';
define('WEBURL', 'http://domain.com');

$db = new Database;
$db->dbhost('localhost');
$db->dbuser('username');
$db->dbpass('password');
$db->dbname('db_name');

$db->connect();
