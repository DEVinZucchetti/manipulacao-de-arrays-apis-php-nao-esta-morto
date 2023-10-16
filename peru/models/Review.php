<?php

require_once '../utils.php';

class Review
{

    private $place_id, $id, $name, $email, $stars, $date, $status;

    public function __construct($place_id)
    {
        $this->id = uniqid();
        $this->place_id = $place_id;
        $this->date = (new DateTime())->format('d/m/Y h:m');
    }

    public function save() {
        $data = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'stars' => $this->getStars(),
            'status' => $this->getStatus(),
            'place_id' => $this->getPlace_id(),
            'date' => $this->getDate()
        ]

        $allData = readFileContent('review.txt');
        array_push($allData, $data);

    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
}