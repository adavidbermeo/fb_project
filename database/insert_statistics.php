<?php
class Database{
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
        $this->con = mysqli_connect($this->host,$this->username,$this->password, $this->database);
    }
    public function 
}

$con = mysqli_connect('127.0.0.1','root','','fb_project') or die('Connection Error');
$sql = "INSERT INTO 'account' VALUES ()";

$res = mysqli_query($con, $sql) or die('');
?>