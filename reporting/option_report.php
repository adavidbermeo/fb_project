<?php  
// namespace functions\submit;

        if(isset($_GET['selected'])){
                $option = $_GET['selected'];
                // echo $option . "<br>";
                list($url, $values) = explode('?', $option);
                // echo $url . "<br>";
                // echo $values . "<br>";

                // list($value1, $value2, $value3) = explode ('&',$values);
                // echo "<br><br><br>";
                // echo $key . "<br>";
                // echo $value . "<br>";
                // echo $value2 . "<br>";

                echo "<div class='report-options'>
                <a href='index.php?click=insert%$values' id='campaign'>INSERT</a>
                <a href='index.php?click=select%$values' id='ad'>SELECT</a>
                <a href='index.php?click=delete%$values' id='page'>DELETE</a>
                </div>";
        }
?>
<script src="js/reporting.js">
        