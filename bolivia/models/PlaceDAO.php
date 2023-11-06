<?php

class PlaceDAO {
    private $connection;

    public function __construct() {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places", "bolivia_places", "bolivia");
    }

    public function getConnection() {
        return $this->connection;
    }
}
