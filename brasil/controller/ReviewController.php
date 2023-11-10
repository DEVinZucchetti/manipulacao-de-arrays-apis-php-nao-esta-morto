<?php
require_once 'utils.php';
require_once 'models/Review.php';



class ReviewController
{

 public function create()
 {
  $body = getBody();
  $blacklist = ['polimorfismo',  'herança', 'abstração', 'encapsulamento'];

  $place_id = sanitizeInput($body, 'place_id', FILTER_SANITIZE_SPECIAL_CHARS);
  $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
  $email = sanitizeInput($body, 'email', FILTER_VALIDATE_EMAIL);
  $stars = sanitizeInput($body, 'stars', FILTER_VALIDATE_FLOAT);

  if (!$place_id) responseError('Parece que o mapa do tesouro está incompleto sem o ID do local. Por favor, adicione-o para que possamos navegar corretamente.', 400);
  if (!$name) responseError('Está faltando a legenda da nossa história de avaliação. Escreva-a para lançar sua estrela no universo das revisões.', 400);
  if (!$email) responseError('Hmm, seu e-mail parece ter caído em um buraco negro. Verifique e tente novamente, com toda a precisão de um lançamento espacial.', 400);
  if (!$stars) responseError('Quantas estrelas este lugar merece no seu céu? Informe o brilho de sua avaliação para continuarmos.', 400);

  if (strlen($name) > 200) responseError('Seu texto é uma saga épica! Mas vamos precisar de uma versão resumida - limite-se a 200 caracteres, por favor.', 400);

  foreach ($blacklist as $word) {
   if (str_contains(strtolower($name), $word)) {
    $name = str_ireplace($word, '[EDITADO PELO ADMIN]', $name);
   }
  }

  $review = new Review($place_id);
  $review->setName($name);
  $review->setEmail($email);
  $review->setStars($stars);
  $review->save();

  response(['message' => 'Avaliação enviada com sucesso. Após a análise, ela ficará visível para todos.'], 201);
 }

 public function list()
 {
  $place_id = sanitizeInput($_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS, false);

  if (!$place_id) responseError('Faltando ID do local.', 400);

  $reviews = new Review($place_id);

  response($reviews->list(), 200);
 }

 public function update()
 {
  $body = getBody();
  $id =  sanitizeInput($_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS, false);

  $status = sanitizeInput($body,  'status', FILTER_SANITIZE_SPECIAL_CHARS);

  if (!$id) responseError('Faltando ID da Avaliação. Insira.', 400);
  if (!$status) responseError('Faltando Status. Insira.', 400);

  $review = new Review();
  $review->updateStatus($id, $status);
  response("Alteração de status para $status realizada com sucesso.", 200);
 }
}
