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
    // User
    public function find_user_by_username($username) {
        $sql = "SELECT * FROM users ";
        $sql .= "WHERE username='". $this->db_escape($username) ."' LIMIT 1";
        $result = $this->connection->query($sql);
        $this->confirm_result_set($result);
    
        $user = $result->fetch_assoc();
        $result->free_result();
        $this->connection->close();

        return $user;
    }

    public function get_all_users() {
        $sql = "SELECT * FROM users ";
        $sql .= "ORDER BY username";
        $result = $this->connection->query($sql);
        $this->confirm_result_set($result);

        if($result->num_rows == 0) {
            return null;
        }

        return $result;
    }

    function register_user($user) {
        $sql = "INSERT INTO users (";
        $sql .= "username, password, first_name, last_name, birthday, address, zip_code, city, phone_number, email";
        $sql .= ") VALUES (";
        $sql .= "'". $this->db_escape($user["username"]) ."', ";
        $sql .= "'". $this->db_escape(password_hash("1234", PASSWORD_DEFAULT)) ."', ";
        $sql .= "'". $this->db_escape($user["first_name"]) ."', ";
        $sql .= "'". $this->db_escape($user["last_name"]) ."', ";
        $sql .= "'". $this->db_escape($user["birthday"]) ."', ";
        $sql .= "'". $this->db_escape($user["address"]) ."', ";
        $sql .= "'". $this->db_escape($user["zip_code"]) ."', ";
        $sql .= "'". $this->db_escape($user["city"]) ."', ";
        $sql .= "'". $this->db_escape($user["phone_number"]) ."', ";
        $sql .= "'". $this->db_escape($user["email"]) ."'";
        $sql .= ")";
    
        $result = $this->connection->query($sql);

        if($result) {
            return true;
        } else {
            echo $this->connection->error;
            $this->db_disconnect();
            exit;
        }
    }

    function update_user($user) {
        $sql = "UPDATE users SET ";
        $sql .= "first_name='". $this->db_escape($user["first_name"]) ."', ";
        $sql .= "last_name='". $this->db_escape($user["last_name"]) ."', ";
        $sql .= "birthday='". $this->db_escape($user["birthday"]) ."', ";
        $sql .= "address='". $this->db_escape($user["address"]) ."', ";
        $sql .= "zip_code='". $this->db_escape($user["zip_code"]) ."', ";
        $sql .= "city='". $this->db_escape($user["city"]) ."', ";
        $sql .= "phone_number='". $this->db_escape($user["phone_number"]) ."', ";
        $sql .= "email='". $this->db_escape($user["email"]) ."' ";
        $sql .= "WHERE username='". $this->db_escape($user["username"]) ."'";
    
        $result = $this->connection->query($sql);

        if($result) {
            return true;
        } else {
            echo $this->connection->error;
            $this->db_disconnect();
            exit;
        }
    }

    // Food Diary
    public function get_food_diary($user_id) {
        $sql = "SELECT * FROM food_diary ";
        $sql .= "WHERE user_id='". $this->db_escape($user_id) ."'";
        $result = $this->connection->query($sql);
        $this->confirm_result_set($result);

        if($result->num_rows == 0) {
            return null;
        }

        return $result;
    }

    public function insert_food_diary($food_diary = []) {
        $sql = "INSERT INTO food_diary (";
        $sql .= "user_id, date, breakfast, breakfast_time, snack_1, lunch, lunch_time, snack_2, "; 
        $sql .= "dinner, dinner_time, snack_3, sleep, water, fruit_veggie, alcohol";
        $sql .= ") VALUES (";
        $sql .= "'". $this->db_escape($food_diary["user_id"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["date"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["breakfast"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["breakfast_time"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["snack_1"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["lunch"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["lunch_time"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["snack_2"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["dinner"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["dinner_time"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["snack_3"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["sleep"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["water"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["fruit_veggie"]) ."', ";
        $sql .= "'". $this->db_escape($food_diary["alcohol"]) ."'";
        $sql .= ")";
        $result = $this->connection->query($sql);

        if($result) {
            return true;
        } else {
            echo $this->connection->error;
            $this->db_disconnect();
            exit;
        }
    }

    // Pull ups & Knee graps
    function update_pull_ups_and_knee_graps($username, $pull_ups, $knee_graps) {
        $sql = "UPDATE users SET ";
        $sql .= "pull_ups='". $this->db_escape($pull_ups) ."', ";
        $sql .= "knee_graps='". $this->db_escape($knee_graps) ."' ";
        $sql .= "WHERE username='". $this->db_escape($username) ."'";
    
        $result = $this->connection->query($sql);

        if($result) {
            return true;
        } else {
            echo $this->connection->error;
            $this->db_disconnect();
            exit;
        }
    }
}

?>