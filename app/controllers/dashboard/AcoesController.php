<?php

namespace cefet\SyncLab\controllers\dashboard;
use cefet\SyncLab\classes\exceptions\PrivilegiesException;
use cefet\SyncLab\controllers\Controller;
use cefet\SyncLab\classes\User;
use cefet\SyncLab\classes\Session;
use cefet\SyncLab\Helper\Helpers;

class AcoesController extends Controller {

    private array $acoes;
    private User $user;
    public function __construct()
    {
        Session::verifyLogin();

        $this->setAcoes();
        $this->user = new User();
    }

    public function viewAtividades(): void
    {
        $this->view("dashboard/atividades", [
            "atividades" => $this->user->getUsuairoAtivadades(Session::get('idMat'))
        ]);
    }

    public function viewAtividadesProj($params): void
    {
        $id = $params[0];
        $this->view("dashboard/atividades-proj", [
            "atividades" => $this->user->getAtivadades($id)
        ]);
    }

    public function viewAtividade($params): void
    {
        $idAtv = filter_var($params[0], FILTER_SANITIZE_NUMBER_INT);

        if(Session::get('type') == 'docente' && $this->user->ehDocenteAtividade($idAtv, Session::get('idMat'))) {
            $this->view("dashboard/atividade", [
                "atividade" => $this->user->getAtividade($idAtv),
                'docente' => true
            ]);
        }elseif (Session::get('type') == 'discente' && $this->user->ehDiscenteAtividade($idAtv, Session::get('idMat'))) {
            $this->view("dashboard/atividade", [
                "atividade" => $this->user->getAtividade($idAtv),
                'docente' => false
            ]);
        }

    }

    public function removerParticipacao(): void
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $idAtv = filter_var($data['atvId'], FILTER_SANITIZE_NUMBER_INT);
        $idMat = filter_var($data['matriculaId'], FILTER_SANITIZE_NUMBER_INT);

        if(Session::get('type') == 'docente' && $this->user->ehDocenteAtividade($idAtv, Session::get('idMat'))) {
            if($this->user->removerDiscenteAtv($idAtv, $idMat)) {
                echo json_encode(['error' => false, 'message' => 'Participação finalizada com sucesso!']);
            } else {
                echo json_encode(['error' => true, 'message' => 'Não foi possível finalizar a participação!']);
            }
        } else {
            echo json_encode(['error' => true, 'message' => 'Você não tem permissão para realizar essa ação!']);
        }
    }

    public function atualizarAtividade(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $idAtv = $data['idAtv'] ?? null;
        $dataIniAtv = $data['dataIniAtv'] ?? null;
        $dataFimAtv = $data['dataFimAtv'] ?? null;
        $statusAtv = $data['statusAtv'] ?? null;
        $descricaoAtv = $data['descricaoAtv'] ?? null;
        $fk_Projeto_idProj = $data['fk_Projeto_idProj'] ?? null;
        $tituloAtv = $data['tituloAtv'] ?? null;

        if ($this->user->ehDocenteAtividade($idAtv, Session::get('idMat'))) {
            if ($this->user->atualizarAtividade($idAtv, $tituloAtv, $dataIniAtv, $dataFimAtv, $statusAtv, $descricaoAtv)) {
                echo json_encode(['success' => true, 'message' => 'Atividade atualizada com sucesso!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao atualizar atividade!']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Você não tem permissão para atualizar essa atividade!']);
        }
    }

    public function listarPossiveisParticipantes($params): void
    {
        header('Content-Type: application/json');
        $idProj = $this->user->getProjAtividade($params[0]);
        $novointegrantes = $this->user->listarPossiveisParticipantesAtv($idProj);
        echo json_encode(['error' => false, 'data' => $novointegrantes]);
    }

    /**
     * @throws PrivilegiesException
     */
    public function adicionarParticipante($params): void
    {
        header('Content-Type: application/json');
        if (Session::get("type") == "docente" && count($this->user->ehTutorOuCotutor($params[0], Session::get("idMat"))) > 0) {

            $data = json_decode(file_get_contents('php://input'), true);
            $idMat = trim(htmlspecialchars($data['idMat'], ENT_QUOTES, 'UTF-8'), " ");

            if ($this->user->adicionarParticipanteAtv($params[0], $idMat)) {
                echo json_encode(['error' => false, 'message' => "Integrante adicionado com sucesso!"]);
            } else {
                echo json_encode(['error' => true, 'message' => "Não foi possível adicionar o integrante!"]);
            }
            exit;
        } else {
            error_log("Usuário não tem permissão para adicionar integrante");
            throw new PrivilegiesException("Você não tem permissão para realizar essa ação!");
        }
    }

    public function getAcoes(): array
    {
        return $this->acoes;
    }

    public function setAcoes(): void
    {
        $this->acoes = [
            [
                "projeto" => "Oktoplus - Programação Competitiva",
                "atividade" => "Produçao Minicurso de Introdução à Programação",
                "atuantes" => "Victor, Wendell, Richard",
                "inicio" => "17-07-2024",
                "entrega" => "29-08-2024",
            ],
            [
                "projeto" => "Oktoplus - Programação Competitiva",
                "atividade" => "Atualizar Exercícios na Planilha",
                "atuantes" => "Victor, Nicole",
                "inicio" => "23-07-2024",
                "entrega" => "10-08-2024",
            ],
            [
                "projeto" => "PET.COMP",
                "atividade" => "Definir Visita Técnica na Semana da Computação",
                "atuantes" => "Victor",
                "inicio" => "04-08-2024",
                "entrega" => "23-08-2024",
            ],
            [
                "projeto" => "PET.COMP",
                "atividade" => "Produzir Minicurso React",
                "atuantes" => "Victor",
                "inicio" => "01-08-2024",
                "entrega" => "18-10-2024",
            ]
        ];
    }


}