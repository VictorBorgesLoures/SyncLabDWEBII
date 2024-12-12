<?php

namespace cefet\SyncLab\controllers\error;


use cefet\SyncLab\controllers\Controller;

class ErrorSystemController extends Controller
{
    public function index(): void
    {
        $this->view("error/error");
    }
}