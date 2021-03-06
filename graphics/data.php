<?php
if(isset($_POST['selected'])){

	// echo $_POST['selected'];
	$selected = $_POST['selected'];
	list($url, $values) = explode('?', $selected);
	list($value1, $value2) = explode('&', $values);
	list($key1, $ad_account_id) = explode('=', $value1);
	list($key2, $db_table_name) = explode('=', $value2);
	
	getData($ad_account_id, $db_table_name);
}
function getData($ad_account_id, $db_table_name){

	//setting header to json
	$db = new database();
	$conn = $db->conn();

	switch ($db_table_name){
		case 'ad':
			$sql = $conn->prepare("SELECT * FROM $db_table_name WHERE ad_account_id='$ad_account_id' ORDER BY interactions DESC ");
			$sql->execute();
			break;
		case 'campaign':
			$sql = $conn->prepare("SELECT * FROM $db_table_name WHERE ad_account_id='$ad_account_id' ORDER BY impressions DESC ");
			$sql->execute();
			break;
		case 'page':
			$sql = $conn->prepare("SELECT * FROM $db_table_name WHERE ad_account_id='$ad_account_id' ORDER BY total_new_likes DESC ");
			$sql->execute();
			break;
		default:
			echo 'An unexpected error has ocurred';
			break;
	}
	// die(var_dump($sql));

	$result = $sql->fetchAll();
	$count = count($result);

	$result[$count]['tabla'] = $db_table_name;
	$result[$count]['Bcolor'] = 'rgba(0, 0, 0, 0.3)';

	echo json_encode($result);
}

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
?>
