<?php
namespace functions;
include_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/metrics/ads/by_account_ad.php');
use metrics\ads\ByAccountAd;
class Interactions{
    public $id_page;
    public function __construct($id_page, $ad_account_id){
        $this->id_page = $id_page;
        $this->ad_account_id = $ad_account_id;
    }
    public function moreInteraction(){
        $info = new ByAccountAd($this->id_page,$this->ad_account_id,1);
        $info-> setAdIdRequest();
        $info->getDataRequest();
        $info->setAccessToken();
        $info->setAdStatistics();
        $info->totalReactions();
        $info->setInteractions();
        // $info->setAdPerformance();
        $array = $info->interactions;
        // print_r($array);

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
        // print_r($max);
        echo "<h3>Top More Interacting Publications</h3>";
        // print_r($value);
        for ($i=0; $i <5 ; $i++) { 
            $item = $i+1;
            echo '#' . $item . '<br>';
            echo 'ID POST: ' . $max[$i]['id_post'] .'<br>';
            echo 'INTERACTIONS : ' . $max[$i]['value'] .'<br><br>';
        }
        
        // for ($i=0; $i <5 ; $i++) { 
        //    print_r($arr[] = max($info->interactions));
        //     unset($info->interactions[$i]);
        // }
        // print_r($arr);
        // $performance = new AdPerformance($info->id_pagePost,$info->interactions,$info->post_ids,$info->account_id,$info->likes,$info->love,$info->wow,$info->haha,$info->sorry,$info->anger,$info->total_reactions,$info->impressions_paid,$info->impressions_organic,$info->total_impressions,$info->post_clicks);
        // $performance->showAdPerformance();
    }
}


