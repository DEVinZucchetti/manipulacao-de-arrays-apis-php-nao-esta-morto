<?php
require_once 'config.php';
require_once 'utils.php';
require_once 'Place.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = getBody();

    $name = validateString($body->name);
    $contact = validateString($body->contact);
    $opening_hours = validateString($body->opening_hours);
    $description = validateString($body->description);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);


    if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
        responseError(400, 'Faltaram informações!');
    }


    $allData = readFileContent(FILE_CITY);


    $itemWithSameName = array_filter($allData, function ($item) use ($name) {
        return $item->name === $name;
    });

    if (count($itemWithSameName) > 0) {
        responseError(409, 'O item já existe');
    }

    $place = new Place($name);
    $place->setContact($contact);
    $place->setOpening_hours($opening_hours);
    $place->setDescription($description);
    $place->setLatitude($latitude);
    $place->setLongitude($longitude);
    $place->save();

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


    saveFileContent(FILE_CITY, $data);

    response(201, $data);
} else if ($method === 'GET' && !isset($_GET['id'])) {
    $places = (new Place())->list();
    response(200, $places);
} else if ($method === 'DELETE') {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);
    if (!$id) {
        responseError(400, 'ID ausente');
    }

    $place = new place();
    $place->delete($id);


    response(204, ['message' => 'Deletado com sucesso!']);
} else if ($method === 'GET' && $_GET['id']) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$id) {
        responseError(400, 'ID ausente');
    }

    $allData = readFileContent((FILE_CITY));

    foreach ($allData as $item) {
        if ($item->id === $id) {
            response(200, $item);
        }
    }
} else if ($method === 'PUT') {

    $body = getBody();

    $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

    $allData = readFileContent(FILE_CITY);

    foreach ($allData as $position => $item) {
        if ($item->id === $id) {
            $allData[$position]->name = isset($body->name) ? $body->name : $item->name;
            $allData[$position]->contact = isset($body->contact) ? $body->contact : $item->contact;
            $allData[$position]->opening_hours = isset($body->opening_hours) ? $body->opening_hours : $item->opening_hours;
            $allData[$position]->description = isset($body->description) ? $body->description : $item->description;
            $allData[$position]->latitude = isset($body->latitude) ? $body->latitude : $item->latitude;
            $allData[$position]->longitude = isset($body->longitude) ? $body->longitude : $item->longitude;
        }
    }

    saveFileContent(FILE_CITY, $allData);
    response(200, ['message' => 'Atualizado com sucesso!']);
}
