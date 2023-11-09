<?php

class ReviewDAO {
    private $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function insert(Review $review) {
        try {
            $sql = "INSERT INTO reviews 
            (
                lugar_id,
                usuario,
                comentario,
                avaliacao,
                data_avaliacao
            ) 
            VALUES 
            (
                :lugar_id,
                :usuario,
                :comentario,
                :avaliacao,
                :data_avaliacao
            )";

            $statement = ($this->getConnection())->prepare($sql);

            $statement->bindValue(':lugar_id', $review->getLugarId());
            $statement->bindValue(':usuario', $review->getUsuario());
            $statement->bindValue(':comentario', $review->getComentario());
            $statement->bindValue(':avaliacao', $review->getAvaliacao());
            $statement->bindValue(':data_avaliacao', $review->getDataAvaliacao());

            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function findMany() {
        $sql = "SELECT * FROM reviews ORDER BY data_avaliacao DESC";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}

?>
