  <?php 
   require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/include/include_click.php');

    use functions\AccountsPageData;       
    use metrics\campaign\CampaignInsights;
    use metrics\posts\PostInsights;
    use metrics\page\PageInsights;
    use metrics\ads\AdInsights;
    use metrics\adset\AdsetInsights;
    
    if (isset($_REQUEST['data'])) {
        $selected = $_REQUEST['data'];
        list($url, $click) = explode('=', $selected);
        showInfo($click, $_REQUEST['start_date']);
    }
  
    function showInfo($click, $start_date, $end_date = 0){
        global $AccountsPageData;
        list($click_value,$data) = explode('*', $click);
        list($id_page, $ad_account_id) = explode('%', $data); 
        
        // echo '<div class="buttons">';
        //     echo "<a href='index.php?click=yesCampaign*$data' class='search-option'>Campaign</a>";
        //     echo "<a href='index.php?click=yesPost*$data' class='search-option'>Post</a>";
        //     echo "<a href='index.php?click=yesPage*$data' class='search-option'>Page</a>";
        //     echo "<a href='index.php?click=yesAd*$data' class='search-option'>Ads</a>";
        //     echo "<a href='index.php?click=yesAdset*$data' class='search-option'>Adset</a>";
        // echo "</div>";
        
        switch ($click_value){
            case 'yesCampaign':
            //For Campaign Info   
                echo "<h1>Campaign Insights</h1>";
                $CampaignInsights = new CampaignInsights($ad_account_id,$start_date);  
                $CampaignInsights->getCampaignStatisticsTable(); 

                break;
            case 'yesPost':
            //For Ad Info
                echo "<h1>Post Insights</h1>";
                $PostInsights = new PostInsights($id_page, $ad_account_id, $start_date);
                $PostInsights->getAdPerformanceTable();

                break;
            case 'yesPage' :
            //For Page Info
                echo "<h1>Page Insights</h1>";
                $PageInsights = new PageInsights($id_page, $ad_account_id, $start_date);
                $PageInsights->getAdPerformanceGeneralTable();
                $PageInsights->getAgeGenderTable();
                $PageInsights->getfansCityTable();
                $PageInsights->getReachPerCityTable();

                break;
            case 'yesAd':
            //For Page Info
                echo "<h1>Ad Insights</h1>";
                $AdInsights = new AdInsights($ad_account_id, $start_date);
                $AdInsights->adsOverview();
                $AdInsights->adDetails();

                break;
            case 'yesAdset':
            //For Page Info
                echo "<h1>Adset Insights</h1>";
                $AdsetInsights = new AdsetInsights($ad_account_id ,$start_date);
                $AdsetInsights->getAdsetInsightsTable();

                break;
            default:
                echo "The model case does not exist";
                break;
        }
    }