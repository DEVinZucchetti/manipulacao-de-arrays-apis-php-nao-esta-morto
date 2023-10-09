<?php
require_once 'config.php';
require_once 'utils.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
 $body = getBody();

 $name = sanitizeString($body->name);
 $contact = sanitizeString($body->contact);
 $opening_hours = sanitizeString($body->opening_hours);
 $description = sanitizeString($body->description);
 $latitude = filter_var($body->latitude, FILTER_VALIDATE_FLOAT);
 $longitude = filter_var($body->longitude, FILTER_VALIDATE_FLOAT);

 if (!$name || !$contact || !$opening_hours || !$description || !$latitude || !$longitude) {
  responseError('Preencha todas as informações para cadastrar um novo lugar.', 400);
 }

 $places = readFileContent(ARQUIVO_TXT);

 foreach ($places as $place) {
  if ($place->name === $name) {
   responseError('Este lugar já está cadastrado.', 409);
  }
 }

 $data = [
  'id' => $_SERVER['REQUEST_TIME'],
  'name' => $name,
  'contact' => $contact,
  'opening_hours' => $opening_hours,
  'description' => $description,
  'latitude' => $latitude,
  'longitude' => $longitude
 ];

 array_push($places, $data);
 saveFileContent(ARQUIVO_TXT, $places);

 response($data, 201);
} elseif ($method === 'GET' && !isset($_GET['id'])) {
 $places = readFileContent(ARQUIVO_TXT);

 response($places, 200);
} elseif ($method === 'DELETE') {
 $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

 if (!$id) {
  responseError('ID ausente', 400);
 }

 $places = readFileContent(ARQUIVO_TXT);

 foreach ($places as $key => $place) {
  if ($place->id === $id) {
   unset($places[$key]);

   saveFileContent(ARQUIVO_TXT, $places);
   response('', 204);
  }
 }
 responseError('ID não encontrado', 404);
} elseif ($method === 'PUT') {
 $body = getBody();
 $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

 if (!$id) {
  responseError('ID ausente', 400);
 }

 $places = readFileContent(ARQUIVO_TXT);

 foreach ($places as $key => $place) {
  if ($place->id === $id) {
   foreach ($body as $field => $value) {
    if (property_exists($place, $field)) {
     if ($field === 'latitude' || $field === 'longitude') {
      $places[$key]->$field = filter_var($value, FILTER_VALIDATE_FLOAT);
      continue;
     }
     $places[$key]->$field = sanitizeString($value);
    }
   }
   saveFileContent(ARQUIVO_TXT, $places);
   response($places[$key], 200);
  }
 }
 responseError('ID não encontrado', 404);
} elseif ($method === 'GET' && isset($_GET['id'])) {
 $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

 if (!$id) {
  responseError('ID ausente', 400);
 }

 $places = readFileContent(ARQUIVO_TXT);

 foreach ($places as $place) {
  if ($place->id === $id) {
   response($place, 200);
  }
 }
 responseError('Lugar não encontrado', 404);
}