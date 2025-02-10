<?php

namespace cefet\SyncLab\classes;

use cefet\SyncLab\Helper\Helpers;
use PDO;
use PDOException;

class Projeto
{
    private $conn;

    public function __construct()
    {
        $this->conn = BdConnection::getInstance()->getConnection();
    }

    public function getProjetosAtivos($idMat): array
    {
        if(Session::get('type') == 'admin') {
            $sql = "SELECT * FROM projeto WHERE statusProj = 'Ativo'";
            $stmt = $this->conn->prepare($sql);
        } else {
            $sql = "SELECT * FROM projeto WHERE statusProj = 'Ativo' AND
                              idProj IN (SELECT fk_Projeto_idProj FROM integra WHERE fk_Matricula_idMat = :idMat)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idMat', $idMat);

        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAtividadesEmAndamento($idMat): array
    {
        if(Session::get('type') == 'admin') {
            $sql = "SELECT * FROM atividade WHERE statusAtv = 'Em andamento'";
            $stmt = $this->conn->prepare($sql);
        } else {
            $sql = "SELECT * FROM atividade WHERE statusAtv = 'Em andamento' AND
                              idAtv IN (SELECT idAtv FROM participa WHERE fk_Matricula_idMat = :idMat)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idMat', $idMat);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAtividadesRealizadas($idMat): array
    {
        if(Session::get('type') == 'admin') {
            $sql = "SELECT * FROM atividade WHERE statusAtv = 'Finalizada'";
            $stmt = $this->conn->prepare($sql);
        } else {
            $sql = "SELECT * FROM atividade WHERE statusAtv = 'Finalizada' AND
                              idAtv IN (SELECT idAtv FROM participa WHERE fk_Matricula_idMat = :idMat)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idMat', $idMat);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProjetosMes($idMat)
    {
        if(Session::get('type') == 'admin') {
            $sql = "SELECT
                MONTH(dataCriacaoProj) AS mes,
                YEAR(dataCriacaoProj) AS ano,
                COUNT(*) AS total_projetos
                    FROM projeto
                    WHERE statusProj = 'Ativo'
                    GROUP BY ano, mes
                    ORDER BY ano DESC, mes DESC";
            $stmt = $this->conn->query($sql);
        }
        else{
            $sql = "SELECT
                MONTH(dataCriacaoProj) AS mes,
                YEAR(dataCriacaoProj) AS ano,
                COUNT(*) AS total_projetos
                    FROM projeto
                    WHERE statusProj = 'Ativo' AND idProj IN (SELECT fk_Projeto_idProj FROM integra WHERE fk_Matricula_idMat = :idMat)
                    GROUP BY ano, mes
                    ORDER BY ano DESC, mes DESC;
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idMat', $idMat);
        }

        $projMes = array_fill(0, 12, 0);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $proj) {
            $projMes[$proj['mes'] - 1] = $proj['total_projetos'];
        }

        return $projMes;
    }

    public function getAtividadesMes($idMat)
    {
        if(Session::get('type') == 'admin') {
            $sql = "SELECT
                MONTH(dataIniAtv) AS mes,
                YEAR(dataIniAtv) AS ano,
                COUNT(*) AS total_atividades
                    FROM atividade
                    WHERE statusAtv = 'Finalizada'
                    GROUP BY ano, mes
                    ORDER BY ano DESC, mes DESC";
            $stmt = $this->conn->query($sql);
        }
        else{
            $sql = "SELECT
                MONTH(dataIniAtv) AS mes,
                YEAR(dataIniAtv) AS ano,
                COUNT(*) AS total_atividades
                    FROM atividade
                    WHERE statusAtv = 'Finalizada' AND idAtv IN (SELECT idAtv FROM participa WHERE fk_Matricula_idMat = :idMat)
                    GROUP BY ano, mes
                    ORDER BY ano DESC, mes DESC
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idMat', $idMat);
        }

        $atvMes = array_fill(0, 12, 0);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $atv) {
            $atvMes[$atv['mes'] - 1] = $atv['total_atividades'];
        }

        return $atvMes;
    }


}
