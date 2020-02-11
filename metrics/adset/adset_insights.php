<?php 
namespace metrics\adset;
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/config/const.php');

use Facebook\Facebook as FB;

 class AdsetInsights{

        public $ad_account_id;
        public $adset_id;
        public $adset_name = [];
        public $clicks = [];
        public $ctr = [];
        public $reach = [];
        public $impressions = [];
        public $spend = [];
        public $cpm = [];
        public $date_start;
        public $date_stop;

        public $query_array = [];
        public $start_date = [];
        public $end_date = [];

        public function __construct($ad_account_id, $start_date, $end_date){
            $this->fb = new FB([
            'app_id'=>'2350209521888424',
            'app_secret'=>'ac382c09d088b06f29e04878922c71f7',
            'default_graph_version'=>'v4.0',
            ]);
            $this->ad_account_id = $ad_account_id;
            $this->app_access_token = ACCESS_TOKEN;
            $this->start_date = $start_date;
            $this->end_time = $end_date;

            $this->callMethods();
        }
        public function callMethods(){
        /**
         * Call all methods in the class 
         */ 
            $this->adsetInsightsQuery();
            $this->setFields();
            $this->adsetInsightsArray();
            //$this->getAdsetInsightsArray();

        }
        public function adsetInsightsQuery(){
            $request = $this->fb->get($this->ad_account_id.'?fields=adsets{id,name,insights.time_range({"since":"'. $this->start_date .'","until":"'. $this->end_time .'"}){clicks,ctr,reach,impressions,spend,cpm}}',$this->app_access_token);
        
            $GraphRequest = $request->getGraphNode();
            $this->query_array = $GraphRequest->asArray();

        }
        public function setFields(){
            $i = 0;
           foreach ($this->query_array['adsets'] as $key) {
                
                if($key['insights']){
                    $this->adset_name[$i] = $key['name'];
                    $this->adset_id[$i] = $key['id'];

                    foreach ($key['insights'] as $item) {
                        $this->clicks[$i] = $item['clicks'];
                        $this->ctr[$i] = $item['ctr'];
                        $this->reach[$i] = $item['reach'];
                        $this->impressions[$i] = $item['impressions'];
                        $this->spend[$i] = $item['spend'];
                        $this->cpm[$i] = $item['cpm'];
                        $this->date_start = $item['date_start'];
                        $this->date_stop = $item['date_stop'];
                    }
                }
                $i++;
            }
        }
        public function adsetInsightsArray(){
           $this->adsetInsights = [
                'ad_account_id' => $this->ad_account_id, 
                'adset_id' => $this->adset_id,
                'adset_name' => $this->adset_name,
                'clicks' => $this->clicks,
                'ctr' => $this->ctr,
                'reach' => $this->reach,
                'impressions' => $this->impressions,
                'spend' => $this->spend,
                'cpm' => $this->cpm,
                'date_start' => $this->date_start,
                'date_stop' => $this->date_stop
           ]; 
        }
        // Methos for changing 
        public function getAdsetInsightsArray(){
           print_r($this->adsetInsights);
            
        }
        public function adsetDahboard(){
            $keys = array_keys($this->adsetInsights['adset_id']);
            echo "
                <div class='dash-section'>
                    <h3> <i class='fab fa-facebook fb-icon'></i> Principales Conjuntos de Anuncios en Facebook </h3>
                    <pre>
                        <table class='overview-table'>
                            <thead>
                                <tr>
                                    <th>Conjunto de Auncios</th>
                                    <th>Clics</th>
                                    <th>CTR %</th>
                                    <th>Alcance</th>
                                    <th>Impresiones</th>
                                    <th>Gastado</th>
                                    <th>CPM</th>
                                </tr>
                            </thead>
                            <tbody>";
                                foreach($keys as $key){
                                    echo "<tr>";
                                    $metrics = ['adset_name','clicks','ctr','reach','impressions','spend','cpm'];
                                    foreach ($metrics as $metric) {

                                        echo "<td>".  $this->adsetInsights[$metric][$key]  ."</td>";
                                    }
                                    echo "</tr>";
                                }
                            echo "
                            </tbody>
                        </table>
                    </pre>
                </div>
            ";
        }
        public function getAdsetInsightsTable(){
            $keys = array_keys($this->adsetInsights['adset_id']);
            echo "
                <pre>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Conjunto de Auncios</th>
                                <th>Clics</th>
                                <th>CTR %</th>
                                <th>Alcance</th>
                                <th>Impresiones</th>
                                <th>Gastado</th>
                                <th>CPM</th>
                            </tr>
                        </thead>
                        <tbody>";
                            // print_r($keys);
                            echo "<td rowspan='". (count($keys)+1) ."'>". $this->adsetInsights['date_start']. "/". $this->adsetInsights['date_stop'] . "</td>";
                            $i = 0;
                            foreach($keys as $key){
                                $i = $i+1;
                                echo "<tr>";
                                $metrics = ['adset_name','clicks','ctr','reach','impressions','spend','cpm'];
                                foreach ($metrics as $metric) {

                                    echo "<td class='fila".$i."'>".  $this->adsetInsights[$metric][$key]  ."</td>";
                                    
                                }
                                echo "</tr>";
                            }
                        echo "
                        </tbody>
                    </table>
                </pre>
            
            ";
        }

    }