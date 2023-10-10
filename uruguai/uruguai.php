<?php

// Caminho do arquivo de armazenamento de lugares do Uruguai
$arquivoUruguai = "uruguai.txt";

// Função para ler os lugares do arquivo
function lerLugaresUruguai() {
    global $arquivoUruguai;
    if (file_exists($arquivoUruguai)) {
        $conteudo = file_get_contents($arquivoUruguai);
        return json_decode($conteudo, true);
    }
    return [];
}

// Função para salvar os lugares no arquivo
function salvarLugaresUruguai($lugares) {
    global $arquivoUruguai;
    $conteudo = json_encode($lugares, JSON_PRETTY_PRINT);
    file_put_contents($arquivoUruguai, $conteudo);
}

// Rota para cadastro de lugar (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validar os campos obrigatórios
    $requiredFields = ['name', 'contact', 'opening_hours', 'description', 'latitude', 'longitude'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            http_response_code(400); // Bad Request
            echo json_encode(array('message' => 'Campo obrigatório ausente: ' . $field));
            exit();
        }
    }

    // Ler os lugares existentes
    $lugares = lerLugaresUruguai();

    // Verificar se o lugar já existe pelo nome
    foreach ($lugares as $lugar) {
        if ($lugar['name'] === $data['name']) {
            http_response_code(400); // Bad Request
            echo json_encode(array('message' => 'Lugar com o mesmo nome já existe.'));
            exit();
        }
    }

    // Adicionar o novo lugar
    $data['id'] = uniqid(); // Gerar um ID único para o lugar
    $lugares[] = $data;

    // Salvar os lugares atualizados
    salvarLugaresUruguai($lugares);

    http_response_code(201); // Created
    echo json_encode(array('message' => 'Lugar cadastrado com sucesso.', 'id' => $data['id']));
}

// Rota para listagem de lugares (GET)
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $lugares = lerLugaresUruguai();
    echo json_encode($lugares);
}

// Rota para deleção de lugar (DELETE)
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $idLugar = $_GET['id']; // Supondo que o ID do lugar seja passado como parâmetro

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
        http_response_code(404); // Not Found
        echo json_encode(array('message' => 'Lugar não encontrado.'));
    }
}

// Rota para atualização de lugar (PUT)
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $idLugar = $_GET['id']; // Supondo que o ID do lugar seja passado como parâmetro
    $data = json_decode(file_get_contents('php://input'), true);

    $lugares = lerLugaresUruguai();

    $updated = false;
    foreach ($lugares as &$lugar) {
        if ($lugar['id'] == $idLugar) {
            // Atualize as informações necessárias do lugar
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
        http_response_code(404); // Not Found
        echo json_encode(array('message' => 'Lugar não encontrado.'));
    }
}

// Rota para visualização de lugar (GET)
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $idLugar = $_GET['id']; // Supondo que o ID do lugar seja passado como parâmetro

    $lugares = lerLugaresUruguai();

    foreach ($lugares as $lugar) {
        if ($lugar['id'] == $idLugar) {
            echo json_encode($lugar);
            exit();
        }
    }

    http_response_code(404); // Not Found
    echo json_encode(array('message' => 'Lugar não encontrado.'));
}

?>