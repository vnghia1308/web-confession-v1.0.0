<?php
/* >_ Developed by Vy Nghia */
require 'config.php';
session_start();
error_reporting(0);
switch($_GET['do']){
	case 'logout':
		if(isset($_SESSION['admin'])){
			if($_GET['type'] == 'admin')
				unset($_SESSION['admin']);
		}
		if(isset($_SERVER[ 'HTTP_REFERER' ]))
			header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
		else 
			header("Location: /");
		break;
	case 'approval':
		if(isset($_POST['id']) && isset($_POST['type']) && isset($_SESSION['admin'])){
			if($_POST['type'] == 'allow')
				mysql_query("UPDATE `post` SET `approval`=1,`time_approval`='".date("Y-m-d H:i:s")."' WHERE `id` = {$_POST['id']}");
			elseif($_POST['type'] == 're-approval')
				mysql_query("UPDATE `post` SET `approval`=0 WHERE `id` = {$_POST['id']}");
			else
				mysql_query("DELETE FROM `post` WHERE `id` = {$_POST['id']}");
		}
		break;
	case 'change':
		if(isset($_SESSION['admin']) && $_POST['password']){
			if($_GET['type'] == 'admin')
				mysql_query("UPDATE `admin` SET `password` = '{$_POST['password']}' WHERE 1");
			unset($_SESSION['admin']);
			echo (true);
		}
		break;
	case 'install':
		if(isset($_SESSION['install'])){
			if($_GET['type'] == 'mysql')
				include ('lib/data/mysql/install/database.install.php');
		}
		break;
}
