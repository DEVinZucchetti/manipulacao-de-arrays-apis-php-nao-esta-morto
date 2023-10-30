<?php 

class PlaceDAO {

    private $connection;
    
    public function __construct()
    {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places", "docker", "docker");
    }

    public function createOne() {

    }

    public function insert(Place $place) {

        try {

        $sql = "insert into places
                    (
                        name,
                        contact,
                        opening_hours,
                        description,
                        latitude,
                        longitude
                    )
                    values 
                    (
                        :name_value,
                        :contact_value,
                        :opening_hours_value,
                        :description_value,
                        :latitude_value,
                        :longitude_value
                    )
        ";

        $statement = ($this->getConnection())->prepare($sql);

        $statement->bindValue(":name_value", $place->getName());
            $statement->bindValue(":contact_value", $place->getContact());
            $statement->bindValue(":opening_hours_value", $place->getOpeningHours());
            $statement->bindValue(":description_value", $place->getDescription());
            $statement->bindValue(":latitude_value", $place->getLatitude());
            $statement->bindValue(":longitude_value", $place->getLongitude());

            $statement->execute();

            return ['sucess' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['sucess' => false];
        }

    }

    public function findMany() {

    }

    public function findOne() {

    }

    public function delete() {

    }

    public function status() {

    }

    public function getConnection()
    {
        return $this->connection;
    }
}
