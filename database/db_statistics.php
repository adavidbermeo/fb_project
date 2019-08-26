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
    }
    public function action($action,$table,$fields = 0,$values = 0){
        /**
         * $crud = 'insert', 'select', 'update' or 'delete'
         */
        switch ($action) {
            case 'insert':
            for ($iterador=0; $iterador <25 ; $i++) { 
                for ($i=0; $i <count($values[$fields]); $i++) { 
                       
                    $this->sql = "INSERT INTO '$table' VALUES (null , ".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].",".$values[$field][$i][$i].")";
                    // Answer
                    $this->result = mysqli_query($this->con, $this->sql) or die('No hubo inserción');
                }
            }
            if ($this->result) {
                echo "Se han insertado correctamente los datos";
            }
                break;

            case 'specificselect':
                echo $table . "<br>";
                echo $fields . "<br>";
                echo $values . "<br>";
                $this->sql = "SELECT * FROM $table WHERE $fields = $values";
                // Answer
                $this->result = mysqli_query($this->con, $this->sql) or die('No hubo consulta especifica');
                if (mysqli_num_rows($this->result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($this->result)) {
                        echo "Query: " . $row[$fields];
                    }
                }else{
                    echo "0 results";
                }
                break;
            case 'generalselect':
                $this->sql = "SELECT * FROM '$table'";
                // Answer
                $this->result = mysqli_query($this->con, $this->sql) or die('No hubo consulta general');
                if (mysqli_num_rows($this->result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($this->result)) {
                        $keys = array_keys($row);
                        foreach ($keys as $key) {
                            echo "Query: " . $row[$key];
                        }
                        
                    }
                }else{
                    echo "0 results";
                }
                break;
            case 'delete':
                $this->sql = "DELETE FROM '$table' WHERE '$fields' = '$values'";
                // Answer
                $this->result = mysqli_query($this->con, $this->sql) or die('No se elimino ningun registro');
                if ($this->result) {
                    echo "Se han eliminado correctamente los datos";
                }
                break;        
            default:
                echo "There is no server answer";
                break;
        }
    } 
}

// $con = mysqli_connect('127.0.0.1','root','','fb_project') or die('Connection Error');
// $sql = "INSERT INTO 'account' VALUES ()";

// $res = mysqli_query($con, $sql) or die('');
?>