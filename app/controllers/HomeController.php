<?php

namespace cefet\SyncLab\controllers;
use cefet\SyncLab\classes\Enviromment;

class HomeController extends Controller {

    public function viewHome(): void
    {
        $this->view("home/home");
    }

    public function viewSobre(): void
    {
        $this->view("home/sobre");
    }

    public function viewContato(): void
    {
        $this->view("home/contato");
    }

    public function viewSaibaMais(): void
    {
        $this->view("home/saibamais");
    }
}