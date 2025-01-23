<?php

namespace cefet\SyncLab\Helper;

use JetBrains\PhpStorm\NoReturn;

class Helpers
{
    static function flash(): ?string
    {
        $message = \cefet\Adequa\classes\Session::returnFlash();

        // Verificar o índice e aplicar o estilo adequado
        if ($message !== null) {
            if ($message['index'] === 'error') {
                return "<p style='color:red'>" . htmlspecialchars($message['message']) . "</p>";
            } elseif ($message['index'] === 'message') {
                return "<p style='color:green'>" . htmlspecialchars($message['message']) . "</p>";
            }
        }

        return null;
    }

    static function redirect(string $router): void
    {
        header('Location: ' . getenv('DOM_URI') . $router);
        exit;
    }


    static function getBaseUrl(): string
    {
        // Determinar o esquema
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

        // Obter o host e a porta
        $host = $_SERVER['HTTP_HOST'];

        // Construir a URL base
        $baseUrl = $scheme . '://' . $host;

        return $baseUrl;
    }

    static function matriculaType($idMat): ?string
    {
        if ($idMat == 1) {
            return "admin";
        } else if ($idMat == 2) {
            return "discente";
        } else if ($idMat == 3) {
            return "docente";
        } else {
            return 'none';
        }
    }
}


