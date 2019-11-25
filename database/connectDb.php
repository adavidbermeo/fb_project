<?php 
class database{
	public function conn(){
		$dbhost = "localhost";
		$dbname = "fb_project";        
		$dbuser = "root";
		$dbpass = "";   
		
		if($conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname, $dbuser, $dbpass,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'))){
			return($conn);
		}
			else {
			return null;
		}
	}
}