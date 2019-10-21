<?php
namespace preview;
require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
use Facebook\Facebook as FB;
if(isset($_POST['btnId'])){
    $ad_id = $_POST['btnId'];
    $ad_preview = new AdsPreview($ad_id);
}
    class AdsPreview{
        
        public $ad_id;
        public $access_token;
        public $fb;
        public $ad_preview;

        public function __construct($ad_id){
            echo '<script type="text/javascript" src="js/popup.js"></script>';
            $this->fb = new FB([
                'app_id' => '2350209521888424',
                'app_secret' => 'ac382c09d088b06f29e04878922c71f7',
                'default_graph_version' => 'v3.3',
            ]);
            $this->access_token ='EAAhZAgMuzLKgBAAsyq0KyfYToRgrPr4XIl5foFMDSzIqL5ZB7hXm3jKweZCQZAWkIlT7bdgga4y6zK0KpxUihfOJPMlNd5gZAtZCxftjJgYptkgT5Hch38jdcWGO3yfp9ZAmjcbmbC9Hkj44HMg8tdvqGQ4nTt5B4wXb5OLwoyNgDj00FFTSOvAOLbE7WgxwFSW63r37O4ktDH52UcZABivTZAlZBQNcfpHkZCSQtDc5wb3TwZDZD';
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
            
        echo '<a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>';
         print_r($this->ad_preview[0]['body']);
            
        }
    }