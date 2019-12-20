<?php
// Db Connection 
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/database/connectDb.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/metrics/page/by_account_page.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/metrics/ads/by_account_ad.php');

use metrics\page\ByAccountPage;
    
    if(isset($_POST['selected'])){
        //$selected = 'index.php?click=dashboard*303239893027115%act_131251207293544';
        $selected = $_POST['selected'];
        // echo $selected; 
        
        list($url, $click) = explode('=', $selected);
        list($click_value,$data) = explode('*', $click);
        list($id_page, $ad_account_id) = explode('%', $data); 

        getData($id_page,$ad_account_id);
    }

function getData($id_page,$ad_account_id){
    
	//setting header to json
	$db = new database();
	$conn = $db->conn();

    // Campaign Graphics
    $sql = $conn->prepare("SELECT `campaign_id`,`campaign_name`,`clicks` FROM `campaign` WHERE `ad_account_id` ='$ad_account_id' ORDER BY `clicks` DESC");
    $sql->execute();
    $campaign_graphic = $sql->fetchAll();

    // Ad Graphics
    $sql = $conn->prepare("SELECT * FROM `ad` WHERE `ad_account_id` ='$ad_account_id' ORDER BY `total_reactions` DESC");
    $sql->execute(); 
    $ad_graphic = $sql->fetchAll();
    
    //Age - Gender

    $by_account_page = new ByAccountPage($id_page, $ad_account_id);
    $fans_age_gender = $by_account_page->account_info_array['fans_age_gender'];
    
    $age_gender_array = [];
    foreach($fans_age_gender as $key => $value){
        array_push($age_gender_array, array("key"=>$key,"value"=>$value));
    }

    $fans_city = $by_account_page->account_info_array['fans_city'];

    $fans_city_array = [];
    foreach($fans_city as $key => $value){
        array_push($fans_city_array, ['key' => $key, 'value'=> $value]); 
    }
    //print_r($by_account_page->account_info_array['fans_age_gender']);

    // Tabla de metricas general 
    

    /**
     * Resume Dashboard Table
     */
    
    /* 
    $by_account_ad = new ByAccountAd($id_page, $ad_account_id, 0);
    $reach = $by_account_ad->adPerformance['total_impressions'];
    $likes = $by_account_ad->adPerformance['likes'];
    $comments = $by_account_ad->adPerformance['comments'];
    $shares = $by_account_ad->adPerformance['shares'];
    $clicks = $by_account_ad->adPerformance['post_clicks']; */

    // Send to cdashboard.js
    $graphic_array = ['campaign_graphic'=> $campaign_graphic, 'ad_graphic'=> $ad_graphic, 'fans_age_gender'=> $age_gender_array, 'fans_city' => $fans_city_array];
    //print_r($graphic_array);
    echo json_encode($graphic_array);
       
}
