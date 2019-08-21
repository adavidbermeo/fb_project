<?php

	session_start();
	
	require_once 'config/main.php';

	require_once 'core/Facebook/vendor/autoload.php';

	require_once 'core/AuthFacebook.class.php';

	$user_fb = new AuthFacebook();

	$token = $user_fb->AccessToken();

	if(!empty($token[0])){

		$_SESSION['fb_token'] = (string) $token[0];
	}

	$msg=base64_encode(json_encode($token[1]));
	header('location:index.php?msg='.$msg);
?>