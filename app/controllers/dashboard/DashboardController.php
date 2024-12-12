<?php

namespace cefet\SyncLab\controllers\dashboard;
use cefet\SyncLab\classes\Enviromment;
use cefet\SyncLab\controllers\Controller;

class DashboardController extends Controller {

    public function viewDashboard(): void
    {
        $totalProjetos = 3;
        $totalAtividades = 4;

        $this->view("dashboard/dashboard", [
            "totalProjetos" => $totalProjetos,
            "totalAtividades" => $totalAtividades
        ]);
    }


}