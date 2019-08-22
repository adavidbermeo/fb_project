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
    public function action($crud){
        /**
         * $crud = 'insert', 'select', 'update' or 'delete'
         */
        switch ($crud) {
            case 'insert':
                $this->sql = "INSERT INTO table() VALUES (),()";
                // Answer
                $this->result = mysqli_query($this->con, $this->sql) or die('');
                break;
            case 'select':
                $this->sql = "SELECT * FROM 'table' WHERE 'id' = '$id'";
                // Answer
                $this->result = mysqli_query($this->con, $this->sql) or die('');
                break;
            case 'update':
                $this->sql = "";
                // Answer
                $this->result = mysqli_query($this->con, $this->sql) or die('');
                break;
            case 'delete':
                $this->sql = "";
                // Answer
                $this->result = mysqli_query($this->con, $this->sql) or die('');
                break;        
            default:
                echo "There is no server answer";
                break;
        }
    } 
}

$con = mysqli_connect('127.0.0.1','root','','fb_project') or die('Connection Error');
$sql = "INSERT INTO 'account' VALUES ()";

$res = mysqli_query($con, $sql) or die('');
?>