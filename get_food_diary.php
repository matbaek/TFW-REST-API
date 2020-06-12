<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");
  
include_once "config/initialize.php";

$errors = "";

if(is_post_request()) {

    $user_id = $_POST["user_id"] ?? 0;

    if(is_blank($user_id)) {
        $errors = "Bruger ID kan ikke være blankt.";
    } 

    if(empty($errors)) {
        $food_diaries_set = $db->get_food_diary($user_id);
        if($food_diaries_set != null) {
            $food_diaries_array = array();

            while($food_diary = mysqli_fetch_assoc($food_diaries_set)) { 
                $food_diary_item = array(
                    "id" => $food_diary["id"],
                    "user_id" => $food_diary["user_id"],
                    "date" => $food_diary["date"],
                    "breakfast" => $food_diary["breakfast"],
                    "breakfast_time" => $food_diary["breakfast_time"],
                    "snack_1" => $food_diary["snack_1"],
                    "lunch" => $food_diary["lunch"],
                    "lunch_time" => $food_diary["lunch_time"],
                    "snack_2" => $food_diary["snack_2"],
                    "dinner" => $food_diary["dinner"],
                    "dinner_time" => $food_diary["dinner_time"],
                    "snack_3" => $food_diary["snack_3"],
                    "sleep" => $food_diary["sleep"],
                    "water" => $food_diary["water"],
                    "fruit_veggie" => $food_diary["fruit_veggie"],
                    "alcohol" => $food_diary["alcohol"]
                );
                array_push($food_diaries_array, $food_diary_item);
            }

            http_response(200, "Madplan(er) fundet.", $food_diaries_array);
        } else {
            http_response(400, "Ingen madplan kunne findes.");
        }
    } else {
        http_response(400, $errors);
    }
} else {
    http_response(404, "No request received.");
}

?>