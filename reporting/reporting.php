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
        $selected_link = $_GET['selected'];
        reportingInfo($parameters);
    }else{
        echo "There is no data";
    }
    function reportingInfo($parameters){
        list($action_selected, $parameters) = explode('_', $selected_link);
        
        echo "
        <h1>Reporting System &copy;</h1>
        
        <div class='buttons'>
        <a href='index.php?click=insert_$parameters'></a>
        <a href='index.php?click=select_$parameters'></a>
        <a href='index.php?click=delete_$parameters'></a>
        </div>";
        
        echo "Si funciona";
        switch ($action_selected) {
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
    <script src="js/repeat_report.js">
    </body>
    </html>
    


