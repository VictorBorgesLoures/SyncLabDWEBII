<?php

namespace cefet\SyncLab\controllers\user;

use cefet\SyncLab\classes\BdConnection;
use cefet\SyncLab\classes\Endereco;
use cefet\SyncLab\classes\Session;
use cefet\SyncLab\classes\User;
use cefet\SyncLab\controllers\Controller;
use cefet\SyncLab\Helper\FieldValidators;
use PDO;

class RegistrarController extends Controller
{
    private $user;
    private $endereco;
    public function __construct()
    {
        $this->user = new User();
        $this->endereco = new Endereco();
    }

    public function viewRegistrar()
    {
        $this->view('user/registrar');
    }

    public function processarRegistro(){
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        $name = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
        $username = htmlspecialchars($data['username'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($data['password'], ENT_QUOTES, 'UTF-8');
        $confirm_password = htmlspecialchars($data['confirm-password'], ENT_QUOTES, 'UTF-8');
        $birthdate = htmlspecialchars($data['data'], ENT_QUOTES, 'UTF-8');
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $cpf = htmlspecialchars($data['cpf'], ENT_QUOTES, 'UTF-8');
        $complemento = htmlspecialchars($data['complement'], ENT_QUOTES, 'UTF-8');
        $numero = htmlspecialchars($data['number'], ENT_QUOTES, 'UTF-8');
        $address = htmlspecialchars($data['address'], ENT_QUOTES, 'UTF-8');
        $cep = htmlspecialchars($data['cep'], ENT_QUOTES, 'UTF-8');

        if ($password !== $confirm_password) {
            Session::flash('error', "As senhas para registro não conferem! Tente novamente.");
            BdConnection::getInstance()->closeConnection();
            echo json_encode(['success' => false, 'redirect' => '/registrar']);
            exit;
        }


        if ($this->user->verificarEmailExistente($email)) {
            Session::flash('error', "Email já registrado.");
            BdConnection::getInstance()->closeConnection();
            echo json_encode(['success' => false, 'redirect' => '/registrar']);
            exit;
        }

        // Cria Endereço
        $idEnd = $this->endereco->verificarCepExistente($cep);
        if (!$idEnd) {

            $idEnd = $this->endereco->inserirEndereco($cep, $address);
        }


        //Cria Usuario
        try {
            if ($this->user->registrar($name, $username, $password, $email, $cpf, $birthdate, $complemento, $numero, $idEnd)) {
                Session::flash('message', "Registro feito com sucesso!");
                BdConnection::getInstance()->closeConnection();
                echo json_encode(['success' => true, 'redirect' => '/login']);
                exit;
            } else {
                Session::flash('message', "Erro ao realizar registro.");
                BdConnection::getInstance()->closeConnection();
                echo json_encode(['success' => false, 'redirect' => '/registrar']);
                exit;
            }
        }catch (\PDOException $e){
            $message = '';
            if ($e->getCode() == 23000 && str_contains($e->getMessage(), '1062 Duplicate entry' && str_contains($e->getMessage(), 'usuario.cpf_'))){
                $message .= "Este CPF já está cadastrado no sistema. ";
            }
            else if ($e->getCode() == 23000 && str_contains($e->getMessage(), '1062 Duplicate entry' && str_contains($e->getMessage(), 'usuario.email'))){
                $message .= "Este email já está cadastrado no sistema. ";
            }
            Session::flash('error',$message);

            BdConnection::getInstance()->closeConnection();
            echo json_encode(['success' => false, 'redirect' => '/registrar']);
            exit;
        }
    }

}