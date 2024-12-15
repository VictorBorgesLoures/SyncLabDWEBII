<?php

namespace cefet\SyncLab\router;

use cefet\SyncLab\classes\exceptions\RotaNaoExisteException;
use cefet\SyncLab\Helper\Request;
use cefet\SyncLab\Helper\Uri;
use Exception;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Throwable;


class Router
{
    public const CONTROLLER_NAMESPACE = 'cefet\\SyncLab\\controllers';

    /** Carrega um controlador e executa um método com os parâmetros fornecidos.
     * @param string $controller Nome do controlador
     * @param string $method Nome do método
     * @param array $params Parâmetros para o método
     * @throws Throwable
     */
    public static function load(string $controller, string $method, array $params = []): void
    {
        $controllerClass = self::findController($controller);
        if (!$controllerClass) {
            throw new Exception("O Controller {$controller} não existe");
        }

        $controllerInstance = new $controllerClass;

        if (!method_exists($controllerInstance, $method)) {
            throw new Exception("O método {$method} não existe no Controller {$controller}");
        }

        call_user_func([$controllerInstance, $method], $params);
    }

    /** Procura recursivamente por um controlador no namespace e retorna a classe se encontrada.
     * @param string $controller Nome do controlador
     * @return string|null Nome da classe do controlador ou null se não encontrado
     */
    private static function findController(string $controller): ?string
    {
        $baseDir = ROOT_PATH . '/app/controllers';
        $controllerFile = "{$controller}.php";
        $controllerNamespace = self::CONTROLLER_NAMESPACE;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($baseDir, FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->getFilename() === $controllerFile) {
                // Substituir o caminho por namespaces
                $relativePath = str_replace([$baseDir, '/', '.php'], ['', '\\', ''], $file->getPathname());
                return $controllerNamespace . $relativePath;
            }
        }

        return null; // Retorna null se o controlador não for encontrado
    }

    /** Retorna as rotas definidas no arquivo routes.php
     * @return array
     */
    public static function routes(): array
    {
        return require_once 'routes.php';
    }


    /** Executa a rota correspondente à URI atual
     * @throws RotaNaoExisteException
     * @throws Exception
     */
    public static function execute(): void
    {
        $routes = self::routes();
        $request = Request::get();
        $uri = Uri::get('path');

        $uri = rtrim($uri, '/');


        $matchedRoute = self::matchRoute($uri, $routes[$request]);
        if (!$matchedRoute && getenv('ENV') == 'production') {
            throw new RotaNaoExisteException('A rota não existe');
        }else if (!$matchedRoute) {
            throw new Exception("A rota não existe ($uri)");
        }

        /*
        if (!in_array($_SERVER['REMOTE_ADDR'], constant('IP_ADDRESS'))) {
            // Exibe página de manutenção para usuários não autorizados
            echo "Estamos em desenvolvimento. Usuário IP não autorizado. <br>";
            echo "Contate o Administrador do sistema.";
            echo $_SERVER['REMOTE_ADDR'];
            die();
        }
        */

        $matchedRoute['callback']($matchedRoute['params']);
    }


    /** Verifica se a URI corresponde a uma rota definida
     * @param string $uri URI a ser verificada
     * @param array $routes Rotas definidas
     * @return array|bool Array com o callback e os parâmetros da rota ou false se não houver correspondência
     */
    private static function matchRoute(string $uri, array $routes): bool|array
    {
        foreach ($routes as $route => $callback) {
            $route = rtrim($route, '/');

            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
            $pattern = str_replace('/', '\/', $pattern);
            if (preg_match('/^' . $pattern . '$/', $uri, $matches)) {
                array_shift($matches);
                return ['callback' => $callback, 'params' => $matches];
            }
        }
        return false;
    }
}