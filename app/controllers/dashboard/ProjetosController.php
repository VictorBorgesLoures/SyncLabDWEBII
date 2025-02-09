<?php

namespace cefet\SyncLab\controllers\dashboard;

use cefet\SyncLab\classes\exceptions\PrivilegiesException;
use cefet\SyncLab\controllers\Controller;
use cefet\SyncLab\classes\Session;
use cefet\SyncLab\classes\BdConnection;
use cefet\SyncLab\classes\User;
use cefet\SyncLab\Helper\FieldValidators;
use cefet\SyncLab\Helper\Helpers;

class ProjetosController extends Controller
{
    private array $projetos;
    private $projeto;
    private $user;

    public function __construct()
    {
        Session::verifyLogin();

        $this->user = new User();
        $this->setProjetos();
    }

    public function viewProjetos(): void
    {
        $this->view("dashboard/projetos", [
            "projetos" => $this->getProjetos()
        ]);
    }

    public function getProjetos(): array
    {
        return $this->projetos;
    }

    public function setProjetos(): void
    {
        $this->projetos = $this->user->getProjetos(Session::get('idMat'));
    }

    public function RequisitarProjeto(): void
    {
        $user_type = Session::get('type');
        if ($user_type == 'docente') {
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);

            $nomeProj = trim(htmlspecialchars($data['nomeProj'], ENT_QUOTES, 'UTF-8'), " ");
            $descricaoProj = trim(htmlspecialchars($data['descricaoProj'], ENT_QUOTES, 'UTF-8'), " ");

            if(!FieldValidators::validate('nomeProj', $nomeProj) || !FieldValidators::validate('descricaoProj', $descricaoProj)) {
                Session::flash('message', "Campos inválidos");
                echo json_encode(['error' => true, 'redirect' => '/projetos']);
                return;
            }

            $idProj = $this->user->requisitarProjeto(Session::get('idMat'), $nomeProj, $descricaoProj);
            if ($idProj) {
                $this->user->adicionarIntegrante($idProj, Session::get('idMat'), 'Ativo');
                Session::flash('message', "Projeto requisitado com sucesso!");
                echo json_encode(['success' => true, 'redirect' => '/projetos']);
            } else {
                Session::flash('message', "Não foi possível requisitar o projeto!");
                echo json_encode(['error' => true, 'redirect' => '/projetos']);
            }
            BdConnection::getInstance()->closeConnection();
        } else {
            Session::flash('message', "Você não é docente para realizar essa ação!");
            echo json_encode(['error' => true, 'redirect' => '/projetos']);
        }
    }

    public function viewProjeto($params): void
    {
        $id = filter_var($params[0], FILTER_SANITIZE_NUMBER_INT);
        $this->setProjeto($id);
        if ($this->getProjeto() == null) {
            $this->view("error/projeto-404");
        } else {
            $this->view("dashboard/projeto", [
                "projeto" => $this->getProjeto(),
                "reqParticipacao" => $this->user->getRequisicoesParticipacao($id),
                "isTutor" => count($this->user->ehTutorOuCotutor($id, Session::get('idMat'))) > 0,
                "possiveisTutores" => $this->user->getPossiveisTutores($id)
            ]);
        }
    }

    public function getProjeto()
    {
        return $this->projeto;
    }

    public function setProjeto($id): void
    {
        $this->projeto = $this->user->getProjeto($id);
    }

    /**
     * Atualiza a participação de um discente em um projeto.
     * @return void
     */
    public function atualizaParticipacao()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        $idProj = filter_var($data['projetoId'], FILTER_SANITIZE_NUMBER_INT);
        $idDiscente = filter_var($data['matriculaId'], FILTER_SANITIZE_NUMBER_INT);
        $status = htmlspecialchars($data['status'], ENT_QUOTES, 'UTF-8');


        if($this->user->atualizaParticipacao($idProj, $idDiscente, $status)) {
            echo json_encode(['success' => true, 'redirect' => '/projetos/' . $idProj]);
        } else {
            echo json_encode(['error' => true]);
        }

    }

    public function listarPossiveisIntegrantes($params) {
        header('Content-Type: application/json');
        $novointegrantes = $this->user->listarPossiveisIntegrantes($params[0]);
        echo json_encode(['error' => false, 'data' => $novointegrantes]);
    }

    /**
     * @throws PrivilegiesException
     */
    public function adicionarIntegrante($params) {
        header('Content-Type: application/json');
        if (Session::get("type") == "docente" && count($this->user->ehTutorOuCotutor($params[0], Session::get("idMat"))) > 0) {

            $data = json_decode(file_get_contents('php://input'), true);
            $idMat = trim(htmlspecialchars($data['idMat'], ENT_QUOTES, 'UTF-8'), " ");

            if ($this->user->adicionarIntegrante($params[0], $idMat, 'Ativo')) {
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

    public function finalizarParticipacao($params)
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $idProj = filter_var($params[0], FILTER_SANITIZE_NUMBER_INT);
        $idMat = filter_var($data['matriculaId'], FILTER_SANITIZE_NUMBER_INT);

        if(Session::get('type') == 'docente' && count($this->user->ehTutorOuCotutor($idProj, Session::get('idMat'))) > 0) {
            if($this->user->finalizarParticipacao($idProj, $idMat)) {
                echo json_encode(['error' => false, 'message' => 'Participação finalizada com sucesso!']);
            } else {
                echo json_encode(['error' => true, 'message' => 'Não foi possível finalizar a participação!']);
            }
        } else {
            echo json_encode(['error' => true, 'message' => 'Você não tem permissão para realizar essa ação!']);
        }
    }

    public function alterarTutor()
    {
        $idProj = filter_input(INPUT_POST, 'idProj', FILTER_SANITIZE_NUMBER_INT);
        $idMat = filter_input(INPUT_POST, 'tutor', FILTER_SANITIZE_NUMBER_INT);

        if(Session::get('type') == 'docente') {
            if($this->user->alterarTutor($idProj, $idMat)) {
                $this->user->atualizaParticipacao($idProj, $idMat, 'Ativo'); //Caso o docente requeriu participação no projeto
                Session::flash('message', 'Tutor alterado com sucesso!');
                Helpers::redirect('projetos/' . $idProj);
            } else {
                Session::flash('error', 'Não foi possível alterar o tutor!');
                Helpers::redirect('projetos/' . $idProj);
            }
        } else {
            Session::flash('error', 'Você não tem permissão para realizar essa ação!');
            Helpers::redirect('projetos/' . $idProj);
        }
    }

    public function listarPossiveisProjetos()
    {
        header('Content-Type: application/json');
        $nomeProjeto = $_POST['nomeProjeto'] ?? '';
        $projetos = $this->user->listarPossiveisProjetos(Session::get('idMat'), $nomeProjeto);
        if (!empty($projetos)) {
            echo json_encode(['error' => false, 'data' => $projetos]);
        } else {
            echo json_encode(['error' => true, 'message' => 'Nenhum projeto encontrado.']);
        }

    }

    public function solicitarParticipacao($params)
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        $idProj = filter_var($data['idProj'], FILTER_SANITIZE_NUMBER_INT);
        $idMat = filter_var($data['idMat'], FILTER_SANITIZE_NUMBER_INT);

        if($this->user->solicitarParticipacao($idProj, $idMat)) {
            echo json_encode(['error' => false, 'message' => 'Solicitação de participação enviada com sucesso!']);
        } else {
            echo json_encode(['error' => true, 'message' => 'Não foi possível enviar a solicitação de participação!']);
        }
    }

    public function adicionarAtividade()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        $idProj = filter_var($data['idProj'], FILTER_SANITIZE_NUMBER_INT);
        $tituloAtv = trim(htmlspecialchars($data['tituloAtv'], ENT_QUOTES, 'UTF-8'), " ");
        $descricaoAtv = trim(htmlspecialchars($data['descricaoAtv'], ENT_QUOTES, 'UTF-8'), " ");
        $dataFimAtv = trim(htmlspecialchars($data['dataFimAtv'], ENT_QUOTES, 'UTF-8'), " ");

        if($this->user->adicionarAtividade($idProj, (Session::get("type") == "docente" ? true : false), $tituloAtv, $descricaoAtv, $dataFimAtv)) {
            echo json_encode(['error' => false, 'message' => (Session::get("type") == "docente" ? "Inserção" : "Solicitação") . ' de atividade enviada com sucesso!']);
        } else {
            echo json_encode(['error' => true, 'message' => 'Não foi possível enviar a '.(Session::get("type") == "docente" ? "inserção" : "solicitação") .' de atividade!']);
        }
    }

}
