<?php

namespace cefet\SyncLab\classes;

use cefet\SyncLab\Helper\Helpers;
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
            $stmt = $this->conn->prepare("SELECT idUsuario, username, email, senha FROM usuario WHERE email = :email OR username = :username");

            $stmt->bindParam(':email', $username);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

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
    public function verifyUserExists(string $email): bool
    {
        $sql = "SELECT * FROM usuario WHERE email = :email || username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $email);
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
        $stmt = $this->conn->prepare("SELECT tipoMat FROM matricula WHERE idMat = :idMat");
        $stmt->bindParam(':idMat', $idMat);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getReqMatriculas() {
        $stmt = $this->conn->prepare("SELECT m.idMat, m.matriculaMat, m.tipoMat, m.statusMat, u.username, u.cpf_, m.dataCriacaoMat FROM matricula as m, usuario as u WHERE u.idUsuario=m.fk_Usuario_idUsuario");
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!$result)
            $result = [];
        return $result;
    }

    public function getReqProjetos() {
        $stmt = $this->conn->prepare("SELECT p.idProj, p.nomeProj, p.descricaoProj, p.statusProj, u.username, m.matriculaMat as matricula, p.dataCriacaoProj FROM projeto as p, matricula as m, usuario as u WHERE p.fk_Matricula_idMat_=m.idMat and u.idUsuario=m.fk_Usuario_idUsuario");
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!$result)
            $result = [];
        return $result;
    }

    public function setNovoStatusRequisicao(string $tabela, int $id, string $novoStatus) {
        if(($tabela != "matricula" && $tabela != "projeto") || $novoStatus == "Em análise")
            return false;
        $campoStatus = "statusMat";
        $campoId = "idMat";
        if($tabela == "projeto") {
            $campoStatus = "statusProj";
            $campoId = "idProj";
        }
        $sql = "UPDATE ".$tabela." SET ".$campoStatus."=:novoStatus WHERE ".$campoId."=:id LIMIT 1;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':novoStatus', $novoStatus);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function getProjetos(int $idMat) {
        $sql = "SELECT p.idProj, p.nomeProj, p.descricaoProj, p.statusProj, u.username as tutor, u2.username as criador, p.dataCriacaoProj
                    FROM projeto as p
                    JOIN matricula as m ON p.fk_Matricula_idMat = m.idMat
                    JOIN usuario as u ON m.fk_Usuario_idUsuario = u.idUsuario
                    JOIN matricula as m2 ON p.fk_Matricula_idMat = m2.idMat
                    JOIN usuario as u2 ON m2.fk_Usuario_idUsuario = u2.idUsuario
                    WHERE m.idMat = :idMat AND p.statusProj = 'Ativo'
    
                    UNION DISTINCT
                    
                    SELECT p.idProj, p.nomeProj, p.descricaoProj, p.statusProj, u.username as tutor, u2.username as criador, p.dataCriacaoProj
                    FROM  projeto as p
                    JOIN integra as i ON i.fk_Projeto_idProj = p.idProj
                    JOIN matricula as m ON p.fk_Matricula_idMat = m.idMat
                    JOIN usuario as u ON m.fk_Usuario_idUsuario = u.idUsuario
                    JOIN matricula as m2 ON p.fk_Matricula_idMat_ = m2.idMat
                    JOIN usuario as u2 ON m2.fk_Usuario_idUsuario = u2.idUsuario
                    WHERE i.fk_Matricula_idMat = :idMat AND p.statusProj = 'Ativo' AND i.status = 'Ativo';
                ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':idMat', $idMat);        
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!$result)
            $result = [];
        return $result;
    }

    public function requisitarProjeto($idMat, $nomeProj, $descricaoProj): false|string
    {
        $sql = "INSERT INTO projeto (nomeProj, descricaoProj, fk_Matricula_idMat, fk_Matricula_idMat_) 
        VALUES (:nomeProj, :descricaoProj, :idMat, :idMat)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nomeProj', $nomeProj);
        $stmt->bindParam(':descricaoProj', $descricaoProj);
        $stmt->bindParam(':idMat', $idMat);

        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getProjeto($idProj)
    {
        $sql = "SELECT 
                    p.idProj, 
                    p.nomeProj, 
                    p.descricaoProj, 
                    p.statusProj, 
                    p.dataCriacaoProj,
                    p.dataAtualizacao,
                    u.nome AS tutor, 
                    u2.username AS criador
                FROM projeto AS p
                INNER JOIN matricula AS m ON p.fk_Matricula_idMat = m.idMat
                INNER JOIN usuario AS u ON m.fk_Usuario_idUsuario = u.idUsuario
                INNER JOIN matricula AS m2 ON p.fk_Matricula_idMat_ = m2.idMat
                INNER JOIN usuario AS u2 ON m2.fk_Usuario_idUsuario = u2.idUsuario
                WHERE p.idProj = :idProj";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idProj', $idProj, PDO::PARAM_INT);
        $stmt->execute();

        $projeto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$projeto) {
            return null;
        }

        $sqlDiscentes = "SELECT 
                            u3.nome AS discente_nome,
                            m3.idMat as matricula_id,
                            m3.matriculaMat AS discente_matricula,
                            m3.tipoMat, 
                            i.dataInicio,
                            i.dataFim
                         FROM integra AS i
                         INNER JOIN matricula AS m3 ON i.fk_Matricula_idMat = m3.idMat
                         INNER JOIN usuario AS u3 ON m3.fk_Usuario_idUsuario = u3.idUsuario
                         WHERE i.fk_Projeto_idProj = :idProj AND (i.status = 'Ativo' OR i.status = 'Finalizado')";

        $stmt2 = $this->conn->prepare($sqlDiscentes);
        $stmt2->bindParam(':idProj', $idProj, PDO::PARAM_INT);
        $stmt2->execute();

        $participantes = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $projeto['participantes'] = $participantes;

        return $projeto;
    }

    public function getRequisicoesParticipacao(int $id)
    {
        $sql = "SELECT 
                    u.nome AS discente_nome,
                    m.matriculaMat AS discente_matricula,
                    i.fk_Matricula_idMat,
                    i.fk_Projeto_idProj,
                    i.status
                FROM integra AS i
                INNER JOIN matricula AS m ON i.fk_Matricula_idMat = m.idMat
                INNER JOIN usuario AS u ON m.fk_Usuario_idUsuario = u.idUsuario
                WHERE i.fk_Projeto_idProj = :id
                  AND i.status = 'Em análise'";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizaParticipacao($idProj, $idDiscente, $status)
    {
        $sql = "UPDATE integra SET status = :status, dataInicio = CURRENT_TIMESTAMP WHERE fk_Projeto_idProj = :idProj AND fk_Matricula_idMat = :idDiscente";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idProj', $idProj, PDO::PARAM_INT);
        $stmt->bindParam(':idDiscente', $idDiscente, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function getDiscentes()
    {
        $sql = "SELECT u.idUsuario, u.nome, m.matriculaMat, m.tipoMat FROM usuario as u, matricula as m 
                          WHERE u.idUsuario = m.fk_Usuario_idUsuario && m.tipoMat = 3";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!$result)
            $result = [];
        return $result;
    }

    public function listarPossiveisIntegrantes($idProj): false|array
    {
        $sql = "SELECT u.idUsuario, u.nome, m.matriculaMat, m.tipoMat, m.idMat 
                    FROM usuario AS u
                    JOIN matricula AS m ON u.idUsuario = m.fk_Usuario_idUsuario
                    WHERE m.tipoMat != 1 AND NOT EXISTS (
                        SELECT 1 FROM integra 
                        WHERE fk_Matricula_idMat = m.idMat 
                        AND fk_Projeto_idProj = :idProj 
                        AND status = 'Ativo'
                )";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idProj', $idProj);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!$result)
            $result = [];
        return $result;
    }

    public function ehTutorOuCotutor($idProj, $idMat) {
        $sql = "SELECT m.idMat FROM integra as i, matricula as m
            WHERE m.idMat=:idMat AND i.fk_Matricula_idMat=m.idMat AND m.tipoMat = 2 AND i.fk_Projeto_idProj = :idProj
            UNION 
            SELECT fk_Matricula_idMat FROM projeto WHERE idProj = :idProj AND fk_Matricula_idMat= :idMat;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idProj', $idProj);
        $stmt->bindParam(':idMat', $idMat);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!$result)
            $result = [];
        return $result;
    }

    public function adicionarIntegrante($idProj, $idMat, $status) {
        try {
            $sql = "INSERT INTO integra (fk_Projeto_idProj, fk_Matricula_idMat, status, dataInicio) VALUES (:idProj, :idMat, :status, CURRENT_TIMESTAMP)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idProj', $idProj);
            $stmt->bindParam(':idMat', $idMat);
            $stmt->bindParam(':status', $status);

            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (\PDOException $e) {
            error_log("Erro no PDO: " . $e->getMessage());
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
            exit;
        }
    }

    public function finalizarParticipacao(int $idProj, int $idMat)
    {
        $sql = "UPDATE integra as i SET i.status = 'Finalizado', i.dataFim = CURRENT_TIMESTAMP WHERE i.status='Ativo' AND fk_Projeto_idProj = :idProj AND fk_Matricula_idMat = :idMat LIMIT 1;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idProj', $idProj, PDO::PARAM_INT);
        $stmt->bindParam(':idMat', $idMat, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function getPossiveisTutores($id)
    {

        $sql = "SELECT u.idUsuario, u.nome, m.matriculaMat, m.tipoMat, m.idMat
                    FROM usuario AS u
                    JOIN matricula AS m ON u.idUsuario = m.fk_Usuario_idUsuario
                    WHERE m.tipoMat = 2 AND EXISTS(
                        SELECT 1 FROM integra
                        WHERE fk_Matricula_idMat = m.idMat
                        AND fk_Projeto_idProj = :id)
                ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!$result)
            $result = [];
        return $result;
    }

    public function alterarTutor(int $idProj, int $idMat): bool
    {
        $sql = "UPDATE projeto SET fk_Matricula_idMat = :idMat WHERE idProj = :idProj";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idProj', $idProj);
        $stmt->bindParam(':idMat', $idMat);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function listarPossiveisProjetos($idMat, $nomeProjeto = '') {
        $sql = "SELECT p.idProj, p.nomeProj, u.nome AS tutor
                FROM projeto AS p
                JOIN matricula AS m ON p.fk_Matricula_idMat = m.idMat
                JOIN usuario AS u ON m.fk_Usuario_idUsuario = u.idUsuario
                WHERE p.statusProj = 'Ativo'
                AND LOWER(p.nomeProj) LIKE LOWER(:nomeProjeto)
                AND :idMat not in (SELECT i.fk_Matricula_idMat from integra as i 
                WHERE i.fk_Projeto_idProj = p.idProj and i.status in ('Ativo', 'Em análise'));";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':nomeProjeto', '%' . $nomeProjeto . '%');
            $stmt->bindValue(':idMat', $idMat);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar projetos: " . $e->getMessage());
            return [];
        }
    }

    public function solicitarParticipacao(int $idProj, int $idMat)
    {
        $sql = "INSERT INTO integra (fk_Projeto_idProj, fk_Matricula_idMat, status) VALUES (:idProj, :idMat, 'Em análise')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idProj', $idProj);
        $stmt->bindParam(':idMat', $idMat);
        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function getAtivadades(int $idProj) {
        $sql = "SELECT *, :idProj as idProj from atividade where fk_Projeto_idProj=:idProj";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idProj', $idProj);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getUsuairoAtivadades(int $idMat) {
        $sql = "SELECT * from atividade as a, projeto as p, participa as par
        where par.fk_Matricula_idMat=:idMat
        AND par.fk_Atividade_idAtv=a.idAtv
        AND a.fk_Projeto_idProj=p.idProj";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idMat', $idMat);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function adicionarAtividade(int $idProj, bool $isDocente, string $tituloAtv, string $descricaoAtv, string $dataFimAtv) {
        $sql = "INSERT INTO atividade (fk_Projeto_idProj, tituloAtv, descricaoAtv, dataFimAtv";

        if ($isDocente) {
            $sql .= ", statusAtv";
        }

        $sql .= ") VALUES (:idProj, :tituloAtv, :descricaoAtv, :dataFimAtv";

        if ($isDocente) {
            $sql .= ", 'Em andamento'";
        }

        $sql .= ");";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idProj', $idProj);
        $stmt->bindParam(':tituloAtv', $tituloAtv);
        $stmt->bindParam(':descricaoAtv', $descricaoAtv);
        $stmt->bindParam(':dataFimAtv', $dataFimAtv);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function getAtividade(int $idAtv)
    {
        $sql = "SELECT * FROM atividade WHERE idAtv = :idAtv";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idAtv', $idAtv, PDO::PARAM_INT);
        $stmt->execute();
        $atividade = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($atividade) {
            $sql = "
                SELECT u.idUsuario, u.nome, u.email, m.matriculaMat as matricula, m.idMat as idMatricula
                FROM usuario u
                JOIN matricula m ON u.idUsuario = m.fk_Usuario_idUsuario
                JOIN participa p ON m.idMat = p.fk_Matricula_idMat
                WHERE p.fk_Atividade_idAtv = :idAtv
            ";

            $stmt2 = $this->conn->prepare($sql);
            $stmt2->bindParam(':idAtv', $idAtv, PDO::PARAM_INT);
            $stmt2->execute();
            $participantes = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $atividade['participantes'] = $participantes;

        }

        return $atividade;
    }

    public function ehDocenteAtividade(int $idAtv, $idTutor)
    {
        $sql = "SELECT fk_Projeto_idProj FROM atividade WHERE idAtv = :idAtv";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idAtv', $idAtv);
        $stmt->execute();
        $idProj = $stmt->fetchColumn();

        $sql = "SELECT i.fk_Matricula_idMat
                FROM integra i
                JOIN matricula m ON i.fk_Matricula_idMat = m.idMat
                WHERE i.fk_Projeto_idProj = :idProj
                  AND i.status = 'Ativo'
                  AND m.idMat = :idMat
                  AND m.tipoMat = 2";
        $stmt2 = $this->conn->prepare($sql);
        $stmt2->bindParam(':idProj', $idProj);
        $stmt2->bindParam(':idMat', $idTutor);
        $stmt2->execute();

        $idDocentes = $stmt2->fetchAll(PDO::FETCH_COLUMN);
        return in_array($idTutor, $idDocentes);
    }

    public function atualizarAtividade(int $idAtv, string $tituloatv,string $dataIniAtv, string $dataFimAtv, string $statusAtv, string $descricaoAtv): bool
    {
        $sql = "UPDATE atividade SET dataIniAtv = :dataIniAtv, dataFimAtv = :dataFimAtv, statusAtv = :statusAtv, tituloAtv = :tituloAtv, descricaoAtv = :descricaoAtv WHERE idAtv = :idAtv";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idAtv', $idAtv);
        $stmt->bindParam(':dataIniAtv', $dataIniAtv);
        $stmt->bindParam(':dataFimAtv', $dataFimAtv);
        $stmt->bindParam(':statusAtv', $statusAtv);
        $stmt->bindParam(':descricaoAtv', $descricaoAtv);
        $stmt->bindParam(':tituloAtv', $tituloatv);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function listarPossiveisParticipantesAtv($idProj): false|array
    {
        $sql = "SELECT u.idUsuario, u.nome, m.matriculaMat, m.tipoMat, m.idMat 
                    FROM usuario AS u
                    JOIN matricula AS m ON u.idUsuario = m.fk_Usuario_idUsuario
                    WHERE m.tipoMat = 3 AND EXISTS (
                        SELECT 1 FROM integra 
                        WHERE fk_Matricula_idMat = m.idMat 
                        AND fk_Projeto_idProj = :idProj 
                        AND status = 'Ativo'
                )";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idProj', $idProj);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!$result)
            $result = [];
        return $result;
    }

    public function getProjAtividade(int $idAtv)
    {
        $sql = "SELECT fk_Projeto_idProj FROM atividade WHERE idAtv = :idAtv";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idAtv', $idAtv);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function adicionarParticipanteAtv(int $idAtv, string $idMat): false|string
    {
        $sql = "INSERT INTO participa (fk_Atividade_idAtv, fk_Matricula_idMat) VALUES (:idAtv, :idMat)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idAtv', $idAtv);
        $stmt->bindParam(':idMat', $idMat);
        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function removerDiscenteAtv(int $idAtv, int $idMat): bool
    {
        $sql = "DELETE FROM participa WHERE fk_Atividade_idAtv = :idAtv AND fk_Matricula_idMat = :idMat";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idAtv', $idAtv);
        $stmt->bindParam(':idMat', $idMat);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function ehDiscenteAtividade(int $idAtv, int $idMat): bool
    {
        $sql = "SELECT fk_Matricula_idMat FROM participa WHERE fk_Atividade_idAtv = :idAtv";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idAtv', $idAtv);
        $stmt->execute();
        $idDiscentes = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return in_array($idMat, $idDiscentes);
    }

    public function getTotalRequisicoesMatConcluidas()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM matricula WHERE statusMat != 'Em análise'");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getTotalRequisicoesProjConcluidas()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM projeto WHERE statusProj != 'Em análise'");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getRequisicoesMes()
    {
        $sql = "SELECT
                MONTH(dataCriacaoMat) AS mes,
                YEAR(dataCriacaoMat) AS ano,
                COUNT(*) AS total_mat
                    FROM matricula
                    WHERE statusMat != 'Em análise'
                    GROUP BY ano, mes
                    ORDER BY ano DESC, mes DESC";
        $stmt = $this->conn->query($sql);

        $reqMes = array_fill(0, 12, 0);

        foreach ($stmt->fetchAll() as $req) {
            $reqMes[$req['mes'] - 1] = $req['total_mat'];
        }

        $sql = "SELECT
                MONTH(dataCriacaoProj) AS mes,
                YEAR(dataCriacaoProj) AS ano,
                COUNT(*) AS total_proj
                    FROM projeto
                    WHERE statusProj != 'Em análise'
                    GROUP BY ano, mes
                    ORDER BY ano DESC, mes DESC";
        $stmt = $this->conn->query($sql);

        foreach ($stmt->fetchAll() as $req) {
            $reqMes[$req['mes'] - 1] += $req['total_proj'];
        }

        return $reqMes;
    }



}
