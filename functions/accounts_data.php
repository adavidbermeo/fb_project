<?php
namespace functions;

require_once( $_SERVER['DOCUMENT_ROOT'].'/fb_project/core/Facebook/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/config/const.php');
use Facebook\Facebook as FB;

Class AccountsPageData{

    public $db_table_name = "account";
    protected $data_array;
    public $page_data = [];
    public $page_id = [];
    public $page_name = [];
    public $page_post_id = [];
    public $post_id = [];
    public $ad_account_id = [];
    public $account_id = [];
    public $ad_ids;
    public $account_ads = [];   

    // protected $value = 1;

    public function __construct(){
        $this->fb = new FB([
            'app_id'=>'2350209521888424',
            'app_secret'=>'ac382c09d088b06f29e04878922c71f7',
            'default_graph_version'=>'v4.0',
        ]);
        $this->access_token = ACCESS_TOKEN;
        $this->request = $this->fb->get('me/adaccounts?fields=id,name,adcreatives.limit(10){object_story_id}&limit=100',$this->access_token);

        /**
         * Invoque Call Methods function 
         */
        $this->callMethods();
    }
    public function callMethods(){
    /**
     * Call all methods in the class 
     */
        $this->setDataArray();
        $this->setAccountsPageData();
        $this->callFunction();
        $this->setArray();
        
    }
    public function setDataArray(){
        $GraphRequest = $this->request->getGraphEdge();
            "<pre>";
        $this->data_array = $GraphRequest->asArray();

    }
    public function getDataArray(){
        echo "<pre>";
        print_r($this->data_array[0]['id']);
    }
    public function setProperties($property ,$name){
        for($i=-1; $i<count($property); $i++) { 
            foreach ($property as $values) {
                $value = key($property);
            } 
            // print_r($value); echo "<br>";
                $property[$i] = $property[$value];
                unset($property[$value]);
        } 
        switch($name){
            case 'PAGE_NAME':
                $property['page_name'] = $property;
                $this->page_name = $property['page_name'];

                break;
            case 'PAGE_POST_ID':
                $property['page_post_id'] = $property;
                 $this->page_post_id = $property['page_post_id'];

                break;
            case 'PAGE_ID':
                $property['page_id'] = $property;
                $this->page_id = $property['page_id'];

                break;
            case 'POST_ID':
                $property['post_id'] = $property;
                $this->post_id = $property['post_id'];
                break;
            case 'AD_ACCOUNT_ID':
                $property['ad_account_id'] = $property;
                $this->ad_account_id = $property['ad_account_id'];
                break;
        }
    }
    public function setAccountsPageData(){
        echo "<pre>";
        // print_r(count($this->data_array));
        for ($i=0; $i <count($this->data_array) ; $i++) { 
        
            foreach ($this->data_array[$i] as $key) {
               if(is_array($key)){
                    foreach ($key as $items){
                        if(is_array($items) and @$items['object_story_id'] == TRUE){
                            list($this->page_id[$i], $this->post_id[$i]) = explode('_', @$items['object_story_id']);
                            $this->page_name[$i] = $this->data_array[$i]['name'];
                            $this->page_post_id[$i] = @$items['object_story_id'];  
                            $this->ad_account_id[$i] = $this->data_array[$i]['id'];
                        }  
                    }
                }    
           }
        
        } 
    }
    public function callFunction(){
        for ($i=0; $i <5 ; $i++) { 
            switch ($i) {
                case '0':
                    $this->setProperties($this->page_name , 'PAGE_NAME');
                    break;
                case '1':
                    $this->setProperties($this->page_post_id , 'PAGE_POST_ID');
                    break;
                case '2':
                    $this->setProperties($this->page_id, 'PAGE_ID');
                    break;
                case '3':
                    $this->setProperties($this->post_id, 'POST_ID');
                    break;
                case '4':
                    $this->setProperties($this->ad_account_id, 'AD_ACCOUNT_ID');
                    break;
                default:
                    echo "An unexpected error has ocurred";
                    break;
            }
                            
        }
    }
    public function setArray(){
        $this->page_data = [
            'page_name' => $this->page_name,
            'page_post_id' => $this->page_post_id,
            'page_id' => $this->page_id,
            'post_id' => $this->post_id,
            'ad_account_id' => $this->ad_account_id,
        ];
        $this->db_page_data = [
            'ad_account_id' => $this->ad_account_id,
            'page_name' => $this->page_name,
        ];
    }

    public function getAccountsPageData(){
        print_r($this->page_data);      
    }
    public function callReporting(){
        error_reporting(0);
        echo "
            <a class='insert-account' href='index.php?pagename=" . $this->page_name ."&accountid=". $this->ad_account_id ."&tablename=". $this->db_table_name ."' id='reporting'>Acccount Reporting</a>
            <script type='text/javascript' src='js/option_reporting.js'></script>";
    }
    public function getCountPageData(){
        return count($this->page_name);
    }
}