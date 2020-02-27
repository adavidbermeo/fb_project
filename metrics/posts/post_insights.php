<?php
namespace metrics\posts;
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/functions/f_reactions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/preview/preview.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/config/const.php');

use Facebook\Facebook as FB;
use preview\AdsPreview;

 class PostInsights{

        public $data_array_post_ad = [];    
        public $db_table_name = "post";

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
        public $comments_count = [];
        public $shares_count = [];
        public $total = [];
        public $ad_image = [];
        public $bimg = [];
        public $bimg_request;
        
        public $start_date = [];
        public $end_date = [];
        
        
        public function __construct($id_page, $ad_account_id , $start_date, $end_date = 0, $more_interaction = 0){
            $this->fb = new FB([
            'app_id'=>'2350209521888424',
            'app_secret'=>'ac382c09d088b06f29e04878922c71f7',
            'default_graph_version'=>'v4.0',
            ]);

            $this->id_page = $id_page;
            $this->ad_account_id = $ad_account_id;
            
            $this->app_access_token = ACCESS_TOKEN;

            
            list($date1,$date2) = explode(' - ',$start_date);
            $ndate1 = explode('/',$date1);
            $ndate2 = explode('/', $date2);
            // print_r($ndate1);
            // print_r($ndate2);
            $s_date = $ndate1[2].'-'.$ndate1[0].'-'.$ndate1[1];
            $this->start_date = date('Y-m-d', strtotime('-1 day', strtotime($s_date)));
            $this->end_date = $ndate2[2].'-'.$ndate2[0].'-'.$ndate2[1];

            // $this->end_date = $end_date;
            
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
            $this->bImage();
            $this->setAdPerformance();
            // $this->getAdPerformance();

        }
        public function setAdIdRequest(){
            $request = $this->fb->get($this->ad_account_id . '?fields=ads.limit(80){id,name,insights.time_range({"since":"'. $this->start_date .'","until":"'. $this->end_date .'"}){impressions},effective_status,created_time,creative.thumbnail_height(170).thumbnail_width(180){effective_object_story_id,thumbnail_url}}',$this->app_access_token);
            $bimg_request = $this->fb->get($this->ad_account_id.'?fields=ads.limit(100){effective_status,creative.thumbnail_height(700).thumbnail_width(800){thumbnail_url},insights.time_range({"since":"'. $this->start_date .'","until":"'. $this->end_date .'"}){clicks}}',$this->app_access_token);
            $GraphRequest = $request->getGraphNode();
            // echo "<pre>";
            
            $this->data_array_post_ad = $GraphRequest->asArray();
            // print_r($this->data_array_post_ad);

            $graph_bimg_request = $bimg_request->getGraphNode();
            $this->bimg_request = $graph_bimg_request->asArray();
            // print_r($this->bimg_request); die();
            
        }

        public function getDataRequest(){
            
            foreach ($this->data_array_post_ad['ads'] as $key) {

                if($key['effective_status'] == 'ACTIVE' && $key['insights']){

                        $this->ad_ids[] = $key['id'];
                        $this->ad_name[] = $key['name'];
                        $this->ad_effective_status[] = $key['effective_status'];
                        if(@$key['creative']['effective_object_story_id']){
                            $this->page_post[] = $key['creative']['effective_object_story_id'];
                        }
                        if(@$key['creative']){
                            $this->ad_image[]  = $key['creative']['thumbnail_url'];
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
            for ($i=0; $i <count($this->page_post); $i++){ 
                $response = $this->fb->get(
                        $this->post_page_id[$i] .'_'. $this->post_ids[$i] .'/?fields=insights.metric(post_reactions_by_type_total,post_impressions_paid_unique,post_impressions_organic_unique,post_impressions_unique,post_clicks_unique),shares,comments.summary(true)',
                        $this->page_access_token
                );
                $GraphEdge = $response->getGraphNode();
                $data = $GraphEdge->asArray();

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
                
                $this->comments_count[] = count($data['comments']);
                $this->shares_count[] = @$data['shares']['count'];
                
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
        public function bImage(){
            foreach($this->bimg_request['ads'] as $img){

                if($img['effective_status'] == 'ACTIVE' && $img['insights']){
                    
                    $this->bimg[] = $img['creative']['thumbnail_url'];
                } 
            }
                // print_r($this->bimg);
        }
        public function setAdPerformance(){
            $this->adPerformance = [
                'ad_ids' => $this->ad_ids,
                'id_page' => $this->id_page,
                'ad_name' => $this->ad_name,
                'bimg' => $this->bimg,
                'ad_image' => $this->ad_image,
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
                'comments' => $this->comments_count,
                'shares' => $this->shares_count
            ];

            //print_r($this->adPerformance);
        }
        
        public function getAdPerformance(){
            print_r($this->adPerformance);
        }
        public function mainPublicactions(){
            echo "
            <div class='dash-section'>
                <h3> <i class='fas fa-puzzle-piece fb-icon'></i> Principales Publicaciones </h3>
                <table class='overview-table'>
                    <thead>
                        <tr>
                            <th>Publicaciones</th>
                            <th>Impresiones de la publicación</th>
                            <th>Impresiones pagas de la publicación</th>
                            <th>Impresiones organicas de la publicación</th>
                            <th>Comentarios</th>
                            <th>Compartidos</th>
                            <th>Interacciones con la publicación</th>
                        </tr>
                    </thead>
                    <tbody>";
                    $fields = ['ad_image','total_impressions','impressions_paid','impressions_organic','comments','shares','interactions'];
                    for($i=0; $i<count($this->adPerformance['ad_ids']); $i++){
                        echo "<tr>";
                        foreach ($fields as $field){
                            if($field == 'ad_image'){
                                echo '<td><img class="dash-img" src="'. $this->adPerformance[$field][$i] .'"></td>';
                            }else{
                                echo "<td>". number_format($this->adPerformance[$field][$i],0,',','.') ."</td>";
                            }  
                        }
                        echo "</tr>";
                    }
                    echo
                    "</tbody>
                </table>
            </div>
            ";
        }
        public function reactionsTable(){
               echo "
            <div class='dash-section'>
                <h3> <i class='fas fa-puzzle-piece fb-icon'></i> Reacciones de Publicaciones </h3>
                <table class='overview-table'>
                    <thead>
                        <tr>
                            <th>Publicaciones</th>
                            <th>Reacciones Totales</th>
                            <th class='csize'><i class='far fa-thumbs-up fa-2x'></i></th>
                            <th class='csize'><i class='fas fa-heart fa-2x'></i></th>
                            <th class='csize'><i class='far fa-surprise fa-2x'></i></th>
                            <th class='csize'><i class='far fa-laugh-squint fa-2x'></i></th>
                            <th class='csize'><i class='fas fa-sad-tear fa-2x'></i></th>
                            <th class='csize'><i class='far fa-angry fa-2x'></i></th>
                        </tr>
                    </thead>
                    <tbody>";
                    $fields = ['ad_image','total_reactions','likes','love','wow','haha','sorry','anger'];
                    for($i=0; $i<count($this->adPerformance['ad_ids']); $i++){
                        echo "<tr>";
                        foreach ($fields as $field) {
                            if($field == 'ad_image'){
                                echo '<td><img class="dash-img" src="'. $this->adPerformance[$field][$i] .'"></td>';
                            }else{
                                echo "<td>". number_format($this->adPerformance[$field][$i],0,',','.') ."</td>";
                            }  
                        }
                        echo "</tr>";
                    }
                    echo
                    "</tbody>
                </table>
            </div>
            ";
        }
        public function getAdPerformanceTable(){
     
            if($this->ad_account_id){
                 echo '<script type="text/javascript" src="js/popup.js"></script>';
                 echo '<script type="text/javascript" src="js/send_btnvalue.js"></script>';
                 echo '
                 <pre>
                    <table id="metrics-table">
                    <thead>
                        <tr><th id="buscador" colspan="16"><i class="fas fa-search fa-2x table-search"></i><input type="text" id="search" autofocus placeholder="Search"></th></tr>
                        <tr>
                        <th colspan="18" id="campaign-title"><h4>'. $this->page_name .'</h4></th>
                        </tr>
                        <tr>
                            <th class="csize id-background"><i class="fas fa-fingerprint fa-2x"></i></th>
                            <th class="csize">Id Anuncio</th>
                            <th class="csize"><i class="fas fa-search-plus fa-2x"></i></th>
                            <th class="csize"><i class="fas fa-toggle-on fa-2x"></i></th>
                            <th class="csize">Interacciones</th>
                            <th class="csize"><i class="far fa-thumbs-up fa-2x"></i></th>
                            <th class="csize"><i class="fas fa-heart fa-2x"></i></th>
                            <th class="csize"><i class="far fa-surprise fa-2x"></i></th>
                            <th class="csize"><i class="far fa-laugh-squint fa-2x"></i></th>
                            <th class="csize"><i class="fas fa-sad-tear fa-2x"></i></th>
                            <th class="csize"><i class="far fa-angry fa-2x"></i></th>
                            <th>Reacciones Totales</th>
                            <th>Impresiones <i class="fas fa-coins fa-2x"></i></th>
                            <th>Impresiones Organicas</th>
                            <th>Total Impresiones</th>
                            <th class="csize"><i class="fas fa-mouse-pointer fa-2x"></i></th>
                            <th class="csize">Comments <i class="fas fa-comments fa-2x"></i></th>
                            <th class="csize">Shares <i class="fas fa-share fa-2x"></i></th>
                        </tr>
                    </thead>
                    <tbody>';
                    for ($i=0; $i <count($this->adPerformance['ad_ids']) ; $i++) { 
                        $metrics = ['ad_ids','ads_preview','ad_effective_status','interactions','likes','love','wow','haha','sorry','anger','total_reactions','impressions_paid','impressions_organic','total_impressions','post_clicks','comments','shares'];
                        echo '
                            <tr class="fila'. $i .'">
                            <td>'.$i.'</td>';
                        foreach ($metrics as $key) {
                            if(@$this->adPerformance[$key][$i]){
                                echo '<td>' . $this->adPerformance[$key][$i] . '</td>';
                            }elseif($key == 'ads_preview'){
                                if (@$this->adPerformance['ad_ids'][$i]) {
                                    echo '
                                        <td><button id="'.$this->adPerformance['ad_ids'][$i].'" class="btn-abrir-popup">Post Preview</button></td>';
                                }
                                echo '<div class="overlay" id="overlay">
                                    <div class="popup" id="popup">
                                    
                                
                                  </div>
                             </div>';
                            }else{
                                echo '<td> </td>';
                            }  
                        }
                        echo '
                        </tr>
                        
                    ';  
                        }
                    echo '
                    </tbody>
                    </table>

                    <script type="text/javascript">
                        var busqueda = document.getElementById("search");
                            var table = document.getElementById("metrics-table").tBodies[0];

                            buscaTabla = function () {
                                texto = busqueda.value.toLowerCase();
                                var r = 0;
                                while (row = table.rows[r++]) {
                                    if (row.innerText.toLowerCase().indexOf(texto) !== -1)
                                        row.style.display = null;
                                    else
                                        row.style.display = "none";
                                }
                            }

                            busqueda.addEventListener("keyup", buscaTabla);
                    </script>
                    ';
                       
                }else{
                    echo "There is no available campaigns";
                }
            }  
            // public function callReporting(){
            //     echo '
            //         <a href="index.php?idpage='. $this->id_page .'&accountid='. $this->ad_account_id .'&tablename='. $this->db_table_name .'" id="reporting">Ad Reporting</a><a href="index.php?accountid='. $this->ad_account_id .'&tablename='. $this->db_table_name .'" class="graphicSystem" id="reporting"> Graphic System </a> 
            //         <script type="text/javascript" src="js/option_reporting.js"></script>
            //         <script src="js/graficas.js" type="text/javascript"></script>
            //     ';
            // }
            public function adPreview($ad_id){
                $ad_preview = new AdsPreview($ad_id);
            }
        }
        // For Sessions arrays
        // $_SESSION['adPerformance']['data'] = $adPerformance;


 