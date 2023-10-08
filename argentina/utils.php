<?php
function getBody()
{
    return json_decode(file_get_contents("php://input")); // pegar o body no formato de string 
}

function readFileContent($fileName)
{
    return json_decode(file_get_contents($fileName));
}

function saveFileContents($fileName, $content)
{
    file_put_contents($fileName, json_encode($content));
}

function validateString($value)
{
    return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS); // filtra o nome dentro o nome dentro do body e pega os dados 
}

function responseError($message, $status) // respota de erro ao fazer o post do body
{
    http_response_code($status);
    echo json_encode(['error' => $message]);
}
