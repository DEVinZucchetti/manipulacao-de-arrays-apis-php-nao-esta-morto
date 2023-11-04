<?php 
require_once 'Database.php';

class ReviewDAO extends Database 

{
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

    public function findMany()
    {
        $sql = "select * from reviews order by name";

        $statement = ($this->getConnection())->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOne($id)
    {
        $sql = "SELECT * from reviews where id = :id_value";

        $statement = ($this->getConnection())->prepare($sql);

        $statement->bindValue(":id_value", $id);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    public function updateOne($id, $data)
    {
        $placeInDatabase = $this->findOne($id);

        $sql = "update reviews 
            set 
                        name=:name_value,
                        email=:email_value,
                        stars=:stars_value,
                        date=:date_value,
                        status=:status_value        
            where id=:id_value
        ";

        $statement = ($this->getConnection())->prepare($sql);

        $statement->bindValue(":id_value", $id);

        $statement->bindValue(
            ":name_value",
            isset($data->name) ?
                $data->name :
                $placeInDatabase['name']
        );
        $statement->bindValue(
            ":email_value",
            isset($data->email) ?
                $data->email :
                $placeInDatabase['email']
        );
        $statement->bindValue(
            ":stars_value",
            isset($data->stars) ?
                $data->stars :
                $placeInDatabase['stars']
        );
        $statement->bindValue(
            ":date_value",
            isset($data->date) ?
                $data->date :
                $placeInDatabase['date']
        );
        $statement->bindValue(
            ":status_value",
            isset($data->status) ?
                $data->status :
                $placeInDatabase['status']
        );
    }
 
}

