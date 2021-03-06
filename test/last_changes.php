<?php 
namespace metrics\ads;
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/config/const.php');

use Facebook\Facebook as FB;
use preview\AdsPreview;

 class AdInsights{

        public $db_table_name = "ad";
        public $ad_insights = [];

        public $ad_account_id;
        public $ad_ids = [];
        public $ad_name = [];
        public $ad_effective_status = [];
        public $clicks = [];
        public $ctr = [];
        public $reach = [];
        public $impressions = [];
        public $spend = [];
        public $action_type = []; //Cost Per Action Type: $action_type . $action_value
        public $action_value = []; //Cost Per Action Type: $action_type . $action_value
        public $cpc = [];
        public $cpm = [];
        public $ad_image = [];
        public $date_start;
        public $date_stop;
        public $clicks_array;
        
 
        //Age per ad click 
        public $age18_24 = [];
        public $age25_34 = [];
        public $age35_44 = [];
        public $age45_54 = [];
        public $age55_64 = [];
        public $age65 = [];

        public $fb;
        public $app_access_token;
        public $query_array;

        public function __construct($ad_account_id){
            $this->fb = new FB([
            'app_id'=>'2350209521888424',
            'app_secret'=>'ac382c09d088b06f29e04878922c71f7',
            'default_graph_version'=>'v4.0',
            ]);
            $this->ad_account_id = $ad_account_id;
            $this->app_access_token = ACCESS_TOKEN;

            $this->callMethods();
        }
        public function callMethods(){
        /**
         * Call all methods in the class 
         */ 
            $this->queryAdInsights();
            $this->setFields();
            $this->setAdInsightsArray();
            $this->getAdInsightsArray();
            // $this->setAdDates();
        }
        public function queryAdInsights(){
            $request = $this->fb->get($this->ad_account_id.'?fields=ads.limit(100){id,name,effective_status,creative.thumbnail_height(220).thumbnail_width(230){id,name,thumbnail_url},insights.breakdowns(age).time_range({"since":"2019-12-01","until":"2019-12-31"}){clicks,ctr,reach,impressions,spend,cost_per_action_type,cpc,cpm}}',$this->app_access_token);
            //$adclicks_per_date = $this->fb->get($this->ad_account_id.'?fields=ads.limit(100){id,name,effective_status,insights.time_increment(1).time_range({"since":"2019-12-01","until":"2019-12-31"}){clicks}}', $this->app_access_token);

            $GraphRequest = $request->getGraphNode();
            $this->query_array = $GraphRequest->asArray();
            print_r($this->query_array);

            // $graph_clicks = $adclicks_per_date->getGraphNode();
            // $this->clicks_array = $graph_clicks->asArray();

            // echo "Clicks Array";
            /* print_r($this->clicks_array); */
        }
        public function setFields(){
            $i = 0;
           foreach($this->query_array['ads'] as $key){
                
                if($key['effective_status'] == 'ACTIVE' and $key['insights']){

                    $this->ad_ids[$i] = $key['id'];
                    $this->ad_name[$i] = $key['name'];
                    $this->ad_effective_status[$i] = $key['effective_status'];

                        foreach ($key['insights'] as $item) {
                            switch($item['age']){
                                case '18-24':
                                    $this->age18_24[$i] = $item['clicks'];
                                 break;
                                case '25-34':
                                    $this->age25_34[$i] =$item['clicks'];
                                break;
                                case '35-44':
                                    $this->age35_44[$i] = $item['clicks'];
                                break;
                                case '45-54':
                                    $this->age45_54[$i] = $item['clicks'];
                                break;
                                case '55-64':
                                    $this->age55_64[$i] = $item['clicks'];
                                break;
                                case '65+':
                                    $this->age65[$i] = $item['clicks'];
                                break;
                                default:
                                    echo 'The model case does not exist. Please try again';
                                break;
                            }
                            $metrics[$i] = $item['clicks'];

                            $ctr[$i] = $item['ctr'];
                            $reach[$i] = $item['reach'];
                            $impressions[$i] = $item['impressions'];
                            $spend[$i] = $item['spend'];
                            $cpc[$i] = @$item['cpc'];
                            $cpm[$i] = $item['cpm'];

                            if($this->ad_ids[$i] != $key['id']){
                                $i++;
                            }else{
                                $i = $i;
                            } 

                        }

                        
                        // $this->ctr[$i] = array_sum($ctr);
                        // $this->reach[$i] = array_sum($reach);
                        // $this->impressions[$i] = array_sum($impressions);
                        // $this->spend[$i] = array_sum($spend);
                        // $this->cpc[$i] = array_sum($cpc);
                        // $this->cpm[$i] = array_sum($cpm);


                        if($item['cost_per_action_type']){
                            // foreach ($item['cost_per_action_type'] as $k) {
                                $this->action_type[$i] = $item['cost_per_action_type'][0]['action_type'];
                                $this->action_value[$i] = $item['cost_per_action_type'][0]['value'];
                            // }
                        }
                        $this->date_start = $item['date_start'];
                        $this->date_stop = $item['date_stop'];
                    
                    if(@$key['creative']){
                        $this->ad_image[$i]  = $key['creative']['thumbnail_url'];
                    }    
                }
               
            }
            echo "CLICKS";
            print_r($metrics);

        }
        public function setAdDates(){
            // print_r($this->clicks_array);

            foreach ($this->clicks_array as $key) {
                // print_r($key);
                if($key['effective_status'] == 'ACTIVE' and $key['insights']){
                    foreach ($key['insights'] as $item) {
                        $ad_dates = $item['date_start'];
                    }
                }
            }
            echo "CLICK AD DATES";
            print_r($ad_dates);
        }
        public function setAdInsightsArray(){
           $this->adInsights = [
                'ad_account_id' => $this->ad_account_id, 
                'ad_ids' => $this->ad_ids,
                'ad_image' => $this->ad_image,
                'ad_name' => $this->ad_name,
                'ad_effective_status' => $this->ad_effective_status,
                'clicks' => $this->clicks,
                'ctr' => $this->ctr,
                'reach' => $this->reach,
                'impressions' => $this->impressions,
                'spend' => $this->spend,
                'action_type' => $this->action_type,
                'action_value' => $this->action_value,
                'cpc' => $this->cpc,
                'cpm' => $this->cpm,
                'age' => [
                    '18-24' => $this->age18_24,
                    '25-34' => $this->age25_34,
                    '35-44' => $this->age35_44,
                    '45-54' => $this->age45_54,
                    '55-64' => $this->age55_64,
                    '65+' => $this->age65
                ],
                'date_start' => $this->date_start,
                'date_stop' => $this->date_stop
           ]; 
        }
        // Methos for changing 
        public function getAdInsightsArray(){
           print_r($this->adInsights);
            
        }
        public function adsOverview(){
            echo "
            <pre>
                <table>
                    <thead>
                        <tr>
                            <th>Clics</th>
                            <th>CTR</th>
                            <th>Alcance</th>
                        </tr>
                    </thead>";
                        $table_fields_head = ['clicks','ctr','reach']; 
                        $table_fields_footer = ['impressions','spend','cpm']; 
                        echo "<tr>";
                            for($i=0; $i< count($table_fields_head); $i++){
                                echo "<td>". array_sum($this->adInsights[$table_fields_head[$i]]) ."</td>";
                            }
                        echo "
                            </tr>
                        <tbody>
                            <tr>
                                <th>Impresiones</th>
                                <th>Gastado</th>
                                <th>CPM Medio</th>
                            </tr>
                            <tr>";
                            for($i=0; $i< count($table_fields_footer); $i++){
                                echo "<td>". array_sum($this->adInsights[$table_fields_footer[$i]]) ."</td>";
                            }
                        echo "
                        </tr>    
                    </tbody>
                </table>";
        }
        public function adDetails(){
            echo "
            <br>
                <table>
                    <thead>
                        <tr>
                            <th>Ads</th>
                            <th>Ad Name</th>
                            <th>Clicks</th>
                            <th>CTR %</th>
                            <th>Alcance</th>
                            <th>Impresiones</th>
                            <th>Gastado</th>
                            <th>CPM Medio</th>
                        </tr>
                    </thead>
                    <tbody>";
                    $keys = array_keys($this->ad_ids);
                    $metrics = ['ad_image','ad_name','clicks','ctr','reach','impressions','spend','cpm'];
                    $i = 0;
                    foreach($keys as $key) {
                        $i = $i+1;
                        echo "<tr>";
                        foreach($metrics as $metric){
                            if($metric == 'ad_image'){
                                echo '<td><img src="'. $this->adInsights[$metric][$key] .'"></td>';
                            }else{
                                echo "<td class='fila".$i."'>" . $this->adInsights[$metric][$key] . "</td>";
                            }
                        }
                        echo "</tr>";
                    }

                    echo "
                    </tbody>
                </table>
            
            ";
        }

    }

 