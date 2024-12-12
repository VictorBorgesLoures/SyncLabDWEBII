<?php

namespace cefet\SyncLab\controllers\dashboard;
use cefet\SyncLab\controllers\Controller;

class RequisicoesController extends Controller {
    private array $requisicoes;

    public function __construct()
    {
        $this->setRequisicoes();
    }

    public function viewRequisicoes(): void
    {
        $this->view("dashboard/requisicoes", [
            "requisicoes" => $this->getRequisicoes()
        ]);
    }

    public function getRequisicoes(): array
    {
        return $this->requisicoes;
    }

    public function setRequisicoes(): void
    {
        $this->requisicoes = [
            [
                "nomeProjeto" => "Oktoplus - Programação Competitiva",
                "laboratorio" => "Não vinculado",
                "assunto" => "Falta de horário para reunião",
                "status" => "Em andamento"
            ],
            [
                "nomeProjeto" => "Oktoplus - Programação Competitiva",
                "laboratorio" => "Lab 6-209",
                "assunto" => "Instalar biblioteca MinGW",
                "status" => "Concluído"
            ],
            [
                "nomeProjeto" => "PET.COMP",
                "laboratorio" => "Lab 6-115",
                "assunto" => "Super lotação",
                "status" => "Em andamento"
            ]
        ];
    }


}