<?php
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = getBody(); //pega o body ao concluir o post 

    //validação dos dados informados no body
    $name = validateString($body->name);
    $contact = validateString($body->contact);
    $opening_hours = validateString($body->opening_hours);
    $description = validateString($body->description);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);

    //error caso algum dado não seja informado 
    if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
        responseError(400, 'Faltaram informações!');
    }

    //fazer a leitura do arquivo primeiro para depois salvar
    $allData = readFileContent(FILE_CITY);

    //faz o filtro para verificar se não tem um name repetido
    $itemWhitSameName = array_filter($allData, function ($item) use($name) {
        return $item->name === $name;
    });


    // salvando as informações dentro dos arquivos com o array associativo  
    $data = [
        'id' => $_SERVER['REQUEST_TIME'], //somente para esse projeto, pega a hora que foi feita a requisição e define como id
        'name' => $name,
        'contact' => $contact,
        'opening_hours' => $opening_hours,
        'description' => $description,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];

    //realiza o push para enviar os valores
    array_push($allData, $data);

    //salvando os dados dentro do arquivo argentina.txt
    saveFileContent(FILE_CITY, $data);

    response($data, 201);
} else if ($method = 'GET') { // inicio da segunda questão do projeto GET
    //ler o arquivo e retornar ele como json 
    $allData = readFileContent(FILE_CITY);
    response($allData, 200);
}
