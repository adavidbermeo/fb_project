<?php
namespace metrics\ads;
require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/functions/f_reactions.php'); 
use Facebook\Facebook as FB;
session_start();

    class ByAccountAd{

        public $db_table_name = "ad";

        public $ad_account_id;
        public $ad_ids = [];
        public $ad_name = [];
        public $ad_effective_status = [];
        public $id_page;
        public $fb;
        public $app_access_token;
        public $page_access_token;

        public $page_post = [];
        public $post_page_id = [];
        public $post_ids = [];
        public $likes = [];
        public $love = [];
        public $wow = [];
        public $haha = [];
        public $sorry = [];
        public $anger = [];
        public $total_reactions = [];
        public $impressions_paid = [];
        public $impressions_organic = [];
        public $total_impressions = [];
        public $post_clicks = [];
        public $interactions = [];
        public $adPerformance;

        
        
        public function __construct($id_page, $ad_account_id ,$more_interaction = 0){
            $this->fb = new FB([
            'app_id'=>'2350209521888424',
            'app_secret'=>'ac382c09d088b06f29e04878922c71f7',
            'default_graph_version'=>'v3.3',
            ]);

            $this->id_page = $id_page;
            $this->ad_account_id = $ad_account_id;
            
            $this->app_access_token = 'EAAhZAgMuzLKgBALw6wMVa3m6UpWPiF130yStQMKB3rLvwI9cQ4UAiCzQ1AWcVm2JeJ7Mh9J0spVSgiW84bs9HmGW79hrbzvCf4DblwAfo207nvza4hGFKA0ZBXCDf9B964HUoqgvkJ3Vf678Gu2bf9WiLoZAozlFswRsLctXvQYEYjAHjsSDlkVZBI3c4ynXh9Ycc3spy8p03WdMZASVycAwIpDkuclvyVZCtWENcyIgZDZD';

            /**
             * Invoque the callMethods function 
             */
            if($more_interaction == FALSE){
                $this->callMethods();
            }
        }
        public function callMethods(){
        /**
         * Call all methods in the class 
         */ 
            
            $this->setAdIdRequest();
            $this->getDataRequest();
            $this->setAccessToken();
            $this->setAdStatistics();
            $this->totalReactions();
            $this->setInteractions();
            $this->setAdPerformance();
            // $this->getAdPerformance();
            // $this->getAdPerformanceTable();
            // $this->callReporting();
        }
        public function setAdIdRequest(){
            $request = $this->fb->get($this->ad_account_id . '?fields=ads{id,name,effective_status,creative{effective_object_story_id}}',$this->app_access_token);
            $GraphRequest = $request->getGraphNode();
            // echo "<pre>";
            $this->data_array_post_ad = $GraphRequest->asArray();
            $this->data_array_post_ad;
        }
        public function getDataRequest(){
        
           foreach ($this->data_array_post_ad['ads'] as $key) {
                //   print_r($key);
                $this->ad_ids[] = $key['id'];
                $this->ad_name[] = $key['name'];
                $this->ad_effective_status[] = $key['effective_status'];
                if(@$key['creative']['effective_object_story_id']){
                    $this->page_post[] = $key['creative']['effective_object_story_id'];
                }
            }
            foreach ($this->page_post as $item) {
                list($this->post_page_id[], $this->post_ids[]) = explode('_', $item);
            } 
            // echo "<pre>";
            // print_r($this->post_ids); 
        }
        public function setAccessToken(){
            $request = $this->fb->get($this->id_page. '?fields=access_token,name',$this->app_access_token); 
            $GraphRequest = $request->getGraphNode();
            
            $data = $GraphRequest->asArray();
            $this->page_access_token = $data['access_token'];
            $this->page_name = $data['name'];
        }
        public function setAdStatistics(){
        for ($i=0; $i <count($this->page_post) ; $i++) { 
            $response = $this->fb->get(
                    $this->post_page_id[$i] .'_'. $this->post_ids[$i] .'/insights?metric=post_reactions_by_type_total,post_impressions_paid_unique,post_impressions_organic_unique,post_impressions_unique,post_clicks_unique',
                    $this->page_access_token
            );
            $GraphEdge = $response->getGraphEdge();
            $data = $GraphEdge->asArray();
            
            foreach ($data as $key){
               
                $name = $key['name'];
                foreach ($key['values'] as $item) {
                    if(is_array($item)){
                        
                        if($name == 'post_reactions_by_type_total'){

                            $this->likes[] = @$item['value']['like'];
                            $this->love[] = @$item['value']['love'];
                            $this->wow[] = @$item['value']['wow'];
                            $this->haha[] = @$item['value']['haha'];
                            $this->sorry[] = @$item['value']['sorry']; 
                            $this->anger[] = @$item['value']['anger'];

                         }  

                        if ($name == 'post_impressions_paid_unique') {
                            $this->impressions_paid[] =  $item['value'];
                        }if ($name == 'post_impressions_organic_unique') {
                            $this->impressions_organic[] = $item['value'];
                        }if ($name == 'post_impressions_unique') {
                            $this->total_impressions[] = $item['value'];
                        }if ($name == 'post_clicks_unique') {
                            $this->post_clicks[] = $item['value'];
                            
                        }
                    
                }
            }   
        }
    }
                
    }
    public function totalReactions(){
        $reactions = [];
        $reactions = [
            'likes' => $this->likes,
            'love' => $this->love,
            'wow' => $this->wow,
            'haha' => $this->haha,
            'sorry' => $this->sorry,
            'anger' => $this->anger
        ];
        
        for ($i=0; $i <count($reactions['likes']) ; $i++) { 
            $this->total[$i] = [ $reactions['likes'][$i],$reactions['love'][$i],$reactions['wow'][$i],$reactions['haha'][$i],$reactions['sorry'][$i], $reactions['anger'][$i] ];
           
        }
        
        for ($i=0; $i <count($this->total) ; $i++) { 
            $this->total_reactions[$i] = array_sum($this->total[$i]);
        }
        
    }
    public function setInteractions(){
        
        for ($i=0; $i <count($this->total_reactions) ; $i++) { 
            $this->interactions[$i] = interactions($this->total_reactions[$i],$this->post_clicks[$i]);
        }
        
    }
        public function setAdPerformance(){
            $this->adPerformance = [
                'ad_ids' => $this->ad_ids,
                'ad_name' => $this->ad_name,
                'ad_effective_status' => $this->ad_effective_status,
                'post_page_id' => $this->post_page_id,
                'post_ids' => $this->post_ids, 
                'interactions' => $this->interactions,
                'ad_account_id' => $this->ad_account_id, 
                'likes' => $this->likes, 
                'love' => $this->love, 
                'wow' => $this->wow, 
                'haha' => $this->haha, 
                'sorry' => $this->sorry, 
                'anger' => $this->anger, 
                'total_reactions' => $this->total_reactions, 
                'impressions_paid' => $this->impressions_paid, 
                'impressions_organic' => $this->impressions_organic, 
                'total_impressions' => $this->total_impressions, 
                'post_clicks' => $this->post_clicks, 
            ];
        }
        
        public function getAdPerformance(){
            
            $keys = array_keys($this->adPerformance);

                for ($i=0; $i <count($this->adPerformance['post_page_id']) ; $i++) { 
                    echo 'ID PAGE POST: '. $this->adPerformance['post_page_id'][$i]."<br>";
                    echo 'INTERACTIONS: '. $this->adPerformance['interactions'][$i]."<br>";
                    echo 'AD IDS: '. $this->adPerformance['ad_ids'][$i]."<br>";
                    echo 'POST ID: '. $this->adPerformance['post_ids'][$i]."<br>";
                    echo 'LIKES: '. $this->adPerformance['likes'][$i].'  ';               
                    echo 'LOVE: '. $this->adPerformance['love'][$i].'  ';
                    echo 'WOW: '. $this->adPerformance['wow'][$i].'  ';
                    echo 'HAHA: '. $this->adPerformance['haha'][$i].'  ';
                    echo 'SORRY '. $this->adPerformance['sorry'][$i].'  ';
                    echo 'ANGER: '. $this->adPerformance['anger'][$i].'  <br>';
                    echo 'TOTAL REACTIONS: '. $this->adPerformance['total_reactions'][$i]."<br>";
                    echo 'IMPRESSIONS PAID: '. $this->adPerformance['impressions_paid'][$i]."<br>";
                    echo 'IMPRESSIONS ORGANIC: '. $this->adPerformance['impressions_organic'][$i]."<br>";
                    echo 'TOTAL IMPRESSIONS: '. $this->adPerformance['total_impressions'][$i]."<br>";
                    echo 'POST CLICKS: '. $this->adPerformance['post_clicks'][$i]."<br><br><br>";
                    echo 'AD ACCOUNT ID: '. $this->adPerformance['ad_account_id']."<br><br><br>";
            }
        }
        public function getAdPerformanceTable(){
            if($this->ad_account_id){
                 echo '
                    <table>
                    <thead>
                        <tr>
                        <th colspan="16" id="campaign-title"><h4>'. $this->page_name .'</h4></th>
                        <tr>
                        <tr>
                            <th class="face"><i class="fas fa-fingerprint fa-2x"></i></th>
                            <th class="face">Id Anuncio</th>
                            <th class="face"><i class="fas fa-search-plus fa-2x"></i></th>
                            <th class="face"><i class="fas fa-toggle-on fa-2x"></i></th>
                            <th class="face">Interacciones</th>
                            <th class="face"><i class="far fa-thumbs-up fa-2x"></i></th>
                            <th class="face"><i class="fas fa-heart fa-2x"></i></th>
                            <th class="face"><i class="far fa-surprise fa-2x"></i></th>
                            <th class="face"><i class="far fa-laugh-squint fa-2x"></i></th>
                            <th class="face"><i class="fas fa-sad-tear fa-2x"></i></th>
                            <th class="face"><i class="far fa-angry fa-2x"></i></th>
                            <th>Reacciones Totales</th>
                            <th>Impresiones <i class="fas fa-coins fa-2x"></i></th>
                            <th>Impresiones Organicas</th>
                            <th>Total Impresiones</th>
                            <th class="face"><i class="fas fa-mouse-pointer fa-2x"></i></th>
                        </tr>
                    </thead>';
                    for ($i=0; $i <count($this->adPerformance['post_ids']) ; $i++) { 
                        $metrics = ['ad_ids','<a href="#">Ad Preview</a>','ad_effective_status','interactions','likes','love','wow','haha','sorry','anger','total_reactions','impressions_paid','impressions_organic','total_impressions','post_clicks'];
                        echo '
                        <tbody>
                        <tr>
                        <td>'.$i.'</td>';
                        foreach ($metrics as $key) {
                            if(@$this->adPerformance[$key][$i]){
                                echo '<td>' . $this->adPerformance[$key][$i] . '</td>';
                            }elseif($key == '<a href="#">Ad Preview</a>'){
                                echo '<td>' . $key . '</td>';
                            }else{
                                echo '<td>x</td>';
                            }  
                        }
                        echo '
                        </tr>
                        </tbody>';  
                        }
                    echo '
                    </table>
                    <section id="callReporting">
                
                    <a href="index.php?idpage='. $this->id_page .'&accountid='. $this->ad_account_id .'&tablename='. $this->db_table_name .'">Ad Reporting</a>

                    </section>
                <script type="text/javascript" src="js/option_report.js"></script>';
                       
                }else{
                    echo "There is no available campaigns";
                }
            }  
            // public function callReporting(){
            //     echo "
                
            //     ";
            // }
        }
        // For Sessions arrays
        // $_SESSION['adPerformance']['data'] = $adPerformance;


 