<?php

namespace cefet\SyncLab\controllers\dashboard;

use cefet\SyncLab\classes\Session;
use cefet\SyncLab\classes\BdConnection;
use cefet\SyncLab\controllers\Controller;
use cefet\SyncLab\classes\User;

class RequisicoesMatriculasController extends Controller
{
    private array $requisicoes;
    private $user;

    public function __construct()
    {
        Session::verifyLogin();
        Session::verifyPrivilegies('admin');

        $this->user = new User();
        $this->setRequisicoes();
    }

    public function viewReqMatriculas(): void
    {
        Session::set('active', 'req-matricula');
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
        if ($user_type == 'admin') {
            $this->requisicoes = $this->user->getReqMatriculas();
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

            $idMat = trim(htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8'), " ");            
            $statusMat = trim(htmlspecialchars($data['status'], ENT_QUOTES, 'UTF-8'), " ");

            if($this->user->setNovoStatusRequisicao("matricula", $idMat, $statusMat)) {
                Session::flash('success', "Status atualizado");
                echo json_encode(['success' => true, 'redirect' => '/requisicoes/matricula']);
            } else {
                Session::flash('error', "Não foi possível salvar o status");
                echo json_encode(['error' => true, 'redirect' => '/requisicoes/matricula']);
            }
            BdConnection::getInstance()->closeConnection();
            
            
        } else {
            $this->requisicoes = [];
        }
    }
}
