<?php  
namespace functions\submit;
        if(isset($_POST['search'])){
                $data = $_POST['search'];

                echo '<div class="menu">';
                echo "<a href='index.php?click=yesCampaign*$data' id='campaign'><img src='img/campaign.png' alt='Index Background'></a>";
                echo "<a href='index.php?click=yesAd*$data' id='ad'><img src='img/ads.png' alt='Index Background'></a>";
                echo "<a href='index.php?click=yesPage*$data' id='page'><img src='img/page.png' alt='Index Background'></a>";
                echo "</div>";
        }
?>
<script src="js/click.js">
        
        

   
                    