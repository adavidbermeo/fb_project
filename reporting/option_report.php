<?php  
// namespace functions\submit;
        if(isset($_GET['selected'])){
                $statistics_array = $_GET['selected'];

                echo '<div class="menu">';
                echo "<a href='index.php?click=insert_$statistics_array' id='campaign'><img src='img/campaign.png' alt='Index Background'></a>";
                echo "<a href='index.php?click=select_$statistics_array' id='ad'><img src='img/ads.png' alt='Index Background'></a>";
                echo "<a href='index.php?click=delete_$statistics_array' id='page'><img src='img/page.png' alt='Index Background'></a>";
                echo "</div>";
        }
?>
<script src="js/reporting.js">
        