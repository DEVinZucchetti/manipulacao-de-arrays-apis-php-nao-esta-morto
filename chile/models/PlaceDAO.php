<?php

class PlaceDAO {
    private $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
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
        $sql = "SELECT * FROM places ORDER BY name";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function update(Place $place) {
        try {
            $sql = "UPDATE places SET
                name = :name,
                contact = :contact,
                opening_hours = :opening_hours,
                description = :description,
                latitude = :latitude,
                longitude = :longitude
            WHERE id = :id";

            $statement = ($this->getConnection())->prepare($sql);

            $statement->bindValue(':id', $place->getId());
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

    public function delete($id) {
        try {
            $sql = "DELETE FROM places WHERE id = :id";
            $statement = ($this->getConnection())->prepare($sql);
            $statement->bindValue(':id', $id);
            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }
}
?>
