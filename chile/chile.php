<?php
require_once "config.php";
require_once "utils.php";

$methods = $_SERVER['REQUEST_METHOD'];
$controller = new PlaceController();


if ($methods === "POST") {
    $controller->create();
}else if($methods === "GET" && !isset($_GET['id'])){
    $controller->list();
}else if ($methods === 'DELETE') {
    $controller->delete();
}else if($methods === 'GET' && $_GET['id']){
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        responseError('ID inexistente!', 400);
    }

    $allData = readFileContent(FILE_CITY);

    foreach($allData as $item) {
        if($item->id === $id) {
            response($item, 200);
        }
    }
}else if($methods === 'PUT'){
    $body = getBody();
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    $body = getBody();

    if (!$body || !property_exists($body, 'name') || !property_exists($body, 'contact') || !property_exists($body, 'opening_hours') || !property_exists($body, 'latitude') || !property_exists($body, 'longitude')) {
        responseError("Preencha todos os campos!", 400);
    }

    $allData = readFileContent(FILE_CITY);

    foreach($allData as $position => $item) {
        if($item->id === $id) {
            $allData[$position]->name = $body->name;
        }
    }
    
    saveFileContent(FILE_CITY, $allData);
}
