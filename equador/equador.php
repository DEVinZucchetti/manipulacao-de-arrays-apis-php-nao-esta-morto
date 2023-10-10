<?php
require_once "config.php";
require_once "utils.php";

$method = $_SERVER["REQUEST_METHOD"];

// pego body
if($method === "POST"){
    $body= getBody();

// valido os dados 
    $name = sanitizeString($body ->name);
    $contact = sanitizeString($body ->contact);
    $opening_hours = sanitizeString($body ->opening_hours);
    $description= sanitizeString($body ->description);
    $latitude = filter_var($body ->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body ->longitude, FILTER_VALIDATE_FLOAT);
   

    if(!$name || !$contact || !$opening_hours ||!$description || !$latitude ||!$longitude){
        responseError("Faltaram informacoes esenciais",400);
       
    }

    $allData = readFileContent(FILE_CITY);

    $data = [
        "id" => $_SERVER["REQUEST_TIME"],// para uso didactico para poner un id con fecha y hora
        "name" => $name,
        "contact" => $contact,
        "opening_hours" => $opening_hours,
        "description" => $description,
        "latitude" => $latitude,
        "longitude" => $longitude,
    ];

    $allData = readFileContent(FILE_CITY);
    array_push($allData, $data);
    saveFileContent(FILE_CITY, $allData);

    response($data, 201);
 } else if($method ="GET"){
    $allData = readFileContent(FILE_CITY);
    response($allData,200);

 }
?>