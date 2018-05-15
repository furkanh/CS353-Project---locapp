<?php
  class Database{
    private $DB_URL = "dijkstra.cs.bilkent.edu.tr";
    private $USER = "furkan.huseyin";
    private $PASS = "8r7zh7j";
    private $DB_NAME = "furkan_huseyin";
    /*private $DB_URL = "localhost";
    private $USER = "root";
    private $PASS = "frknhsyn8";
    private $DB_NAME = "furkan_huseyin";*/
    private $connection;

    function __construct(){
      $this->connection = new mysqli($this->DB_URL, $this->USER, $this->PASS, $this->DB_NAME);
      if ($this->connection->connect_errno) {
        //loginfail 3 is connection error
        header("Location:login.php?loginfail=3");
        exit();
      }
    }

    function __destruct() {
      mysqli_close($this->connection);
    }

    public function getConnection(){
      return $this->connection;
    }
  }
 ?>
