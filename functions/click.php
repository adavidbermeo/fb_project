<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/include/include_click.php');
    use functions\AccountsPageData;       
    use metrics\campaign\ByAccountCampaign;
    use metrics\ads\ByAccountAd;
    use metrics\page\ByAccountPage;
    use metrics\ads\AdIds;

    $AccountsPageData = new AccountsPageData();

    if (isset($_GET['selected'])) {
        $selected = $_GET['selected'];
        list($url, $click) = explode('=', $selected);
        showInfo($click);
    }
  
    function showInfo($click){
        global $AccountsPageData;
        list($click_value, $selected_register_id) = explode('_', $click); 

        echo '<div class="buttons">';
        echo "<a href='index.php?click=yesCampaign_$selected_register_id'>Campaign</a>";
        echo "<a href='index.php?click=yesAd_$selected_register_id'>Ad</a>";
        echo "<a href='index.php?click=yesPage_$selected_register_id'>Page</a>";
        echo "</div>";
        
        
        switch ($click_value) {
            case 'yesCampaign':
            //For Campaign Info   
                $ad_account_id = $AccountsPageData->page_data['ad_account_id'][$selected_register_id];
                echo "<h1>Campaign Statistics</h1>";
                $by_account_campaign = new ByAccountCampaign($ad_account_id); 
                $by_account_campaign->getCampaignStatisticsTable(); 
                $by_account_campaign->callReporting(); 
                break;
            case 'yesAd':
            //For Ad Info
                $id_page = $AccountsPageData->page_data['page_id'][$selected_register_id];
                $ad_account_id = $AccountsPageData->page_data['ad_account_id'][$selected_register_id];
                // $ad_ids_object = new AdIds($ad_account_id); 
                echo "<h1>Ad Statistics</h1>";
                $by_account_ad = new ByAccountAd($id_page, $ad_account_id);
                $by_account_ad->getAdPerformanceTable();
                $by_account_ad->callReporting();
                break;
            case 'yesPage' :
            //For Page Info
                
                $id_page = $AccountsPageData->page_data['page_id'][$selected_register_id];
                $ad_account_id = $AccountsPageData->page_data['ad_account_id'][$selected_register_id];
                echo "<h1>Page Fans</h1>";
                $by_account_page = new ByAccountPage($id_page,$ad_account_id, 1);
                $by_account_page->getAdPerformanceGeneralTable();
                $by_account_page->getAgeGenderTable();
                $by_account_page->getfansCityTable();
                $by_account_page->callReporting();
                break;
            default:
                
                break;
        }
    }
?>
<script src="js/account_click.js">
    