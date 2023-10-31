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

        $result = $placeDAO->insert($place);

        if($result['sucess'] === true) {
            response(201, ['message' => 'Cadastrado com sucesso!']);

        } else {
            responseError(400, "Não foi possível realizar o cadastro!");
        }
    }

    public function list()
    {
        $placeDAO = new PlaceDAO();
        $result = $placeDAO->findMany();
        response(200, $result); 
    }

    public function delete()
    {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id) {
            responseError(400, 'ID ausente');
        }

        $placeDAO = new PlaceDAO();
        $placeDAO->deleteOne($id);

        response(204, ['message' => 'Deletado com sucesso!']);
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
