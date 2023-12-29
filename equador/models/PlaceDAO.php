<?php 

class PlaceDAO{
    private $connection;

    public function __construct()
    {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_places","docker","docker");
    }

    public function insert(Place $place){
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

    }

    public function findMany(){

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
