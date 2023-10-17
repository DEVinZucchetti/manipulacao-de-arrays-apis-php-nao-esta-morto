<?php
require_once 'config.php';
require_once 'utils.php';
require_once 'models/Place.php';

$method = $_SERVER['REQUEST_METHOD'];

$controller = new PlaceController();

if ($method === 'POST') {
    $controller->create();
} else if ($method === 'GET' && !isset($_GET['id'])) {
    $places = (new Place())->list();
    response(200, $places);
} else if ($method === 'DELETE') {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);
    if (!$id) {
        responseError(400, 'ID ausente');
    }

    $place = new Place();
    $place->delete($id);


    response(204, ['message' => 'Deletado com sucesso!']);
} else if ($method === 'GET' && $_GET['id']) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$id) {
        responseError(400, 'ID ausente');
    }

    $place = new Place();
    $item = $place->listOne($id);
    response(200, $item);
} else if ($method === 'PUT') {

    $body = getBody();
    $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$id) {
        responseError(400, 'ID ausente');
    }

    $place = new Place();
    $place->update($id, $body);

    response(200, ['message' => 'Atualizado com sucesso!']);
}
