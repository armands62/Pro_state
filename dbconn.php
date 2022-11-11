<?php
class dbconn
{
    private $conn;
    private $DB_HOST = "localhost";
    private $DB_USER = "root";
    private $DB_PASS = "";
    private $DB_NAME = "pro_state";


    function __construct()
    {
        $this->connect();
    }

    private function connect() {
        $this->conn = mysqli_connect($this->DB_HOST, $this->DB_USER, $this->DB_PASS, $this->DB_NAME);
        if(mysqli_connect_errno()) {
            exit("Failed to connect to the database: " . mysqli_connect_error());
        }
    }

    function __destruct()
    {
        $this->conn->close();
    }

    function db() {
        if(!isset($this->conn)) {
            $this->connect();
        }
        return $this->conn;
    }
}


/* USAGE:
 * To connect a .php document to database, create an instance of the class 'dbconn'.
 * The constructor will automatically try to connect to the database.
 * If an additional database connection is needed, call the 'db()' function.
 */