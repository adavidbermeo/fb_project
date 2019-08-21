<?php
  namespace metrics\campaign; 

  require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
  use Facebook\Facebook as FB;

  Class ByAccountCampaign{
    // Properties 
    public $access_token;
    public $fb;
    public $request;
    public $campaign_info;
    public $campaign_statistics = [];

    public $id_adAccount;
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


    // Methods 
    public function __construct($id_adAccount){
      $this->fb = new FB([
        'app_id' => '2350209521888424',
        'app_secret' => 'ac382c09d088b06f29e04878922c71f7',
        'default_graph_version' => 'v3.3',
      ]);
      $this->access_token ='EAAhZAgMuzLKgBACempvSxEZBTZBhji3ZBU4dvLYZC0AT0kCWBxTKZCThJXdm9cHo0WvdbEvuZCUxQIWNDuJjxMZAg9RS6wmKv9YvnexbJcua4bd6XXgDm3SWWLuvxQgb9olNPnP3wexicbMnUIqvfHPUaEvIzxHWDcEmMhDTMag6YPVvZBVaLilW1vpekv1T6aZCbmx1AEBVnnjISiOfRkBURJ0vJ0JFRY7MibS2dF4YpDZAAZDZD';
      $this->id_adAccount = $id_adAccount;

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
      $this->getCampaignStatisticsTable();
    }
    public function setRequest(){
      try {
        // Returns a `FacebookFacebookResponse` object
        $this->request = $this->fb->get( $this->id_adAccount .'?fields=name,id,campaigns{name,status,objective,insights{clicks,impressions,spend,reach,objective,cost_per_unique_click,cost_per_conversion,cost_per_action_type}}&limit=100',$this->access_token);
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
        foreach ($n as $i =>$value) {
          if(is_array($value)){
            foreach ($value as $key) {
              if(is_array($key)){
                $this->clicks[] = @$key['clicks'];
                $this->impressions[] = @$key['impressions'];
                $this->spend[] = @$key['spend'];
                $this->reach[] = @$key['reach'];
                $this->objective[] = @$key['objective'];
                $this->cost_per_lead[] = @$key['cost_per_unique_click'];
                if(@$key['cost_per_action_type']){
                  foreach (@$key['cost_per_action_type'] as $severals =>$i) {
                    $this->cost_per_result[] = $i;
                  }
                }
              }else{
                echo 'NO CONTENT AVAILABLE';
              }
            }
          }
        }   
      }
    }
    public function setCampaignStatisticsArray(){
      $this->campaign_statistics = [
        'id_adAccount' => $this->id_adAccount,
        'ad_account_name' => $this->ad_account_name,
        'campaign_name' => $this->campaign_name,
        'campaign_id' => $this->campaign_id,
        'status' => $this->status,
        'clicks' => $this->clicks,
        'impressions' => $this->impressions,
        'spend' => $this->spend,
        'reach' => $this->reach,
        'objective' => $this->objective,
        'cost_per_lead' => $this->cost_per_lead,
        'cost_per_result' => $this->cost_per_result,
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
              <th>ID</th>
              <th>Nombre</th>
              <th>Estado</th>
              <th>Clicks</th>
              <th>Impresiones</th>
              <th>Gasto</th>
              <th>Alcance</th>
              <th>Objetivo</th>
              <th>Costo por Lead</th>
              <th>Costo por Resultado</th>
            </tr>
          </thead>';
          for ($i=0; $i <count($this->campaign_statistics['campaign_name']) ; $i++) { 
            echo '
            <tbody>
              <tr>';
                $metrics = ['campaign_id','campaign_name','status', 'clicks','impressions','spend','reach','objective','cost_per_lead'];
                foreach ($metrics as $key){
                  if(@$this->campaign_statistics[$key][$i]){
                    echo '<td>' . $this->campaign_statistics[$key][$i] . '</td>';
                  }else{
                    echo '<td>x</td>';
                  }
                }
                for ($i=0; $i <count($this->campaign_statistics['cost_per_result'][$i]) ; $i++) { 
                   echo '<td>' . $this->campaign_statistics['cost_per_result'][$i]['action_type'] . ' => ' . $this->campaign_statistics['cost_per_result'][$i]['value'] . '</td>';
                }
              echo '
              </tr>
              </tbody>';  
            }
            echo '
              </table>';   
    } 
  }
