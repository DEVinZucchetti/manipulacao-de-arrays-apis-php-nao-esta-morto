<?php 
require_once 'Database.php';

class ReviewDAO extends Database {
    public function insert(Review $review)
    {

        try {

            $sql = "insert into places
                    (
                        place_id,
                        name,
                        email,
                        stars,
                        date,
                        status
                    )
                    values 
                    (
                        :place_id_value,
                        :name_value,
                        :email_value,
                        :stars_value,
                        :date_value,
                        :status_value
                    )
        ";

            $statement = ($this->getConnection())->prepare($sql);

            $statement->bindValue(":name_value", $review->getName());
            $statement->bindValue(":email_value", $review->getEmail()); 
            $statement->bindValue(":stars_value", $review->getStars()); 
            $statement->bindValue(":date_value", $review->getDate());
            $statement->bindValue(":status_value", $review->getStatus());
            

            $statement->execute();

            return ['sucess' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['sucess' => false];
        }
    }
 
}

