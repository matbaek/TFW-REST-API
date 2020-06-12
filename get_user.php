<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");
  
include_once "config/initialize.php";

$errors = "";

if(is_post_request()) {

    $username = $_POST["username"] ?? "";

    if(is_blank($username)) {
        $errors = "Brugernavn kan ikke være blankt.";
    } 

    if(empty($errors)) {
        $user = $db->find_user_by_username($username);
        if($user) {
            unset($user["password"]);

            http_response(200, "Bruger fundet.", $user);
        } else {
            http_response(400, "Brugeren findes ikke.");
        }
    } else {
        http_response(400, $errors);
    }
} else {
    http_response(404, "No request received.");
}

?>