<?php  
// namespace functions\submit;

        if(isset($_GET['selected'])){
                $option = $_GET['selected'];
                print_r($option);
                list($url, $values) = explode('?', $option);

                echo "<div class='report-options'>
                <a href='index.php?click=insert%$values' id='campaign'>INSERT</a>
                <a href='index.php?click=generalselect%$values' id='ad'>GENERAL SELECT</a>
                <a href='index.php?click=specificselect%$values' id='ad'>SPECIFIC SELECT</a>
                <a href='index.php?click=delete%$values' id='page'>DELETE</a>
                </div>";
        }
?>
<script type="text/javascript" src="js/report_data.js"></script>
