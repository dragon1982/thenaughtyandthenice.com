<?php
class Service{
    private $conn;
    
    public function __construct() {
        //connection settings....do not store this in the www folder
        include_once("http://thenaughtyandthenice.east-wolf.com/assets/swf/database.php");
        $this->conn = $db;
    }

    public function publish($u,$p) {
        $userlist = Number($u);
        $performer = Number($p);
        
        //This assumes you have an auto-incrementing ID
        $query = "INSERT INTO table ";
        $query .= "(userNum,performerNum) ";
        $query .= "VALUES ('{$userlist}','{$performer}')";
        mysqli_query($this->conn,$query) or die(mysqli_error($this->conn));
    }
}
?>