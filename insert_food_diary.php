<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");
  
include_once "config/initialize.php";

$errors = "";

if(is_post_request()) {

    $food_diary = [];
    $food_diary["user_id"] = $_POST["user_id"] ?? 0;
    if(isset($_POST["date"])) { $food_diary["date"] = date($_POST["date"]);  } //date("Y-M-D")
    else { $food_diary["date"] = ""; }
    $food_diary["breakfast"] = $_POST["breakfast"] ?? "";
    $food_diary["breakfast_time"] = $_POST["breakfast_time"] ?? 0;
    $food_diary["snack_1"] = $_POST["snack_1"] ?? "";
    $food_diary["lunch"] = $_POST["lunch"] ?? "";
    $food_diary["lunch_time"] = $_POST["lunch_time"] ?? 0;
    $food_diary["snack_2"] = $_POST["snack_2"] ?? "";
    $food_diary["dinner"] = $_POST["dinner"] ?? "";
    $food_diary["dinner_time"] = $_POST["dinner_time"] ?? 0;
    $food_diary["snack_3"] = $_POST["snack_3"] ?? "";
    $food_diary["sleep"] = $_POST["sleep"] ?? 0;
    $food_diary["water"] = $_POST["water"] ?? 0;
    $food_diary["fruit_veggie"] = $_POST["fruit_veggie"] ?? 0;
    $food_diary["alcohol"] = $_POST["alcohol"] ?? 0;

    if(is_blank($food_diary["user_id"])) {
        $errors = "Bruger ID kan ikke være blankt.";
    } else if(is_blank($food_diary["date"])) {
        $errors = "Dato kan ikke være blankt.";
    } else if(is_blank($food_diary["breakfast"])) {
        $errors = "Morgenmad kan ikke være blankt.";
    } else if(is_blank($food_diary["breakfast_time"])) {
        $errors = "Tidspunkt for morgenmad kan ikke være blankt.";
    } else if(is_blank($food_diary["snack_1"])) {
        $errors = "Første snack kan ikke være blankt.";
    } else if(is_blank($food_diary["lunch"])) {
        $errors = "Frokost kan ikke være blankt.";
    } else if(is_blank($food_diary["lunch_time"])) {
        $errors = "Tidspunkt for frokost kan ikke være blankt.";
    } else if(is_blank($food_diary["snack_2"])) {
        $errors = "Anden snack kan ikke være blankt.";
    } else if(is_blank($food_diary["dinner"])) {
        $errors = "Aftensmad kan ikke være blankt.";
    } else if(is_blank($food_diary["dinner_time"])) {
        $errors = "Tidspunkt for aftensmad kan ikke være blankt.";
    } else if(is_blank($food_diary["snack_3"])) {
        $errors = "Tredje snack kan ikke være blankt.";
    } else if(is_blank($food_diary["sleep"])) {
        $errors = "Søvn kan ikke være blankt.";
    } else if(is_blank($food_diary["water"])) {
        $errors = "Vand kan ikke være blankt.";
    } else if(is_blank($food_diary["fruit_veggie"])) {
        $errors = "Frugt og grønt kan ikke være blankt.";
    } else if(is_blank($food_diary["alcohol"])) {
        $errors = "Alcohol kan ikke være blankt.";
    }

    if(empty($errors)) {
        $result_food_diary = $db->insert_food_diary($food_diary);
        if($result_food_diary) {
            http_response(201, "Madplan oprettet.", $user);
        } else {
            http_response(400, "Madplan kunne ikke oprettes.");
        }
    } else {
        http_response(400, $errors);
    }
} else {
    http_response(404, "No request received.");
}

?>