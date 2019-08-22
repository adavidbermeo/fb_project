<?php  
// namespace functions\submit;
        if(isset($_POST['search'])){
                $option = $_POST['search'];
                list($selected_page_name, $selected_register_id) = explode('-  ', $option);
                echo '<div class="menu">';
                echo "<a href='index.php?click=insert_$selected_register_id' id='campaign'><img src='img/campaign.png' alt='Index Background'></a>";
                echo "<a href='index.php?click=select_$selected_register_id' id='ad'><img src='img/ads.png' alt='Index Background'></a>";
                echo "<a href='index.php?click=delete_$selected_register_id' id='page'><img src='img/page.png' alt='Index Background'></a>";
                echo "</div>";
        }
?>
<script src="js/reporting.js">
        