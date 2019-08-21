<?php
/**
 * 
 */
	class AuthFacebook{

		private $helper;

		public $ulrcallback = HOST.'/fb-callback.php';

		public $scopes = ['ads_management'];

		public function __construct(){

			$user_fb = new Facebook\Facebook([

				'app_id' => '2350209521888424',

				'app_secret' => 'ac382c09d088b06f29e04878922c71f7'
			]);

			$this->helper = $user_fb->getRedirectLoginHelper();

		}

		private function hasTokenError($token){

			if(!isset($token)){

				if($this->helper->getError()){

					$get_error = 'Error Code: '.$this->helper->getErrorCode().'<br>'.'Error Reason: '. $this->helper->getErrorReason();

				}
				else{

					$get_error = 'Bad request';

				}

				$Error = sprintf(msg_error_token,$get_error );

			}

			return (!isset($Error))? array('success',msg_success_token): array('danger',$Error);

		}

		public function getUrl(){

			return $this->helper->getLoginUrl($this->ulrcallback,$this->scopes);

		}

		public function AccessToken(){

			try{

				$token = $this->helper->getAccessToken();

				return array($token,$this->hasTokenError($token));

			}
			catch(Facebook\Exceptions\FacebookSDKException $e){

				return array(NULL,array('danger',$e->getMessage()));

			}

		}

	}

?>