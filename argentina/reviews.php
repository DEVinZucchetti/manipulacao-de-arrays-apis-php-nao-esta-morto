<?php
require_once 'config.php';
require_once 'utils.php';
require_once 'models/Review.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = getBody();

    $place_id = sanitizeInput($body, 'place_id', FILTER_VALIDATE_INT);
    $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
    $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);

    $prohibited_words = ['polimorfismo', 'herança', 'abstração', 'encapsulamento'];

    if (!$place_id) responseError(400, 'Id do lugar ausente');
    if (!$name) responseError(400, 'Descrição da avaliação ausente');
    if (!$email) responseError(400, 'Email ausente');
    if (!$stars) responseError(400, 'Quantidade de estrelas ausente');
    if (!$status) responseError(400, 'Status de avaliação ausente');

    if (strlen($name) > 200) responseError(400, 'O texto ultrapassou o limite');

    foreach ($prohibited_words as $word) {
        if (str_contains(strtolower($name), $word)) {
            $name = str_ireplace($word, '[EDITADO PELO ADMIN]', $name);
        }
    }


    // maneira de salvar um arquivo 
    $review = new Review($place_id);
    $review->setName($name);
    $review->setEmail($email);
    $review->setStars($stars);
    $review->setStatus($status);
    $review->save();

    response(201, ['message' => 'Cadastrado com sucesso!']);
} else if ($method === 'GET') {

    $place_id = filter_var($_GET, 'id', FILTER_VALIDATE_INT);

    if (!$place_id) responseError(400, 'ID do lugar esta ausente'); 
}
