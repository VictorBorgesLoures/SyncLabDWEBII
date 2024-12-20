<?php

namespace cefet\SyncLab\controllers\user;

use cefet\SyncLab\classes\BdConnection;
use cefet\SyncLab\controllers\Controller;
use Exception;

class UserController extends Controller
{

    /**
     * @throws Exception
     */
    public function logout(): void
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Limpa todas as variáveis de sessão
            $_SESSION = array();

            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            BdConnection::getInstance()->closeConnection();

            session_destroy();

        } catch (Exception $e) {
            throw new Exception("Erro ao realizar o logout: " . $e->getMessage());
        }
        redirect('');
    }
}