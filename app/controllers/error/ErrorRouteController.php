<?php

namespace cefet\SyncLab\controllers\error;


use cefet\SyncLab\controllers\Controller;

class ErrorRouteController extends Controller
{
    public function index(): void
    {
        $this->view("error/errorRota");
    }
}