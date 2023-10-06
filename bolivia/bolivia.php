<?php
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = getBody();

    $name =  filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
    $contact =  filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
    $openingHours =  filter_var($body->openingHours, FILTER_SANITIZE_SPECIAL_CHARS);
    $description =  filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);

    if (!$name || !$contact || !$openingHours || !$description || !$latitude || !$longitude) {
        echo json_encode(['error' => 'Preencha todas as informações para cadastrar um novo lugar.']);
        exit;
    }

    $lugares = readFileContent(ARQUIVO_TXT);

    foreach ($lugares as $lugar) {
        if ($lugar->name === $name) {
            echo json_encode(['error' => 'Este lugar já está cadastrado.']);
            exit;
        }
    }

    $newPlace = [
        'name' => $name,
        'contact' => $contact,
        'openingHours' => $openingHours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];

    array_push($lugares, $newPlace);
    saveFileContent(ARQUIVO_TXT, $lugares);

    echo json_encode(['success' => 'Lugar cadastrado com sucesso.']);
    exit;
}
