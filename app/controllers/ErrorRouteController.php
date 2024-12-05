<?php

namespace cefet\SyncLab\controllers;


class ErrorRouteController extends Controller
{
    public function index(): void
    {
        $this->view("errorRota");
    }
}