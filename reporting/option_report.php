<?php  
// namespace functions\submit;

        if(isset($_GET['selected'])){
                $option = $_GET['selected'];
                list($url, $parameters) = explode('=', $option);
                

                echo "<div class='report-options'>
                <a href='index.php?click=insert_$parameters' id='campaign'>INSERT</a>
                <a href='index.php?click=select_$parameters' id='ad'>SELECT</a>
                <a href='index.php?click=delete_$parameters' id='page'>DELETE</a>
                </div>";
        }
?>
<script src="js/reporting.js">
        