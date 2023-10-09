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
    $itemWhitSameName = array_filter($allData, function ($item) use ($name) {
        return $item->name === $name;
    });

    if (count($itemWhitSameName) > 0) {
        responseError(409, 'O item já existe');
    }

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
} else if ($method === 'GET' && !isset($_GET['id'])) { // inicio da segunda questão do projeto GET
    //ler o arquivo e retornar ele como json 
    $allData = readFileContent(FILE_CITY);
    response($allData, 200);
} else if ($method === 'DELETE') { // inicio da terceira questão do projeto DELETE, pegar parametro pela url para poder deletar
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if (!$id) {
        responseError(400, 'ID ausente');
    }

    $allData = readFileContent(FILE_CITY);

    $itemsFiltered = array_filter($allData, function ($item) use ($id) {
        if ($item->id !== $id) return $item;
    });

    saveFileContent(FILE_CITY, $itemsFiltered);
    response(204, ['message' => 'Deletado com sucesso!']);
} else if ($method === 'GET' && $_GET['id']) { //inicio da quinta questão, visualização do lugar
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); // recebe o id 

    if (!$id) { //validade para ver se existe
        responseError(400, 'ID ausente');
    }

    $allData = readFileContent((FILE_CITY)); //leitura do arquivo 

    foreach ($allData as $item) { // quando recebe o id, se for o correto, ele retorna
        if ($item->id === $id) {
            response(200, $item);
        }
    }
} else if ($method === 'PUT') { // inicio da quarta questão, faz o put para atualizar as informações, FUNÇÃO MAIS COMPLETA POIS MANDA INFORMAÇÕES VIA BODY E UTILIZA O ID PARA DEFINIR QUAL ITEM SERÁ ATUALIZADO

$body = getBody(); //pegar o body

$id = $_GET['id']; //pegar o id 

$allData = readFileContent((FILE_CITY)); //leitura do arquivo

foreach ($allData as $position => $item) { // quando recebe o id, se for o correto, ele retorna o item da posição para poder alterar depois definir o item alterado dentro do if
    if ($item->id === $id) {
        $allData[$position]['name'] = $body->name; 
    }
}
}
