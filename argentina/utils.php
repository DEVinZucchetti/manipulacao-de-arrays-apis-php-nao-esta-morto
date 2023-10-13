<?php
function getBody()
{
    return json_decode(file_get_contents("php://input")); 
}

function readFileContent($fileName)
{
    return json_decode(file_get_contents($fileName));
}

function saveFileContent($fileName, $content)
{
    file_put_contents($fileName, json_encode($content));
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
