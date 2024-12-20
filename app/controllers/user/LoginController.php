<?php

namespace cefet\SyncLab\controllers\user;
use cefet\SyncLab\classes\BdConnection;
use cefet\SyncLab\classes\Session;
use cefet\SyncLab\classes\User;
use cefet\SyncLab\controllers\Controller;

class LoginController extends Controller {

    private $user;
    public function __construct()
    {
        $this->user = new User();
    }

    public function viewLogin(): void
    {
        $this->view("user/login");
    }

    public function ProcessaLogin(): void{
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        $username = trim(htmlspecialchars($data['username'], ENT_QUOTES, 'UTF-8'), " ");
        $password = trim(htmlspecialchars($data['password'], ENT_QUOTES, 'UTF-8'), " ");



        if(empty($username) || empty($password)){
            Session::flash('error', 'Preencha todos os campos');
            echo json_encode(['success' => false, 'redirect' => '/login']);
        }
        else{
            $dados = $this->user->login($username, $password);

            if ($dados) {
                Session::set('loggedin', true);
                Session::set('user_id', $dados['idUsuario']);
                Session::set('type', $dados['tipo_usuario']);
                Session::set('user_name', $data['username']);

                BdConnection::getInstance()->closeConnection();
                echo json_encode(['success' => true, 'redirect' => '/dashboard']);
            } else {
                Session::flash('error', "Email ou senha inválidos.");
                BdConnection::getInstance()->closeConnection();
                echo json_encode(['success' => false, 'redirect' => '/login']);
            }
        }



    }


}