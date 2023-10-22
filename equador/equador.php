<?php
require_once "config.php";
require_once "utils.php";
require_once "models/Place.php";

$method = $_SERVER["REQUEST_METHOD"];

$controller = new PlaceController();

// 1. pego body
if ($method === "POST") {
    $controller->create();
} else if ($method === 'GET' && !isset($_GET['id'])) {
    $controller->list();
} else if ($method === "DELETE") {
    $controller->delete();
   
} else if ($method === "GET" && $_GET["id"]) {
    $id = filter_var($_GET["id"], FILTER_SANITIZE_SPECIAL_CHARS);


    if (!$id) {
        responseError("ID ausente", 400);
    }

    $place = new Place();
    $item = $place->listOne($id);

    response($item, 200);


    //pra atualizar os dados do cadastro
} else if ($method === "PUT") {
    $body = getBody();
    $id = filter_var($_GET["id"], FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$id) {
        responseError("ID ausente", 400);
    }

    $place = new Place();
    $place->update($id, $body);

    response(["message" => "atualizado com sucesso"], 200);
}
