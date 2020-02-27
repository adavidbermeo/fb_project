<?php  
namespace functions\submit;

        if(isset($_POST['search'])){
                $data = $_POST['search'];

                echo '<div class="menu">';
                echo "<a href='index.php?click=yesCampaign*$data' id='campaign' class='search-option'><img src='img/campaign-option.png' alt='Campaign Reporting'></a>";
                echo "<a href='index.php?click=yesPost*$data' id='post' class='search-option'><img src='img/facebooksearch1.png' alt='Post Reporting'></a>";
                echo "<a href='index.php?click=yesPage*$data' id='page' class='search-option'><img src='img/pages-icon.png' alt='Page Reporting'></a><br>";
                echo "<a href='index.php?click=dashboard*$data' id='custom-dashboard'><img src='img/dashboard.png' alt='Account Dashboard'></a>";
                echo "<a href='index.php?click=yesAd*$data' id='ad' class='search-option'><img src='img/ads-option.png' alt='Ad Reporting'></a>";
                echo "<a href='index.php?click=yesAdset*$data' id='adset' class='search-option'><img src='img/adsets.jpg' alt='Adset Reporting'></a>";
                echo "</div>";
           
        }
?>

<script src="js/click.js"></script>
<script src="dashboard/js/click_dashboard.js">
        

   
                    