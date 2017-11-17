<?php
/* >_ Developed by Vy Nghia */
require 'server/config.php';
session_start();
error_reporting(0);
if(isset($_POST['content']) && isset($_POST['code'])){
	if($_SESSION['code'] == $_POST['code']){
		if(!$_COOKIE['posted'])
			mysql_query("INSERT INTO `post`(`id`,  `content`, `approval`, `time`) VALUES ('', '".base64_encode($_POST['content'])."', '0', '".date("Y-m-d H:i:s")."')");
		else
			echo (false);
	}
	else 
		echo (false);
} else {
	echo ("null");
}