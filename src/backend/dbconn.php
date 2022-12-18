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
        // A local key is necessary for this file to work
        // This is a file in the root folder which is not included in the git repository
        try {
            if(!file_exists("../local_key.php")) {
                echo('Local key not found! Connection terminated.');
                exit();
            }
            include_once("../local_key.php");
            $localkey = new Localkey();
            $this->DB_HOST = $localkey->get_db_host();
            $this->DB_USER = $localkey->get_db_user();
            $this->DB_PASS = $localkey->get_db_pass();
            $this->DB_NAME = $localkey->get_db_name();
        } catch (Exception $e) {
            echo('Local key not found! Connection terminated.');
            exit();
        }
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