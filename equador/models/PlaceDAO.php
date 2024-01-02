<?php 

class PlaceDAO{
    private $connection;

    public function __construct()
    {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places_database","docker","docker");
    }

    public function insert(Place $place){
        try{
            $sql = "insert into places
                            {
                                name,
                                contact,
                                opening_hours,
                                description,
                                latitude,
                                longitude
                            }
                            values
                            {
                                :name_value,
                                :contact_value,
                                :opening_hours_value,
                                :description_value,
                                :latitude_value,
                                :longitude_value
                            };
            ";
        $statement = ($this->getConnection())->prepare($sql);

        $statement->bindValue(":name_value", $place->getName());
        $statement->bindValue(":contact_value", $place->getContact());
        $statement->bindValue(":opening_hours", $place->getOpeningHours());
        $statement->bindValue(":description", $place->getDescription());
        $statement->bindValue(":latitude_value", $place->getLatitude());
        $statement->bindValue(":longitude_value", $place->getLongitude());

        $statement->execute();

        return['success' => 'true'];
        }catch (PDOException $error){
            debug($error->getMessage());
            return['success => false'];
        }
    }

    public function findMany(){
        $sql = "select * from places order by name ASC";
        $statement = ($this->getConnection())->prepare($sql);

        return $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

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
