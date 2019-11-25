<?php
// Db Connection 
require_once('database/connectDb.php');

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

    $sql = $conn->prepare("SELECT `total_new_likes` FROM `page` WHERE `ad_account_id` = '$ad_account_id'");
    $sql->execute();
    $result = $sql->fetchAll();
    for($i=0; $i<count($result); $i++){
        echo '<div id="dash_section"><b>' . 'Total New Likes' . '</b><br>' . $result[0]['total_new_likes']. '</div>';
    }
    
    $sql = $conn->prepare("SELECT `interactions` FROM `ad` WHERE `ad_account_id` = '$ad_account_id'");
    $sql->execute();
    $result = $sql->fetchAll();

    for($i=0; $i<count($result); $i++){
            $interactions_array[] = $result[$i]['interactions'];
    }
        echo '<div id="dash_section"><b>' . 'Interactions' . '</b><br>' . $result[0]['interactions']. '</div>';

    $sql = $conn->prepare("SELECT `cost_per_lead`,`spend` FROM `campaign` WHERE `ad_account_id` = '$ad_account_id'");
    $sql->execute();
    $result = $sql->fetchAll();

        for($i=0; $i<count($result); $i++){
        $cost_per_lead[] = $result[$i]['cost_per_lead'];
        $spend[] = $result[$i]['spend'];
    }
    $total_cpl = array_sum($cost_per_lead);

    echo '<div id="dash_section"><b>' . 'cost_per_lead' . '</b><br>' . $total_cpl / count($cost_per_lead) . '</div>';
    echo '<div id="dash_section"><b>' . 'spend' . '</b><br>' . array_sum($spend). '</div>';
}