<?php 
require_once "config.php";
require_once "config.php";

    class Place{
        private $id, $name, $contact, $openingHours, $description, $latitude, $longitude;

        public function __construct($name = null) {
            $this->name = $name;
        }

        public function save() {
            $data = [
                'id' => $this->getId(),
                'name' => $this->getName(),
                'contact' => $this->getContact(),
                'openingHours' => $this->getOpeningHours(),
                'description' => $this->getDescription(),
                'latitude' => $this->getLatitude(),
                'longitude' => $this->getLongitude()
            ];
    
            $allData = $this->getAll();
            array_push($allData,  $data);
            saveFileContent(FILE_CITY, $allData);
            response($data, 201);
        }

        public function getAll() {
            $allData = readFileContent(FILE_CITY);
            return $allData;
        }

        public function getPlaceById($id) {
            $places = $this->getAll();
    
            foreach ($places as $place) {
                if ($place->id === $id) {
                    response($place, 200);
                }
            }
            responseError('Lugar não encontrado', 404);
        }
    
        public function deletePlace($id) {
            $places = $this->getAll();
    
            foreach ($places as $key => $place) {
                if ($place->id === $id) {
                    unset($places[$key]);
                    saveFileContent(FILE_CITY, $places);
                    response('', 204);
                }
            }
            responseError('ID não encontrado', 404);
        }
    
        public function updatePlace($id, $data) {
            $places = $this->getAll();
    
            foreach ($places as $key => $place) {
                if ($place->id === $id) {
                    foreach ($data as $field => $value) {
                        if (property_exists($place, $field)) {
                            if ($field === 'latitude' || $field === 'longitude') {
                                $places[$key]->$field = filter_var($value, FILTER_VALIDATE_FLOAT);
                            } else {
                                $places[$key]->$field = sanitizeString($value);
                            }
                        }
                    }
                    saveFileContent(FILE_CITY, $places);
                    response($places[$key], 200);
                }
            }
            responseError('ID não encontrado', 404);
        }
    
        public function getId() {
            return $this->id;
        }
        public function getName() {
            return $this->name;
        }
        public function setName($name) {
            $this->name = $name;
        }
    
        public function getContact() {
            return $this->contact;
        }
        public function setContact($contact) {
            $this->contact = $contact;
        }
    
        public function getOpeningHours() {
            return $this->openingHours;
        }
        public function setOpeningHours($openingHours) {
            $this->openingHours = $openingHours;
        }
    
        public function getDescription() {
            return $this->description;
        }
        public function setDescription($description) {
            $this->description = $description;
        }
    
        public function getLatitude() {
            return $this->latitude;
        }
        public function setLatitude($latitude) {
            $this->latitude = $latitude;
        }
    
        public function getLongitude() {
            return $this->longitude;
        }
        public function setLongitude($longitude) {
            $this->longitude = $longitude;
        }
    }
?>