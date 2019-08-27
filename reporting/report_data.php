<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/include/include_click.php');
    use metrics\ads\ByAccountAd;
    use metrics\campaign\ByAccountCampaign;
    use metrics\page\ByAccountPage;

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
                switch ($db_table_name){
                    case 'ad':
                        
                        echo "Se insertara la actual consulta de Anuncios. ¿Desea continuar?";
                        echo '<div class="call">';
                        echo "<a href='index.php?click=$click'>Si</a>";
                        echo "</div>";
                         echo "<a href='index.php'>No</a>";
                    break;
                    case 'campaign':
                        echo "Se insertara la actual consulta de Campañas. ¿Desea continuar?";
                        echo '<div class="call">';
                        echo "<a href='index.php?click=$click'>Si</a>";
                        echo "</div>";
                        echo "<a href='index.php'>No</a>";
                    break;
                    case 'page':
                        echo "Se insertara la actual consulta de Pagina. ¿Desea continuar?";
                        echo '<div class="call">';
                        echo "<a href='index.php?click=$click'>Si</a>";
                        echo "</div>";
                        echo "<a href='index.php'>No</a>";
                    break;
                          
                    default:
                        echo "There is no data";
                    break;
                }
                break;
            case 'generalselect':
                switch ($db_table_name) {
                    case 'ad':
                        echo "Se procedera a consultar todos los registros de los anuncios existentes. ¿Desea continuar?";
                        echo "<div class='call'>";
                        echo "<a href='index.php?click=$click'>Si</a>";
                        echo "</div>";
                         echo "<a href='index.php'>No</a>";
                    break;
                    case 'campaign':
                        echo "Se procedera a consultar todos los registros de las campañas existentes. ¿Desea continuar?";
                        echo "<div class='call'>";
                        echo "<a href='index.php?click=$click'>Si</a>";
                        echo "</div>";
                        echo "<a href='index.php'>No</a>";
                    break;
                    case 'page':
                        echo "Se procedera a consultar todos los registros de la pagina solicitada. ¿Desea continuar?";
                        echo "<div class='call'>";
                        echo "<a href='index.php?click=$click'>Si</a>";
                        echo "</div>";
                        echo "<a href='index.php'>No</a>";
                    break;
                          
                    default:
                        echo "There is no data";
                    break;
                }
                break;
            case 'specificselect':
                switch ($db_table_name) {
                    case 'ad':
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
                            <form id='db-query'>
                                <input list='db_fields' name='db_field' placeholder='Select a field' id='db_field'>
                                <input list='db_values' name='db_field_value' placeholder='Field value' id='db_values'>
                                <input type='hidden' name='parameters' id='parameters' value='". $click ."'>
                                <input type='submit' value='SEND DATA'>
                            </form>
                        ";
                    break;
                    case 'campaign':
                       $campaign = new ByAccountCampaign($ad_account_id);
                        $keys = array_keys($campaign->campaign_statistics);
                        echo "
                        <datalist id='db_fields'>";
                        foreach ($keys as $key) {
                            echo '<option id="option" value="'.$key .'"' .
                            ' label="options">' . '</option>';
                        }
                        echo   
                        "</datalist>"; 
                        
                            echo "
                            <form id='db-query'>
                                <input list='db_fields' name='db_field' placeholder='Select a field' id='db_field'>
                                <input list='db_values' name='db_field_value' placeholder='Field value' id='db_values'>
                                <input type='hidden' name='parameters' id='parameters' value='". $click ."'>
                                <input type='submit' value='SEND DATA'>
                            </form>
                        ";
                    break;
                    case 'page':
                        echo "
                        <form>
                            <input type='text'>
                        </form>
                        ";
                    break;
                          
                    default:
                        echo "There is no data";
                    break;
                }
                break;
            case 'delete':
                switch ($db_table_name) {
                    case 'ad':
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
                        <form id='db-query'>
                            <input list='db_fields' name='db_field' placeholder='Select a field' id='db_field'>
                            <input list='db_values' name='db_field_value' placeholder='Field value' id='db_values'>
                            <input type='hidden' name='$click' id='parameters'>
                            <input type='submit' value='SEND DATA'>
                        </form>
                      ";
                    break;
                    case 'campaign':
                        echo "
                            <form>
                                <input type='text'>
                            </form>
                        ";
                    break;
                    case 'page':
                        echo "
                        <form>
                            <input type='text'>
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

