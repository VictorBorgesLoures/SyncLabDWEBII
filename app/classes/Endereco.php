<?php

namespace cefet\SyncLab\classes;

use PDO;

class Endereco
{
    private $conn;
    public function __construct()
    {
        $this->conn = BdConnection::getInstance()->getConnection();
    }

    public function getEndereco(string $cep): array
    {
        $sql = "SELECT * FROM endereco WHERE cepEnd = :cep";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cep', $cep);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verificarCepExistente(string $cep): ?int
    {
        $sql = "SELECT idEnd FROM endereco WHERE cepEnd = :cep";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cep', $cep);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['idEnd'] ?? null;
    }

    public function inserirEndereco(string $cep, string $adreess): int
    {
        $sql = "INSERT INTO endereco (cepEnd, ruaEnd) VALUES (:cep, :adreess)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':adreess', $adreess);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }


}