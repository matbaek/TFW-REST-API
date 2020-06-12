<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");
  
include_once "config/initialize.php";

$errors = "";

if(is_post_request()) {

    $admin = $_POST["admin"] ?? 0;

    if(is_blank($admin) || $admin == 0) {
        $errors = "Du skal være administrator for at se denne funktion.";
    } 

    if(empty($errors)) {
        $user_set = $db->get_all_users();
        if($user_set != null) {
            $users_array = array();

            while($user = mysqli_fetch_assoc($user_set)) { 
                $user_temp = array(
                    "id" => $user["id"],
                    "username" => $user["username"],
                    "first_name" => $user["first_name"],
                    "last_name" => $user["last_name"],
                    "birthday" => $user["birthday"],
                    "address" => $user["address"],
                    "zip_code" => $user["zip_code"],
                    "city" => $user["city"],
                    "phone_number" => $user["phone_number"],
                    "email" => $user["email"]
                );
                array_push($users_array, $user_temp);
            }

            http_response(200, "Brugere fundet.", $users_array);
        } else {
            http_response(400, "Ingen brugere kunne findes.");
        }
    } else {
        http_response(400, $errors);
    }
} else {
    http_response(404, "No request received.");
}

?>