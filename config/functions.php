<?php 

function is_post_request() {
    return $_SERVER["REQUEST_METHOD"] === "POST";
}

function is_get_request() {
    return $_SERVER["REQUEST_METHOD"] === "GET";
}

function http_response($code, $message, $item = array()) {
    $response["message"] = $message;  
    if($item) {
        $response["item"] = $item;
    }

    http_response_code($code);
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}


// VALIDATION FUNCTIONs
function is_blank($value) {
    return !isset($value) || trim($value) === "";
}

?>