<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/include/include_click.php');
    use metrics\ads\ByAccountAd;
    use metrics\campaign\ByAccountCampaign;
    use metrics\page\ByAccountPage;
    use functions\AccountsPageData;
    use Database\DbStatistics;

    if(isset($_GET['selected'])){

        $selected = $_GET['selected'];
        reportingInfo($selected);

    }elseif(isset($_POST['db_field'],$_POST['field_value'],$_POST['parameter'])){
        
        $click = $_POST['parameter'];
        $db_field = $_POST['db_field'];
        $db_field_value = $_POST['field_value'];

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

        /***
         * Database Object
         */
        $database = new DbStatistics('localhost','root','','fb_project');

        switch ($action_selected){
            case 'insert':  
                switch ($db_table_name) {
                    case 'ad':
                        $ad = new ByAccountAd($first_value,$ad_account_id);
                        $ad_array = $ad->adPerformance;

                        $database->connectDatabase();
                        $database->insertData($db_table_name, $ad_array);
                        break;
                     case 'campaign':
                        $campaign = new ByAccountCampaign($ad_account_id);
                        $campaign_array = $campaign->db_campaign_statistics; 

                        $database->connectDatabase();
                        $database->insertData($db_table_name, $campaign_array);
                        break;
                     case 'page':
                        $page = new ByAccountPage($first_value, $ad_account_id,0);
                        $page_array = $page->db_account_info_array;

                        $database->connectDatabase();
                        $database->insertData($db_table_name, $page_array);
                        break;
                     case 'account':
                        $account = new AccountsPageData();
                        $account_array = $account->db_page_data;

                        $database->connectDatabase();
                        $database->insertData($db_table_name, $account_array);
                        break;    
                    default:
                        echo "The model case does not exist";
                        break;
                }
                break;
            case 'generalselect':

                $database->connectDatabase();
                $database->generalSelectData($db_table_name, $ad_account_id);
                break;        

            case 'specificselect':

                $database->connectDatabase();
                $database->specificSelectData($db_table_name, $ad_account_id, $db_field, $db_field_value);
                break;

            case 'delete':
                $database->connectDatabase();
                $database->deleteData($db_table_name,$db_field, $db_field_value,$ad_account_id);   
                break;
            }
        }
    ?>
    <script src="js/repeat_reporting.js">


