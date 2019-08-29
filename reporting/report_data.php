<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/include/include_click.php');
    use metrics\ads\ByAccountAd;
    use metrics\campaign\ByAccountCampaign;
    use metrics\page\ByAccountPage;
    use functions\AccountsPageData;

    if(isset($_GET['selected'])){
        
        $selected = $_GET['selected'];
        list($url, $click) = explode('?click=', $selected);
        list($action_selected, $values) = explode('%', $click);
        list($index1,$index2,$index3) = explode('&',$values);
        $indexs =[$index1,$index2,$index3];
        foreach ($indexs as $index){
            list($entrada[],$index_value[]) = explode('=',$index);
        }
        generateResponse($index_value,$action_selected,$click);

    }
    function generateResponse($index_value,$action_selected,$click){
        
        $first_value = $index_value[0];
        $ad_account_id = $index_value[1];
        $db_table_name = $index_value[2]; 
        // Load Script to action
        echo "<script src='js/get_reporting.js'></script>";
        echo "<script src='js/post_reporting.js'></script>";

        switch ($action_selected) {
            case 'insert':
              
                    echo "Se insertara el actual registro consultado. ¿Desea continuar?";
                    echo '<div class="call">';
                    echo "<a href='index.php?click=$click'>Si</a>";
                    echo "</div>";
                    echo "<a href='index.php'>No</a>";    
                   
                break;
            case 'generalselect':

                    echo "Se procedera a consultar todos los registros de los anuncios existentes. ¿Desea continuar?";
                    echo "<div class='call'>";
                    echo "<a href='index.php?click=$click'>Si</a>";
                    echo "</div>";
                    echo "<a href='index.php'>No</a>";
                 
                break;
            case 'specificselect':
            case 'delete':
                switch ($db_table_name) {
                    case 'ad':
                    echo $click;
                        $ad = new ByAccountAd($first_value, $ad_account_id);
                        $keys = array_keys($ad->adPerformance);
                        echo "
                        <datalist id='db_fields'>";
                        foreach ($keys as $key) {
                            echo '<option id="option" value="'.$key .'"' .
                            ' label="options">' . '</option>';
                        }
                        echo   
                        "</datalist>"; 
                        
                            echo "
                            <h3>$db_table_name Query</h3>
                            <form id='consulta'>
                                <input list='db_fields' name='db_field' placeholder='Select a field' id='db_field'>
                                <input name='db_values' placeholder='Field value' id='db_values'>
                                <input type='hidden' name='parameters' id='parameters' value='". $click ."'>
                                <input type='submit' value='SEND DATA'>
                            </form>
                        ";
                    break;
                    case 'campaign':
                    echo $click;
                       $campaign = new ByAccountCampaign($ad_account_id);
                        $keys = array_keys($campaign->db_campaign_statistics);
                        echo "
                        <datalist id='db_fields'>";
                        foreach ($keys as $key) {
                            echo '<option id="option" value="'.$key .'"' .
                            ' label="options">' . '</option>';
                        }
                        echo   
                        "</datalist>"; 
                        
                            echo "
                            <h3>$db_table_name Query</h3>
                            <form id='consulta'>
                                <input list='db_fields' name='db_field' placeholder='Select a field' id='db_field'>
                                <input type='text' name='db_values' placeholder='Field value' id='db_values'>
                                <input type='hidden' name='parameters' id='parameters' value='". $click ."'>
                                <input type='submit' value='SEND DATA'>
                            </form>
                        ";
                    break;
                    case 'page':
                        $page = new ByAccountPage($first_value,$ad_account_id);
                        $keys = array_keys($page->db_account_info_array);
                        echo "
                        <datalist id='db_fields'>";
                        foreach ($keys as $key) {
                            echo '<option id="option" value="'.$key .'"' .
                            ' label="options">' . '</option>';
                        }
                        echo   
                        "</datalist>"; 
                        
                            echo "
                            <h3>$db_table_name Query</h3>
                            <form id='consulta'>
                                <input list='db_fields' name='db_field' placeholder='Select a field' id='db_field'>
                                <input name='db_values' placeholder='Field value' id='db_values'>
                                <input type='hidden' name='parameters' id='parameters' value='". $click ."'>
                                <input type='submit' value='SEND DATA'>
                            </form>
                        ";
                    break;
                    case 'account':
                        $account = new AccountsPageData();
                        $keys = array_keys($account->db_page_data);
                        echo "
                        <datalist id='db_fields'>";
                        foreach ($keys as $key) {
                            echo '<option id="option" value="'.$key .'"' .
                            ' label="options">' . '</option>';
                        }
                        echo   
                        "</datalist>"; 
                        
                            echo "
                            <h3>$db_table_name Query</h3>
                            <form id='consulta'>
                                <input list='db_fields' name='db_field' placeholder='Select a field' id='db_field'>
                                <input name='db_values' placeholder='Field value' id='db_values'>
                                <input type='hidden' name='parameters' id='parameters' value='". $click ."'>
                                <input type='submit' value='SEND DATA'>
                            </form>
                        ";
                    break;            
                    default:
                        echo "There is no data";
                    break;
                }
                break;
            default:
                echo "An unexpected error has ocurred";
                break;
        }
           
    }

