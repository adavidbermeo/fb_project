<?php
// Db Connection 
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/database/connectDb.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/database/connectDb.php');


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
    
	// //setting header to json
	// $db = new database();
	// $conn = $db->conn();

    // // Campaign Graphics
    // $sql = $conn->prepare("SELECT `campaign_id`,`campaign_name`,`clicks` FROM `campaign` WHERE `ad_account_id` ='$ad_account_id' ORDER BY `clicks` DESC");
    // $sql->execute();
    // $campaign_graphic = $sql->fetchAll();

    // // Ad Graphics
    // $sql = $conn->prepare("SELECT * FROM `ad` WHERE `ad_account_id` ='$ad_account_id' ORDER BY `total_reactions` DESC");
    // $sql->execute(); 
    // $ad_graphic = $sql->fetchAll();
    
    // //Age - Gender

    // $by_account_page = new ByAccountPage($id_page, $ad_account_id);
    // $fans_age_gender = $by_account_page->account_info_array['fans_age_gender'];
    
    // $age_gender_array = [];
    // foreach($fans_age_gender as $key => $value){
    //     array_push($age_gender_array, array("key"=>$key,"value"=>$value));
    // }

    // $fans_city = $by_account_page->account_info_array['fans_city'];

    // $fans_city_array = [];
    // foreach($fans_city as $key => $value){
    //     array_push($fans_city_array, ['key' => $key, 'value'=> $value]); 
    // }
    // /**
    //  * Comments and Shares graphics $ad_graphic
    // */
    

    // // Send to cdashboard.js
    // $graphic_array = ['campaign_graphic'=> $campaign_graphic, 'ad_graphic'=> $ad_graphic, 'fans_age_gender'=> $age_gender_array, 'fans_city' => $fans_city_array];
    // //print_r($graphic_array);
    // echo json_encode($graphic_array);
       
}
