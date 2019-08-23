<?php 
    require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/database/insert_statistics.php'); 

    if(isset($_GET['selected'])){
        echo $selected = $_GET['selected'];
        echo "<br>";
        list($url, $click) = explode('?click=', $selected);
        echo $click . "<br>";
        list($action_selected, $values) = explode('%', $click);
        echo "<br><br><br>";
        echo $action_selected . "<br>";
        echo $values . "<br>";

        list($index1,$index2,$index3) = explode('&',$values);
        echo "<br><br><br>";
        echo $index1 . "<br>";
        echo $index2 . "<br>";
        echo $index3 . "<br>";
        $indexs = [$index1, $index2, $index3];
        foreach ($indexs as $index) {
            list($entrada[], $index_value[]) = explode('=',$index);
        }
       print_r($entrada);
       print_r($index_value);
            
        
        reportingInfo($action_selected, $index_value);
    }else{
        echo "There is no data";
    }
    function reportingInfo($click){
        //list($action_selected, $parameters) = explode('_', $click);
        
        echo '<div class="buttons">';
        echo "<a href='index.php?click=insert%$values'>Insert</a>";
        echo "<a href='index.php?click=select%$values'>Select</a>";
        echo "<a href='index.php?click=delete%$values'>Delete</a>";
        echo "</div>";

        echo "<h3>Reporting System &copy;</h3>";
        // echo $parameters;
        switch ($action_selected){
            case 'insert':
                   
                switch ($db_table_name) {
                    case 'ad':
                        $ad = new ByAccountAd('');
                        $database = new Database('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                     case 'campaign':
                        $campaign = new ByAccountCampaign('');
                        $database = new Database('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                     case 'page':
                        $page = new ByAccountPage('');
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
               switch ($db_table_name) {
                    case 'ad':
                        $ad = new ByAccountAd('');
                        $database = new Database('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                     case 'campaign':
                        $campaign = new ByAccountCampaign('');
                        $database = new Database('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                     case 'page':
                        $page = new ByAccountPage('');
                        $database = new Database('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;    

                    default:
                        # code...
                        break;
                }

                break;
            case 'delete':
                switch ($db_table_name) {
                    case 'ad':
                        $ad = new ByAccountAd('');
                        $database = new Database('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                     case 'campaign':
                        $campaign = new ByAccountCampaign('');
                        $database = new Database('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                     case 'page':
                        $page = new ByAccountPage('');
                        $database = new Database('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;    

                    default:
                        # code...
                        break;
                }
                break;
            }
        }
    ?>
    <script src="js/repeat_report.js">


