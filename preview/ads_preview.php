<?php 
namespace showpreview;
require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/preview/preview.php');


use preview\AdsPreview;
    
    $selected = @$_GET['selected'];
    list($url, $ad_id)= explode('=', $selected);
    $ads_preview = new AdsPreview($ad_id);