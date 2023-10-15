<?php 
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = getBody();

    $place_id = sanitizeInput($body, 'place_id', FILTER_VALIDATE_INT);
    $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
    $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);
    $date = (new DateTime())->format('d/m/Y h:m');
    $status = sanitizeInput($body, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

    $prohibited_words = ['polimorfismo', 'herança', 'abstração', 'encapsulamento'];

    if(!$place_id) responseError(400,'Id do lugar ausente');
    if(!$name) responseError(400,'Descrição da avaliação ausente');
    if(!$email) responseError(400,'Email ausente');
    if(!$stars) responseError(400,'Quantidade de estrelas ausente');
    if(!$status) responseError(400,'Status de avaliação ausente');

    if(strlen($name) > 200) responseError(400, 'O texto ultrapassou o limite');

    foreach($prohibited_words as $word) {
        if(str_contains($name, $word)) {
            str_replace($word, '[EDITADO PELO ADMIN]', $name);
        }
    }
}

?>