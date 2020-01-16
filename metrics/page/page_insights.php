<?php 
namespace metrics\page; 
require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/functions/more_interaction.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/config/const.php');
  
use functions\Interactions;
use Facebook\Facebook as FB;

Class PageInsights{
  // Attributes
  public $db_table_name = "page";

  public $more_interaction;
  public $fb;
  public $app_access_token;
  public $page_access_token;
  public $id_page;
  public $response;
  public $page_name;
  public $page_impressions = [];
  public $page_fans = [];
  public $page_views_total = [];

  public $end_time= [];
  public $total_new_likes= [];
  public $people_paid_like= [];
  public $people_unpaid_like= [];
  public $fans_age_gender= [];
  public $fans_city= [];
  public $page_post_engagements= [];
  public $page_posts_impressions = [];

  public $account_info_array= [];
  

  // Methods
  public function __construct($id_page, $ad_account_id, $more_interaction = 0){
    $this->fb = new FB([
      'app_id' => '2350209521888424',
      'app_secret' => 'ac382c09d088b06f29e04878922c71f7',
      'default_graph_version' => 'v3.3',
    ]);
    $this->app_access_token = ACCESS_TOKEN;
    $this->id_page = $id_page;
    $this->ad_account_id = $ad_account_id;
    $this->more_interaction = $more_interaction;

    /**
     * Pre-load methods 
     */
      $this->callMethods();
  }
  public function callMethods(){
    /**
     * Helps to preload the needed methods by the user 
     */
    $this->setAccessToken();
    $this->setResponse();
    $this->setAccountInfo();
    $this->setArrayAccountInfo();

    if($this->more_interaction == TRUE){
      $most_interactionsPost  = new Interactions($this->id_page, $this->ad_account_id);
      $most_interactionsPost->moreInteraction();
    }
  }
   public function setAccessToken(){
    $request = $this->fb->get($this->id_page. '?fields=access_token,name',$this->app_access_token); 
    $GraphRequest = $request->getGraphNode();
    
    $data = $GraphRequest->asArray();
    $this->page_access_token = $data['access_token'];
    $this->page_name = $data['name'];
    }
  public function getAccessToken(){
      echo $this->access_token;
  }
  public function setResponse(){
    try{
      // Returns a `Facebook\FacebookResponse` object
      $this->response = $this->fb->get($this->id_page .'/insights?metric=page_fan_adds_by_paid_non_paid_unique,page_fans_gender_age,page_fans_city,page_post_engagements,page_impressions,page_posts_impressions,page_fans,page_views_total&since=2019-12-01T08:00:00&until=2019-12-31T08:00:00',
        $this->page_access_token
      );
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
  }
  public function setAccountInfo(){
    
    $graphNode = $this->response->getGraphEdge();
    $data = $graphNode->asArray();

    // echo '<h1>Page Fans</h1>';
    $item = -1;
    
    foreach ($data as $i => $camp){
      // print_r($data);
      $item++;
      $name = $camp['name'];
      $this->period = $camp['period'];
      foreach ($data[$item] as $n){
        
        if (is_array($n)) {
          
          for ($i=0; $i <count($n) ; $i++) { 
            switch ($name) {
            case 'page_fan_adds_by_paid_non_paid_unique':
              // echo count($n);
              $this->end_time[] = $n[$i]['end_time']->format('Y-m-d H:i:s');
              $total_new_likes[] =  $n[$i]['value']['total'];
              $people_paid_like[] = $n[$i]['value']['paid'];
              $people_unpaid_like[] =  $n[$i]['value']['unpaid'];
              break;
            case 'page_fans_gender_age':
              $fans_age_gender[] = $n[$i]['value'];
            break;
            case 'page_fans_city':
              $fans_city[] =  $n[$i]['value'];
            break;
            case 'page_post_engagements':
              if ($this->period == 'day') {
                $page_post_engagements[] =  $n[$i]['value'];
              }
            break;
            case 'page_impressions':
              if ($this->period == 'day') {
                $page_impressions[] = $n[$i]['value'];
              }
              break;
            case 'page_posts_impressions':
              if ($this->period == 'day') {
                $page_posts_impressions[] = $n[$i]['value'];
              }
              break;
            case 'page_fans':
              if ($this->period == 'day') {
                $page_fans[] = $n[$i]['value'];
              }
              break;
            case 'page_views_total':
               if ($this->period == 'day') {
                $page_views_total[] = $n[$i]['value'];
              }
              break;
            default:
              echo "An unexpected error has ocurred";
            break;
          }
          }
        }
      }
    }
    // Set statistics vars

    $this->page_posts_impressions = array_sum($page_posts_impressions);
    $this->fans_age_gender = end($fans_age_gender);
    $this->fans_city = end($fans_city);
    $this->page_impressions = array_sum($page_impressions);
    $this->total_new_likes = array_sum($total_new_likes);
    $this->page_post_engagements = array_sum($page_post_engagements);
    $this->people_paid_like = array_sum($people_paid_like);
    $this->people_unpaid_like = array_sum($people_unpaid_like);
    $this->page_fans = end($page_fans);
    $this->page_views_total = array_sum($page_views_total);

  }
  public function setArrayAccountInfo(){
    $this->account_info_array = [
      'id_page'=>$this->id_page,
      'end_time' => $this->end_time,
      'total_new_likes' => $this->total_new_likes,  
      'people_paid_like' => $this->people_paid_like,  
      'people_unpaid_like' => $this->people_unpaid_like,  
      'page_post_engagements' => $this->page_post_engagements,
      'page_impressions' => $this->page_impressions,
      'page_posts_impressions' => $this->page_posts_impressions,
      'page_fans' => $this->page_fans,
      'page_views_total' => $this->page_views_total,
      'fans_age_gender' => $this->fans_age_gender,  
      'fans_city' => $this->fans_city,
      'ad_account_id' => $this->ad_account_id    
    ];
    $this->db_account_info_array = [
      'id_page'=>$this->id_page,
      'page_name' => $this->page_name,
      'end_time' => $this->end_time,
      'total_new_likes' => $this->total_new_likes,  
      'people_paid_like' => $this->people_paid_like,  
      'people_unpaid_like' => $this->people_unpaid_like,  
      'ad_account_id' => $this->ad_account_id,    
      'page_post_engagement' => $this->page_post_engagements
    ];
  }
  public function getArrayAccountInfo(){
    print_r($this->account_info_array);
  }
  public function getAdPerformanceGeneralTable(){
      echo '
      <pre>
        <table>
          <thead>
            <tr>
              <th colspan="13" id="campaign-title"><h4>'. $this->page_name .'<br> General Performance</h4></th>
            <tr>
            <tr>
                <th class="id-background"><i class="fas fa-barcode fa-2x"></i></th>
                <th><i class="far fa-calendar-alt fa-2x"></i></th>
                <th>Total: Nuevos <i class="far fa-thumbs-up fa-2x"></i></th>
                <th>Like <i class="fas fa-money-check-alt fa-2x"></i></th>
                <th>Like Organico</th>
                <th>Interacciones Totales</th>
                <th>Impresiones de Pagina</th>
                <th>Impresiones de Publicaciones</th>
                <th>Me gusta</th>
                <th>Paginas Vistas</th>
            </tr>
          </thead>
          <tbody>';
          for ($i=0; $i <1 ; $i++) { 
            $metrics = array_keys($this->account_info_array);
            unset($metrics[10]); unset($metrics[11]); unset($metrics[12]);
            echo '
            
              <tr class="fila'. $i .'">';
              foreach ($metrics as $key) {
                
                if($key == 'end_time'){
                  $pos = count($this->account_info_array['end_time']) - 1;
                  echo '<td>'. $this->account_info_array[$key][0] .' / '.  $this->account_info_array[$key][$pos] .'</td>';
                }else{
                   if($this->account_info_array[$key]){
                      echo '<td>' . $this->account_info_array[$key] . '</td>';
                  }else{
                      echo '<td>  </td>';
                  }
                }     
              }
              // echo '<td>F.13-17</td>';
              echo '
              </tr>
              ';  
            }
        echo '
        </tbody>
        </table>
        '; 
    }
    public function getAgeGenderTable(){
      echo '
      <table id="metrics-table">
        <thead>
          <tr><th id="buscador" colspan="2"><i class="fas fa-search fa-2x table-search"></i><input type="text" id="search" autofocus placeholder="Search" class="pageStaTable"></th></tr>
          <tr>
            <th id="campaign-title"><h4>'. $this->page_name .'<br> Age Gender</h4></th>
            <th class="age-gender"><i class="fas fa-equals fa-2x"></i></th>
          </tr>
        </thead>
        <tbody>';
        $keys = array_keys($this->account_info_array['fans_age_gender']);
        $i = 0;
        foreach ($keys as $item) {
          $i = $i+1;
             echo '
              <tr rowspan="2" class="fila'. $i .'">
              <th>'. $item .'</th>
              <td>'. $this->account_info_array['fans_age_gender'][$item] .'</td>  
            ';   
          
          
        }
        echo '
        </tbody>
        <tfoot>
        </tfoot>
      </table>';  
    }
    public function getfansCityTable(){
      echo '
      <table id="fansCity-table">
        <thead>
          <tr><th id="buscador" colspan="2"><i class="fas fa-search fa-2x table-search"></i><input type="text" id="fans-search" autofocus placeholder="Search" class="pageStaTable"></th></tr>
          <tr>
            <th id="campaign-title"><h4>'. $this->page_name .'<br> Fans City</h4></th>
            <th class="age-gender"><i class="fas fa-equals fa-2x"></i></th>
          </tr>
        </thead>
        <tbody>';
        $keys = array_keys($this->account_info_array['fans_city']);
        $i = 0;
        foreach ($keys as $item) {
          $i = $i+1;

              echo '
              <tr rowspan="2" class="fila'. $i .'">
              <th>'. $item .'</th>
              <td>'. $this->account_info_array['fans_city'][$item] .'</td>  
            ';
          
        }
        echo '
        </tbody>
        <tfoot>
        </tfoot>
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

            /*Second Table*/

            var busqueda2 = document.getElementById("fans-search");
            var table2 = document.getElementById("fansCity-table").tBodies[0];

            buscaTabla2 = function () {
                texto = busqueda2.value.toLowerCase();
                var r = 0;
                while (row = table2.rows[r++]) {
                    if (row.innerText.toLowerCase().indexOf(texto) !== -1)
                        row.style.display = null;
                    else
                        row.style.display = "none";
                }
            }

            busqueda2.addEventListener("keyup", buscaTabla2);
    </script>';  
    }
    public function callReporting(){
      echo "
        <a href='index.php?idpage=". $this->id_page ."&accountid=". $this->ad_account_id ."&tablename=". $this->db_table_name ."' id='reporting'>Page Reporting</a><a href='index.php?accountid=". $this->ad_account_id ."&tablename=". $this->db_table_name ."' class='graphicSystem' id='reporting'> Graphic System </a> 
        <script type='text/javascript' src='js/option_reporting.js'></script>
        <script src='js/graficas.js' type='text/javascript'></script>
        ";
    }
}


  


  
       