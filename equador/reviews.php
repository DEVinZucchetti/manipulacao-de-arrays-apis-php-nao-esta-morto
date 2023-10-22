<?php
require_once "config.php";
require_once "utils.php";
require_once "models/Review.php";


$method = $_SERVER["REQUEST_METHOD"];

$blacklist = ["polimorfismo", "heranca", "abstração", "encapsulamento"];

// 1. pego body
if ($method === "POST") {
    $controller->create();
    
    foreach ($blacklist as $word) {
        if (str_contains(strtolower($name), $word)) {
            $name = str_ireplace($word, "[EDITADO PELO ADMIN] 💔", $name);
        }
    }

       
} else if ($method = "GET") {
    $controller->list();
   

   //pra atualizar status
}else if($method === "PUT"){
    echo "............";
    $body = getBody();
    $id = sanitizeInput($_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS,false);

    $status = sanitizeInput($body, "status", FILTER_SANITIZE_SPECIAL_CHARS);

    if(!$status){
        responseError("Status ausente",400);
    }

    $review =new Review();
    $review->updateStatus($id,$status);

    response(["message" => "Atualizado com sucesso"],200);


}
