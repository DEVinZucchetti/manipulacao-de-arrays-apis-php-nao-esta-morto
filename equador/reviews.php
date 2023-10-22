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
    $controller->update();  


}
