<?php

namespace cefet\Adequa\controllers;
use cefet\Adequa\classes\Enviromment;

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
}