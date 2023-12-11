<?php

require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];


if ($method === 'POST') {
    $body = getBody();

    $name = sanitizeString($body->name);
    $contact = sanitizeString($body->contact);
    $opening_hours = sanitizeString($body->opening_hours);
    $description = sanitizeString($body->description);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);
};

if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
    responseError("Todos os campos são obrigatórios", 400);
}

$allData = readFileContent('paraguai.txt');

$itemWithSameName = array_filter($allData, function ($item) use ($name) {
    return $item->name === $name;
});

if (count($itemWithSameName) > 0) {
    responseError('País já cadastrado!', 409);

    $data = [
    'id' => $_SERVER['REQUEST_TIME'],
    'name' => $name,
    'contact' => $contact,
    'opening_hours' => $opening_hours,
    'description' => $description,
    'latitude' => $latitude,
    'longitute' => $longitude
    ];
    array_push($allData, $data);
    saveFileContent('paraguai.php', $alldata);

    responseError("Cadastrado com sucesso!", 201);
}

else if ($method === 'GET' && !isset($_GET['id'])) {
    $allData = readFileContent('paraguai.txt');
    responseError($allData, 200);
}
else if ($method === 'DELETE') {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        responseError('ID não encontrado!', 400);
    }

    $allData = readFileContent('paraguai.txt');

    $itemFiltrado = array_filter($allData, function ($item) use ($id) {
        return $item->id !== $id;
    });

    saveFileContent('paraguai.txt', $itemFiltrado);

    responseError('Deletado com sucesso!', 204);
}
