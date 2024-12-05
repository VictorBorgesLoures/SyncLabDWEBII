<?php

use JetBrains\PhpStorm\NoReturn;


function flash(): ?string
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

function redirect(string $router): void
{
    header('Location: ' . getenv('DOM_URI') . $router);
    exit;
}


function getBaseUrl(): string
{
    // Determinar o esquema
    $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

    // Obter o host e a porta
    $host = $_SERVER['HTTP_HOST'];

    // Construir a URL base
    $baseUrl = $scheme . '://' . $host;

    return $baseUrl;
}



