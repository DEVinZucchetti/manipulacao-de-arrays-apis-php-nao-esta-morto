<?php
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

$blacklist = ['polimorfismo', 'herança', 'abstração', 'encapsulamento'];

if ($method === 'POST') {
    $body = getBody();

    $place_id = sanitizeInput($body, 'place_id', FILTER_VALIDATE_INT);
    $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
    $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);
    $date = (new DateTime())->format('d/m/Y h:m');
    $status = sanitizeInput($body, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$place_id) responseError('Id não declarado!', 400);
    if (!$name) responseError('Descrição não declarada!', 400);
    if (!$email) responseError('Email não declarado!', 400);
    if (!$stars) responseError('Estrelas não declaradas!', 400);
    if (!$status) responseError('Status de avaliação não declarado!', 400);

    if (strlen($name) > 200) responseError('O texto ultrapassou o limite', 400);

    foreach ($blacklist as $word) {
        if (str_contains($name, $word)) {
            $name = str_replace($word, '[EDITADO PELO ADMIN]', $name);
        }
    }
}