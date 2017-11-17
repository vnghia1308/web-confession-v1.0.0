<?php
/* >_ Developed by Vy Nghia */
require 'lib/class/confession.class.php';
define('WEBURL', '{1}');

$db = new Database;
$db->dbhost('{2}');
$db->dbuser('{3}');
$db->dbpass('{4}');
$db->dbname('{5}');

$db->connect();