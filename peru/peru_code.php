<?php
require_once 'config.php';
require_once 'util.php';
require_once 'models/Review.php'

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = getBody();

    $name = sanitizeString($body->name);
    $contact = sanitizeString($body->contact);
    $opening_hours = sanitizeString($body->opening_hours);
    $description = sanitizeString($body->description);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);

    if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
        responseError('Todos os campos são obrigatórios!', 400);
    }

    $allData = readFileContent(FILE_COUNTRY);

    $itemSameName = array_filter($allData, function ($item) use ($name) {
        return $item->name === $name;
    });

    if (count($itemSameName) > 0) {
        responseError('Localização ja existente!', 409);
    };

    $data = [
        'id' => $_SERVER['REQUEST_TIME'],
        'name' => $name,
        'contact' => $contact,
        'opening_hours' => $opening_hours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];

    array_push($allData, $data);
    saveFileContent(FILE_COUNTRY, $allData);

    response($data, 201);
} else if ($method === 'GET' && !isset($_GET['id'])) {
    $allData = readFileContent(FILE_COUNTRY);
    response($allData, 200);
} else if ($method === 'DELETE') {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        responseError('ID não encontrado!', 400);
    }

    $allData = readFileContent(FILE_COUNTRY);

    $itemsFiltered = array_filter($allData, function ($item) use ($id) {
        return $item->id !== $id;
    });

    saveFileContent(FILE_COUNTRY, $itemsFiltered);

    response('', 204);
} else if ($method === 'GET' && $_GET['id']) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        responseError('ID não encontrado!', 400);
    }

    $allData = readFileContent(FILE_COUNTRY);

    foreach ($allData as $items) {
        if ($item->id === $id) {
            response($item, 200);
        }
    }

    $review = new Review($place_id);
    $review->setName($name);
    $review->setEmail($email);
    $review->setStars($stars);
    $review->setStatus($status);
    $review->save();

    response(['message' => 'Cadastrado com sucesso', 201]);

}