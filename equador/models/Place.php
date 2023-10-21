<?php 
require_once "config.php";
class Place{
    public $id;
    private $name;
    private $contact;
    private $opening_hours;
    private $description;
    private $latitude;
    private $longitude;

    public function __construct($name=null) {
        $this-> id = uniqid();
        $this-> name = $name();
    }
    public function save(){
        $data = [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "contact" => $this->getContact(),
            "opening_hours" => $this->getOpeningHours(),
            "description" => $this->getDescription(),
            "latitude" => $this->getLatitude(),
            "longitude" => $this->getLongitude()
        ];
    
        $allData= readFileContent(FILE_CITY);
        array_push($allData, $data);
        saveFileContent(FILE_CITY, $allData);    
    }
    public function list(){
        $allData = readFileContent(FILE_CITY);
        return $allData;
    }

    public function delete($id){
        $allData = readFileContent(FILE_CITY);

        $itemsFiltered = array_values(array_filter($allData, function ($item) use ($id) {
            return $item->id !== $id;
        }));
    
          
        saveFileContent(FILE_CITY, $itemsFiltered);

    }
  
    public function getName()
    {
        return $this->name;
    }  
    public function setName($name)
    {
        $this->name = $name;
    }

    
    public function getContact()
    {
        return $this->contact;
    }

    public function setContact($contact)
    {
        $this->contact = $contact;
    }

  
    public function getOpeningHours()
    {
        return $this->opening_hours;
    }

    public function setOpeningHours($opening_hours)
    {
        $this->opening_hours = $opening_hours;
    }

    
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }

   
    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

  
    public function getLongitude()
    {
        return $this->longitude;
    }
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

       public function getId()
    {
        return $this->id;
    }
}
?>