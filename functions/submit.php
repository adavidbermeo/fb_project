<?php  
namespace functions\submit;
        if(isset($_POST['search'])){
                $data = $_POST['search'];

                echo '<div class="menu">';
                echo "<a href='index.php?click=yesCampaign*$data' id='campaign' class='search-option'><img src='img/campaign.png' alt='Index Background'></a>";
                echo "<a href='index.php?click=yesAd*$data' id='ad' class='search-option'><img src='img/ads.png' alt='Index Background'></a>";
                echo "<a href='index.php?click=yesPage*$data' id='page' class='search-option'><img src='img/page.png' alt='Index Background'></a><br>";
                 echo "<a href='index.php?click=dashboard*$data' id='custom-dashboard'><img src='img/dashboard.png' alt='Account Dashboard'></a>";
                echo "</div>";
           
        }
?>

<script src="js/clic.js"></script>
<script src="dashboard/js/dashboard.js"></script>

        
        

   
                    