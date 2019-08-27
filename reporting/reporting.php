<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/include/include_click.php');
    use metrics\ads\ByAccountAd;
    use Database\DbStatistics;

    if(isset($_GET['selected'])){

        $selected = $_GET['selected'];
        reportingInfo($selected);

    }elseif(isset($_POST['db_field'],$_POST['field_value'],$_POST['parameter'])){
        $click = $_POST['parameter'];
        $db_field = $_POST['db_field'];
        $db_field_value = $_POST['field_value'];

        // list($action_selected, $values) = explode('%', $click);

        // list($index1,$index2,$index3) = explode('&',$values);

        // $indexs = [$index1, $index2, $index3];
        // foreach ($indexs as $index) {
        //     list($entrada[], $index_value[]) = explode('=',$index);
        // }

        //Execute function
        reportingInfo($click, $db_field, $db_field_value);

    }else{
        echo "There is no data";
    }
    function reportingInfo($selected, $db_field = 0, $db_field_value = 0){
        if($db_field and $db_field_value){
            $click = $selected;
            list($action_selected, $values) = explode('%', $click);
        
            list($index1,$index2,$index3) = explode('&',$values);
            $indexs = [$index1, $index2, $index3];
            foreach ($indexs as $index) {
                list($entrada[], $index_value[]) = explode('=',$index);
            }        
        }else{
            list($url, $click) = explode('?click=', $selected);
    
            list($action_selected, $values) = explode('%', $click);
            
            list($index1,$index2,$index3) = explode('&',$values);
            $indexs = [$index1, $index2, $index3];
            foreach ($indexs as $index) {
                list($entrada[], $index_value[]) = explode('=',$index);
            }        
        }

        $first_value = $index_value[0];
        $ad_account_id = $index_value[1];
        $db_table_name = $index_value[2]; 

        //list($action_selected, $parameters) = explode('_', $click);
        
        echo '<div class="repeat">';
        echo "<a href='index.php?click=insert%". $values ."'>Insert</a>";
        echo "<a href='index.php?click=specificselect%". $values ."'>Specific Select</a>";
        echo "<a href='index.php?click=generalselect%". $values ."'>General Select</a>";
        echo "<a href='index.php?click=delete%". $values ."'>Delete</a>";
        echo "</div>";

        echo "<h3>Reporting System &copy;</h3>";
        // echo $parameters;
        switch ($action_selected){
            case 'insert':  
                switch ($db_table_name) {
                    case 'ad':
                        
                        $ad = new ByAccountAd($first_value,$ad_account_id);
                        $array = $ad->adPerformance;
                        // $fields = array_keys($ad->adPerformance);
                        // print_r($fields);

                        $database = new DbStatistics('localhost','root','','fb_project');
                        $database->connectDatabase();
                        $database->insertAd($db_table_name, $array);
                        break;
                     case 'campaign':
                        $campaign = new ByAccountCampaign('');
                        $database = new DbStatistics('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                     case 'page':
                        $page = new ByAccountPage('');
                        $database = new DbStatistics('localhost','root','','fb_project');
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
                        $ad = new ByAccountAd($first_value,$ad_account_id);
                        $database = new DbStatistics('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                     case 'campaign':
                        $campaign = new ByAccountCampaign('');
                        $database = new DbStatistics('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                     case 'page':
                        $page = new ByAccountPage('');
                        $database = new DbStatistics('localhost','root','','fb_project');
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
                        $ad = new ByAccountAd($first_value, $ad_account_id);
                        $array = $ad->adPerformance;

                        $database = new DbStatistics('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action($action_selected, $db_table_name, $array, $db_field, $db_field_value);
                        break;
                     case 'campaign':
                        $campaign = new ByAccountCampaign('');
                        $database = new DbStatistics('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                     case 'page':
                        $page = new ByAccountPage('');
                        $database = new DbStatistics('localhost','root','','fb_project');
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
                        $database = new DbStatistics('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                     case 'campaign':
                        $campaign = new ByAccountCampaign('');
                        $database = new DbStatistics('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;
                     case 'page':
                        $page = new ByAccountPage('');
                        $database = new DbStatistics('localhost','root','','fb_project');
                        $database->connectDatabase();

                        $database->action();
                        break;    

                    default:
                        echo ""
                        break;
                }
                break;
            }
        }
    ?>
    <script src="js/repeat_reporting.js">


