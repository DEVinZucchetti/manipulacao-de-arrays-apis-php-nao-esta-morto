<?php 
class Place {
    private $id, $name, $contact, $opening_hours, $description, $latitude, $longitude;

    public function __construct($name)
    {
        $this->id = uniqid();
        $this->name =   $name;
    }
}
