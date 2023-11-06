<?php

class PlaceDAO {
    private $connection;

    public function __construct() {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places", "bolivia_places", "bolivia");
    }

    public function getConnection() {
        return $this->connection;
    }

    public function insert(Place $place) {
        try {
            $sql = "INSERT INTO places 
            (
                name, 
                contact, 
                opening_hours, 
                description, 
                latitude, 
                longitude
            ) 
            VALUES 
            (
                :name, 
                :contact, 
                :opening_hours, 
                :description, 
                :latitude, 
                :longitude
            )";

            $statement = ($this->getConnection())->prepare($sql);

            $statement->bindValue(':name', $place->getName());
            $statement->bindValue(':contact', $place->getContact());
            $statement->bindValue(':opening_hours', $place->getOpeningHours());
            $statement->bindValue(':description', $place->getDescription());
            $statement->bindValue(':latitude', $place->getLatitude());
            $statement->bindValue(':longitude', $place->getLongitude());

            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function findMany() {
        $sql = "SELECT * FROM places order by name";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
