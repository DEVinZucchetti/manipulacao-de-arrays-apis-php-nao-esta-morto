<?php 
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = json_decode(file_get_contents("php://input"));

    $name = filter_var($body->name, FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($body->contact, FILTER_SANITIZE_SPECIAL_CHARS);
    $opening_hours = filter_var($body->opening_hours, FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($body->description, FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude =filter_var($body->longitude, FILTER_VALIDATE_FLOAT); 

    if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude ) {
        http_response_code(400);
        echo json_encode(["error" => "Faltaram informações"]);
        exit;
    }

    $data = [
        'name' => $name,
        'contact' => $contact,
        'opening_hours' => $opening_hours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];
    
    $fileContent = file_get_contents('indonesia.txt');
    $file = json_decode($fileContent);
    array_push($file, $data);
    file_put_contents('indonesia.txt', json_encode($data));

    echo json_encode($data);


}

?>