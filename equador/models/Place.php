<?php 
class Place{
    public $id;
    private $name;
    private $contact;
    private $opening_hours;
    private $description;
    private $latitude;
    private $longitude;

    public function __construct($name) {
        $this-> id = uniqid();
        $this-> name = $name();
    }

  
    
}
?>