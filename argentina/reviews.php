<?php
require_once 'config.php';
require_once 'controller/ReviewsController.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $controller->create();
} else if ($method === 'GET') {
    $controller->list();
} else if ($method === 'PUT') {
    $controller->update();
}
