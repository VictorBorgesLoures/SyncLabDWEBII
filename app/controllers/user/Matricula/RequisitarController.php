<?php

namespace cefet\SyncLab\controllers\user\Matricula;

use cefet\SyncLab\classes\BdConnection;
use cefet\SyncLab\classes\Session;
use cefet\SyncLab\classes\User;
use cefet\SyncLab\controllers\Controller;
use cefet\SyncLab\Helper\FieldValidators;

class RequisitarController extends Controller
{

    private $user;
    public function __construct()
    {
        $this->user = new User();
    }

    public function viewRequisitarMatricula(): void
    {
        $this->view("user/matricula/requisitar", [
            "listaRequisicaoMatriculas" => $this->user->carregarMatriculasEmAnalise(Session::get("user_id"))
        ]);
        BdConnection::getInstance()->closeConnection();
    }

    public function RequisitarMatricula(): void
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        $tipoMat = trim(htmlspecialchars($data['tipo'], ENT_QUOTES, 'UTF-8'), " ");
        $matricula = trim(htmlspecialchars($data['matricula'], ENT_QUOTES, 'UTF-8'), " ");
        if (FieldValidators::validate('matricula', $matricula) && FieldValidators::validate('matriculaType', $tipoMat)) {
            $idUsuario = Session::get('user_id');
            if ($this->user->requisitarMatricula($idUsuario, $tipoMat, $matricula)) {
                BdConnection::getInstance()->closeConnection();
                Session::flash('message', "Inserida com sucesso!");
                echo json_encode(['success' => true, 'redirect' => '/matricula/requisitar']);
            } else {
                Session::flash('error', "Falha ao adicionar requisição de matrícula");
                echo json_encode(['success' => false, 'redirect' => '/matricula/requisitar']);
            }
        } else {
            Session::flash('error', "Campos inválidos!");
            echo json_encode(['success' => false, 'redirect' => '/matricula/requisitar']);
        }
    }
}
