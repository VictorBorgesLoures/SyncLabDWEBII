<?php

namespace cefet\SyncLab\controllers\dashboard;
use cefet\SyncLab\controllers\Controller;

class LaboratoriosController extends Controller {
    private array $laboratorios;

    public function __construct()
    {
        $this->setLaboratorios();
    }

    public function viewLaboratorios(): void
    {
        $this->view("dashboard/laboratorios", [
            'laboratorios' => $this->getLaboratorios()
        ]);
    }

    public function monitorar($params): void
    {
        $id = filter_var($params[0], FILTER_SANITIZE_NUMBER_INT);

        $this->view("dashboard/laboratorio/monitorar", [
            'laboratorio' => $this->getLaboratorios($id)
        ]);

    }

    public function getLaboratorios($id = null): array
    {
        if(isset($id)) {
            return $this->laboratorios[$id];
        }

        return $this->laboratorios;
    }

    public function setLaboratorios(): void
    {
        $this->laboratorios = [
            '1' => [
                'id' => 1,
                'nomeLab' => '6-115',
                'numPessoas' => 7,
                'status' => 'Funcionando'
            ],
            '2' => [
                'id' => 2,
                'nomeLab' => '6-209',
                'numPessoas' => 5,
                'status' => 'Em manutenção'
            ],
            '3' => [
                'id' => 3,
                'nomeLab' => 'Nietec',
                'numPessoas' => 22,
                'status' => 'Desativado'
            ]
        ];
    }



}