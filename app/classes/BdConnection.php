<?php

namespace cefet\SyncLab\classes;

use PDO;
use PDOException;

class BdConnection
{
    private static ?BdConnection $instance = null;
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn = null;

    /**
     * Construtor privado para implementar o padrão Singleton.
     */
    private function __construct() {
        $this->servername = getenv('BANCO_SERVERNAME');
        $this->username = getenv('BANCO_USERNAME');
        $this->password = getenv('BANCO_PASSWORD');
        $this->dbname = getenv('BANCO_DATABASE');


        try {
            // Criando a conexão com PDO
            $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
            // Definindo o modo de erro do PDO como exceções
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e);
            die("Conexão falhou: " . $e->getMessage());
        }
    }

    /**
     * Retorna a instância singleton da classe ConexaoBD.
     *
     * @return BdConnection A instância da conexão com o banco de dados.
     */
    public static function getInstance(): BdConnection
    {
        if (self::$instance === null) {
            self::$instance = new BdConnection();
        }
        return self::$instance;
    }

    /**
     * Retorna a conexão com o banco de dados.
     *
     * @return PDO|null A conexão PDO ou null.
     */
    public function getConnection(): ?PDO {
        if ($this->conn === null) {
            $this->reconnect();
        }
        return $this->conn;
    }

    /**
     * Fecha a conexão com o banco de dados.
     */
    public function closeConnection(): null
    {
        if ($this->conn != null) {
            $this->conn = null;
        }
        return null;
    }

    /**
     * Tenta reconectar ao banco de dados.
     */
    public function reconnect(): void
    {
        try {
            $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Falha na reconexão: " . $e->getMessage());
        }
    }

}