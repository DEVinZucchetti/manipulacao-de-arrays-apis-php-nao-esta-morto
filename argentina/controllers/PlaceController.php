<?php

require_once '../utils.php';
require_once '../models/Place.php';
require_once '../models/PlaceDAO.php';
class PlaceController
{
    public function create()
    {
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


        /*  $allData = readFileContent(FILE_CITY);


         $itemWithSameName = array_filter($allData, function ($item) use ($name) {
            return $item->name === $name;
        });

        if (count($itemWithSameName) > 0) {
            responseError(409, 'O item já existe');
        }

        */

        $place = new Place($name);
        $place->setContact($contact);
        $place->setOpening_hours($opening_hours);
        $place->setDescription($description);
        $place->setLatitude($latitude);
        $place->setLongitude($longitude);

        $placeDAO = new PlaceDAO();

        $placeDAO->insert($place);

        response(201, ['message' => 'Cadastrado com sucesso!']);
    }

    public function list()
    {
        $places = (new Place())->list();
        response(200, $places);
    }

    public function delete()
    {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id) {
            responseError(400, 'ID ausente');
        }

        $place = new Place();
        $place->delete($id);

        response(200, ['message' => 'Deletado com sucesso!']);
    }

    public function listOne()
    {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$id) {
            responseError(400, 'ID ausente');
        }

        $place = new Place();
        $place->delete($id);


        response(204, ['message' => 'Deletado com sucesso!']);
    }

    public function update()
    {
        $body = getBody();
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id) {
            responseError(400, 'ID ausente');
        }

        $place = new Place();
        $place->update($id, $body);

        response(200, ['message' => 'Atualizado com sucesso!']);
    }
}
