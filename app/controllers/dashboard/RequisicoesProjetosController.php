<?php

namespace cefet\SyncLab\controllers\dashboard;

use cefet\SyncLab\classes\Session;
use cefet\SyncLab\classes\BdConnection;
use cefet\SyncLab\controllers\Controller;
use cefet\SyncLab\classes\User;

class RequisicoesProjetosController extends Controller {
    private array $requisicoes;
    private $user;

    public function __construct()
    {
        $this->user = new User();
        $this->setRequisicoes();
    }

    public function viewReqProjetos(): void
    {
        Session::set('active', 'req-projeto');
        $this->view("dashboard/admin/requisicoes", [
            "requisicoes" => $this->getRequisicoes()
        ]);
    }

    public function getRequisicoes(): array
    {
        return $this->requisicoes;
    }

    public function setRequisicoes(): void
    {
        $user_type = Session::get('type');
        if($user_type == 'admin') {
            $this->requisicoes = $this->user->getReqProjetos();            
        } else {
            $this->requisicoes = [];
        }

    }

    public function setNovoStatusRequisicao(): void
    {
        $user_type = Session::get('type');
        if ($user_type == 'admin') {
            header('Content-Type: application/json');            
            $data = json_decode(file_get_contents('php://input'), true);

            $idProj = trim(htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8'), " ");
            $statusProj = trim(htmlspecialchars($data['status'], ENT_QUOTES, 'UTF-8'), " ");
            
            if($this->user->setNovoStatusRequisicao("projeto", $idProj, $statusProj)) {
                Session::flash('success', "Status atualizado");
                echo json_encode(['success' => true, 'redirect' => '/requisicoes/projeto']);
            } else {
                Session::flash('error', "Não foi possível salvar o status");
                echo json_encode(['error' => true, 'redirect' => '/requisicoes/projeto']);
            }
            BdConnection::getInstance()->closeConnection();
            
            
        } else {
            $this->requisicoes = [];
        }
    }


}