<?php
date_default_timezone_set("America/Guayaquil"); //Date

define('FILE_CITY', 'equador.txt');
define('FILE_REVIEWS', 'reviews.txt');

header("Content-Type: application/json"); // a aplicação retorna json
header("Access-Control-Allow-Origin: *"); // vai aceitar requisições de todas origens
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // habilita métodos
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
