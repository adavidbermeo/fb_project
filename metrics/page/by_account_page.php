<?php 
namespace metrics\page; 
require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/functions/more_interaction.php');
  
use functions\Interactions;
use Facebook\Facebook as FB;

Class ByAccountPage{
  // Attributes
  public $db_table_name = "page";

  protected $fb;
  protected $app_access_token;
  protected $page_access_token;
  protected $id_page;
  protected $response;
  protected $page_name;

  protected $end_time= [];
  protected $total_new_likes= [];
  protected $people_paid_like= [];
  protected $people_unpaid_like= [];
  protected $fans_age_gender= [];
  protected $fans_city= [];
  protected $page_post_engagements= [];

  protected $account_info_array= [];
  

  // Methods
  public function __construct($id_page, $ad_account_id){
    $this->fb = new FB([
      'app_id' => '2350209521888424',
      'app_secret' => 'ac382c09d088b06f29e04878922c71f7',
      'default_graph_version' => 'v3.3',
    ]);
    $this->app_access_token ='EAAhZAgMuzLKgBAG3RH7iiUZARc8uHPfueVRWl5DHZBuhigF5CyyB41R1LzueQvhrCSe3UDNFOgeFnYSoBzZAsFSDx5Ts6HonqrB72Dd0HEVZB5dOqlTrA1IXfPCuQkncjodG5CeG5ytJEu9AoCFVuXRjVYZAS9f6LgZAF8uZBDzYUecfxGtd385ZCgtE7Yq6Y6x4giWyOe1NgEAZDZD';
    $this->id_page = $id_page;
    $this->ad_account_id = $ad_account_id;

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
    // $this->getArrayAccountInfo();
    $this->getAdPerformanceGeneralTable();
    $this->getAgeGenderTable();
    $this->getfansCityTable();
    $this->callReporting();
    
    $most_interactionsPost  = new Interactions($this->id_page, $this->ad_account_id);
    $most_interactionsPost->moreInteraction();
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
      $this->response = $this->fb->get($this->id_page .'/insights?metric=page_fan_adds_by_paid_non_paid_unique,page_fans_gender_age,page_fans_city,page_post_engagements',
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
    echo '<pre>'.'<br>';
    $graphNode = $this->response->getGraphEdge();
    $data = $graphNode->asArray();

    // echo '<h1>Page Fans</h1>';
    $item = -1;
    foreach ($data as $i => $camp){
      $item++;
      $name = $camp['name'];
      $this->period = $camp['period'];
      foreach ($data[$item] as $n){
        if (is_array($n)) {
          switch ($name) {
            case 'page_fan_adds_by_paid_non_paid_unique':
              $this->end_time = $n[1]['end_time']->format('Y-m-d H:i:s');
              $this->total_new_likes =  $n[1]['value']['total'];
              $this->people_paid_like = $n[1]['value']['paid'];
              $this->people_unpaid_like =  $n[1]['value']['unpaid'];
              break;
            case 'page_fans_gender_age':
              $this->fans_age_gender = $n[1]['value'];
            break;
            case 'page_fans_city':
              $this->fans_city =  $n[1]['value'];
            break;
            case 'page_post_engagements':
              if ($this->period == 'days_28') {
                $this->page_post_engagements =  $n[1]['value'];
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
  public function setArrayAccountInfo(){
    $this->account_info_array = [
      'id_page'=>$this->id_page,
      'end_time' => $this->end_time,
      'total_new_likes' => $this->total_new_likes,  
      'people_paid_like' => $this->people_paid_like,  
      'people_unpaid_like' => $this->people_unpaid_like,  
      'fans_age_gender' => $this->fans_age_gender,  
      'fans_city' => $this->fans_city,  
      'page_post_engagements' => $this->page_post_engagements,  
    ];
     $this->database_account_info_array = [
      'id_page'=>$this->id_page,
      'end_time' => $this->end_time,
      'total_new_likes' => $this->total_new_likes,  
      'people_paid_like' => $this->people_paid_like,  
      'people_unpaid_like' => $this->people_unpaid_like,  
      'page_post_engagements' => $this->page_post_engagements,  
    ];
  }
  public function getArrayAccountInfo(){
    print_r($this->account_info_array);
  }
  public function getAdPerformanceGeneralTable(){
      echo '
        <table>
          <thead>
            <tr>
              <th colspan="13" id="campaign-title"><h4>'. $this->page_name .'<br> General Performance</h4></th>
            <tr>
            <tr>
                <th><i class="fas fa-barcode fa-2x"></i></th>
                <th><i class="far fa-calendar-alt fa-2x"></i></th>
                <th>Total: Nuevos <i class="far fa-thumbs-up fa-2x"></i></th>
                <th>Like <i class="fas fa-money-check-alt fa-2x"></i></th>
                <th>Like Organico</th>
                <th>Interacciones Totales</th>
            </tr>
          </thead>';
          for ($i=0; $i <1 ; $i++) { 
            $metrics = array_keys($this->account_info_array);
            unset($metrics[5]); unset($metrics[6]);
            echo '
            <tbody>
              <tr>';
              foreach ($metrics as $key) {
                  if($this->account_info_array[$key]){
                      echo '<td>' . $this->account_info_array[$key] . '</td>';
                   
                  }else{
                      echo '<td>x</td>';
                  }
              }
              // echo '<td>F.13-17</td>';
              echo '
              </tr>
              </tbody>';  
            }
        echo '
        </table>'; 
    }
    public function getAgeGenderTable(){
      echo '
      <table>
        <thead>
          <tr>
            <th id="campaign-title"><h4>'. $this->page_name .'<br> Age Gender</h4></th>
            <th class="age-gender"><i class="fas fa-equals fa-2x"></i></th>
          </tr>
        </thead>';
        $keys = array_keys($this->account_info_array['fans_age_gender']);
        
        foreach ($keys as $item) {
           echo '
          <tbody>
            <tr rowspan="2">
            <th>'. $item .'</th>
            <td>'. $this->account_info_array['fans_age_gender'][$item] .'</td>  
          </tbody>';   
        }
        echo '
        <tfoot>
        </tfoot>
      </table>';  
    }
    public function getfansCityTable(){
      echo '
      <table>
        <thead>
          <tr>
            <th id="campaign-title"><h4>'. $this->page_name .'<br> Fans City</h4></th>
            <th class="age-gender"><i class="fas fa-equals fa-2x"></i></th>
          </tr>
        </thead>';
        $keys = array_keys($this->account_info_array['fans_city']);
            
        foreach ($keys as $item) {
           echo '
          <tbody>
            <tr rowspan="2">
            <th>'. $item .'</th>
            <td>'. $this->account_info_array['fans_city'][$item] .'</td>  
          </tbody>';
        }
        echo '
        <tfoot>
        </tfoot>
      </table>';  
    }
    public function callReporting(){
      echo "
      <div id='callReporting'>
        <a href='index.php?idpage=". $this->id_page ."&accountid=". $this->ad_account_id ."&tablename=". $this->db_table_name ."' id='reporting-page'>Page Reporting</a>
      </div>";
    }
}
?>
<script type="text/javascript" src="js/option_report.js"></script>

  


  
       