<?php
class DBConnection{
	function connect(){
		$mysql_username='root';
		$mysql_password='';
		$con=mysqli_connect("localhost",$mysql_username,$mysql_password);
		if (!$con)
			die('不能连接数据库');
		return $con;
	}
	function gen($usrName){
		$usrName=addslashes($usrName);
		$nowTime=intval(time());
		return hash("sha1","%Imbd^&1f*()".(String)$nowTime."%Imbd^&1f*()").hash("sha256",hash("sha256", $usrName)."%Imbd^&1f*(");
	}
	function pushUserQueue($usrName,$usrPassword,$con){
		mysqli_select_db($con,"myapp");
		mysqli_query($con,"INSERT INTO todo (name, password) 
		VALUES ($usrName,$usrPassword)");
		return true;
	}
	function regLogin($con){
		$result = mysqli_query($con,"SELECT * FROM store WHERE name=".$usrName." AND password=".$usrPassword);
		if ($result===false)
			return false;
		if ($result->num_rows<=0)
			return false;
		return true;
	}
	function getToken($usrName,$con){
		$usrName=addslashes($usrName);
		regLogin($con);
		mysqli_select_db($con,"myapp");
		$result = mysqli_query($con,"SELECT * FROM store WHERE name=".$usrName);
		$result = mysqli_fetch_array($result);
		$nowTime=intval(time());
		if ($result['token']=="KNA"||($nowTime-$result['live']>=600)){
			$Token=hash("sha1","%Imbd^&1f*()".(String)$nowTime."%Imbd^&1f*()").hash("sha256",hash("sha256", $usrName)."%Imbd^&1f*(");
			mysqli_query($con,"UPDATE store SET live=".$nowTime.",token=".$Token." WHERE name=".$usrName);
			return $Token;
		}else{
			mysqli_query($con,"UPDATE store SET live=".$nowTime." WHERE name=".$usrName);
			return $result['token'];
		}
	}
	function isStore($usrName,$con){
		$usrName=addslashes($usrName);
		mysqli_select_db($con,"myapp");
		$result = mysqli_query($con,"SELECT * FROM store WHERE name=".$usrName);
		if ($result===false)
			return false;
		if ($result->num_rows<=0)
			return false;
		return true;
	}
	function setCookies($Token){
		setCookie("WP-Token",$Token,time()+600);
		return true;
	}
	function getCookie(){
		if (!empty($_cookie["WP-Token"]))
			return $_cookie["WP-Token"];
		return false;
	}
	function isInQueue($usrName,$con){
		$usrName=addslashes($usrName);
		mysqli_select_db($con,"myapp");
		$result = mysqli_query($con,"SELECT * FROM todo WHERE name=".$usrName);
		if ($result===false)
			return false;
		if ($result->num_rows<=0)
			return false;
		return true;
	}
	function check($usrName,$usrPassword,$con){
		$usrName=addslashes($usrName);
		$usrPassword=addslashes($usrPassword);
		$result = mysqli_query($con,"SELECT * FROM store WHERE name=".$usrName." AND password=".$usrPassword);
		if ($result===false)
			return false;
		if ($result->num_rows<=0)
			return false;
		return true;
	}
}
?>