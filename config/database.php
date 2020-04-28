<?php

class Database {
    private $connection;

    public function __construct($server, $username, $password, $database) {
        $this->connection = new mysqli($server, $username, $password, $database);
        if($this->connection->connect_errno) {
            die("Database connection failed: ". mysqli_connect_error() ." (". mysqli_connect_errno(). ")");
        }
        $this->connection->set_charset("utf8");
    }

    public function db_disconnect() {
        if(isset($this->connection)) {
            mysqli_close($this->connection);
        }
    }

    public function db_escape($string) {
        return mysqli_real_escape_string($this->connection, $string);
    }

    public function confirm_result_set($result_set) {
        if(!$result_set) {
            exit("Database query failed.");
        }
    }

    // QUERY FUNCTIONS
    public function find_user_by_username($username) {
        $sql = "SELECT * FROM user ";
        $sql .= "WHERE username='". $this->db_escape($username) ."' LIMIT 1";
        $result = $this->connection->query($sql);
        $this->confirm_result_set($result);
    
        $user = $result->fetch_assoc();
        $result->free_result();
        $this->connection->close();

        return $user;
    }
}

?>