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

             $statement -> execute();
             return['success' => 'true'];
            }catch (PDOException $error){
                debug($error->getMessage());
                return['success => false'];
            }
        }

    public function findMany()
    {
        $sql = "select * from reviews";
        $statement = ($this->getConnection())->prepare($sql);

        return $statement->execute();//retorna solo os dados
        return $statement->fetchAll(PDO::FETCH_ASSOC);// transforma em um array asociativo
    }
    public function updateOne()
    {
        
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
