<?php
// Db Connection 
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/database/connectDb.php');

    if(isset($_POST['selected'])){
        $selected = $_POST['selected'];
        list($url, $click) = explode('=', $selected);
        list($click_value,$data) = explode('*', $click);
        list($id_page, $ad_account_id) = explode('%', $data); 

        getData($ad_account_id);
    }

function getData($ad_account_id){
    
	//setting header to json
	$db = new database();
	$conn = $db->conn();

    // Campaign Graphics
    $sql = $conn->prepare("SELECT `campaign_id`,`campaign_name`,`clicks` FROM `campaign` WHERE `ad_account_id` ='$ad_account_id' ORDER BY `clicks` DESC");
    $sql->execute();
    $campaign_graphic = $sql->fetchAll();

    // Ad Graphics
    $sql = $conn->prepare("SELECT `ad_ids`,`ad_name`,`total_reactions` FROM `ad` WHERE `ad_account_id` ='$ad_account_id' ORDER BY `total_reactions` DESC");
    $sql->execute(); 
    $ad_graphic = $sql->fetchAll();
    
    //$count = count($result);
    
    $graphic_array = ['campaign_graphic'=> $campaign_graphic, 'ad_graphic'=> $ad_graphic ];
    echo json_encode($graphic_array);
	        
}
