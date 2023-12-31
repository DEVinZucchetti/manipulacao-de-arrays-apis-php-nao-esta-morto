<?php

require_once './utils.php';
//nome da classe
//atributos

//enum = enumarador de opções
/* enum ReviewsStatus {
    case 1: 'PENDENTE';
    case 2: 'FINALIZADO';
    case 3: 'REPROVADO';
} */

class Review
{
    private $id, $place_id, $name, $email, $stars, $date, $status;

    public function __construct($place_id = null)
    {
        $this->id = uniqid();
        $this->place_id = $place_id;
        $this->date = (new DateTime())->format('d/m/Y H:i');
        $this->status = 'PENDENTE';
    }

    public function save()
    {
        $data = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'stars' => $this->getStars(),
            'date' => $this->getDate(),
            'place_id' => $this->getPlace_id(),

        ];

        $allData = readFileContent('reviews.txt');
        array_push($allData, $data);
        saveFileContent('reviews.txt', $allData);
    }

    public function list()
    {
        $allData = readFileContent('reviews.txt');
        $filtered = array_values(array_filter($allData, function ($review) {
            return $review->place_id === $this->getPlace_id();
        }));
        return $filtered;
    }

    public function updateStatus($id, $status)
    {
        $allData = readFileContent('reviews.txt');

        foreach ($allData as $position => $item) {
            if ($item->id === $id) {
                $allData[$position]->status = $status;
            }
        }
        saveFileContent('reviews.txt', $allData);
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
