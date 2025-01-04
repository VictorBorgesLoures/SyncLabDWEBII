<?php

namespace cefet\SyncLab\controllers\error;


use cefet\SyncLab\controllers\Controller;

class ErrorPrivilegioController extends Controller
{
    public function index(): void
    {
        $this->view("error/errorPrivilegio");
    }
}