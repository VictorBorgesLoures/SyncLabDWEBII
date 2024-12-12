<?php

namespace cefet\SyncLab\controllers\dashboard;
use cefet\SyncLab\controllers\Controller;

class ProjetosController extends Controller {
    private array $projetos;

    public function __construct()
    {
        $this->setProjetos();
    }

    public function viewProjetos(): void
    {
        $this->view("dashboard/projetos", [
            "projetos" => $this->getProjetos()
        ]);
    }

    public function getProjetos(): array
    {
        return $this->projetos;
    }

    public function setProjetos(): void
    {
        $this->projetos = [
            [
                "nome" => "Oktoplus - Programação Competitiva",
                "tutor" => "Anderson Grandi Pires",
                "coTutores" => ["Matheus", "Luan"]
            ],
            [
                "nome" => "Oktoplus Gamming",
                "tutor" => "Gustavo Montes",
                "coTutores" => ["Luan", "Samuel"]
            ],
            [
                "nome" => "PET.COMP",
                "tutor" => "Luís Augusto",
                "coTutores" => ["Gabriela Dalpra"]
            ]
        ];
    }



}