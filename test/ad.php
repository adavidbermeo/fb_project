<?php 
require_once( $_SERVER['DOCUMENT_ROOT'].'/proyecto_sem/core/Facebook/vendor/autoload.php');
use Facebook\Facebook as FB;
Class App{
public function __construct(){
    $this->fb = new FB([
      'app_id' => '2350209521888424',
      'app_secret' => 'ac382c09d088b06f29e04878922c71f7',
      'default_graph_version' => 'v3.3',
    ]);
    $this->access_token ='EAAhZAgMuzLKgBAAKYsl5ExnnyrzNnLh4UiOTkExGhuRLcrtaZAvKZA9alcKIGOHxoTS3RWEqYi8zZBguc4JEPZConIWvWF4COZClbLa1nXZCFXZBavPnoK3tkELSSuRHpahnnpRZAFbsRiReu90eRMFFPSuj8RmLsVoyYkFOJgOILXG2gM1f7HVjiNiU1yc7nHQCNqnGnIlyAzgZDZD';
    $this->id_account = 303239893027115;
  }
  public function setResponse(){
    try{
      // Returns a `Facebook\FacebookResponse` object
      // Aveces ayuda ?pretty=0
      $this->response = $this->fb->get('303239893027115/ads_posts?fields=id&limit=100',
        $this->access_token
      );
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
  }
  public function getResponse(){
    $graphNode = $this->response->getGraphEdge();
    echo "<pre>";
    print_r($graphNode); die();
    $data = $graphNode->asArray();
    // echo "<pre>";
    print_r($data);
  }
}
$prueba = new App();
$prueba->setResponse();
$prueba->getResponse();
