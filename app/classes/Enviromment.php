<?php

namespace cefet\SyncLab\classes;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Respect\Validation\Validator as v;
class Enviromment{
    /**
     * Método responsável por carregar as variáveis de ambiente do projeto
     * @param string $dir Caminho absoluto da pasta com o arquivo .env
     * @throws Exception
     */
    public static function load(string $dir, string $envName = '')
    {
        $envFile = $dir . "/$envName.env";
        //Verifica se o arquivo existe
        if(!file_exists($envFile)) {
            throw new Exception("Arquivo .env não encontrado no caminho fornecido");
        }

        //Define as variaveis do ambiente
        $lines = file($envFile);
        foreach($lines as $line){
            putenv(trim($line));
        }
    }

    public static function whoops(): void
    {
        $whoops = new Run;

        if (getenv("ENV") == 'development') {
            // Exibe os erros na página no modo de desenvolvimento
            $whoops->pushHandler(new PrettyPageHandler);
        } else {
            // Cria o logger Monolog
            $logFile = __DIR__ . '/../logs/error.log';
            $logger = new Logger('error_logger');
            $logger->pushHandler(new StreamHandler($logFile, Logger::ERROR));

            // Cria o PlainTextHandler para armazenar erros em logs
            $plainTextHandler = new PlainTextHandler();
            $plainTextHandler->setLogger($logger); // Usa o Monolog como logger
            $whoops->pushHandler($plainTextHandler);


            $whoops->pushHandler(function($exception, $inspector, $run) use ($logger) {
                $logger->error($exception->getMessage(), ['exception' => $exception]);
                //redirect('/error');
            });
        }

        // Registrar o Whoops para capturar os erros
        $whoops->register();
    }


    public static function modifyPhpIni(){
        ini_set('log_errors', 1); // Logar erros
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 1);

        error_reporting(E_ALL);

        date_default_timezone_set('America/Sao_Paulo');

    }

    public static function getDomUri(){
        return getenv('DOM_URI');
    }


}