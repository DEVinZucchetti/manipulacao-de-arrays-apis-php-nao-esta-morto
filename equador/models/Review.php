<?php
require_once "./utils.php";
class Review
{
    private $id, $name, $email, $stars, $date, $status, $place_id;

    public function __construct($place_id) 
    {
        $this->id = uniqid();
        $this->place_id = $place_id;
       $this->date = (new DateTime())-> format("d/m/Y h:m");
    }

    public function save()
    {
        $data = [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "email" => $this->getEmail(),
            "stars" => $this->getStars(),
            "date" => $this->getDate(),
            "status" => $this->getStatus(),
            "place_id" => $this->getId(),

        ];

        $allData = readFileContent(FILE_REVIEWS);
        array_push($allData, $data);
        saveFileContent(FILE_REVIEWS, $allData);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getStars()
    {
        return $this->stars;
    }
    public function setStars($stars)
    {
        $this->stars = $stars;
    }

    public function getDate()
    {
        return $this->date;
    }
   

    public function getStatus()
    {
        return $this->status;
    }   
    public function setStatus($status)
    {
        $this->status = $status;
    }
    

    public function getPlace_id()
    {
        return $this->place_id;
    }
   
}
