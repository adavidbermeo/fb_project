<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/include/include_click.php');
    use functions\AccountsPageData;       
    use metrics\campaign\CampaignInsights;
    use metrics\posts\PostInsights;
    use metrics\page\PageInsights;
    use metrics\ads\AdInsights;
    
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
        echo "<a href='index.php?click=yesPost*$data' class='search-option'>Post</a>";
        echo "<a href='index.php?click=yesPage*$data' class='search-option'>Page</a>";
        echo "</div>";
        
        switch ($click_value) {
            case 'yesCampaign':
            //For Campaign Info   
               
                echo "<h1>Campaign Insights</h1>";
                $CampaignInsights = new CampaignInsights($ad_account_id);  
                $CampaignInsights->getCampaignStatisticsTable(); 
                $CampaignInsights->callReporting(); 
                break;
            case 'yesPost':
            //For Ad Info
                echo "<h1>Post Insights</h1>";
                $PostInsights = new PostInsights($id_page, $ad_account_id);
                $PostInsights->getAdPerformanceTable();
                $PostInsights->callReporting();
                break;
            case 'yesPage' :
            //For Page Info
                echo "<h1>Page Insights</h1>";
                $PageInsights = new PageInsights($id_page,$ad_account_id, 1);
                $PageInsights->getAdPerformanceGeneralTable();
                $PageInsights->getAgeGenderTable();
                $PageInsights->getfansCityTable();
                $PageInsights->callReporting();
                break;
            case 'yesAd':
            //For Page Info
                echo "<h1>Page Insights</h1>";
                $AdInsights = new AdInsights($ad_account_id);
                // $AdInsights->getAdPerformanceGeneralTable();
                // $AdInsights->getAgeGenderTable();
                // $AdInsights->getfansCityTable();
                // $AdInsights->callReporting();
                break;
            default:
                echo "The model case does not exist";
                break;
        }
    }
?>
<script src="js/accounts_click.js">
    