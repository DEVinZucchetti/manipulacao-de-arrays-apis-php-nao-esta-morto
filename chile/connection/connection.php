<?php

class ConexaoBD {
    private $host;
    private $dbname;
    private $usuario;
    private $senha;
    private $charset;
    private $pdo;

    public function __construct($host, $dbname, $usuario, $senha, $charset = 'utf8') {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->charset = $charset;

        $this->conectar();
    }

    private function conectar() {
        $dsn = "pgsql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

        try {
            $this->pdo = new PDO($dsn, $this->usuario, $this->senha);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public function getPDO() {
        return $this->pdo;
    }
}

    $host = "localhost";
    $dbname = "chile";
    $usuario = "docker";
    $senha = "docker";

    $conexao = new ConexaoBD($host, $dbname, $usuario, $senha);

    $pdo = $conexao->getPDO();
?>