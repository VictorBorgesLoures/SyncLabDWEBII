<?php

namespace cefet\SyncLab\classes;

use PDO;
use PDOException;

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = BdConnection::getInstance()->getConnection();
    }

    /** Realize the login of the user
     * @param string $username
     * @param string $senha
     * @return array|null
     * @throws PDOException
     */
    public function login(string $username, string $senha): ?array
    {
        try {
            $stmt = $this->conn->prepare("SELECT idUsuario, username, email, senha, tipo_usuario FROM Usuario WHERE email = :email OR username = :username");

            $stmt->bindParam(':email', $username);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $this->conn->prepare("SELECT tipoMat FROM matricula WHERE fk_Usuario_idUsuario = :idUser AND statusMat = 'Ativo'");
            $stmt->bindParam(':idUser', $user['idUsuario']);
            $stmt->execute();

            $user['tipoMat'] = [];
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $matricula) {
                $user['tipoMat'][] = $matricula['tipoMat'];
            }

            if ($user) {
                if (password_verify($senha, $user['senha'])) {
                    return $user;
                }
            }

            return null;
        } catch (\PDOException $e) {
            throw new \PDOException("Erro ao realizar o login: " . $e->getMessage());
        }
    }

    /** Get the name of the user
     * @param string $username
     * @return string
     */
    public function getNomeUser(string $username): string
    {
        $sql = "SELECT nome FROM usuario WHERE username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /** verify if the email is already registered
     * @param string $email
     * @return bool
     */
    public function verifyEmailExists(string $email): bool
    {
        $sql = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /** Register a new user
     * @param string $name
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $cpf
     * @param string $birthdate
     * @param string $complemento
     * @param int $numero
     * @param int $fk_end
     * @return false|string
     */
    public function insertUser(string $name, string $username, string $password, string $email, string $cpf, string $birthdate, string $complemento, int $numero, int $fk_end): false|string
    {
        $hash_senha = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (nome, username, email, senha, cpf_, dataNasc, complemento_, numero_, fk_Endereco_idEnd) VALUES (:name, :username, :email, :password, :cpf, :birthdate, :complemento, :numero, :fk_end)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hash_senha);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':birthdate', $birthdate);
        $stmt->bindParam(':complemento', $complemento);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':fk_end', $fk_end);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function requisitarMatricula(int $idUsuario, int $tipo, int $matricula): false|string
    {
        $sql = "INSERT INTO matricula (tipoMat, matriculaMat, fk_Usuario_idUsuario) 
                    VALUES (:tipoMat, :matriculaMat, :fk_Usuario_idUsuario)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tipoMat', $tipo);
        $stmt->bindParam(':matriculaMat', $matricula);
        $stmt->bindParam(':fk_Usuario_idUsuario', $idUsuario);

        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function carregarMatriculasAtivas(int $idUsuario): array
    {
        $sql = "SELECT m.idMat, m.matriculaMat, m.tipoMat, m.statusMat FROM matricula as m, usuario as u
                    WHERE m.fk_Usuario_idUsuario=:idUsuario
                        and m.statusMat='Ativo'
                        and u.idUsuario=:idUsuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
        $matriculas = $stmt->fetchAll();
        if (!$matriculas)
            $matriculas = [];

        return $matriculas;
    }

    public function carregarMatriculasEmAnalise(int $idUsuario): array
    {
        $sql = "SELECT m.matriculaMat, m.tipoMat FROM matricula as m, usuario as u
        WHERE m.fk_Usuario_idUsuario=:idUsuario
            and m.statusMat='Em análise'
            and u.idUsuario=:idUsuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
        $matriculas = $stmt->fetchAll();
        if (!$matriculas)
            $matriculas = [];
        return $matriculas;
    }

    public function ehMatriculaValida(int $idUsuario, int $idMatricula): bool
    {
        $sql = "SELECT m.idMat FROM matricula as m, usuario as u
                    WHERE m.fk_Usuario_idUsuario=:idUsuario
                        and u.idUsuario=:idUsuario
                        and m.idMat =:idMatricula";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':idMatricula', $idMatricula);
        $stmt->execute();

        return $stmt->columnCount() > 0;
    }

    public function getMatricula($idMat)
    {
        $stmt = $this->conn->prepare("SELECT * FROM matricula WHERE idMat = :idMat");
        $stmt->bindParam(':idMat', $idMat);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTypeMatricula($idMat)
    {
        $stmt = $this->conn->prepare("SELECT tipoMat FROM Matricula WHERE idMat = :idMat");
        $stmt->bindParam(':idMat', $idMat);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
