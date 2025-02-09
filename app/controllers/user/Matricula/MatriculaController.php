<?php

namespace cefet\SyncLab\controllers\user\Matricula;

use cefet\SyncLab\classes\BdConnection;
use cefet\SyncLab\classes\Session;
use cefet\SyncLab\classes\User;
use cefet\SyncLab\controllers\Controller;

class MatriculaController extends Controller
{

    private $user;
    public function __construct()
    {
        Session::verifyLogin(true);
        $this->user = new User();
    }

    public function viewMatricula(): void
    {
        $this->view("user/matricula/index", [
            "listaMatriculas" => $this->user->carregarMatriculasAtivas(Session::get("user_id"))
        ]);
        BdConnection::getInstance()->closeConnection();
    }

    public function SelecionarMatricula(): void
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        $idMat = trim(htmlspecialchars($data['idMat'], ENT_QUOTES, 'UTF-8'), " ");

        if ($this->user->ehMatriculaValida(Session::get("user_id"), $idMat)) {
            BdConnection::getInstance()->closeConnection();
            Session::set('idMat', $idMat);
            Session::set('type', $this->getType($idMat));
            echo json_encode(['success' => true, 'redirect' => '/dashboard']);
        } else {
            Session::flash('error', "Seleção de matrícula inválida.");
            BdConnection::getInstance()->closeConnection();
            echo json_encode(['success' => false, 'redirect' => '/matricula']);
        }
    }

    private function getType($idMat): ?string
    {
        if($this->user->getTypeMatricula($idMat) == 1){
            return "admin";
        }
        else if($this->user->getTypeMatricula($idMat) == 2){
            return "docente";
        }
        else if($this->user->getTypeMatricula($idMat) == 3){
            return "discente";
        }
        else{
            return null;
        }
    }
}
