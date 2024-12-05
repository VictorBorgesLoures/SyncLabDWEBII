<?php

namespace cefet\Adequa\controllers;


class ErrorSystemController extends Controller
{
    public function index(): void
    {
        $this->view("error");
    }
}