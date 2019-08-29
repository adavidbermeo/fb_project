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

        $array = $info->interactions;

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
        echo "<h3>Top More Interacting Publications</h3>";
        
        for ($i=0; $i <5 ; $i++) { 
            $item = $i+1;
            echo '#' . $item . '<br>';
            echo 'ID POST: ' . $max[$i]['id_post'] .'<br>';
            echo 'INTERACTIONS : ' . $max[$i]['value'] .'<br><br>';
        }
    }
}


