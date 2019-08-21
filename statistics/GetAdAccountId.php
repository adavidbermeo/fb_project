<?php 
    // namespace statistics;
    require_once '../core/Facebook/vendor/autoload.php';
    session_start();
    use Facebook as FB;
    $fb = new Facebook\Facebook([
        'app_id' => '2350209521888424',
        'app_secret' => 'ac382c09d088b06f29e04878922c71f7',
        'default_graph_version' => 'v3.3',
    ]);
    $access_token
    ='EAAhZAgMuzLKgBABXM4kYG02JQnBGSaHG5YKZAOlzcAxyfTPUdcINbZBFDkEXEuRrkGLRMJvM33EMIYZCEOJPdTBn413LBZBotQUAYIZBSQOa35qbu1FhPZCUY5iJt6WClEd54wtZCT3j3ih9UILWxq6xedmVHtBZAwzaOAJybmU8ZCKBZBIUN3Q8CYQZA5DoANrKGIToqMrG43834QZDZD';
    try {
    // Returns a `FacebookFacebookResponse` object
    $response = $fb->get(
        'me/adaccounts?fields=name,id,campaigns{id,name,status,objective}',
        $_SESSION['fb_token']
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
    $id_ad_account = $ad_account['id'];
    echo $id_ad_account .'<br>';
    }
    
    