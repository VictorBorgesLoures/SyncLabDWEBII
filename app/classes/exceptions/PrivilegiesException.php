<?php

namespace cefet\SyncLab\classes\exceptions;

use cefet\SyncLab\Helper\Helpers;
use Exception;

class PrivilegiesException extends Exception
{
    public function __construct($message = "Você não tem permissão para acessar essa página", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        Helpers::redirect('error-privilegio');
    }


    public function obterDetalhesErro() {
        return "[Erro] Código: {$this->code} - Mensagem: {$this->message}";
    }
}