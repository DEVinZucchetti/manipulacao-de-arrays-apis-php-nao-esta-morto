<?php

$arquivoUruguai = "uruguai.txt";


function lerLugaresUruguai() {
    global $arquivoUruguai;
    if (file_exists($arquivoUruguai)) {
        $conteudo = file_get_contents($arquivoUruguai);
        return json_decode($conteudo, true);
    }
    return [];
}


function salvarLugaresUruguai($lugares) {
    global $arquivoUruguai;
    $conteudo = json_encode($lugares, JSON_PRETTY_PRINT);
    file_put_contents($arquivoUruguai, $conteudo);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    
    $requiredFields = ['name', 'contact', 'opening_hours', 'description', 'latitude', 'longitude'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            http_response_code(400); 
            echo json_encode(array('message' => 'Campo obrigatório ausente: ' . $field));
            exit();
        }
    }

    
    $lugares = lerLugaresUruguai();

    
    foreach ($lugares as $lugar) {
        if ($lugar['name'] === $data['name']) {
            http_response_code(400); 
            echo json_encode(array('message' => 'Lugar com o mesmo nome já existe.'));
            exit();
        }
    }

    
    $data['id'] = uniqid(); 
    $lugares[] = $data;

   
    salvarLugaresUruguai($lugares);

    http_response_code(201);
    echo json_encode(array('message' => 'Lugar cadastrado com sucesso.', 'id' => $data['id']));
}


elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $lugares = lerLugaresUruguai();
    echo json_encode($lugares);
}


elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $idLugar = $_GET['id']; 

    $lugares = lerLugaresUruguai();
    $lugaresAtualizados = array();

    $found = false;
    foreach ($lugares as $lugar) {
        if ($lugar['id'] == $idLugar) {
            $found = true;
        } else {
            $lugaresAtualizados[] = $lugar;
        }
    }

    if ($found) {
        salvarLugaresUruguai($lugaresAtualizados);
        echo json_encode(array('message' => 'Lugar deletado com sucesso.'));
    } else {
        http_response_code(404); 
        echo json_encode(array('message' => 'Lugar não encontrado.'));
    }
}


elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $idLugar = $_GET['id']; 
    $data = json_decode(file_get_contents('php://input'), true);

    $lugares = lerLugaresUruguai();

    $updated = false;
    foreach ($lugares as &$lugar) {
        if ($lugar['id'] == $idLugar) {
           
            foreach ($data as $key => $value) {
                if (isset($lugar[$key])) {
                    $lugar[$key] = $value;
                }
            }
            $updated = true;
        }
    }

    if ($updated) {
        salvarLugaresUruguai($lugares);
        echo json_encode(array('message' => 'Lugar atualizado com sucesso.'));
    } else {
        http_response_code(404); 
        echo json_encode(array('message' => 'Lugar não encontrado.'));
    }
}


elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $idLugar = $_GET['id']; 

    $lugares = lerLugaresUruguai();

    foreach ($lugares as $lugar) {
        if ($lugar['id'] == $idLugar) {
            echo json_encode($lugar);
            exit();
        }
    }

    http_response_code(404); 
    echo json_encode(array('message' => 'Lugar não encontrado.'));
}

?>