<?php 
$interactions = 44;
$post_id  = 123;
$id_account = 477;
$likes = 60;
$love = 21;
$wow = 11;
$haha = 31;
$sorry = 98;
$anger = 21;
$total_reactions = 32;
$impressions_paid = 64;
$impressions_organic = 20;
$total_impressions = 784;
$post_clicks = 213;
$adPerformance = [
            'interactions' => $interactions,
            'post_id' => $post_id, 
            'id_account' => $id_account, 
            'likes' => $likes, 
            'love' => $love, 
            'wow' => $wow, 
            'haha' => $haha, 
            'sorry' => $sorry, 
            'anger' => $anger, 
            'total_reactions' => $total_reactions, 
            'impressions_paid' => $impressions_paid, 
            'impressions_organic' => $impressions_organic, 
            'total_impressions' => $total_impressions, 
            'post_clicks' => $post_clicks, 
        ];

$_SESSION['adPerformance']['content'] = $adPerformance;