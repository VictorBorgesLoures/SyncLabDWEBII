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

    /** View the login page
     * @return void
     */
    public function viewLogin(): void
    {
        $this->view("user/login");
    }

    /** Process the login of a user
     * @return void echo json
     */
    public function ProcessLogin(): void{
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        $username = trim(htmlspecialchars($data['username'], ENT_QUOTES, 'UTF-8'), " ");
        $password = trim(htmlspecialchars($data['password'], ENT_QUOTES, 'UTF-8'), " ");

        if(empty($username) || empty($password)){
            Session::flash('error', 'Preencha todos os campos');
            echo json_encode(['success' => false, 'redirect' => '/login']);
        }else{
            $dados = $this->user->login($username, $password);

            if ($dados) {
                self::setLogin($dados);

                BdConnection::getInstance()->closeConnection();
                echo json_encode(['success' => true, 'redirect' => '/matricula']);
            } else {
                Session::flash('error', "Email ou senha inválidos.");
                BdConnection::getInstance()->closeConnection();
                echo json_encode(['success' => false, 'redirect' => '/login']);
            }
        }
    }

    private function setLogin($dados): void
    {
        Session::set('loggedin', true);
        Session::set('user_id', $dados['idUsuario']);
        Session::set('user_name', $dados['username']);
    }


}