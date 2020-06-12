<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");
  
include_once "config/initialize.php";

$errors = [];
$temp_user = [];

if(is_post_request()) {

    $temp_user["username"] = $_POST["username"] ?? "";
    $temp_user["first_name"] = $_POST["first_name"] ?? "";
    $temp_user["last_name"] = $_POST["last_name"] ?? "";
    $temp_user["birthday"] = $_POST["birthday"] ?? "";
    $temp_user["address"] = $_POST["address"] ?? "";
    $temp_user["zip_code"] = $_POST["zip_code"] ?? "";
    $temp_user["city"] = $_POST["city"] ?? "";
    $temp_user["phone_number"] = $_POST["phone_number"] ?? "";
    $temp_user["email"] = $_POST["email"] ?? "";

    if(is_blank($temp_user["username"])) {
        $errors = "Brugernavn kan ikke være blankt.";
    } else if(is_blank($temp_user["first_name"])) {
        $errors = "Fornavn kan ikke være blankt.";
    } else if(is_blank($temp_user["last_name"])) {
        $errors = "Efternavn kan ikke være blankt.";
    } else if(is_blank($temp_user["birthday"])) {
        $errors = "Fødselsdag kan ikke være blankt.";
    } else if(is_blank($temp_user["address"])) {
        $errors = "Adresse kan ikke være blankt.";
    } else if(is_blank($temp_user["zip_code"])) {
        $errors = "Post nummer kan ikke være blankt.";
    } else if(is_blank($temp_user["city"])) {
        $errors = "By kan ikke være blankt.";
    } else if(is_blank($temp_user["phone_number"])) {
        $errors = "Telefon nummer kan ikke være blankt.";
    } else if(is_blank($temp_user["email"])) {
        $errors = "Email kan ikke være blankt.";
    }

    if(empty($errors)) {
        $user = $db->register_user($temp_user);
        if($user) {
            http_response(200, "Brugeren er blevet oprettet.");
        } else {
            http_response(400, "Brugeren kunne ikke oprettes.");
        }
    } else {
        http_response(400, $errors);
    }
} else {
    http_response(404, "No request received.");
}

?>