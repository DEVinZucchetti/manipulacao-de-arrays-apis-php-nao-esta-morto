<?php

function getBody() {
    return json_decode(file_get_contents("php://input"));
}

function readFileContent($fileName){
    if (file_exists($fileName)) {
        return json_decode(file_get_contents($fileName));
    }
    return null;
}

function saveFileContent($fileName, $content) {
    file_put_contents($fileName, json_encode($content));
}

function sanitizeString($value) {
    return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
}

function responseError($message, $status) {
    http_response_code($status);
    echo json_encode(['error' => $message]);
    exit;
}

function response($response, $status) {
    http_response_code($status);
    echo json_encode($response);
    exit;
}

function getCityById($allData, $id) {
    foreach ($allData as $item) {
        if ($item->id === $id) {
            return $item;
        }
    }
    return null;
}
