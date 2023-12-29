<?php 

class PlaceDAO{
    private $connection;

    public function __construct()
    {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places","docker","docker");
    }

    public function insert(){

    }

    public function findMany(){

    }

    public function findOne(){

    }

    public function deleteOne(){

    }

    public function updateOne(){

    }

  
    public function getConnection()
    {
        return $this->connection;
    }
}
