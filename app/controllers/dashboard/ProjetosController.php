<?php

namespace cefet\SyncLab\controllers\dashboard;

use cefet\SyncLab\controllers\Controller;
use cefet\SyncLab\classes\Session;
use cefet\SyncLab\classes\BdConnection;
use cefet\SyncLab\classes\User;
use cefet\SyncLab\Helper\FieldValidators;

class ProjetosController extends Controller
{
    private array $projetos;
    private $projeto;
    private $user;

    public function __construct()
    {
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
                Session::flash('error', "Campos inválidos");
                echo json_encode(['error' => true, 'redirect' => '/projetos']);
                return;
            }

            if ($this->user->requisitarProjeto(Session::get('idMat'), $nomeProj, $descricaoProj)) {
                Session::flash('success', "Projeto requisitado com sucesso!");
                echo json_encode(['success' => true, 'redirect' => '/projetos']);
            } else {
                Session::flash('error', "Não foi possível requisitar o projeto!");
                echo json_encode(['error' => true, 'redirect' => '/projetos']);
            }
            BdConnection::getInstance()->closeConnection();
        } else {
            Session::flash('error', "Você não é docente para realizar essa ação!");
            echo json_encode(['error' => true, 'redirect' => '/projetos']);
        }
    }

    public function viewProjeto($params): void
    {
        $id = filter_var($params[0], FILTER_SANITIZE_NUMBER_INT);
        $this->setProjeto($id);
        $this->view("dashboard/projeto", [
            "projeto" => $this->getProjeto(),
            "reqParticipacao" => $this->user->getRequisicoesParticipacao($id)
        ]);
    }

    public function getProjeto()
    {
        return $this->projeto;
    }

    public function setProjeto($id): void
    {
        $this->projeto = $this->user->getProjeto($id);
    }

}
