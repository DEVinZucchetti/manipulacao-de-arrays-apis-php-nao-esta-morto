<?php
require_once "config.php";
require_once "utils.php";

$methods = $_SERVER['REQUEST_METHOD'];

if ($methods === "POST") {
    $body = getBody();

    if (!$body || !property_exists($body, 'name') || !property_exists($body, 'contact') || !property_exists($body, 'opening_hours') || !property_exists($body, 'latitude') || !property_exists($body, 'longitude')) {
        responseError("Preencha todos os campos!", 400);
    }

    $allData = readFileContent(FILE_CITY);

    $itemWithSameName = array_filter($allData, function ($item) use ($name) {
        return $item->name === $name;
    });

    if (count($itemWithSameName) > 0) {
        responseError('Essas informações já foram cadastradas anteriormente!', 409);
    };

    $data = [
        'id' => $_SERVER['REQUEST_TIME'], // somente para uso didático
        'name' => $name,
        'contact' => $contact,
        'opening_hours' =>  $opening_hours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];


    array_push($allData, $data);
    saveFileContent(FILE_CITY, $allData);

    response($data, 201);
}else if($methods === "GET" && !isset($_GET['id'])){
    $allData = readFileContent(FILE_CITY);
    response($allData, 200);
}else if ($methods === 'DELETE') {
    $id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : null;

    if ($id === null) {
        responseError('ID ausente', 400);
    }

    $allData = readFileContent(FILE_CITY);

    $itemToDelete = null;

    foreach ($allData as $item) {
        if ($item->id === $id) {
            $itemToDelete = $item;
            break;
        }
    }

    if ($itemToDelete === null) {
        responseError('ID não encontrado', 400);
    }

    $itemsFiltered = array_filter($allData, function ($item) use ($id) {
        return $item->id !== $id;
    });

    saveFileContent(FILE_CITY, $itemsFiltered);

    response(['message' => 'Item excluído com sucesso!'], 204);
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
