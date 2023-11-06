<?php 
require_once 'utils.php';
require_once 'models/Review.php';
require_once 'models/ReviewDAO.php'; 

class ReviewsController {
    public function create() {
        $body = getBody();

    $place_id = sanitizeInput($body, 'place_id', FILTER_SANITIZE_SPECIAL_CHARS); 
    $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
    $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);

    $prohibited_words = ['polimorfismo', 'herança', 'abstração', 'encapsulamento'];

    if (!$place_id) responseError(400, 'Id do lugar ausente');
    if (!$name) responseError(400, 'Descrição da avaliação ausente');
    if (!$email) responseError(400, 'Email ausente');
    if (!$stars) responseError(400, 'Quantidade de estrelas ausente');
    

    if (strlen($name) > 200) responseError(400, 'O texto ultrapassou o limite');

    foreach ($prohibited_words as $word) {
        if (str_contains(strtolower($name), $word)) {
            $name = str_ireplace($word, '[EDITADO PELO ADMIN]', $name);
        }
    }


    // maneira de salvar um arquivo 
    $review = new Review($place_id);
    $review->setName($name);
    $review->setEmail($email);
    $review->setStars($stars);
    $review->save();

    $reviewDAO = new ReviewDAO();
    $result = $reviewDAO->insert($review);

    if($result['success'] === true) {
        response(201, ['message' => 'Cadastrado com sucesso!']);
        
    } else {
        responseError(400, "Não foi possível enviar a avaliação");
    }
    }

    public function list() {
        $place_id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS, false);

    if (!$place_id) responseError(400, 'ID do lugar esta ausente');

    $reviewDAO = new ReviewDAO();
    $result = $reviewDAO->list($place_id);
    
    response(200, $result);

    }

    public function update() {
        $body = getBody();
    $id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS, false);

    $status = sanitizeInput($body, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$id) {
        responseError(400, ['message' => 'ID ausente!']);
    }
    if (!$status) {
        responseError(400, 'Status ausente');
    }

    $reviewDAO = new ReviewDAO();
    $reviewDAO->update($id, $status); 

    response(200, ['message' => 'Atualizado com sucesso!']);
    }
}
