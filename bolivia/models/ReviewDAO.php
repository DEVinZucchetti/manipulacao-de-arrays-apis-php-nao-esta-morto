<?php

class ReviewDAO {
    private $connection;

    public function __construct() {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places", "bolivia_places", "bolivia");
    }

    public function getConnection() {
        return $this->connection;
    }


    public function insert(Review $review) {
        try {
            $sql = "INSERT INTO reviews 
            (
                name, 
                email, 
                stars, 
                date, 
                status, 
                place_id
            )
            VALUES 
            (
                :name, 
                :email, 
                :stars, 
                :date, 
                :status, 
                :place_id
            )";

            $statement = ($this->getConnection())->prepare($sql);

            $statement->bindValue(':name', $review->getName());
            $statement->bindValue(':email', $review->getEmail());
            $statement->bindValue(':stars', $review->getStars());
            $statement->bindValue(':date', $review->getDate());
            $statement->bindValue(':status', $review->getStatus());
            $statement->bindValue(':place_id', $review->getPlaceId());

            $statement->execute();


            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function list($place_id) {
        $sql = "SELECT * from reviews where place_id = :id_value";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->bindValue(":id_value", $place_id);
        $statement->execute();

        $result = $statement->fetchALL(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateStatus($id, $status) {
        $allData  = readFileContent(FILE_REVIEWS);
        foreach ($allData  as $review) {
            if ($review->id === $id) {
                $review->status = $status;
                saveFileContent(FILE_REVIEWS, $allData);
                return;
            }
        }
        responseError('Avaliação não encontrada.', 404);
    }
}
