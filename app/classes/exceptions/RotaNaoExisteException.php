<?php

namespace cefet\SyncLab\classes\exceptions;

use cefet\SyncLab\Helper\Helpers;
use Exception;

class RotaNaoExisteException extends Exception
{
    public function __construct($message = "A rota não existe", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        Helpers::redirect('error404');
    }


    public function obterDetalhesErro() {
        return "[Erro] Código: {$this->code} - Mensagem: {$this->message}";
    }
}