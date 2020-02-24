<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/include/include_click.php');
use metrics\ads\AdInsights;
use metrics\adset\AdsetInsights;
use metrics\page\PageInsights;
use metrics\posts\PostInsights;

    if(isset($_REQUEST['selected'])){

        $selected = $_REQUEST['selected'];
        list($url, $click) = explode('=', $selected);
        list($click_value,$data) = explode('*', $click);
        list($id_page, $ad_account_id) = explode('%', $data); 

        getData($ad_account_id, $id_page, $_REQUEST['start_time'], $_REQUEST['end_time']);
    }

function getData($ad_account_id, $id_page, $start_time, $end_time){

    //Page Insights
    $PageInsights = new PageInsights($id_page,$ad_account_id,$start_time, $end_time);
    $page_insights_array = $PageInsights->account_info_array;
    

    //Ad Insights
    $AdInsights = new AdInsights($ad_account_id,$start_time, $end_time);
    $ad_insights_array = $AdInsights->adInsights;

    // // Post Insights
    $PostInsights = new PostInsights($id_page,$ad_account_id, $start_time, $end_time);
    $post_insights_array = $PostInsights->adPerformance;

    //Adset Insights   
    $AdSetInsights = new AdsetInsights($ad_account_id,$start_time, $end_time);  
    $adset_insights_array = $AdSetInsights->adsetInsights;

    /* Table Values Array */
    $table_values_array = ['adset_insights' => $adset_insights_array, 'post_insights'=> $post_insights_array, 'ad_insights'=> $ad_insights_array, 'page_insights'=> $page_insights_array ];
    echo json_encode($table_values_array);
}