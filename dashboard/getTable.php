<?php
// Db Connection 
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/database/connectDb.php');

    if(isset($_POST['selected'])){
        $selected = $_POST['selected'];
        list($url, $click) = explode('=', $selected);
        list($click_value,$data) = explode('*', $click);
        list($id_page, $ad_account_id) = explode('%', $data); 

        getData($ad_account_id);
    }

function getData($ad_account_id){

	//setting header to json
	$db = new database();
	$conn = $db->conn();

    $sql = $conn->prepare("SELECT `total_new_likes` FROM `page` WHERE `ad_account_id` = '$ad_account_id'");
    $sql->execute();
    $result = $sql->fetchAll();

    if($result == TRUE){
        for($i=0; $i<count($result); $i++){
            echo '<div id="dash_section"><b>' . 'Total New Likes' . '</b><br>' . $result[0]['total_new_likes']. '</div>';
        }
    }

    $sql = $conn->prepare("SELECT * FROM `ad` WHERE `ad_account_id` = '$ad_account_id'");
    $sql->execute();
    $ad_result = $sql->fetchAll();

    if($ad_result == TRUE){
        for($i=0; $i<count($ad_result); $i++){
            $interactions_array[] = $ad_result[$i]['interactions'];
        }
        echo '<div id="dash_section"><b>' . 'Interactions' . '</b><br>' . $ad_result[0]['interactions']. '</div>';
    }
       
    $sql = $conn->prepare("SELECT `cost_per_lead`,`spend` FROM `campaign` WHERE `ad_account_id` = '$ad_account_id'");
    $sql->execute();
    $result = $sql->fetchAll();
    if($result == TRUE){
        for($i=0; $i<count($result); $i++){
            $cost_per_lead[] = $result[$i]['cost_per_lead'];
            $spend[] = $result[$i]['spend'];
        }
        $total_cpl = array_sum($cost_per_lead);

        echo '<div id="dash_section"><b>' . 'cost_per_lead' . '</b><br>' . $total_cpl / count($cost_per_lead) . '</div>';
        echo '<div id="dash_section"><b>' . 'spend' . '</b><br>' . array_sum($spend). '</div>';
    }

    /**
     * Main metrics by account for dashboard
     */
    echo '<script type="text/javascript" src="js/send_btnvalue.js"></script>';
    echo "
        <table id='general-report'>
            <thead>
                <tr>
                    <th>Reach</th>
                    <th>Likes</th>
                    <th>Comments</th>
                    <th>Shares</th>
                    <th>Clicks</th>
                </tr>
            </thead>
            <tbody>
                <tr>";
            for($i=0; $i<count($ad_result); $i++){
                    if(($ad_result[$i]['total_impressions'])>0){
                        $total_impressions[] = $ad_result[$i]['total_impressions'];
                        $likes[] = $ad_result[$i]['likes'];
                        $comments[] = $ad_result[$i]['comments'];
                        $shares[] = $ad_result[$i]['shares'];
                        $post_clicks[] = $ad_result[$i]['post_clicks'];
                    }
            }

            $count_timpressions = array_sum($total_impressions); 
            $count_likes = array_sum($likes);
            $count_comments = array_sum($comments);
            $count_shares = array_sum($shares);
            $count_pclicks = array_sum($post_clicks);

            $fields = [$count_timpressions,$count_likes,$count_comments,$count_shares,$count_pclicks];
 
            for ($i=0; $i <count($fields); $i++) { 
                echo "
                    <td>". $fields[$i] ."</td>";
            }

            echo "
            </tr>
            </tbody>
            </table>";

        /***
         * Ad Statistics Table with preview
         */
        
        // echo "
        //     <table>
        //         <thead>
        //             <tr>
        //                 <th colspan='3'></th>
        //             </tr>
        //             <tr>
        //                 <th>Preview</th>
        //                 <th>Ad name</th>
        //                 <th>Interactions</th>
        //             </tr>
        //         <thead>
        //         <tbody>
        //             <tr>";

        //            echo  '<td><button id="'.$this->adPerformance['ad_ids'][$i].'" class="btn-abrir-popup">Ad Preview</button></td>';
                        
        //            echo "</tr>
        //         </tbody>
        //     </table>
        // ";
}