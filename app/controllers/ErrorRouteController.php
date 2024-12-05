<?php

namespace cefet\Adequa\controllers;


class ErrorRouteController extends Controller
{
    public function index(): void
    {
        $this->view("errorRota");
    }
}