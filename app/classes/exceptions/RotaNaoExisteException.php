<?php

namespace cefet\Adequa\classes\exceptions;

use Exception;

class RotaNaoExisteException extends Exception
{
    public function __construct($message = "A rota não existe", $code = 0, Exception $previous = null) {
        // Chama o construtor da classe pai para garantir que tudo seja inicializado corretamente
        parent::__construct($message, $code, $previous);
        redirect('/error404');
    }

    // Exemplo de método customizado
    public function obterDetalhesErro() {
        return "[Erro] Código: {$this->code} - Mensagem: {$this->message}";
    }
}