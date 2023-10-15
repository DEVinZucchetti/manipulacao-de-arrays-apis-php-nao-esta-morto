<?php
require_once "config.php";
require_once "utils.php";

$method = $_SERVER["REQUEST_METHOD"];

// 1. pego body
if ($method === "POST") {
    $body = getBody();

    // 2. pego os dados 
    $place_id = sanitizeInput($body, "place_id", FILTER_VALIDATE_INT);
    $name = sanitizeInput($body, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = sanitizeInput($body, "email", FILTER_VALIDATE_EMAIL);
    $stars = sanitizeInput($body, "stars", FILTER_VALIDATE_FLOAT);
    $date = (new DateTime())-> format("d/m/Y h:m" );
    $status = sanitizeInput($body, "status", FILTER_SANITIZE_SPECIAL_CHARS);   
   

    if (!$place_id) responseError("Id do lugar ausente", 400); 
    if (!$name) responseError("Descripcao da avaliacao ausente", 400); 
    if (!$email) responseError("Email inválido", 400); 
    if (!$stars) responseError("Quantidade de estrelas ausente", 400); 
    if (!$status) responseError("Quantidade da valiacao ausente", 400); 
    
}

?>
