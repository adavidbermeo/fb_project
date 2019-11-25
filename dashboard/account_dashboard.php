<?php 
// echo "Angel";
    if(isset($_POST['selected'])){
        $selected = $_POST['selected'];
        list($url, $click) = explode('=', $selected);
        list($click_value,$data) = explode('*', $click);
        list($id_page, $ad_account_id) = explode('%', $data); 

        getData($ad_account_id);
    }

    class Database{
        // Connection Attributes
        protected $db_host;
        protected $username;
        protected $password;
        protected $database_name;

        protected $con;
        protected $request;
        protected $result;
        protected $ad_account_id;
        protected $data_graphics;
        protected $campaign_graphic;
        protected $ad_graphic;
        protected $graphic_array;
        

        public function __construct($ad_account_id){
            $this->db_host = 'localhost';
            $this->username = 'root';
            $this->password = '';
            $this->database_name = 'fb_project';

            $this->ad_account_id = $ad_account_id;
        }
        public function connectDb(){
            $this->con = mysqli_connect($this->db_host, $this->username, $this->password, $this->database_name) or die('Connection has failed');
        }
        public function requestData(){
            // First Request

            $this->request = "SELECT `total_new_likes` FROM `page` WHERE `ad_account_id` = '$this->ad_account_id'";
            $this->result = mysqli_query($this->con, $this->request) or die('There was an error');
            
            if (mysqli_num_rows($this->result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($this->result)){
                    $keys = array_keys($row);
                    foreach ($keys as $key) {
                        echo '<div id="dash_section"><b>' . $key . '</b><br>' . $row[$key]. '</div>'; 
                    }
                }
            }
            // Second Request 

            $this->request = "SELECT `interactions` FROM `ad` WHERE `ad_account_id` = '$this->ad_account_id'";
            $this->result = mysqli_query($this->con, $this->request) or die('There was an error');

            if(mysqli_num_rows($this->result) > 0 ){
                while($row = mysqli_fetch_assoc($this->result)){
                    $keys = array_keys($row);
                    foreach ($keys as $key) {
                        $interactions_array[] = $row[$key];
                        $field = $key; 
                    }
                }
                 echo '<div id="dash_section"><b>' . $field . '</b><br>' . array_sum($interactions_array). '</div>';
            }
            // Third Request 

            $this->request = "SELECT `cost_per_lead`,`spend` FROM `campaign` WHERE `ad_account_id` = '$this->ad_account_id'";
            $this->result = mysqli_query($this->con, $this->request) or die('There was an error');

            if(mysqli_num_rows($this->result) > 0 ){
                while($row = mysqli_fetch_assoc($this->result)){
                    // print_r($row);
                    $cost_per_lead[] = $row['cost_per_lead'];
                    $spend[] = $row['spend'];
                    $keys = array_keys($row);
                }
                $total_cpl = array_sum($cost_per_lead);
                 echo '<div id="dash_section"><b>' . $keys[0] . '</b><br>' . $total_cpl / count($cost_per_lead) . '</div>';
                 echo '<div id="dash_section"><b>' . $keys[1] . '</b><br>' . array_sum($spend). '</div>';
            }
        }
        public function requestGraphics(){
            $this->request = "SELECT `campaign_id`,`campaign_name`,`clicks` FROM `campaign` WHERE `ad_account_id` ='$this->ad_account_id' ORDER BY `clicks` DESC";
            $this->result = mysqli_query($this->con,$this->request) or die('There was an error');
           
            $this->campaign_graphic = mysqli_fetch_all($this->result ,MYSQLI_ASSOC);
            // print_r($this->campaign_graphic);
            //  if(mysqli_num_rows($this->result) > 0 ){

            //     while($data = mysqli_fetch_array($this->result, MYSQLI_ASSOC)){
            //         $this->campaign_graphic[] = $data;
            //     }
            //     //print_r($this->campaign_graphic);
            //  }
             
            $this->request = "SELECT `ad_ids`,`ad_name`,`total_reactions` FROM `ad` WHERE `ad_account_id` ='$this->ad_account_id' ORDER BY `total_reactions` DESC";
            $this->result = mysqli_query($this->con,$this->request) or die('There was an error');

            $this->ad_graphic = mysqli_fetch_all($this->result, MYSQLI_ASSOC);
            // print_r($data); die('jajaja');
            // if(mysqli_num_rows($this->result) > 0 ){

            //     while($data = mysqli_fetch_array($this->result, MYSQLI_ASSOC)){
            //        $this->ad_graphic[] = $data;
            //     }
            //      //print_r($this->ad_graphic);
            //  }
            $this->graphic_array = [$this->ad_graphic, $this->campaign_graphic];
            // print_r($this->graphic_array);
            echo json_encode($this->graphic_array);
            // echo '<div id="chart-container"></div>';
        }
    }
     function getData($ad_account_id){
        $db = new Database($ad_account_id);
        $db->connectDb();
        $db->requestData();
        $db->requestGraphics();
    }
