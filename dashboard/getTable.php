<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/include/include_click.php');
use metrics\ads\AdInsights;
use metrics\adset\AdsetInsights;
use metrics\page\PageInsights;
use metrics\post\PostInsights;

    if(isset($_POST['selected'])){
        $selected = $_POST['selected'];
        list($url, $click) = explode('=', $selected);
        list($click_value,$data) = explode('*', $click);
        list($id_page, $ad_account_id) = explode('%', $data); 

        getData($ad_account_id, $id_page);
    }

function getData($ad_account_id, $id_page){
    
    //Visión General de la pagina
    $PageInsights = new PageInsights($id_page,$ad_account_id);
    $PageInsights->dashboardPerformanceGeneralTable();

    //Visión General de los Anuncios
    $AdInsights = new AdInsights($ad_account_id);
    $AdInsights->dashboardAdsOverview();

    //Rendimiento de pagina por fecha
    $PageInsights->dashboardGetFansCityTable();
}