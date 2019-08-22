<?php  
// namespace functions\submit;
        if(isset($_GET['selected'])){
                $parameters = $_GET['selected'];

                echo '<div class="menu">';
                echo "<a href='index.php?click=insert_$parameters' id='campaign'><img src='img/campaign.png' alt='Index Background'></a>";
                echo "<a href='index.php?click=select_$parameters' id='ad'><img src='img/ads.png' alt='Index Background'></a>";
                echo "<a href='index.php?click=delete_$parameters' id='page'><img src='img/page.png' alt='Index Background'></a>";
                echo "</div>";
        }
?>
<script src="js/reporting.js">
        