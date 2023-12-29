<?php 

class PlaceDAO{
    private $connection;

    public function __construct()
    {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places","docker","docker");
    }

  
    public function getConnection()
    {
        return $this->connection;
    }
}
