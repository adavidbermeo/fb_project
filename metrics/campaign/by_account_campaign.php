<?php
  namespace metrics\campaign; 

  require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
  use Facebook\Facebook as FB;

  Class ByAccountCampaign{
    // Properties 

    public $db_table_name = "campaign";

    public $access_token;
    public $fb;
    public $request;
    public $campaign_info;
    public $campaign_statistics = [];
    

    public $ad_account_id;
    public $ad_account_name;
    public $campaign_name = [];
    public $campaign_id = [];
    public $status = [];
    public $clicks = [];
    public $impressions = [];
    public $spend = [];
    public $reach = [];
    public $objective = [];
    public $cost_per_lead = [];
    public $cost_per_result = [];
    public $action_type = [];
    public $action_value = [];


    // Methods 
    public function __construct($ad_account_id){
      $this->fb = new FB([
        'app_id' => '2350209521888424',
        'app_secret' => 'ac382c09d088b06f29e04878922c71f7',
        'default_graph_version' => 'v3.3',
      ]);
      $this->access_token ='EAAhZAgMuzLKgBALw6wMVa3m6UpWPiF130yStQMKB3rLvwI9cQ4UAiCzQ1AWcVm2JeJ7Mh9J0spVSgiW84bs9HmGW79hrbzvCf4DblwAfo207nvza4hGFKA0ZBXCDf9B964HUoqgvkJ3Vf678Gu2bf9WiLoZAozlFswRsLctXvQYEYjAHjsSDlkVZBI3c4ynXh9Ycc3spy8p03WdMZASVycAwIpDkuclvyVZCtWENcyIgZDZD';
      $this->ad_account_id = $ad_account_id;

      /**
       * Invoque the CallMethods function
       */
        $this->CallMethods();
    }
    public function callMethods(){
    /**
     * Call all methods in the class 
     */
      $this->setRequest();
      $this->setDataArray();
      $this->setCampaignStatistics();
      $this->setCampaignStatisticsArray();
      //$this->getCampaignStatisticsArray();

      // $this->getCampaignStatisticsTable();
      // $this->callReporting();
    }
    public function setRequest(){
      try {
        // Returns a `FacebookFacebookResponse` object
        $this->request = $this->fb->get( $this->ad_account_id .'?fields=name,id,campaigns{name,status,objective,insights{clicks,impressions,spend,reach,objective,cost_per_unique_click,cost_per_conversion,cost_per_action_type}}&limit=100',$this->access_token);
      } catch(FacebookExceptionsFacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
      } catch(FacebookExceptionsFacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
      }
    } 
    public function setDataArray(){
      $graphNodes = $this->request->getGraphNode();
      $this->campaign_info = $graphNodes->asArray();
     
    }
    public function getDataArray(){
      // echo "<pre>";
      print_r($this->campaign_info);
      // echo "</pre>";
    }
    public function setCampaignStatistics(){
      $this->ad_account_name = $this->campaign_info['name'];
      foreach ($this->campaign_info['campaigns'] as $n){

          $this->campaign_name[] =  $n['name'];
          $this->campaign_id[] = $n['id']; 
          $this->status[] = $n['status']; 
          // foreach ($n as $i =>$value) {
            // print_r($value);
            // if(is_array($value)){
              // foreach ($value as $key) {
                  $this->clicks[] = @$n['insights'][0]['clicks'];
                  $this->impressions[] = @$n['insights'][0]['impressions'];
                  $this->spend[] = @$n['insights'][0]['spend'];
                  $this->reach[] = @$n['insights'][0]['reach'];
                  $this->objective[] = @$n['insights'][0]['objective'];
                  $this->cost_per_lead[] = @$n['insights'][0]['cost_per_unique_click'];
                  if(@$n['insights'][0]['cost_per_action_type']){
                    foreach (@$n['insights'][0]['cost_per_action_type'] as $severals =>$i) {
                      $this->cost_per_result[] = $i;
                      $this->action_type[] = $i['action_type'];
                      $this->action_value[] = $i['value'];
                    }
                  }
              // }
            // }
          // } 
        // }   
      }
    }
    public function setCampaignStatisticsArray(){
      $this->campaign_statistics = [
        'campaign_id' => $this->campaign_id,
        'campaign_name' => $this->campaign_name,
        'c_status' => $this->status,
        'clicks' => $this->clicks,
        'impressions' => $this->impressions,
        'spend' => $this->spend,
        'reach' => $this->reach,
        'objective' => $this->objective,
        'cost_per_lead' => $this->cost_per_lead,
        'cost_per_result' => $this->cost_per_result,
        'action_type' => $this->action_type,
        'action_value' => $this->action_value,
        'ad_account_id' => $this->ad_account_id,
        'ad_account_name' => $this->ad_account_name,
      ];
      $this->db_campaign_statistics = [
        'campaign_id' => $this->campaign_id,
        'campaign_name' => $this->campaign_name,
        'c_status' => $this->status,
        'clicks' => $this->clicks,
        'impressions' => $this->impressions,
        'spend' => $this->spend,
        'reach' => $this->reach,
        'objective' => $this->objective,
        'cost_per_lead' => $this->cost_per_lead,
        'action_type' => $this->action_type,
        'action_value' => $this->action_value, 
        'ad_account_id' => $this->ad_account_id
      ];
    }
    public function getCampaignStatisticsArray(){
      // echo "<pre>";
      print_r($this->campaign_statistics);
      // echo "</pre>";
    }
    public function getCampaignStatisticsTable(){
      echo '
        <table>
          <thead>
            <tr>
              <th colspan="12" id="campaign-title"><h4>'. $this->campaign_statistics['ad_account_name'] .'</h4></th>
            <tr>
            <tr>
              <th><i class="fas fa-barcode fa-2x"></i></th>
              <th>Nombre</th>
              <th><i class="fas fa-toggle-on fa-2x"></i></th>
              <th><i class="fas fa-mouse-pointer fa-2x"></i></th>
              <th>Impresiones</th>
              <th><i class="fas fa-dollar-sign fa-2x"></i></th>
              <th>Alcance</th>
              <th><i class="fas fa-bullseye fa-2x"></i></th>
              <th>Costo por Lead</th>
              <th>Costo por Resultado</th>
            </tr>
          </thead>';
          for ($i=0; $i <count($this->campaign_statistics['campaign_name']) ; $i++) { 
            echo '
            <tbody>
              <tr>';
                $metrics = ['campaign_id','campaign_name','c_status', 'clicks','impressions','spend','reach','objective','cost_per_lead'];
                foreach ($metrics as $key){
                  if(@$this->campaign_statistics[$key][$i]){
                    echo '<td>' . $this->campaign_statistics[$key][$i] . '</td>';
                  }else{
                    echo '<td>x</td>';
                  }
                }
                if(@$this->campaign_statistics['cost_per_result'][$i]){
                  echo '<td>' . $this->campaign_statistics['action_type'][$i] . ' => ' . $this->campaign_statistics['action_value'][$i] . '</td>';
                }else{
                  echo '<td>x</td>';
                }
                  
              echo '
              </tr>
              </tbody>';  
            }
            echo '
              </table>';   
    }
    public function callReporting(){
        echo "
          <div id='callReporting'>
            <a href='index.php?accountname=". $this->ad_account_name ."&accountid=". $this->ad_account_id ."&tablename=". $this->db_table_name ."' id='reporting-campaign'>Campaign Reporting</a>
          </div>
          <script type='text/javascript' src='js/option_report.js'></script>";
    } 
  }

  
