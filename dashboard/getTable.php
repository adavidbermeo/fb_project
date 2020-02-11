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

        getData($ad_account_id, $id_page, $_REQUEST['start_date'],$_REQUEST['end_date']);
    }

function getData($ad_account_id, $id_page, $start_date, $end_date){
    
    //Visión General de la pagina
    $PageInsights = new PageInsights($id_page,$ad_account_id,$start_date, $end_date);
    $PageInsights->dashboardPerformanceGeneralTable();
    $PageInsights->dashboardGetFansCityTable();

    // //Visión General de los Anuncios
    $AdInsights = new AdInsights($ad_account_id,$start_date, $end_date);
    $AdInsights->dashboardAdsOverview();

    //Rendimiento de pagina por fecha
    

    // // Principales publicaciones
    // $PostInsights = new PostInsights($id_page,$ad_account_id);
    // $PostInsights->mainPublicactions(); 

    // Reacciones de las publicaciones 
    
    // $PostInsights->reactionsTable();

    //Principales Conjuntos de Anuncios en Facebook    
    // $AdSetInsights = new AdsetInsights($ad_account_id,$start_date, $end_date);
    // $AdSetInsights->adsetDahboard();

    //Principales Anuncios de Facebook 

    // $AdInsights->gashboardAdDetails();
}