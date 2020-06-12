<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");
  
include_once "config/initialize.php";

$errors = "";

if(is_post_request()) {

    $username = $_POST["username"] ?? "";
    $pull_ups = $_POST["pull_ups"] ?? "";
    $knee_graps = $_POST["knee_graps"] ?? "";

    if(is_blank($username)) {
        $errors = "Brguernavn kan ikke være blankt.";
    } else if(is_blank($pull_ups)) {
        $errors = "Pull Ups kan ikke være blankt.";
    } else if(is_blank($knee_graps)) {
        $errors = "Knee Graps kan ikke være blankt.";
    } 

    if(empty($errors)) {
        $update_records = $db->update_pull_ups_and_knee_graps($username, $pull_ups, $knee_graps);
        if($update_records) {
            http_response(201, "Dine rekorder blev opdateret.");
        } else {
            http_response(400, "Dine rekorder kunne ikke opdateres.");
        }
    } else {
        http_response(400, $errors);
    }
} else {
    http_response(404, "No request received.");
}

?>