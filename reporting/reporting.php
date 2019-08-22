<?php 
    require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/database/insert_statistics.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="js/account_click.js">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporting System</title>
</head>
<body>
    <?
    if(isset($_GET['selected'])){
        $statistics_array = $_GET['selected'];
        reportingInfo($statistics_array);
    }else{
        echo "There is no data";
    }
    function reportingInfo($statistics_array){

        echo "
        <h1>Reporting System &copy;</h1>
        
        <div class='buttons'>
        <a href='index.php?click=insert_$statistics_array'></a>
        <a href='index.php?click=select_$statistics_array'></a>
        <a href='index.php?click=delete_$statistics_array'></a>
        </div>";
        
        switch ($click_value) {
            case 'insert':
            //For Campaign Info   
                $database = new Database();
                
                break;
            case 'select':
            //For Ad Info
                $database = new Database();

                break;
            case 'delete':
            //For Page Info
                $database = new Database();

                break;
            default:
                
                break;
        }
    }
    ?>
    </body>
    </html>
    


