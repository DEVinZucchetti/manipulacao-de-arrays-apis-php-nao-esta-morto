<?php 
function getBody() {
    return json_decode(file_get_contents("php://input")); // pegar o body no formato de string 
}

function readFileContent($fileName){
    return json_decode(file_get_contents($fileName));
}

function saveFileContents($fileName, $content) {
    file_put_contents($fileName, json_encode($content));
}

function validateString($value) {
    return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
}
?>