<?php
/* >_ Developed by Vy Nghia */
class Database
{
	protected $dbhost;
	protected $dbuser;
	protected $dbpass;
	protected $dbname;
	
	public function dbhost($dbhost){
		$this->dbhost = $dbhost;
	}
	
	public function dbuser($dbuser){
		$this->dbuser = $dbuser;
	}
	
	public function dbpass($dbpass){
		$this->dbpass = $dbpass;
	}
	
	public function dbname($dbname){
		$this->dbname = $dbname;
	}
	
	public function connect(){
		$con = @mysql_connect($this->dbhost, $this->dbuser, $this->dbpass);
		@mysql_select_db($this->dbname, $con);
	}
	
	public function dbinfo($db){
		echo $this->$db;
	}
	
}

class Website
{
	public function codeSecurity($length) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	public function timeAgo($time_ago){
	  $cur_time 	= time();
	  $time_elapsed = $cur_time - $time_ago;
	  $seconds 		= $time_elapsed ;
	  $minutes 		= round($time_elapsed / 60 );
	  $hours 		= round($time_elapsed / 3600);
	  $days 		= round($time_elapsed / 86400 );
	  $weeks 		= round($time_elapsed / 604800);
	  $months 		= round($time_elapsed / 2600640 );
	  $years 		= round($time_elapsed / 31207680 );
	  // Seconds
	  if($seconds <= 60){
		return "$seconds giây trước";
	  }
	  //Minutes
	  else if($minutes <=60){
		if($minutes==1){
		  return "1 phút trước";
		}
		else{
		  return "$minutes phút trước";
		}
	  }
	  //Hours
	  else if($hours <=24){
		if($hours==1){
		  return "1 giờ trước";
		}else{
		  return "$hours giờ trước";
		}
	  }
	  //Days
	  else if($days <= 7){
		if($days==1){
		  return "hôm qua";
		}else{
		  return "$days ngày tước";
		}
	  }
	  //Weeks
	  else if($weeks <= 4.3){
		if($weeks==1){
		  return "1 tuần trước";
		}else{
		  return "$weeks tuần trước";
		}
	  }
	  //Months
	  else if($months <=12){
		if($months==1){
		  return "1 tháng trước";
		}else{
		  return "$months tháng trước";
		}
	  }
	  //Years
	  else{
		if($years==1){
		  return "1 năm trước";
		}else{
		  return "$years năm trước";
		}
	  }
	}
}

class Admin
{
	public function checkadmin($username, $password){
		global $status;
		$query = mysql_query("SELECT * FROM `admin` WHERE 1");
		$admin = mysql_fetch_array($query);
		
		if($admin['username'] == $username && $admin['password'] == $password)
			$status = true;
		else 
			$status = false;		
	}
}