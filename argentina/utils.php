<?php
function getBody()
{
    return json_decode(file_get_contents("php://input")); // pegar o body no formato de string
}

function readFileContent($fileName)
{
    return json_decode(file_get_contents($fileName));
}

function saveFileContent($fileName, $content)
{
    file_put_contents($fileName, json_encode($content, JSON_PRETTY_PRINT));
}

function sanitizeString($value)
{
  return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
}

function validateString($value)
{
    return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS); 
}

function responseError($status, $message) 
{
    http_response_code($status);
    echo json_encode(['error' => $message]);
    exit;
}

function response($status, $response) { 
    http_response_code($status);
    echo json_encode($response);
    exit; 
}

function debug($content)
{
  echo '<pre>';
  echo var_dump($content);
  echo '</pre>';
}

function sanitizeInput($data, $property, $filterType) {
    return isset($data->$property) ? filter_var($data->$property, $filterType) : null;
}
