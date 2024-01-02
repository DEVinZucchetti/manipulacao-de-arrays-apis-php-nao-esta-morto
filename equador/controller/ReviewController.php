<?php 
require_once '../utils.php';
require_once '../models/Review.php';
require_once '../models/ReviewDAO.php';

class ReviewController{
    public function create(){
        $body = getBody();

    // 2. pego os dados 
    $place_id = sanitizeInput($body, "place_id", FILTER_SANITIZE_SPECIAL_CHARS);
    $name = sanitizeInput($body, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = sanitizeInput($body, "email", FILTER_VALIDATE_EMAIL);
    $stars = sanitizeInput($body, "stars", FILTER_VALIDATE_FLOAT);


    // 3. valido os dados
    if (!$place_id) responseError("Id do lugar ausente", 400);
    if (!$name) responseError("Descripcao da avaliacao ausente", 400);
    if (!$email) responseError("Email inválido", 400);
    if (!$stars) responseError("Quantidade de estrelas ausente", 400);
    //validar name max:200 caracteres
    if (strlen($name) > 200) responseError("O texto ultrapassou o limite", 400);

    
    $review = new Review($place_id);
    $review->setName($name);
    $review->setEmail($email);
    $review->setStars($stars);

    $reviewDAO = new ReviewDAO();
    $result = $reviewDAO->create($review);

    if($result['success'] === true){
        response(["message" => " Cadastro com sucesso"], 201);
    }else{
        responseError("Nao foi possivel realizar o cadastro",400);
    }

    response(["message" => "Cadastrado com sucesso"], 201);

    }

    public function list(){
        var_dump($_GET);
        $place_id = sanitizeInput($_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS, false);
    
        if (!$place_id) responseError("ID do lugar está ausente", 400);
    
       $reviewDAO = new ReviewDAO($place_id);  
       $result = $reviewDAO->findMany(); 

       response($result, 200);
    }

    public function update(){        
        $body = getBody();
        $id = sanitizeInput($_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS,false);
    
        $status = sanitizeInput($body, "status", FILTER_SANITIZE_SPECIAL_CHARS);
    
        if(!$status){
            responseError("Status ausente",400);
        }
    
        $review =new Review();
        $review->updateStatus($id,$status);
    
        response(["message" => "Atualizado com sucesso"],200);
    }

}

?>