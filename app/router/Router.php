<?php

namespace cefet\SyncLab\router;

use cefet\SyncLab\classes\exceptions\RotaNaoExisteException;
use cefet\SyncLab\classes\Session;

use cefet\SyncLab\controllers\ErrorSystemController;
use cefet\SyncLab\controllers\HomeController;


use cefet\SyncLab\Helper\Request;
use cefet\SyncLab\Helper\Uri;
use Exception;
use Throwable;

class Router
{
    public const CONTROLLER_NAMESPACE = 'cefet\\SyncLab\\controllers';

    /**
     * @throws Throwable
     */
    public static function load(string $controller, string $method, array $params = [])
    {
        // verificar se o controller existe
        $controllerNamespace = self::CONTROLLER_NAMESPACE . '\\' . $controller;
        if (!class_exists($controllerNamespace)) {
            throw new Exception("O Controller {$controller} não existe");
        }

        $controllerInstance = new $controllerNamespace;

        if (!method_exists($controllerInstance, $method)) {
            throw new Exception("O método {$method} não existe no Controller {$controller}");
        }

        //$controllerInstance->$method((object)$_REQUEST);
        call_user_func([$controllerInstance, $method], $params);
    }

    public static function routes(): array
    {
        return require_once 'routes.php';
    }


    /**
     * @throws Exception
     */
    public static function execute()
    {
        $routes = self::routes();
        $request = Request::get();
        $uri = Uri::get('path');

        $uri = rtrim($uri, '/');

        if (!isset($routes[$request])) {
            throw new Exception('A rota não existe');
        }

        $matchedRoute = self::matchRoute($uri, $routes[$request]);
        if (!$matchedRoute) {
            throw new RotaNaoExisteException('A rota não existe');
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


    private static function matchRoute(string $uri, array $routes)
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