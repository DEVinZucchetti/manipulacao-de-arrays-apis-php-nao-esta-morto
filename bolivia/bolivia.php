<?php
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = getBody();

    $name = sanitizeString($body->name);
    $contact =  sanitizeString($body->contact);
    $openingHours = sanitizeString($body->openingHours);
    $description =  sanitizeString($body->description);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);

    if (!$name || !$contact || !$openingHours || !$description || !$latitude || !$longitude) {
        responseError('Preencha todas as informações para cadastrar um novo lugar.', 400);
    }

    $places = readFileContent(ARQUIVO_TXT);

    foreach ($places as $place) {
        if ($place->name === $name) {
            echo json_encode(['error' => 'Este lugar já está cadastrado.']);
            exit;
        }
    }

    $data = [
        'id' => $_SERVER['REQUEST_TIME'], // timestamp da requisição, uso didático
        'name' => $name,
        'contact' => $contact,
        'openingHours' => $openingHours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];

    array_push($places, $data);
    saveFileContent(ARQUIVO_TXT, $places);

    response($data, 201);
    exit;
}
