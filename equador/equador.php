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
    $controller->listOne();
    //pra atualizar os dados do cadastro
} else if ($method === "PUT") {
    $controller->update();   
}
