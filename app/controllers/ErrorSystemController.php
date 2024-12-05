<?php

namespace cefet\SyncLab\controllers;


class ErrorSystemController extends Controller
{
    public function index(): void
    {
        $this->view("error");
    }
}