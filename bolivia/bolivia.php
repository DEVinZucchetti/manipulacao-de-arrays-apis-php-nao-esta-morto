<?php
require_once 'config.php';
require_once 'utils.php';
require_once 'models/Place.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = getBody();

    $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = sanitizeInput($body, 'contact', FILTER_SANITIZE_SPECIAL_CHARS);
    $openingHours = sanitizeInput($body, 'openingHours', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = sanitizeInput($body, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = sanitizeInput($body, 'latitude', FILTER_VALIDATE_FLOAT);
    $longitude = sanitizeInput($body, 'longitude', FILTER_VALIDATE_FLOAT);

    if (!$name) responseError('Nome do local ausente. Insira para prosseguir.', 400);
    if (!$contact) responseError('Contato do local ausente. Insira para prosseguir.', 400);
    if (!$openingHours) responseError('Horário de funcionamento do local ausente. Insira para prosseguir.', 400);
    if (!$description) responseError('Descrição do local ausente. Insira para prosseguir.', 400);
    if (!$latitude) responseError('Latitude do local ausente. Insira para prosseguir.', 400);
    if (!$longitude) responseError('Longitude do local ausente. Insira para prosseguir.', 400);


    $places = readFileContent(FILE_CITY);
    foreach ($places as $place) {
        if ($place->name === $name) {
            responseError('Este lugar já está cadastrado.', 409);
        }
    }

    $place = new Place($name);
    $place->setContact($contact);
    $place->setOpeningHours($openingHours);
    $place->setDescription($description);
    $place->setLatitude($latitude);
    $place->setLongitude($longitude);
    $place->save();
} else if ($method === 'GET' && !isset($_GET['id'])) {
    $place = new Place();
    $places = $place->getAllPlaces();

    response($places, 200);
} else if ($method === 'DELETE') {
    $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

    if (!$id) {
        responseError('ID ausente', 400);
    }

    $place = new Place();
    $place->deletePlace($id);
} else if ($method === 'PUT') {
    $body = getBody();
    $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

    if (!$id) {
        responseError('ID ausente', 400);
    }

    $place = new Place();
    $places = $place->updatePlace($id, $body);
} else if ($method === 'GET' && isset($_GET['id'])) {
    $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
    if (!$id) {
        responseError('ID ausente', 400);
    }

    $place = new Place();
    $foundPlace = $place->getPlaceById($id);
}
