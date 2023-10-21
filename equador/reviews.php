<?php
require_once "config.php";
require_once "utils.php";
require_once "models/Review.php";

$method = $_SERVER["REQUEST_METHOD"];

$blacklist = ["polimorfismo", "heranca", "abstração", "encapsulamento"];

// 1. pego body
if ($method === "POST") {
    $body = getBody();

    // 2. pego os dados 
    $place_id = sanitizeInput($body, "place_id", FILTER_SANITIZE_SPECIAL_CHARS);
    $name = sanitizeInput($body, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = sanitizeInput($body, "email", FILTER_VALIDATE_EMAIL);
    $stars = sanitizeInput($body, "stars", FILTER_VALIDATE_FLOAT);


    // 3. valido os dados
    if (!$place_id) responseError("Id do lugar ausente", 400);
    if (!$name) responseError("Descripcao da avaliacao ausente", 400);
    if (!$email) responseError("Email inválido", 400);
    if (!$stars) responseError("Quantidade de estrelas ausente", 400);
    //validar name max:200 caracteres
    if (strlen($name) > 200) responseError("O texto ultrapassou o limite", 400);


    foreach ($blacklist as $word) {
        if (str_contains(strtolower($name), $word)) {
            $name = str_ireplace($word, "[EDITADO PELO ADMIN] 💔", $name);
        }
    }

    $review = new Review($place_id);
    $review->setName($name);
    $review->setEmail($email);
    $review->setStars($stars);
    $review->save();

    response(["message" => "Cadastrado com sucesso"], 201);
} else if ($method = "GET") {
    var_dump($_GET);
    $place_id = sanitizeInput($_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS, false);

    if (!$place_id) responseError("ID do lugar está ausente", 400);

   $reviews = new Review($place_id);   
   response($reviews->list(), 200);
}
