<?php 
    require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/database/insert_statistics.php'); 

    if(isset($_GET['selected'])){
        $selected = $_GET['selected'];
        echo $selected;
        list($url, $click) = explode('=', $selected);
        reportingInfo($click);
    }else{
        echo "There is no data";
    }
    function reportingInfo($click){
        list($action_selected, $parameters) = explode('_', $click);
        
        echo '<div class="buttons">';
        echo "<a href='index.php?click=insert_$parameters'>Insert</a>";
        echo "<a href='index.php?click=select_$parameters'>Select</a>";
        echo "<a href='index.php?click=delete_$parameters'>Delete</a>";
        echo "</div>";

        echo "<h3>Reporting System &copy;</h3>";
        // echo $parameters;
        switch ($action_selected){
            case 'insert':
                   
                switch ($table_name) {
                    case 'ad':
                        $ad = new ('');
                        $database = new Database('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                    
                    default:
                        # code...
                        break;
                }
               

                break;
            case 'select':
                
                $database = new Database('localhost','root','','fb_project');
                $database->connectDatabase();
                $database->action();

                break;
            case 'delete':
                
                $database = new Database('localhost','root','','fb_project');
                $database->connectDatabase();
                $database->action();

                break;
            default:
                echo "An unexpected error has ocurred";
                break;
        }
    }
    ?>
    <script src="js/repeat_report.js">


