<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/include/include_click.php');
    use functions\AccountsPageData;       
    use metrics\campaign\ByAccountCampaign;
    use metrics\ads\ByAccountAd;
    use metrics\page\ByAccountPage;
    use metrics\ads\AdIds;
    
    if (isset($_GET['selected'])) {
        $selected = $_GET['selected'];
        list($url, $click) = explode('=', $selected);
        showInfo($click);
    }
  
    function showInfo($click){
        global $AccountsPageData;
        list($click_value,$data) = explode('*', $click);
        list($id_page, $ad_account_id) = explode('%', $data); 
        
        echo '<div class="buttons">';
        echo "<a href='index.php?click=yesCampaign*$data' class='search-option'>Campaign</a>";
        echo "<a href='index.php?click=yesAd*$data' class='search-option'>Ad</a>";
        echo "<a href='index.php?click=yesPage*$data' class='search-option'>Page</a>";
        echo "</div>";
        
        switch ($click_value) {
            case 'yesCampaign':
            //For Campaign Info   
               
                echo "<h1>Campaign Statistics</h1>";
                $by_account_campaign = new ByAccountCampaign($ad_account_id);  
                $by_account_campaign->getCampaignStatisticsTable(); 
                $by_account_campaign->callReporting(); 
                break;
            case 'yesAd':
            //For Ad Info
                echo "<h1>Ad Statistics</h1>";
                $by_account_ad = new ByAccountAd($id_page, $ad_account_id);
                $by_account_ad->getAdPerformanceTable();
                $by_account_ad->callReporting();
                break;
            case 'yesPage' :
            //For Page Info
                echo "<h1>Page Fans</h1>";
                $by_account_page = new ByAccountPage($id_page,$ad_account_id, 1);
                $by_account_page->getAdPerformanceGeneralTable();
                $by_account_page->getAgeGenderTable();
                $by_account_page->getfansCityTable();
                $by_account_page->callReporting();
                break;
            default:
                echo "The model case does not exist";
                break;
        }
    }
?>
<script src="js/accounts_click.js">
    