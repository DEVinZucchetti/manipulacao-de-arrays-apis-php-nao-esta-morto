<?php 

class PlaceController {
    public function create() {
        $body = getBody();

    $name = validateString($body->name);
    $contact = validateString($body->contact);
    $opening_hours = validateString($body->opening_hours);
    $description = validateString($body->description);
    $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);


    if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
        responseError(400, 'Faltaram informações!');
    }


    $allData = readFileContent(FILE_CITY);


    $itemWithSameName = array_filter($allData, function ($item) use ($name) {
        return $item->name === $name;
    });

    if (count($itemWithSameName) > 0) {
        responseError(409, 'O item já existe');
    }

    $place = new Place($name);
    $place->setContact($contact);
    $place->setOpening_hours($opening_hours);
    $place->setDescription($description);
    $place->setLatitude($latitude);
    $place->setLongitude($longitude);
    $place->save();

    response(201, ['message' => 'Cadastrado com sucesso!']);
    }

    public function list() {
        $places = (new Place())->list();
        response(200, $places);
    }
}
