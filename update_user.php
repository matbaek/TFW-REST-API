<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");
  
include_once "config/initialize.php";

$errors = "";

if(is_post_request()) {

    $user = [];
    $user["username"] = $_POST["username"] ?? "";
    $user["first_name"] = $_POST["first_name"] ?? "";
    $user["last_name"] = $_POST["last_name"] ?? "";
    $user["birthday"] = date($_POST["birthday"]) ?? "";
    $user["address"] = $_POST["address"] ?? "";
    $user["zip_code"] = $_POST["zip_code"] ?? "";
    $user["city"] = $_POST["city"] ?? "";
    $user["phone_number"] = $_POST["phone_number"] ?? "";
    $user["email"] = $_POST["email"] ?? "";

    if(is_blank($user["first_name"])) {
        $errors = "Fornavn kan ikke være blankt.";
    } else if(is_blank($user["last_name"])) {
        $errors = "Efternavn kan ikke være blankt.";
    } else if(is_blank($user["birthday"])) {
        $errors = "Fødselsdag kan ikke være blankt.";
    } else if(is_blank($user["address"])) {
        $errors = "Adresse kan ikke være blankt.";
    } else if(is_blank($user["zip_code"])) {
        $errors = "Post nummer kan ikke være blankt.";
    } else if(is_blank($user["city"])) {
        $errors = "By kan ikke være blankt.";
    } else if(is_blank($user["phone_number"])) {
        $errors = "Telefon nummer kan ikke være blankt.";
    } else if(is_blank($user["email"])) {
        $errors = "Email kan ikke være blankt.";
    }

    if(empty($errors)) {
        $update_user = $db->update_user($user);
        if($update_user) {
            http_response(201, "Brugeren blev opdateret.", $user);
        } else {
            http_response(400, "Brugeren findes ikke opdateres.");
        }
    } else {
        http_response(400, $errors);
    }
} else {
    http_response(404, "No request received.");
}

?>