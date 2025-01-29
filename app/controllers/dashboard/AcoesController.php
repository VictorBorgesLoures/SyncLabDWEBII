<?php

namespace cefet\SyncLab\controllers\dashboard;
use cefet\SyncLab\controllers\Controller;
use cefet\SyncLab\classes\User;
use cefet\SyncLab\classes\Session;

class AcoesController extends Controller {

    private array $acoes;
    private User $user;
    public function __construct()
    {
        $this->setAcoes();
        $this->user = new User();
    }

    public function viewAtividades(): void
    {
        $this->view("dashboard/atividades", [
            "atividades" => $this->user->getUsuairoAtivadades(Session::get('idMat'))
        ]);
    }

    public function viewAtividadesProj($params): void
    {
        $id = $params[0];
        $this->view("dashboard/atividades-proj", [
            "atividades" => $this->user->getAtivadades($id)
        ]);
    }

    public function viewAtividade($params): void
    {
        $id = $params[0];
        $this->view("dashboard/atividade", [
            "atividades" => $this->user->getAtivadades($id)
        ]);
    }

    public function getAcoes(): array
    {
        return $this->acoes;
    }

    public function setAcoes(): void
    {
        $this->acoes = [
            [
                "projeto" => "Oktoplus - Programação Competitiva",
                "atividade" => "Produçao Minicurso de Introdução à Programação",
                "atuantes" => "Victor, Wendell, Richard",
                "inicio" => "17-07-2024",
                "entrega" => "29-08-2024",
            ],
            [
                "projeto" => "Oktoplus - Programação Competitiva",
                "atividade" => "Atualizar Exercícios na Planilha",
                "atuantes" => "Victor, Nicole",
                "inicio" => "23-07-2024",
                "entrega" => "10-08-2024",
            ],
            [
                "projeto" => "PET.COMP",
                "atividade" => "Definir Visita Técnica na Semana da Computação",
                "atuantes" => "Victor",
                "inicio" => "04-08-2024",
                "entrega" => "23-08-2024",
            ],
            [
                "projeto" => "PET.COMP",
                "atividade" => "Produzir Minicurso React",
                "atuantes" => "Victor",
                "inicio" => "01-08-2024",
                "entrega" => "18-10-2024",
            ]
        ];
    }


}