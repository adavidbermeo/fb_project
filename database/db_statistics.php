<?php
namespace Database;
class DbStatistics{
    //Attributes 
    protected $host;
    protected $username;
    protected $password;
    protected $database;

    protected $con;
    protected $sql;
    protected $result;


    //Methods
    public function __construct($host,$username,$password,$database){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }
    public function connectDatabase(){
        $this->con = mysqli_connect($this->host,$this->username,$this->password, $this->database) or die('Error Connection Database');
        $this->con->set_charset('utf8');
        // echo "Se ha conectado correctamente";
    }
    public function insertData($table, $array){
        // $field = array_keys($array);
        switch ($table) {
            case 'ad':
                for ($i=0; $i <count($array['ad_ids']) ; $i++) { 
                    // Answer
                    error_reporting(0);
                    $this->sql = "INSERT INTO $table VALUES (null ,'". $array['ad_ids'][$i] ."','". $array['ad_name'][$i] ."','". $array['ad_effective_status'][$i] ."','". $array['post_page_id'][$i] ."','". $array['post_ids'][$i] ."','". $array['interactions'][$i] ."','". $array['ad_account_id'] ."','". $array['likes'][$i] ."','". $array['love'][$i] ."','". $array['wow'][$i] ."','". $array['haha'][$i] ."','". $array['sorry'][$i] ."','". $array['anger'][$i] ."','". $array['total_reactions'][$i] ."','". $array['impressions_paid'][$i] ."','". $array['impressions_organic'][$i] ."','". $array['total_impressions'][$i] ."','". $array['post_clicks'][$i] ."')";   
                    $this->result = mysqli_query($this->con, $this->sql) or die('No hubo inserción');
                }
                if(mysqli_affected_rows($this->con)>0){
                    echo "Sus datos fueron insertados correctamente";
                }else{
                    echo "Hubo un error en la insercion. Intentelo de nuevo";
                }
                break;
            case 'campaign':
                for ($i=0; $i <count($array['campaign_id']) ; $i++) { 
                    // Answer
                    error_reporting(0);
                    $this->sql = "INSERT INTO $table VALUES ('". $array['campaign_id'][$i] ."','". $array['campaign_name'][$i] ."','". $array['c_status'][$i] ."','". $array['clicks'][$i] ."','". $array['impressions'][$i] ."','". $array['spend'][$i] ."','". $array['reach'][$i] ."','". $array['objective'][$i] ."','". $array['cost_per_lead'][$i] ."','". $array['action_type'][$i]."  => ".$array['action_value'][$i]."','". $array['id_adAccount'] ."')";   
                    $this->result = mysqli_query($this->con, $this->sql) or die('No hubo inserción');
                }
                if(mysqli_affected_rows($this->con)>0){
                    echo "Sus datos fueron insertados correctamente";
                }else{
                    echo "Hubo un error en la insercion. Intentelo de nuevo";
                }
                break;
            case 'page':
                // Answer
                error_reporting(0);
                $this->sql = "INSERT INTO $table VALUES ('". $array['id_page'] ."','". $array['end_time'] ."','". $array['total_new_likes'] ."','". $array['people_paid_like'] ."','". $array['people_unpaid_like'] ."','". $array['ad_account_id'] ."','". $array['page_post_engagement'] ."')";   
                $this->result = mysqli_query($this->con, $this->sql) or die('No hubo inserción');

                if(mysqli_affected_rows($this->con)>0){
                    echo "Sus datos fueron insertados correctamente";
                }else{
                    echo "Hubo un error en la insercion. Intentelo de nuevo";
                }
                break;
             case 'account':
                // Answer
                for ($i=0; $i <count($array['ad_acount_id']) ; $i++) { 
                    // Answer
                    // error_reporting(0);
                    $this->sql = "INSERT INTO $table VALUES ('". $array['ad_account_id'][$i] ."','". $array['page_name'][$i] ."')";   
                    $this->result = mysqli_query($this->con, $this->sql) or die('No hubo inserción');
                }
                if(mysqli_affected_rows($this->con)>0){
                    echo "Sus datos fueron insertados correctamente";
                }else{
                "Hubo un error en la insercion. Intentelo de nuevo";
                }
                break;
            default:
                echo "Check the argument values and try again";
                break;
        }
    }
    public function specificSelectData($table, $array, $field, $value){
        $keys = array_keys($array);
        $this->sql = "SELECT * FROM $table WHERE $field = $value";
        // Answer
        $this->result = mysqli_query($this->con, $this->sql) or die('No hubo consulta especifica');
        if (mysqli_num_rows($this->result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($this->result)) {
                foreach ($keys as $key) {
                    if($row[$key]){
                        echo $key .": ". $row[$key] . "<br>";
                    }
                }
            }
        }else{
            echo "0 results";
        }
    }
    public function generalSelectData($table, $value){
        $this->sql = "SELECT * FROM $table WHERE 'ad_account_id' = $value";
        // Answer
        $this->result = mysqli_query($this->con, $this->sql) or die('No hubo consulta general');
        if (mysqli_num_rows($this->result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($this->result)) {
                $keys = array_keys($row);
                foreach ($keys as $key) {
                    if($row[$key]){
                        echo $key .": ". $row[$key] . "<br>";
                    }
                }
            }
        }else{
            echo "0 results";
        }
    }
    public function deleteData($table, $value){
        $this->sql = "DELETE FROM '$table' WHERE '$fields' = '$values'";
        // Answer
        $this->result = mysqli_query($this->con, $this->sql) or die('No se elimino ningun registro');
        if ($this->result) {
            echo "Se han eliminado correctamente los datos";
        }      
    }
}

// $con = mysqli_connect('127.0.0.1','root','','fb_project') or die('Connection Error');
// $sql = "INSERT INTO 'account' VALUES ()";

// $res = mysqli_query($con, $sql) or die('');
?>