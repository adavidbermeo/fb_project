<!DOCTYPE html>
<html>
  <head>
    <title> Ad List FB</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
  </head>
  <body>
    <div class="containers body">
      <h1 id="maintitle">Ad list by Account</h1>
      <?php
        require_once '../core/Facebook/vendor/autoload.php';
        session_start();
        set_time_limit(0);

        use FacebookAds\Api;
        use Facebook as FB;
        // Initialize a new Session and instantiate an API object
        $api = Api::init('2350209521888424','ac382c09d088b06f29e04878922c71f7','EAAhZAgMuzLKgBABXM4kYG02JQnBGSaHG5YKZAOlzcAxyfTPUdcINbZBFDkEXEuRrkGLRMJvM33EMIYZCEOJPdTBn413LBZBotQUAYIZBSQOa35qbu1FhPZCUY5iJt6WClEd54wtZCT3j3ih9UILWxq6xedmVHtBZAwzaOAJybmU8ZCKBZBIUN3Q8CYQZA5DoANrKGIToqMrG43834QZDZD');
        $api = Api::instance();
        
        //Datos sobre la campaña id/nombre
        use FacebookAds\Object\Ad;
        use FacebookAds\Object\Fields\AdFields;
        use FacebookAds\Object\AdSet;
        use FacebookAds\Object\Fields\AdSetFields;

        $fb = new Facebook\Facebook([
          'app_id' => '2350209521888424',
          'app_secret' => 'ac382c09d088b06f29e04878922c71f7',
          'default_graph_version' => 'v3.3',
        ]);
        $access_token
        ='EAAhZAgMuzLKgBAOVuahJO2T1ntue85TZAXcqEpG9fD3wHZBGrN6vwVbKJeCh5ndisbgpwz209RFZCFVVCzjYEhQvUAUv7HurJQLFKhlLtGSvbTU7qI1OKNGQnZCfhe0JyzzwGA7GLweKLYw9iY4ahWo2xYyizaAXkxWZA2GqSFtE3ggMM2h4uyrRZBUQa8l3VsZD';
        try {
        // Returns a `FacebookFacebookResponse` object
        $response = $fb->get(
        '/me/adaccounts?fields=name,id,campaigns{id,name,status,objective}',
       $access_token
        );
        } catch(FacebookExceptionsFacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
        } catch(FacebookExceptionsFacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
        }
        $graphNode = $response->getGraphEdge();
        $data = $graphNode->asArray();
        foreach ($data as $i => $ad_account){
          echo '<h2><a href="../metrics/campaign/campaign_info.php">ALL CAMPAIGN STATISTICS</a></h2><h3>'. $ad_account['id'].'</h3>';
          echo '<h2>'. $ad_account['name'].'</h2>';
          $id_ad_account = $ad_account['id'];
          foreach ($ad_account['campaigns'] as $i => $camp) {
          ?>
          <div id="data-info">
            <?php
              echo '<b> AD ID:</b>'.$camp['id'].'<br>';
              echo '<b> AD NAME:</b>'.$camp['name'].'<br>';
              echo '<b> OBJECTIVE:</b>'.$camp['objective'].'<br>';
              echo '<b> AD STATUS:</b>'.$camp['status'].'<br><br>';
              echo '<b> AD DETAILS :</b><a href="../metrics/ads/AdPerformance.php">See here</a>'.'<br><br>';
            ?>
          </div>
          <?php
          }
        }
        try {
        // Returns a `FacebookFacebookResponse` object
        $response2 = $fb->get(
        '2169954096621238?fields=country_page_likes',
        $access_token
        );
        } catch(FacebookExceptionsFacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
        } catch(FacebookExceptionsFacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
        }
        $graphNodes = $response2->getGraphNode();
        print_r($graphNodes);

        /**
         * Custom class to set and get the Ad Account id
         */
      ?>
    </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>