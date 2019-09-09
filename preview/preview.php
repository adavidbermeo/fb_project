<?php
namespace preview;
require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
use Facebook\Facebook as FB;

    class AdsPreview{
        
        public $ad_id;
        public $access_token;
        public $fb;
        public $ad_preview;

        public function __construct($ad_id){
            $this->fb = new FB([
                'app_id' => '2350209521888424',
                'app_secret' => 'ac382c09d088b06f29e04878922c71f7',
                'default_graph_version' => 'v3.3',
            ]);
            $this->access_token ='EAAhZAgMuzLKgBAKlw99pRzobWtWXZBzEttgmBfr05o3dEeqggu9zVwnic8gMH8lRec7zMLcBZCoeder4nd9YAJVua0SIvy5fEqvIB4MzSGVnpvIb3MV7EuH8bIv9OZAoFouL65e7UxMRjKmEKPos2kdwaYZBZB3uEHalfD9IuWVRLYI1o4r4Qcl1lXIGim2bALvIhbeBgegt8EHaShZBJztcyihOkRLZBFcZAoI4S0xfrdgZDZD';
            $this->ad_id = $ad_id;
            
            /**
             * Invoque callMethods function to preload
             */
            $this->callMethods();

        }
        public function callMethods(){
            $this->setAdPreview();
            $this->getAdPreview();
        }
        public function setAdPreview(){
            $request = $this->fb->get($this->ad_id.'/previews/?ad_format=DESKTOP_FEED_STANDARD',$this->access_token);
            $GraphRequest = $request->getGraphEdge();
            $this->ad_preview = $GraphRequest->asArray();
            // print_r($this->ad_preview);
        }
        public function getAdPreview(){
            print_r($this->ad_preview[0]['body']);
        }
    }