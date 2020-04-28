<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");
  
include_once "config/initialize.php";

$errors = [];

if(is_post_request()) {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if(is_blank($username) && is_blank($password)) {
        $errors[] = "Brugernavn og kodeord kan ikke være blankt.";
    } else if(is_blank($username)) {
        $errors[] = "Brugernavn kan ikke være blankt.";
    }if(is_blank($password)) {
        $errors[] = "Kodeord kan ikke være blankt.";
    }

    if(empty($errors)) {
        $user = $db->find_user_by_username($username);
        if($user && password_verify($password, $user["password"])) {
            unset($user["password"]);

            http_response(200, "Logget ind.", $user);
        } else {
            http_response(400, "Brugernavn eller kodeord var forkert.");
        }
    } else {
        http_response(400, $errors[0]);
    }
} else {
    http_response(404, "No request received.");
}

?>