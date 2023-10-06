<?php
header("Content-Type: application/json"); // a aplicação retorna json
header("Access-Control-Allow-Origin: *"); // vai aceitar requisições de todas origens
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // habilita métodos
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

$method = $_SERVER["REQUEST_METHOD"];
if($method === "POST"){
    $body= json_decode(file_get_contents("php://input"));

    var_dump($body);

    $name = filter_var($body ->name, FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($body ->contact, FILTER_SANITIZE_SPECIAL_CHARS);
    $opening = filter_var($body ->opening, FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($body ->description, FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_var($body ->latitude, FILTER_SANITIZE_SPECIAL_CHARS);
    $longitude = filter_var($body ->longitude, FILTER_SANITIZE_SPECIAL_CHARS);

    if(!$name || !$contact || !$opening ||!$description || !$latitude ||!$longitude){
        echo json_encode(["error" => "Preencha todas as informacoes"]);
    }

    $equador = json_decode (file_get_contents("equador.txt")) ;
    array_push($equador, ["name"=>$name, "contact" => $contact, "opening" => $opening, "description" => $description, "latitude " => $latitude , "longitude " => $longitude ]);
    file_put_contents("equador.txt",json_encode($equador));
    var_dump( $equador);

    
}
