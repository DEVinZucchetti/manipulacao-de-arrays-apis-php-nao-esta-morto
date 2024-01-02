<?php

class ReviewDAO
{

    private $connection;

    public function __construct()
    {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places_database", "docker", "docker");
    }

    public function create(Review $review)
    {
        try {

            $sql = "insert into reviews
              (
                place_id,
                name,
                email,
                stars,
                date
             )
             values
             {
                :place_id_value,
                :name_value,
                :email_value,
                :stars_value,
                :date_value
             };

             ";

            $statement = ($this->getConnection())->prepare($sql);

            $statement->bindValue(":place_id_value", $review->getName());
            $statement->bindValue(":name_value", $review->getName());
            $statement->bindValue(":email_value", $review->getName());
            $statement->bindValue(":stars_value", $review->getName());

            $statement->execute();
            return ['success' => 'true'];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success => false'];
        }
    }

    public function findMany()
    {
        $sql = "select * from reviews";
        $statement = ($this->getConnection())->prepare($sql);

        return $statement->execute(); //retorna solo os dados
        return $statement->fetchAll(PDO::FETCH_ASSOC); // transforma em um array asociativo
    }
    //atualizar
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
        $reviewInDatabase = $this->findOne($id);

        $sql = "update reviews
                          set
                          place_id=:place_id_value,
                          name=:name_value,
                          email=:email_value,
                          stars=:atars_value,
                          date=:date_value
                    where id=:id_value      
    
    ";

    $statement = ($this->getConnection())->prepare($sql);

    $statement->bindValue(":id_value", $id);

    $statement->bindValue(
        ":place_id_value",
        isset($data->place_id) ?
            $data->place_id :
            $reviewInDatabase['place_id']
    );

    $statement->bindValue(
        ":name_value",
        isset($data->name) ?
            $data->name :
            $reviewInDatabase['name']
    );

    $statement->bindValue(
        ":email_value",
        isset($data->email) ?
            $data->email :
            $reviewInDatabase['email']
    );

    $statement->bindValue(
        ":stars_value",
        isset($data->stars) ?
            $data->stars:
            $reviewInDatabase['stars']
    );

    $statement->bindValue(
        ":date_value",
        isset($data->date) ?
            $data->date :
            $reviewInDatabase['date']
    );

    $statement->execute();

    return ['success' => true];
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
