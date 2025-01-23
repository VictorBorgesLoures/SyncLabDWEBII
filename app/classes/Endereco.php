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

    /** Return the address data from the database
     * @param string $cep CEP to be searched
     * @return array Address data
     */
    public function getAdreess(string $cep): array
    {
        $sql = "SELECT * FROM endereco WHERE cep = :cep";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cep', $cep);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** Check if the CEP already exists in the database
     * @param string $cep CEP to be checked
     * @return int|null ID of the address if it exists
     */
    public function checkExistingCep(string $cep): ?int
    {
        $sql = "SELECT idEnd FROM endereco WHERE cep = :cep";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cep', $cep);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['idEnd'] ?? null;
    }

    /** Insert a new address in the database
     * @param string $cep CEP to be inserted
     * @param string $adreess Address to be inserted
     * @return int ID of the inserted address
     */
    public function insertAdreess(string $cep, string $adreess): int
    {
        $sql = "INSERT INTO endereco (cep, ruaEnd) VALUES (:cep, :adreess)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':adreess', $adreess);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }


}