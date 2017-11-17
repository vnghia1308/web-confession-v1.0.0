<?php
/* >_ Developed by Vy Nghia */
require 'lib/class/confession.class.php';
define('WEBURL', 'http://support.hoitruongdep.com');

$db = new Database;
$db->dbhost('localhost');
$db->dbuser('htd_support');
$db->dbpass('1151985611');
$db->dbname('htd_support');

$db->connect();