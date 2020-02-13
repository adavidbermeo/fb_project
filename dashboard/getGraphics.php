<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/include/include_click.php');

use metrics\page\PageInsights;
use metrics\ads\AdInsights;
    
    if(isset($_REQUEST['selected'])){
        $selected = $_REQUEST['selected'];
        //$selected = $_REQUEST['selected'];
        // echo $selected; 
        
        list($url, $click) = explode('=', $selected);
        list($click_value,$data) = explode('*', $click);
        list($id_page, $ad_account_id) = explode('%', $data); 

        getData($id_page,$ad_account_id,$_REQUEST['start_time'],$_REQUEST['end_time']);
    }

function getData($id_page,$ad_account_id, $start_date, $end_date){

    //Page Insights

    $PageInsights = new PageInsights($id_page, $ad_account_id, $start_date, $end_date);
    $page_insights_array = $PageInsights->account_info_array;
    
    // Ad Insights
    
    $AdInsights = new AdInsights($ad_account_id,$start_date, $end_date);
    $ad_insights_array = $AdInsights->adInsights;

    /* Ad Clicks per Date */

    $age = ($ad_insights_array['ad_clicks_per_age']);
    // $fans_city = $by_account_page->account_info_array['fans_city']
     $ages = [];
     foreach($age as $key => $value){
         array_push($ages, ['key' => $key, 'value'=> $value]); 
     }
     $ad_insights_array['ad_clicks_per_age'] = $ages;

    /* Page Impressions Per Age */

     $impressions = ($page_insights_array['page_impressions_per_age']);
     $impressions_per_age = [];
     foreach($impressions as $key => $value){
         array_push($impressions_per_age, ['key' => $key, 'value'=> $value]); 
     }
     $page_insights_array['page_impressions_per_age'] = $impressions_per_age;


    // Send to cdashboard.js
    $graphic_array = ['page_graphic'=> $page_insights_array, 'ad_graphic'=> $ad_insights_array];
    // print_r($graphic_array);
    echo json_encode($graphic_array);
    //  echo 'ss'; 
}
