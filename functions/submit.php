<?php  
namespace functions\submit;

        if(isset($_POST['search'])){
                $data = $_POST['search'];

                echo '<div class="menu">';
                echo "<a href='index.php?click=yesCampaign*$data' id='campaign' class='search-option'><img src='img/campaign.png' alt='Campaign Reporting'></a>";
                echo "<a href='index.php?click=yesPost*$data' id='post' class='search-option'><img src='img/post_insights.jpg' alt='Post Reporting'></a>";
                echo "<a href='index.php?click=yesPage*$data' id='page' class='search-option'><img src='img/page.png' alt='Page Reporting'></a><br>";
                echo "<a href='index.php?click=dashboard*$data' id='custom-dashboard'><img src='img/dashboard.png' alt='Account Dashboard'></a>";
                echo "<a href='index.php?click=yesAd*$data' id='ad' class='search-option'><img src='img/ads.png' alt='Ad Reporting'></a>";
                echo "<a href='index.php?click=yesAdset*$data' id='adset' class='search-option'><img src='img/adsets.jpg' alt='Adset Reporting'></a>";
                echo "</div>";
           
        }
?>

<script src="js/clicks.js"></script>
<script src="dashboard/js/gdashboard.js"></script>
        

   
                    