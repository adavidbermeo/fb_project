<?php 
namespace metrics\ads;
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/functions/f_reactions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/preview/preview.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/config/const.php');

use Facebook\Facebook as FB;
use preview\AdsPreview;

 class Testing{

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
            
            $this->app_access_token = ACCESS_TOKEN;

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

            // $this->totalReactions();
            // $this->setInteractions();
            // $this->setAdPerformance();
        }
        public function setAdIdRequest(){
            $request = $this->fb->get($this->ad_account_id . '?fields=ads.limit(50){id,name,effective_status,creative{effective_object_story_id}}',$this->app_access_token);
            $GraphRequest = $request->getGraphNode();
            // echo "<pre>";
            $this->data_array_post_ad = $GraphRequest->asArray();
            $this->data_array_post_ad;
        }
        public function getDataRequest(){
        
           foreach ($this->data_array_post_ad['ads'] as $key) {
                //   print_r($key);
                
                if($key['effective_status'] == 'ACTIVE'){
                    $this->ad_ids[] = $key['id'];
                    $this->ad_name[] = $key['name'];
                    $this->ad_effective_status[] = $key['effective_status'];
                    if(@$key['creative']['effective_object_story_id']){
                        $this->page_post[] = $key['creative']['effective_object_story_id'];
                    }
                        
                }   
            }
             foreach ($this->page_post as $item) {
                    list($this->post_page_id[], $this->post_ids[]) = explode('_', $item);
                }   
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
                        $this->post_page_id[$i] .'_'. $this->post_ids[$i] .'/?fields=insights.metric(post_reactions_by_type_total,post_impressions_paid_unique,post_impressions_organic_unique,post_impressions_unique,post_clicks_unique),shares,comments.summary(true)',
                        $this->page_access_token
                );
                $GraphEdge = $response->getGraphNode();
                $data = $GraphEdge->asArray();
                echo "<pre>";

                print_r($data);
                /***
                 * Set VARS
                 */
                foreach ($data['insights'] as $key => $value) {
                    switch ($value['name']) {
                        case 'post_reactions_by_type_total':
                            foreach ($value['values'] as $element) {
                                $this->likes[] =  @$element['value']['like'];
                                $this->love[] = @$element['value']['love'];
                                $this->wow[] =  @$element['value']['wow'];
                                $this->haha[] =  @$element['value']['haha'];
                                $this->sorry[] =  @$element['value']['sorry'];
                                $this->anger[] =  @$element['value']['anger'];
                            }
                            break;
                        case 'post_impressions_paid_unique':
                            foreach ($value['values'] as $element) {
                                $this->impressions_paid[] = $element['value']; 
                            }
                            break;
                        case 'post_impressions_organic_unique': 
                            foreach ($value['values'] as $element) {
                                $this->impressions_organic[] =$element['value'];
                            }
                            break;
                        case 'post_impressions_unique':
                            foreach($value['values'] as $element){
                                $this->total_impressions[] = $element['value'];
                            }
                            break;
                        case 'post_clicks_unique':
                            foreach($value['values'] as $element){
                                $this->post_clicks[] = $element['value'];
                            } 
                            break;
                        default:
                            echo "An unexpected error has ocurred";
                            break;
                    }
                }
                // foreach ($data['comments'] as $key => $value) {
                //     # code...
                // }
                // switch ($item['name']) {
                //     case 'post_reactions_by_type_total':
                //         # code...
                //         break;
                    
                //     default:
                //         # code...
                //         break;
                // }

                // foreach ($data as $key => $value) {
                //     # code...
                // }
            }
        }
 }
 
 $testing = new Testing('303239893027115','act_131251207293544',0);