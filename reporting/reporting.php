<?php 
    require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/database/insert_statistics.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/include/include_click.php');
    use metrics\ads\ByAccountAd;

    if(isset($_GET['selected'])){
        $selected = $_GET['selected'];

        list($url, $click) = explode('?click=', $selected);
        list($action_selected, $values) = explode('%', $click);
        list($index1,$index2,$index3) = explode('&',$values);
        $indexs = [$index1, $index2, $index3];
        foreach ($indexs as $index) {
            list($entrada[], $index_value[]) = explode('=',$index);
        }
       print_r($entrada);
       print_r($index_value);
            
        //Execute function
        reportingInfo($action_selected, $index_value);

    }elseif(isset($_POST['db_field'],$_POST['field_value'],$_POST['parameter'])){
        
        echo $click = $_POST['parameter'];
        list($action_selected, $values) = explode('%', $click);

        list($index1,$index2,$index3) = explode('&',$values);

        $indexs = [$index1, $index2, $index3];
        foreach ($indexs as $index) {
            list($entrada[], $index_value[]) = explode('=',$index);
        }

        //Execute function
        reportingInfo($action_selected, $index_value);

    }else{
        echo "There is no data";
    }
    function reportingInfo($action_selected, $index_value){
        $db_table_name = $index_value[2]; 
        //list($action_selected, $parameters) = explode('_', $click);
        
        // echo '<div class="buttons">';
        // echo "<a href='index.php?click=insert%$values'>Insert</a>";
        // echo "<a href='index.php?click=select%$values'>Select</a>";
        // echo "<a href='index.php?click=delete%$values'>Delete</a>";
        // echo "</div>";

        echo "<h3>Reporting System &copy;</h3>";
        // echo $parameters;
        switch ($action_selected){
            case 'insert':  
                switch ($db_table_name) {
                    case 'ad':
                        $ad = new ByAccountAd($index_value[0],$index_value[1]);
                        $field_value = $ad->adPerformance;
                        $fields = array_keys($ad->adPerformance);
                        print_r($fields);

                        $database = new Database('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action($action_selected, $db_table_name, $fields, $field_value);
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
            case 'generalselect':
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
            case 'specificselect':
               switch ($db_table_name) {
                    case 'ad':
                    echo "LLEGA AQUI";
                        // $ad = new ByAccountAd('');
                        // $database = new Database('localhost','root','','fb_project');
                        // $database->connectDatabase();

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


