<?php 
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

    $allData = readFileContent(FILE_CITY); // 4. leo o arquivo

    $itemWithSameName = array_filter($allData, function ($item) use ($name) {
        return $item->name === $name;
    });

    if (count($itemWithSameName) > 0) {
        responseError("O item ja existe", 409);
    }

    $place = new Place($name);
    $place->setContact($contact);
    $place->setOpeningHours($opening_hours);
    $place->setDescription($description);
    $place->setLatitude($latitude);
    $place->setLongitude($longitude);
    $place->save();


    response(["message" => "cadastrado com sucesso"], 201);
    }

    public list(){
        $places = (new Place())->list();
        response($places,200);
    }

}
?>