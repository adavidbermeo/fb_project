<?php
namespace functions;
include_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/metrics/posts/post_insights.php');
use metrics\posts\PostInsights;
error_reporting(0);

class Interactions{
    public $id_page;
    public $ad_account_id;
    public $start_date;
    public $end_date;

    public function __construct($id_page, $ad_account_id, $start_date, $end_date){
        $this->id_page = $id_page;
        $this->ad_account_id = $ad_account_id;
        $this->start_date = $start_date; 
        $this->end_time = $end_date;
    }
    public function moreInteraction(){
        $info = new PostInsights($this->id_page,$this->ad_account_id,$this->start_date, $this->end_date,1);
        $info-> setAdIdRequest();
        $info->getDataRequest();
        $info->setAccessToken();
        $info->setAdStatistics();
        $info->totalReactions();
        $info->setInteractions();

        $array = $info->interactions;

        if(count($array)>0){
            for ($i=0; $i <5 ; $i++){ 
                $maxs = array_keys($array, max($array));

                foreach ($maxs as $keys) {
                    $key = $keys;
                    
                }
                $max[] = [
                    'id_post' => $key,
                    'value' =>max($array)
                ];
                unset($array[$key]);
            }
        }
       
        echo "<h3>Top More Interacting Publications</h3>";
        
        for ($i=0; $i <5 ; $i++) { 
            $item = $i+1;
            echo '<div class="top-interaction">';
                echo '#' . $item . '<br>';
                echo 'ID POST: ' . $max[$i]['id_post'] .'<br>';
                echo 'INTERACTIONS : ' . $max[$i]['value'] .'<br><br>';
            echo "</div>";
        }
    }
}


