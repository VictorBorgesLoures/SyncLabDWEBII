<?php

namespace cefet\SyncLab\controllers;
use cefet\SyncLab\classes\Session;
use League\Plates\Engine;
abstract class Controller
{

    /**
     * Renderiza uma vista com os dados fornecidos.
     *
     * @param string $view O nome da vista a ser renderizada.
     * @param array $data Os dados a serem passados para a vista.
     * @return void
     */
    protected function view(string $view, array $data = []): void
    {
        $pathViews = dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'views' ;
        $templates = new Engine($pathViews);
        echo $templates->render($view, $data);
    }

    protected function renderTemplate(string $view, array $data = []): string
    {
        $pathViews = dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'views' ;
        $templates = new Engine($pathViews);
        return $templates->render($view, $data);
    }

}