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
        public $ad_clicks_per_date = [];
        public $dates;
        public $bimg = [];
        public $bimg_request;

        //Testing 
        public $array;
        
 
        //Age per ad click 
        public $age13_17 = [];
        public $age18_24 = [];
        public $age25_34 = [];
        public $age35_44 = [];
        public $age45_54 = [];
        public $age55_64 = [];
        public $age65 = [];

        public $fb;
        public $app_access_token;
        public $query_array;
        public $start_date;
        public $end_date;
        public $ctve_response;
        public $ctve_end_date;
        public $ctve_start_date;
        public $ctve_total_clicks;
        public $ctve_total_ctr;
        public $ctve_total_reach;
        public $ctve_total_impressions;
        public $ctve_total_spend;
        public $ctve_total_cpm;


        public function __construct($ad_account_id, $start_date , $end_date = 0){
            $this->fb = new FB([
            'app_id'=>'2350209521888424',
            'app_secret'=>'ac382c09d088b06f29e04878922c71f7',
            'default_graph_version'=>'v4.0',
            ]);
            $this->ad_account_id = $ad_account_id;
            $this->app_access_token = ACCESS_TOKEN;
                    
            list($date1,$date2) = explode(' - ',$start_date);
            $ndate1 = explode('/',$date1);
            $ndate2 = explode('/', $date2);
            // print_r($ndate1);
            // print_r($ndate2);
            $this->start_date = $ndate1[2].'-'.$ndate1[0].'-'.$ndate1[1];
            $this->end_date = $ndate2[2].'-'.$ndate2[0].'-'.$ndate2[1];

            // $this->start_date = $start_date;
            // $this->end_date = $end_date;
            $this->ctve_start_date = date('Y-m-d', strtotime('-1 month', strtotime($this->start_date)));
            $this->ctve_end_date = date('Y-m-d', strtotime('-1 month', strtotime($this->end_date)));

            // print_r($this->end_date);    
            // $dates = explode('-',$this->start_date);
            // if(end($dates) == 31){
            //     // echo "Es mayor";
            //     $this->ctve_start_date = date('Y-m-d', strtotime('-1 month -1 day', strtotime($this->start_date)));
            // }else{
            //     // echo "Es menor";
            //     $this->ctve_start_date = date('Y-m-d', strtotime('-1 month', strtotime($this->start_date)));
            // }

            // $dates = explode('-',$this->end_date);
            // if(end($dates) == 31){
            //     // echo "Es mayor";
            //     $this->ctve_end_date = date('Y-m-d', strtotime('-1 month -1 day', strtotime($this->end_date)));
            // }else{
            //     // echo "Es menor";
            //     $this->ctve_end_date = date('Y-m-d', strtotime('-1 month', strtotime($this->end_date)));
            // }

            $this->callMethods();
        }
        public function callMethods(){
        /**
         * Call all methods in the class 
         */ 
            $this->queryAdInsights();
            $this->setFields();
            $this->adDatesQuery();
            $this->bImage();
            $this->setComparativeFields();
            $this->monthlyVariation();
            $this->setAdInsightsArray();
            // $this->getAdInsightsArray();

        }
        public function queryAdInsights(){
            $request = $this->fb->get($this->ad_account_id.'?fields=ads.limit(100){id,name,effective_status,creative.thumbnail_height(170).thumbnail_width(180){id,name,thumbnail_url,image_url},insights.breakdowns(age).time_range({"since":"'. $this->start_date .'","until":"'. $this->end_date .'"}){clicks,ctr,reach,impressions,spend,cost_per_action_type,cpc,cpm}}',$this->app_access_token);
            $bimg_request = $this->fb->get($this->ad_account_id.'?fields=ads.limit(100){effective_status,creative.thumbnail_height(700).thumbnail_width(800){thumbnail_url},insights.time_range({"since":"'. $this->start_date .'","until":"'. $this->end_date .'"}){clicks}}',$this->app_access_token);
            $second_request = $this->fb->get($this->ad_account_id.'?fields=ads.limit(100){id,effective_status,insights.time_increment(1).time_range({"since":"'. $this->start_date .'","until":"'. $this->end_date .'"}){clicks}}',$this->app_access_token);
            $ctve_request = $this->fb->get($this->ad_account_id.'?fields=ads.limit(100){id,name,effective_status,insights.time_range({"since":"'. $this->ctve_start_date .'","until":"'. $this->ctve_end_date .'"}){clicks,ctr,reach,impressions,spend,cpm}}',$this->app_access_token);

            $GraphRequest = $request->getGraphNode();
            $this->query_array = $GraphRequest->asArray();
            // print_r($this->query_array);

            $graph_second_request = $second_request->getGraphNode();
            $this->array =  $graph_second_request->asArray();

            $graph_bimg_request = $bimg_request->getGraphNode();
            $this->bimg_request = $graph_bimg_request->asArray();

            $graph_ctve_response = $ctve_request->getGraphNode();
            $this->ctve_response = $graph_ctve_response->asArray();
            // print_r($this->ctve_response); die();
        }
        public function setFields(){
            $i = 0;
           foreach ($this->query_array['ads'] as $key) {
                
                if($key['effective_status'] == 'ACTIVE' and $key['insights']){

                    $this->ad_ids[$i] = $key['id'];
                    $this->ad_name[$i] = $key['name'];
                    $this->ad_effective_status[$i] = $key['effective_status'];

                    foreach ($key['insights'] as $item) {
                        switch($item['age']){
                             case '13-17':
                                $age13_17[$i] = $item['clicks'];
                                
                                break;
                            case '18-24':
                                $age18_24[$i] = $item['clicks'];
                                
                                break;
                            case '25-34':
                                $age25_34[$i] =$item['clicks'];
                                
                            break;
                            case '35-44':
                                $age35_44[$i] = $item['clicks'];
                                
                            break;
                            case '45-54':
                                $age45_54[$i] = $item['clicks'];
                                
                            break;
                            case '55-64':
                                $age55_64[$i] = $item['clicks'];
                                
                            break;
                            case '65+':
                                $age65[$i] = $item['clicks'];
                                
                            break;
                            default:
                                echo 'The model case does not exist. Please try again';
                            break;
                        }

                        $clicks[] = $item['clicks'];    
                        $ctr[] = $item['ctr'];
                        $reach[] = $item['reach'];
                        $impressions[] = $item['impressions'];
                        $spend[] = $item['spend'];
                        $cpc[] = @$item['cpc'];
                        $cpm[] = $item['cpm'];

                    }

                    $this->clicks[$i] = array_sum($clicks);
                    unset($clicks);
                    $this->ctr[$i] = array_sum($ctr);
                    unset($ctr);
                    $this->reach[$i] = array_sum($reach);
                    unset($reach);
                    $this->impressions[$i] = array_sum($impressions);
                    unset($impressions);
                    $this->spend[$i] = array_sum($spend);
                    unset($spend);
                    $this->cpc[$i] = array_sum($cpc);
                    unset($cpc);
                    $this->cpm[$i] = array_sum($cpm);
                    unset($cpm);

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
                $i++;    
            }

            $this->total_clicks = array_sum($this->clicks);    
            $this->total_ctr = (array_sum($this->ctr)/count($this->ad_ids));    
            $this->total_reach = array_sum($this->reach);    
            $this->total_impressions = array_sum($this->impressions);    
            $this->total_spend = array_sum($this->spend);    
            $this->total_cpm = array_sum($this->cpm);    

            $this->age13_17 = array_sum($age13_17);
            $this->age18_24 = array_sum($age18_24);
            $this->age25_34 = array_sum($age25_34);
            $this->age35_44 = array_sum($age35_44);
            $this->age45_54 = array_sum($age45_54);
            $this->age55_64 = array_sum($age55_64);
            $this->age65 = array_sum($age65);
        }
         public function setComparativeFields(){
            $i = 0;
           foreach ($this->ctve_response['ads'] as $key) {
                
                if($key['effective_status'] == 'ACTIVE' and $key['insights']){

                    foreach ($key['insights'] as $item) {
                    
                        $clicks[$i] = $item['clicks'];    
                        $ctr[$i] = $item['ctr'];
                        $reach[$i] = $item['reach'];
                        $impressions[$i] = $item['impressions'];
                        $spend[$i] = $item['spend'];
                        $cpm[$i] = $item['cpm'];

                    }
                    // print_r($clicks);

                    $this->ctve_total_clicks = array_sum($clicks);
                    $this->ctve_total_ctr = array_sum($ctr);
                    $this->ctve_total_impressions = array_sum($impressions);
                    $this->ctve_total_reach = array_sum($reach);
                    $this->ctve_total_spend = array_sum($spend);
                    $this->ctve_total_cpm = array_sum($cpm);  
                }
                $i++;
                
            }
            // print_r($this->ctve_total_clicks);
    
        }
        public function monthlyVariation(){
            // print_r($this->ctve_total_ctr); echo "Comparative <br>";

            // Calculo de Diferencia porcentual vs Mes Anterior
            $i=0;
            $metrics = [$this->total_clicks => $this->ctve_total_clicks, $this->total_ctr => $this->ctve_total_ctr,$this->total_reach => $this->ctve_total_reach,$this->total_impressions =>$this->ctve_total_impressions,$this->total_spend => $this->ctve_total_spend, $this->total_cpm => $this->ctve_total_cpm ];
            $names = ['ctve_total_clicks','ctve_total_ctr','ctve_total_reach','ctve_total_impressions','ctve_total_spend','ctve_total_cpm'];
            foreach($metrics as $key => $value){
                $difference = ($key-$value);
                $percentage_process = ($difference/$key);
                ${$names[$i]} = ($percentage_process * 100); 
                $i++;
            }
            
            $this->ctve_total_clicks = $ctve_total_clicks;
            $this->ctve_total_ctr = $ctve_total_ctr;
            $this->ctve_total_reach = $ctve_total_reach;
            $this->ctve_total_impressions = $ctve_total_impressions;
            $this->ctve_total_spend = $ctve_total_spend;
            $this->ctve_total_cpm = $ctve_total_cpm;

            // print_r($this->ctve_total_ctr); echo " Percentage<br>";

        }
        public function bImage(){
            $i = 0;
            foreach($this->bimg_request['ads'] as $img){

                if($img['effective_status'] == 'ACTIVE' && $img['insights']){
                    
                    $this->bimg[$i] = $img['creative']['thumbnail_url'];
                } 
                $i++; 
            }
            // print_r($this->bimg);
        }
        public function adDatesQuery(){
            $i=1;
            $this->dates = array();

            $this->dates[0]['clicks'] = '0';
            $this->dates[0]['fecha'] = '0';

             foreach ($this->array['ads'] as $key) {
                
                if($key['effective_status'] == 'ACTIVE' and $key['insights']){
                    foreach ($key['insights'] as $item) {
                        if($item['date_start']){
                            if(array_search($item['date_start'], array_column($this->dates, 'fecha'))){                                
                                $pos = array_search($item['date_start'], array_column($this->dates, 'fecha'));
                                $this->dates[$pos]['clicks'] = ($item['clicks']+$this->dates[$pos]['clicks']); 
                            }else{
                                $this->dates[$i]['clicks'] = $item['clicks'];
                                $this->dates[$i]['fecha'] = $item['date_start'];
                                $i++;
                            }
                        }
                    }
                }
            }

            unset($this->dates[0]);
            $this->dates = array_values($this->dates);

            $this->ad_clicks_per_date = $this->array_sort_by_column($this->dates, 'fecha', SORT_DESC);

            // echo "ad_clicks_per_date";
        }

        public function array_sort_by_column(&$arr, $col, $dir) {
            $sort_col = array();
            $i=0;
            foreach ($arr as $key=> $row) {
                $sort_col[$i][$col] = $row[$col];
                $sort_col[$i]['clicks'] = $row['clicks'];
                $i++;
            }
        
            array_multisort($sort_col, $dir, $arr);

            return $sort_col;
        }

        public function setAdInsightsArray(){
          $this->adInsights = [
                'ad_account_id' => $this->ad_account_id, 
                'ad_ids' => $this->ad_ids,
                'ad_image' => $this->ad_image,
                'bimg' => $this->bimg,
                'ad_name' => $this->ad_name,
                'ad_effective_status' => $this->ad_effective_status,
                'clicks' => $this->clicks,
                'total_clicks' => $this->total_clicks,
                'ctr' => $this->ctr,
                'total_ctr' => $this->total_ctr,
                'reach' => $this->reach,
                'total_reach' => $this->total_reach,
                'ad_clicks_per_date' => $this->ad_clicks_per_date,
                'impressions' => $this->impressions,
                'total_impressions' => $this->total_impressions,
                'spend' => $this->spend,
                'total_spend' => $this->total_spend,
                'action_type' => $this->action_type,
                'action_value' => $this->action_value,
                'cpc' => $this->cpc,
                'cpm' => $this->cpm,
                'total_cpm' => $this->total_cpm,
                'ad_clicks_per_age' => [
                    '13-17' => $this->age13_17,
                    '18-24' => $this->age18_24,
                    '25-34' => $this->age25_34,
                    '35-44' => $this->age35_44,
                    '45-54' => $this->age45_54,
                    '55-64' => $this->age55_64,
                    '65+' => $this->age65
                ],
                'ctve_total_clicks' => $this->ctve_total_clicks,
                'ctve_total_ctr' => $this->ctve_total_ctr,
                'ctve_total_reach' => $this->ctve_total_reach,
                'ctve_total_impressions' => $this->ctve_total_impressions,
                'ctve_total_spend' => $this->ctve_total_spend,
                'ctve_total_cpm' => $this->ctve_total_cpm,
                'date_start' => $this->date_start,
                'date_stop' => $this->date_stop
           ]; 
        }
        // Methos for changing 
        public function getAdInsightsArray(){
           print_r($this->adInsights);
            
        }
        public function dashboardAdsOverview(){
            echo "
                <div class='dash-section'>";
                    echo "<h3> <i class='fas fa-ad fb-icon'></i> Visión general de los anuncios </h3>";
                    echo 
                        "<table class='overview-table'>
                            <thead>
                                <tr>
                                    <th>Clics</th>
                                    <th>CTR</th>
                                    <th>Alcance</th>
                                </tr>
                            </thead>";
                            $table_fields_head = ['total_clicks','total_ctr','total_reach']; 
                            $table_fields_footer = ['total_impressions','total_spend','total_cpm']; 
                            echo "<tr>";
                                for($i=0; $i< count($table_fields_head); $i++){
                                    echo "<td>". number_format(array_sum($this->adInsights[$table_fields_head[$i]]),0,',','.') ."</td>";
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
                                    echo "<td>". number_format(array_sum($this->adInsights[$table_fields_footer[$i]]),0,',','.') ."</td>";
                                }
                            echo "
                            </tr>    
                        </tbody>
                    </table>
                </div>";
        }
        public function adsOverview(){
            echo "
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
        public function gashboardAdDetails(){
            echo "
            <div class='dash-section'>
                <h3> <i class='fas fa-puzzle-piece fb-icon'></i> Principales Anuncios en Facebook</h3>
                <br>
                <table class='overview-table'>
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
                    foreach($keys as $key) {
                        echo "<tr>";
                        foreach($metrics as $metric){
                            if($metric == 'ad_image'){
                                echo '<td><a href="'. $this->adInsights[$metric][$key] .'" class="zoom parent-zoom" target="_blank"><img class="dash-img" src="'. $this->adInsights[$metric][$key] .'"></a></td>';
                            }elseif($metric == 'ad_name'){
                                echo "<td>" . $this->adInsights[$metric][$key] . "</td>";
                            }else{
                                echo "<td>" . number_format($this->adInsights[$metric][$key],0,',','.') . "</td>";
                            }
                        }
                        echo "</tr>";
                    }

                    echo "
                    </tbody>
                </table>
            </div>
            
            ";
        }
        public function adDetails(){
            echo "
                <h3> <i class='fas fa-puzzle-piece fb-icon'></i> Principales Anuncios en Facebook</h3>
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
                    foreach($keys as $key) {
                        echo "<tr>";
                        foreach($metrics as $metric){
                            if($metric == 'ad_image'){
                                echo '<td><a href="'. $this->adInsights[$metric][$key] .'" class="zoom parent-zoom" target="_blank"><img class="dash-img" src="'. $this->adInsights[$metric][$key] .'"></a></td>';
                            }else{
                                echo "<td>" . $this->adInsights[$metric][$key] . "</td>";
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
        // For Sessions arrays
        // $_SESSION['adPerformance']['data'] = $adPerformance;
