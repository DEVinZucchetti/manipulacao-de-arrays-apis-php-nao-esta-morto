<?php
require_once 'config.php';
require_once 'utils.php';
require_once 'models/Review.php';

$method = $_SERVER['REQUEST_METHOD'];

$blacklist = ['polimorfismo',  'herança', 'abstração', 'encapsulamento'];

if ($method === 'POST') {
    $body = getBody();

    $place_id = sanitizeInput($body, 'place_id', FILTER_VALIDATE_INT);
    $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
    $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);

    if (!$place_id) responseError('ID do local ausente. Insira para prosseguir.', 400);
    if (!$name) responseError('Descrição da avaliação ausente. Insira para prosseguir.', 400);
    if (!$email) responseError('Email informado inválido. Insira corretamente para prosseguir.', 400);
    if (!$stars) responseError('Quantidade de estrelas ausente. Insira para prosseguir.', 400);

    if (strlen($name) > 200) responseError('O texto ultrapassou o limite de 200 caracteres.', 400);

    foreach ($blacklist as $word) {
        if (str_contains(strtolower($name), $word)) {
            $name = str_ireplace($word, '[EDITADO PELO ADMIN]', $name);
        }
    }

    $review = new Review($place_id);
    $review->setName($name);
    $review->setEmail($email);
    $review->setStars($stars);
    $review->save();

    response(['message' => 'Avaliação enviada com sucesso. Ela ficará visível para todos assim que terminarmos de analisá-la!.'], 201);
} else if ($method = 'GET') {

    $place_id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
    var_dump($place_id);

    if (!$place_id) responseError('ID do local ausente. Insira para prosseguir.', 400);

     $reviews = new Review($place_id);

    response($reviews->list(), 200);
} else if ($method === "PUT") {
    $body = getBody();
    $id =  sanitizeInput($_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS, false);

    $status = sanitizeInput($body,  'status', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$id) responseError('ID da avaliação ausente. Insira para prosseguir.', 400);
    if (!$status) responseError('Status ausente. Insira para prosseguir.', 400);

    $review = new Review();
    $reviewFound = $review->modifyReviewStatus($id, $status);
}