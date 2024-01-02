<?php 
require_once "../utils.php";
require_once "../models/Place.php";
require_once "../models/PlaceDAO.php";
class PlaceController{

    public function create(){
        $body = getBody();

   // 2. pego os dados 
    $name = sanitizeString($body->name);
    $contact = sanitizeString($body->contact);
    $opening_hours = sanitizeString($body->opening_hours);
    $description = sanitizeString($body->description);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);


    if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
        responseError("Faltaram informacoes esenciais", 400); // 3. valido os dados

    }

    /* $allData = readFileContent(FILE_CITY); // 4. leo o arquivo

    $itemWithSameName = array_filter($allData, function ($item) use ($name) {
        return $item->name === $name;
    });

    if (count($itemWithSameName) > 0) {
        responseError("O item ja existe", 409);
    }*/

    $place = new Place($name);
    $place->setContact($contact);
    $place->setOpeningHours($opening_hours);
    $place->setDescription($description);
    $place->setLatitude($latitude);
    $place->setLongitude($longitude);

    $placeDAO= new PlaceDAO();

    $result = $placeDAO->insert($place);

    if($result['success'] === true){
        response(["message" => " Cadastro com sucesso"], 201);
    }else{
        responseError("Nao foi possivel realizar o cadastro",400);
    }

    response(["message" => "cadastrado com sucesso"], 201);
    }

    public function list(){
        $placeDAO = new PlaceDAO();
        $result = $placeDAO->findMany();
        response($result,200);
    } 
    
    public function delete(){
        $id = filter_var($_GET["id"], FILTER_SANITIZE_SPECIAL_CHARS);


        if (!$id) {
            responseError("ID ausente", 400);
        }
    
        $placeDAO = new PlaceDAO();
        $placeDAO->deleteOne($id);
    
        response(["message" => "Deletado com sucesso"], 204);
    }

    public function listOne(){
        $id = filter_var($_GET["id"], FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$id) {
        responseError("ID ausente", 400);
    }

    $place = new Place();
    $item = $place->listOne($id);

    response($item, 200);
    }

    public function update(){
        $body = getBody();
        $id = filter_var($_GET["id"], FILTER_SANITIZE_SPECIAL_CHARS);
    
        if (!$id) {
            responseError("ID ausente", 400);
        }
    
        $place = new Place();
        $place->update($id, $body);
    
        response(["message" => "atualizado com sucesso"], 200);
    }

}
